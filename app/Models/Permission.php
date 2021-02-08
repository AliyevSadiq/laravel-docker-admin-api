<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Class Permission
 * @package App\Models
 * @mixin Builder
 */
class Permission extends Model
{
    use HasFactory;


    protected $guarded=['id'];

    public $timestamps=false;



}
