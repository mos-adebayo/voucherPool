<?php

namespace App\Http\Controllers;

use App\Recipient;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class RecipientController extends Controller
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
        return response()->json(['data' => Recipient::all()]);
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
            'email' => $request->input('email')
        ], [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:recipients',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->messages()], 400);

        }else{
            $recipient = new Recipient;
            $recipient->email = $request->input('email');
            $recipient->name = $request->input('name');

            try{
                $recipient->save();
                return response()->json("Done");
            }catch (\Exception $exception){
                return response()->json(['error' => $exception->getMessage()], 500);
            }
        }


//        $recipient = new Recipient;
//        $recipient->email = $request->email;
//        $recipient->name = $request->name;
//        $recipient->save();
//
//        return response()->json(['data' => Recipient::all()]);
     }
}
