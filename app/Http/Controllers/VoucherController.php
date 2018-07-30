<?php

namespace App\Http\Controllers;

 use App\Recipient;
 use App\Status;
 use App\Voucher;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class VoucherController extends Controller
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
     * Retrieve all vouchers.
     *
     * @return Response
     */
    public function showAll()
    {
        return response()->json(['data' => Voucher::where([])->with('recipient')->get()]);
     }

    /**
     * Retrieve all vouchers By Recipient Id.
     * @param  Request  $request
     * @return Response
     */
    public function showAllVouchersByEmail(Request $request)
    {
        $validator = Validator::make(
            $request->input(),
            [
                'email' => 'required|email',
            ]);
        if($validator->fails()){
            return response()->json(['error' => $validator->messages()], 400);
        }else{
            $recipient = Recipient::where('email', $request->input('email'))->first();
            if($recipient === null){
                return response()->json(['error' => 'Recipient does not exist!'], 400);
            }else{
                $vouchers  = Voucher::where('recipient_id', $recipient->id)->with('offer')->with('status')->get();
                return response()->json([
                    'data' => [
                        'recipient' => $recipient,
                        'vouchers' => $vouchers
                    ]
                ]);
            }
        }
     }

    /**
     * Retrieve all users.
     * @param  Request  $request
     * @return Response
     */
    public function create(Request $request)
    {

        $validator = Validator::make(
            $request->input(),
            [
            'name' => 'required|max:255|unique:offers',
            'description' => 'sometimes',
            'fixed_discount' => 'required|numeric',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->messages()], 400);
        }else{
            $voucher = new Voucher();
            $voucher->name = $request->input('name');
            $voucher->description = $request->input('description');
            $voucher->fixed_discount = $request->input('fixed_discount');
            try{
                $voucher->save();
                return response()->json(['data' => $voucher], 201);
            }catch (\Exception $exception){
                return response()->json(['error' => $exception->getMessage()], 500);
            }
        }
     }

    /**
     * Retrieve all users.
     * @param  Request  $request
     * @return Response
     */
    public function validateVoucher(Request $request)
    {

        $validator = Validator::make(
            $request->input(),
            [
            'email' => 'required|email',
            'voucher' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->messages()], 400);
        }else{
            $voucher = Voucher::where('code', $request->input('voucher'))->with('offer')->first();

            if($voucher === null){
                return response()->json(['error' => 'Voucher does not exist'], 400);
            }else{
                if($voucher->recipient->email === $request->input('email')){
                    if($voucher->status->name === 'Used'){
                        return response()->json(['error' => 'Voucher has been used'], 200);
                    } else if($voucher->status->name === 'Expired'){
                        return response()->json(['error' => 'Voucher has expired'], 200);
                    }else{
                        $status = Status::where('name', 'Used')->first();
                        if($status !== null){
                            //Check if Voucher Has Not Expire
                            if(strtotime($voucher->expiry_date) > strtotime('now') ) {
                                $voucher->used_on = date('Y-m-d');
                                $voucher->updated_at = date('Y-m-d');
                                $voucher->status_id = $status->id;
                                try{
                                    $voucher->save();
                                    return response()->json(['data' => [
                                        'voucher' => [
                                            "code" => $voucher->code,
                                            "used_on" => $voucher->used_on,
                                            "expiry_date" => $voucher->expiry_date,
                                        ] ,
                                        'offer' => $voucher->offer,
                                        'message' => 'Voucher used successfully'
                                    ]], 200);
                                }catch (\Exception $exception){
                                    return response()->json(['error' => $exception->getMessage()], 500);
                                }
                            }else{
                                try{
                                    $status = Status::where('name', 'Expire')->first();
                                    $voucher->status_id  = $status->id;
                                    $voucher->save();
                                    return response()->json(['error' => 'Voucher has expired'], 200);
                                }catch (\Exception $exception){
                                    return response()->json(['error' => 'Voucher has Expired'], 500);
                                }
                            }
                        }else{
                            return response()->json(['error' => 'Please run migration. Status table is empty'], 400);
                        }
                    }

                }else{
                    return response()->json(['error' => 'Code does not match recipient'], 400);
                }
            }
        }
     }
}
