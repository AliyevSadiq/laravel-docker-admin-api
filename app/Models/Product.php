<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Class Product
 * @package App\Models
 * @mixin Builder
 */
class Product extends Model
{
    use HasFactory;

    protected $guarded=['id'];


    public static $createRules=[
       'title'=>['required','unique:products'],
       'description'=>['required'],
       'price'=>['required','numeric','min:1'],
       'image'=>['required','image']
    ];

    public static $updateRules=[
        'title'=>['required'],
        'description'=>['required'],
        'price'=>['required','numeric','min:1'],
        'image'=>['image']
    ];


    public function setTitleAttribute($value){
        $this->attributes['title']=Str::ucfirst($value);
    }

    public function setDescriptionAttribute($value){
        $this->attributes['description']=Str::ucfirst($value);
    }


    public static function uploadImg($request,$name,$image=null){
        if($request->hasFile($name)){
            if($image){
                Storage::delete($image);
            }
            $folder="product/".date("Y-m-d");
            return $request->file($name)->store("images/{$folder}");
        }
        return null;
    }
}
