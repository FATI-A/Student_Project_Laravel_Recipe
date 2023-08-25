<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Illuminate\Support\Facades\View;

class RecipeController extends Controller
{
    public function index(){
    $recipe= Recipe::all();
    if($recipe -> count() > 0){
        return response()->json([
            'status'=>200,
            'recipe'=>$recipe
        ],200);
    } else {
        $data=[
            'status'=>404,
             'message'=>'no records found'
             ];
              return response()-> json($data,404);

    }
    }
    public function store(Request $request){
$validator= FacadesValidator::make($request->all(),[
    "title"=>"required",
    "ingrediants"=>"required",
    "preparation"=>"required",
    "img"=>"required",
    "duration"=>"required",
    "category"=>"required|max:25",
]);
if($validator->fails()){
    return response()->json([
'status'=> 422,
"errors"=> $validator->messages()
    ], 422);
}else{
    $recipe=Recipe::create([
"title"=>$request->title,
"ingrediants"=>$request->ingrediants,
"preparation"=>$request->preparation,
"img"=>$request->img,
"category"=>$request->category,
"duration"=>$request->duration,
    ]);
}
if($recipe){
return response()->json([
    'status'=>200,
    'message'=>'recipe created successfully'
],200);
}else{
    return response()->json([
        'status'=>500,
        'message'=>'something went wrong'
    ],500);
}
    }
public function showLunch(){
    $recipe= Recipe::all();
    if($recipe -> count() > 0){
    $join_recipe= Recipe::select(
        "recipe.id",
        "recipe.title",
        "recipe.ingrediants",
        "recipe.img",
    )->where('recipe.category', "=","lunch")->get();
    return $join_recipe;}
    else {
        $data=[
            'status'=>404,
             'message'=>'no records found'
             ];
              return response()-> json($data,404);

    }
}
public function showDinner(){
    $recipe= Recipe::all();
    if($recipe -> count() > 0){
    $join_recipe= Recipe::select(
        "recipe.id",
        "recipe.title",
        "recipe.ingrediants",
        "recipe.img",
    )->where('recipe.category', "=","diner")->get();
    return $join_recipe;}
    else {
        $data=[
            'status'=>404,
             'message'=>'no records found'
             ];
              return response()-> json($data,404);

    }
}
public function showBreakfast(){
    $recipe= Recipe::all();
    if($recipe -> count() > 0){
    $join_recipe= Recipe::select(
        "recipe.id",
        "recipe.title",
        "recipe.ingrediants",
        "recipe.img",
    )->where('recipe.category', "=","breakfast")->get();
    return $join_recipe;}
    else {
        $data=[
            'status'=>404,
             'message'=>'no records found'
             ];
              return response()-> json($data,404);

    }
}
 
public function show($id){
     $recipe=Recipe::find($id);
      if($recipe){
    // $join_recipe= Recipe::select(
    //     "recipe.title",
    //     "recipe.ingrediants",
    //     "recipe.duration",
    //     "recipe.preparation",
    //     "recipe.img",
    // )->where('recipe.id', "=", $id)->get();
    // return $join_recipe;
    return response()->json([
        'status'=>200,
        'recipe'=>$recipe
    ],200);
    }else{
        return response()->json([
            'status'=>404,
            'message'=>'No recipe Found!'
        ],404);
    }
}
public function edit($id){
    $recipe=Recipe::find($id);
    if($recipe){
        return response()->json([
            'status'=>200,
            'recipe'=>$recipe
        ],200);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'No recipe Found!'
            ],404);
        }
}
public function update(Request $request,int $id){
$validator= FacadesValidator::make($request->all(),[
    "title",
    "ingrediants",
    "preparation",
    "img",
    "duration",
    "category",
]);
if($validator->fails()){
    return response()->json([
     'status'=> 422,
     "errors"=> $validator->messages()
    ], 422);
}else{
    $recipe=Recipe::find($id);
}
if($recipe){
    $recipe->update([
        "title"=>$request->title,
        "ingrediants"=>$request->ingrediants,
        "preparation"=>$request->preparation,
        "img"=>$request->img,
        "category"=>$request->category,
        "duration"=>$request->duration,
            ]);
    return response()->json([
    'status'=>200,
    'message'=>'recipe updated successfully'
    ],200);
}else{
    return response()->json([
        'status'=>404,
        'message'=>'No such recipe found !'
    ],404);
}
}
public function destroy($id){
$recipe=Recipe::find($id);
if($recipe){
$recipe->delete();
return response()->json([
    'status'=>200,
    'message'=>'recipe deleted successfully'
    ],200);
}else{
    return response()->json([
        'status'=>404,
        'message'=>'No such recipe found !'
    ],404);
}
}
}