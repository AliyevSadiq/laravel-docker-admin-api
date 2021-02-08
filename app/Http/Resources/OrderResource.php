<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
//            'first_name'=>$this->first_name,
//            'last_name'=>$this->last_name,
            'email'=>$this->email,
            'total'=>$this->total,
            'order_items'=>$this->orderItems

        ];
    }
}
