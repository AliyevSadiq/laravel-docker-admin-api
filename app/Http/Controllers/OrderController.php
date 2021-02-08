<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Response;


class OrderController extends Controller
{
    public function index(){
        Gate::authorize('view','orders');

        $orders=OrderResource::collection(Order::paginate(10));
        return response()->json($orders);
    }


    public function show($id){
        Gate::authorize('view','orders');

        $order=Order::where('id','=',$id)->first();
        if(!empty($order)){
            return response()->json(new OrderResource($order));
        }
        return response()->json(['error'=>true,'message'=>'ORDER NOT FOUND']);
    }


    public function export(){
        Gate::authorize('edit','orders');
        $headers=[
            'Content-type'=>'text/csv',
            'Content-Disposition'=>'attachment; filename=orders.csv',
            'Pragma'=>'no-cache',
            'Cache-Control'=>'must-revalidate, post-check=0, pre-check=0',
            'Expires'=>'0'
        ];

        $callBack=function (){
           $orders=Order::all();
           $file=fopen('php://output','w');

           fputcsv($file,['ID','NAME','EMAIL','PRODUCT TITLE','PRICE','QUANTITY']);

           foreach ($orders as $order){
               fputcsv($file,[$order->id,$order->name,$order->email,'','','']);


               foreach ($order->orderItems as $orderItem){
                   fputcsv($file,['','','',$orderItem->product_title,$orderItem->price,$orderItem->quantity]);
               }
           }
           fclose($file);
        };

        return Response::stream($callBack,200,$headers);


    }
}
