<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Commentairy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentairyController extends Controller
{
    public function index(){
        $commentairy = Commentairy::all();
        if( $commentairy->count()>0){
            $commentairy= Commentairy::select(
                "commentairy.id",
                "users.pseudo_name",
                "users.email",
                "commentairy.commentairy",
                "recipe.title",
                "commentairy.user_id",
                "commentairy.recipe_id",
                "commentairy.created_at",

            )->join("users","users.id","=","commentairy.user_id")
            ->join("recipe","recipe.id","=","commentairy.recipe_id")
            ->get();
            return $commentairy;
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
            "commentairy"=>"required",
            "user_id"=>"required",
            "recipe_id"=>"required",
           
        ]);
        if($validator->fails()){
            return response()->json([
        'status'=> 422,
        "errors"=> $validator->messages()
            ], 422);
        }else{
        $commentairy=Commentairy::create([
        "commentairy"=>$request->commentairy,
        "user_id"=>$request->user_id,
        "recipe_id"=>$request->recipe_id,
            ]);
        }
        if($commentairy){
          return response()->json([
            'status'=>200,
            'message'=>'commentairy created successfully'
        ],200);
        }else{
            return response()->json([
             'status'=>500,
             'message'=>'something went wrong'
            ],500);
        }
    }
    public function show($id){
        $commentairy=Commentairy::find($id);
        if($commentairy->count()>0){
            $join_commentary= Commentairy::select(
                "users.pseudo_name",
                "commentairy.commentairy")
                ->where('commentairy.id', "=", $id)
                ->join("users","users.id","=","commentairy.user_id")
                ->join("recipe","recipe.id","=","commentairy.recipe_id")
                ->get();
                return $join_commentary;
       }else{
           return response()->json([
           'status'=>404,
           'message'=>'No commenatiry Found!'
              ],404);
          }
    }
    public function edit($id){
        $commentairy=Commentairy::find($id);
        if($commentairy){
            // return response()->json([
            //     'status'=>200,
            //     'commentairy'=>$commentairy
            // ],200);
            $join_commentary= Commentairy::select(
                "users.pseudo_name",
                "commentairy.commentairy")
                ->where('commentairy.id', "=", $id)
                ->join("users","users.id","=","commentairy.user_id")
                ->join("recipe","recipe.id","=","commentairy.recipe_id")
                ->get();
                return $join_commentary;
       }else{
            return response()->json([
                'status'=>404,
                   'message'=>'No commentairy Found!'
                ],404);
            }
        }
 public function update(Request $request,int $id){
    $validator= Validator::make($request->all(),[
        "commentairy"=>"required",
       
    ]);
   if($validator->fails()){
       return response()->json([
        'status'=> 422,
        "errors"=> $validator->messages()
       ], 422);
   }else{
       $commentairy=Commentairy::find($id);
   }
   if($commentairy){
       $commentairy->update([
        "commentairy"=>$request->commentairy,
       ]);
       return response()->json
       ([
       'status'=>200,
       'message'=>'commentairy updated successfully'
       ],200);
   }else{
       return response()->json([
           'status'=>404,
           'message'=>'No such user found !'
       ],404);
   }
}
    public function destroy($id){
         $commentairy=Commentairy::find($id);
         if($commentairy){
         $commentairy->delete();
         return response()->json([
             'status'=>200,
             'message'=>'commentairy detele successfully'
             ],200);
         }else{
             return response()->json([
                 'status'=>404,
                 'message'=>'No such contact found !'
             ],404);
         }
    }  
}
