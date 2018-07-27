<?php

namespace App\Http\Controllers;

use App\Offer;
 use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
     * Retrieve all users.
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
            'fixed_discount' => $request->input('fixed_discount')
        ], [
            'name' => 'required|max:255|unique:offers',
            'description' => 'sometimes',
            'fixed_discount' => 'required|numeric',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->messages()], 400);
        }else{
            $offer = new Offer;
            $offer->name = $request->input('name');
            $offer->description = $request->input('description');
            $offer->fixed_discount = $request->input('fixed_discount');
            try{
                $offer->save();
                return response()->json(['data' => $offer], 201);
            }catch (\Exception $exception){
                return response()->json(['error' => $exception->getMessage()], 500);
            }
        }
     }
}
