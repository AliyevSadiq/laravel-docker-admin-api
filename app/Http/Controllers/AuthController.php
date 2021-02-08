<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;


class AuthController extends Controller
{
    public function login(Request $request)
    {
      if(Auth::attempt($request->only('email','password'))) {
          $user=Auth::user();

          $token=$user->createToken('admin')->accessToken;

          $cookie=cookie('jwt',$token,3600);

          return response()->json(['token'=>$token])->withCookie($cookie);
      }

      return response()->json('INVALID USERNAME/PASSWORD');
   }

   public function logout(){
        $cookie=Cookie::forget('jwt');
        return response()->json([
            'message'=>'user logout'
        ])->withCookie($cookie);
   }


   public function register(Request $request){
    $register=   User::register($request);
    return response()->json($register);
   }
}
