<?php

namespace App\Http\Controllers;

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
        return response()->json(['data' => Voucher::all()]);
     }

    /**
     * Retrieve all users.
     * @param  Request  $request
     * @return Response
     */
    public function create(Request $request)
    {

        $validator = Validator::make([
            'recipient_id' => $request->input('name'),
            'offer_id' => $request->input('name'),
            'description' => $request->input('description'),
            'fixed_discount' => $request->input('fixed_discount')
        ], [
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
