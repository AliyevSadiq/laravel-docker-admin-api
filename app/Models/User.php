<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\HasApiTokens;

/**
 * Class User
 * @package App\Models
 * @mixin Builder
 */
class User extends Authenticatable
{
    use HasFactory,HasApiTokens,Notifiable;





    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'rule_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];






    public static $registerRules=[
      'first_name'=>['required'],
      'last_name'=>['required'],
      'email'=>['required','email','unique:users'],
      'password'=>['required'],
       'rule_id'=>['required','exists:rules,id']
    ];

    public static $updateRules=[
        'first_name'=>['required'],
        'last_name'=>['required'],
        'email'=>['required','email'],
        'password'=>['required'],
        'rule_id'=>['required','exists:rules,id']
    ];


    public static $updateInfo=[
        'first_name'=>['required'],
        'last_name'=>['required'],
        'email'=>['required','email']
    ];

    public static $updatePassword=[
        'password'=>['required'],
        'confirm_password'=>['required','same:password']
    ];


    public static function register($request){
        if($request->method()=='POST'){
            $data=$request->all();
            $validator=Validator::make($data,self::$registerRules);

            if($validator->fails()){
                return response()->json(['error' => true, 'messages' => $validator->errors()]);
            }

            $data['password']=Hash::make($request->input('password'));



            self::create($data);

            return response()->json('USER IS REGISTERED');
        }
    }


    public static function updateProfile($request,$rules,$updateType='info'){
        if($request->method()=='PUT'){
            $data=$request->all();
            $validator=Validator::make($data,$rules);

            if($updateType=='password'){
                $data['password']=Hash::make($request->input('password'));
            }

            $user=Auth::user();


            if($validator->fails()){
                return response()->json(['error' => true, 'messages' => $validator->errors()]);
            }

            $user->update($data);

            return response()->json("USER'S PROFILE WAS UPDATE");

        }
    }


    public function rule(){
        return $this->belongsTo(Rule::class);
    }

    public function permissions(){
        return $this->rule->permissions->pluck('name');
    }


    public function hasAccess($access)
    {
        return $this->permissions()->contains($access);
    }


}
