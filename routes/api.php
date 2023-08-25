<?php

use App\Http\Controllers\Api\CommentairyController;
use App\Http\Controllers\Api\RecipeController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FavorisController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('users',[UserController::class,'index']);
Route::post('users',[UserController::class,'store']);
Route::get('users/{id}',[UserController::class,'show']);
// Route::get('users/{id}/edit',[UserController::class,'edit']);
Route::put('users/{id}/update',[UserController::class,'update']);
Route::delete('users/{id}/delete',[UserController::class,'destroy']);

Route::get('recipe',[RecipeController::class,'index']);
Route::get('recipe/lunch',[RecipeController::class,'showLunch']);
Route::get('recipe/diner',[RecipeController::class,'showDinner']);
Route::get('recipe/breakfast',[RecipeController::class,'showBreakfast']);
Route::post('recipe',[RecipeController::class,'store']);
Route::get('recipe/{id}',[RecipeController::class,'show']);
// Route::get('recipe/{id}/edit',[RecipeController::class,'edit']);
Route::put('recipe/{id}/update',[RecipeController::class,'update']);
Route::delete('recipe/{id}/delete',[RecipeController::class,'destroy']);

Route::get('commentairy',[CommentairyController::class,'index']);
Route::post('commentairy',[CommentairyController::class,'store']);
Route::get('commentairy/{id}',[CommentairyController::class,'show']);
// Route::get('commentairy/{id}/edit',[CommentairyController::class,'edit']);
Route::put('commentairy/{id}/update',[CommentairyController::class,'update']);
Route::delete('commentairy/{id}/delete',[CommentairyController::class,'destroy']);

Route::get('contact',[ContactController::class,'index']);
Route::post('contact',[ContactController::class,'store']);
Route::get('contact/{id}',[ContactController::class,'show']);
Route::delete('contact/{id}/delete',[ContactController::class,'destroy']);

Route::get('favoris',[FavorisController::class,'index']);
Route::post('favoris',[FavorisController::class,'store']);
Route::get('favoris/{id}',[FavorisController::class,'show']);
Route::delete('favoris/{id}/delete',[FavorisController::class,'destroy']);


Route::post('login', [UserController::class,'login']);
Route::post('register', [UserController::class,'register']);
Route::group(['middleware' => 'auth:api'], function(){
Route::post('details', [UserController::class,'details']);
});