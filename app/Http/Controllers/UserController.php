<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(){
        Gate::authorize('view','users');


         return response()->json(User::with('rule')->paginate(2));
    }


    public function show($id){
        Gate::authorize('view','users');
        if(!empty($id)){
            return response()->json(User::where('id','=',$id)->with('rule')->first());
        }else{
            return response()->json('ID NOT FOUND');
        }
    }


    public function store(Request $request){
        Gate::authorize('edit','users');

        $register=   User::register($request);

        return response()->json($register);
    }


    public function update(Request $request,$id){
        Gate::authorize('edit','users');
           if($request->method()=='PUT'){
               if(!empty($id)){
                  $user=User::find($id);
                  if(!empty($user)){
                      $data=$request->all();
                      $validator=Validator::make($data,User::$updateRules);

                      if($validator->fails()){
                          return response()->json(['error' => true, 'messages' => $validator->errors()]);
                      }

                      $data['password']=Hash::make($request->input('password'));

                      $user->update($data);

                      return response()->json('USER IS UPDATED');


                  }else{
                      return response()->json('USER NOT FOUND');
                  }

               }
           }
    }


    public function destroy($id){
        Gate::authorize('edit','users');
       if (!empty($id)) {
           $user=User::find($id);

           if(!empty($user)){
               $user->delete();
               return response()->json('USER DELETED');
           }else{
               return response()->json('USER NOT FOUND');
           }

       }

    }

    public function user(){
       $user=Auth::user();
       return response()->json((new UserResource($user))->additional([
           'data'=>[
               'permissions'=>$user->permissions()
           ]
       ]));
    }

    public function updateInfo(Request $request){
        return User::updateProfile($request,User::$updateInfo);
    }

    public function updatePassword(Request $request){
     return   User::updateProfile($request,User::$updatePassword,'password');
    }
}
