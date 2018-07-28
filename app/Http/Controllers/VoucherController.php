<?php

namespace App\Http\Controllers;

 use App\Recipient;
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
     * @param  int  $id
     * @return Response
     */
    public function showAllVouchersByRecipientId($id)
    {
        $recipient = Recipient::find($id);
        if($recipient === null){
            return response()->json(['error' => "Recipient does not exist."], 400);
        }else{
            return response()->json(
                [
                    'data' => [
                        'recipient' => $recipient,
                        'vouchers' => Voucher::where('recipient_id', $id)->get()
                    ]
                ]
            );
        }

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
                $vouchers  = Voucher::where('recipient_id', $recipient->id)->with('offer')->get();
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
}
