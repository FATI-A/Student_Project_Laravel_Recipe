<?php

namespace App\Http\Controllers;

use App\Models\Favoris;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FavorisController extends Controller
{
    public function index(){
        $favoris =Favoris::all();
        if($favoris->count()>0){
        $favoris= Favoris::select(
            "favoris.id",
            "recipe.title",
            "recipe.ingrediants",
            "recipe.img",
            "favoris.user_id",
            "favoris.recipe_id"
        )
        ->join("users","users.id","=","favoris.user_id")
        ->join("recipe","recipe.id","=","favoris.recipe_id")
        ->get();
        return $favoris;
        } else {
            $data=[
                'status'=>404,
                 'message'=>'no records found'
                 ];
                  return response()->json($data,404);
    
    }
    }
    public function store(Request $request){
        $validator= Validator::make($request->all(),[
            "user_id"=>"required",
            "recipe_id"=>"required",
           
        ]);
        if($validator->fails()){
            return response()->json([
        'status'=> 422,
        "errors"=> $validator->messages()
            ], 422);
        }else{
            $favoris=Favoris::create([
            "user_id"=>$request->user_id,
            "recipe_id"=>$request->recipe_id,
            ]);
        }
        if($favoris){
          return response()->json([
            'status'=>200,
            'message'=>'favoris created successfully'
        ],200);
        }else{
            return response()->json([
             'status'=>500,
             'message'=>'something went wrong'
            ],500);
        }
    }
    public function show($id){
        $favoris=Favoris::find($id);
        if($favoris){
            $favoris= Favoris::select(
            "favoris.id",
            "recipe.title",
            "recipe.ingrediants",
            "recipe.duration",
            "recipe.preparation",
            "recipe.img",
        )->where("favoris.id","=",$id)
        ->join("users","users.id","=","favoris.user_id")
        ->join("recipe","recipe.id","=","favoris.recipe_id")
        ->get();
        return $favoris;
       }else{
           return response()->json([
           'status'=>404,
           'message'=>'No favoris Found!'
              ],404);
          }
    }
    public function destroy($id){
         $favoris=Favoris::find($id);
         if($favoris){
         $favoris->delete();
         return response()->json([
             'status'=>200,
             'message'=>'favoris detele successfully'
             ],200);
         }else{
             return response()->json([
                 'status'=>404,
                 'message'=>'No such contact found !'
             ],404);
         }
    } 
}
