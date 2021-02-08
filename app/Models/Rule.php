<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * Class Role
 * @package App\Models
 * @mixin Builder
 */
class Rule extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded=['id'];

    public static $rules=[
      'name'=>['required','unique:rules']
    ];


    public function permissions(){
        return $this->belongsToMany(Permission::class,'rule_permission');
    }


}
