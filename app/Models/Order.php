<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Order
 * @package App\Models
 * @mixin Builder
 */
class Order extends Model
{
    use HasFactory;

    protected $guarded=['id'];


    public function orderItems(){
        return $this->hasMany(OrderItem::class);
    }

    public function getTotalAttribute(){
        return $this->orderItems->sum(function (OrderItem $item){
           return $item->price*$item->quantity;
        });
    }

    public function getNameAttribute(){
        return $this->last_name.' '.$this->first_name;
    }
}
