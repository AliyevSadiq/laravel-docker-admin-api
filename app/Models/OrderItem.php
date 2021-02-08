<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OrderItem
 * @package App\Models
 * @mixin Builder
 */
class OrderItem extends Model
{
    use HasFactory;

    protected $guarded=['id'];


    public function order(){
        return $this->belongsTo(Order::class);
    }
}
