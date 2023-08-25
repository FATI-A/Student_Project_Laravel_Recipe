<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    public function index(){
        $contact = Contact::all();
        if($contact->count()>0){
            return response()->json([
                'status'=>200,
                 'contact'=>$contact
               ],200);
        }else{
            $data=[
                'status'=>404,
                 'message'=>'no records found'
                 ];
                  return response()->json($data,404);
    
    }
   
}
    public function store(Request $request){
        $validator= Validator::make($request->all(),[
            "first_name"=>"required",
            "last_name"=>"required",
            "email"=>"required",
            "message"=>"required",
          
        ]);
        if($validator->fails()){
            return response()->json([
        'status'=> 422,
        "errors"=> $validator->messages()
            ], 422);
        }else{
        $contact=Contact::create([
         "first_name"=>$request->first_name,
         "last_name"=>$request->last_name,
         "email"=>$request->email, 
         "message"=>$request->message,
            ]);
        }
        if($contact){
          return response()->json([
            'status'=>200,
            'message'=>'contact created successfully'
        ],200);
        }else{
            return response()->json([
             'status'=>500,
             'message'=>'something went wrong'
            ],500);
        }
    }
    public function show($id){
        $Contact=Contact::find($id);
        if($Contact){
          return response()->json([
           'status'=>200,
            'contact'=>$Contact
          ],200);
       }else{
           return response()->json([
           'status'=>404,
           'message'=>'No contact Found!'
              ],404);
          }
    }
    public function destroy($id){
         $contact=Contact::find($id);
         if($contact){
         $contact->delete();
         return response()->json([
             'status'=>200,
             'message'=>'contact detele successfully'
             ],200);
         }else{
             return response()->json([
                 'status'=>404,
                 'message'=>'No such contact found !'
             ],404);
         }
    }    
}