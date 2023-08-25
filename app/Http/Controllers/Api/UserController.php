<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public $successStatus = 200;
    /** 
         * login api 
         * 
         * @return \Illuminate\Http\Response 
         */ 
        public function login(){ 
            if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
                $user = Auth::user(); 
                $success['token'] =  $user->createToken('MyApp')-> accessToken; 
                return response()->json(['success' => $success], $this-> successStatus); 
            } 
            else{ 
                return response()->json(['error'=>'Unauthorised'], 401); 
            } 
        }
    /** 
         * Register api 
         * 
         * @return \Illuminate\Http\Response 
         */ 
        public function register(Request $request) 
        { 
            $validator = Validator::make($request->all(), [ 
                'pseudo_name' => 'required', 
                'email' => 'required|email', 
                'password' => 'required',
                'c_password' => 'required|same:password', 
            ]);
    if ($validator->fails()) { 
                return response()->json(['error'=>$validator->errors()], 401);            
            }
    $input = $request->all(); 
            $input['password'] = bcrypt($input['password']); 
            $user = User::create([
                "first_name"=>$request->first_name,
                "last_name"=>$request->last_name,
                'pseudo_name'=>$request->pseudo_name,
                "privilage"=>"client",
                "favoris"=>"[]",
                "email"=>$request->email,
                "password"=>$input['password'],
                    ]); 
            $success['token'] =  $user->createToken('MyApp')-> accessToken; 
            $success['name'] =  $user->name;
    return response()->json(['success'=>$success], $this-> successStatus); 
        }
    /** 
         * details api 
         * 
         * @return \Illuminate\Http\Response 
         */ 
        public function details() 
        { 
            $user = Auth::user(); 
            return response()->json(['success' => $user], $this-> successStatus); 
        } 
    
    public function index(){
        $user = User::all();
        if($user->count()>0){
        $data=[
       'status'=>200,
        'user'=>$user
        ];
         return response()->json($data,200);
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
            "first_name"=>"required",
            "last_name"=>"required",
            'pseudo_name'=>"required",
            "email"=>"required",
            "privilage",
            "password"=>"required",
            "favoris",
          
        ]);
        if($validator->fails()){
            return response()->json([
        'status'=> 422,
        "errors"=> $validator->messages()
            ], 422);
        }else{
        $user=User::create([
        "first_name"=>$request->first_name,
        "last_name"=>$request->last_name,
        'pseudo_name'=>$request->pseudo_name,
        "privilage"=>"client",
        "favoris"=>"1",
        "email"=>$request->email,
        "password"=>$request->password,
    
            ]);
        }
        if($user){
          return response()->json([
            'status'=>200,
            'message'=>'user created successfully'
        ],200);
        }else{
            return response()->json([
             'status'=>500,
             'message'=>'something went wrong'
            ],500);
        }
    }
    public function show($id){
     $user=User::find($id);
     if($user){
       return response()->json([
        'status'=>200,
         'user'=>$user
       ],200);
    }else{
        return response()->json([
        'status'=>404,
        'message'=>'No user Found!'
           ],404);
       }
    }
    public function edit($id){
     $user=User::find($id);
     if($user){
         return response()->json([
             'status'=>200,
             'user'=>$user
         ],200);
    }else{
         return response()->json([
             'status'=>404,
                'message'=>'No user Found!'
             ],404);
         }
     }
     public function update(Request $request,int $id){
        $validator= Validator::make($request->all(),[
            "first_name",
            "last_name",
            'pseudo_name',
            "privilage",
            "email",
          
        ]);
        if($validator->fails()){
            return response()->json([
             'status'=> 422,
             "errors"=> $validator->messages()
            ], 422);
        }else{
            $user=User::find($id);
        }
        if($user){
            $user->update([
                "first_name"=>$request->first_name,
                "last_name"=>$request->last_name,
                'pseudo_name'=>$request->pseudo_name,
                "privilage"=>$request->privilage,
                "email"=>$request->email,
            ]);
            return response()->json
            ([
            'status'=>200,
            'message'=>'User updated successfully'
            ],200);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'No such user found !'
            ],404);
        }
        }
        public function destroy($id){
        $user=User::find($id);
        if($user){
        $user->delete();
        return response()->json([
            'status'=>200,
            'message'=>'user deleted successfully'
            ],200);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'No such user found !'
            ],404);
        }
        }
    }
