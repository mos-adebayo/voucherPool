<?php

namespace App\Http\Controllers;

use App\Offer;
use App\Recipient;
use App\Status;
use App\Voucher;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OfferController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Retrieve all offers.
     *
     * @return Response
     */
    public function showAll()
    {
        return response()->json(['data' => Offer::all()]);
     }

    /**
     * Retrieve all users.
     * @param  Request  $request
     * @return Response
     */
    public function create(Request $request)
    {

        $validator = Validator::make([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'fixed_discount' => $request->input('fixed_discount'),
            'expiry_date' => $request->input('expiry_date')
        ], [
            'name' => 'required|max:255|unique:offers',
            'description' => 'sometimes',
            'fixed_discount' => 'required|numeric',
            'expiry_date' => 'required|date|after:today',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->messages()], 400);
        }else{
            DB::beginTransaction();

            $offer = new Offer;
            $offer->name = $request->input('name');
            $offer->description = $request->input('description');
            $offer->fixed_discount = $request->input('fixed_discount');
            try{
                $recipients = Recipient::all();
                $status = Status::where('name', 'Active')->first();

                if($status === null && $recipients->count() === 0){
                    return response()->json(['error' => 'Please run the migration command'], 500);
                }else if($status === null && $recipients->count() > 0){
                    return response()->json(['error' => 'Please run the migration command. Status table is empty'], 500);
                }else if($status !== null && $recipients->count() === 0){
                    return response()->json(['error' => 'No recipient yet!. Please add recipient'], 500);
                }else{
                    /*Save Offer*/
                    $offer->save();
                    //Generate Voucher For All Recipients
                    foreach ($recipients as $recipient){
                        Voucher::create([
                            'code' => uniqid(),
                            'offer_id' => $offer->id,
                            'recipient_id' => $recipient->id,
                            'expiry_date' => $request->input('expiry_date'),
                            'status_id' => $status->id,
                        ]);
                    }
                    DB::commit();
                    return response()->json(['data' => [
                        'message' => 'Offer created successfully & voucher generated!',
                        'offer' => $offer
                    ]], 201);
                }
            }catch (\Exception $exception){
                DB::rollBack();
                return response()->json(['error' => 'Sorry unable to create offer. Validate your request and try again!'], 500);
            }
        }
     }
}
