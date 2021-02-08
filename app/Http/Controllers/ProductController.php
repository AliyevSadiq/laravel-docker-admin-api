<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index() {
        Gate::authorize('view','products');

        return response()->json(Product::paginate(10));
    }

    public function show($id) {
        Gate::authorize('view','products');

        $product=Product::find($id);
        if(!empty($product)){
            return response()->json($product);
        }

        return response()->json(['error'=>true,'message'=>'PRODCUT NOT FOUND']);

    }

    public function store(Request $request)
    {
        Gate::authorize('edit','products');

        $data=$request->all();

        $validation=Validator::make($data,Product::$createRules);

        if($validation->fails()){
            return response()->json(['error'=>true,'message'=>$validation->errors()]);
        }

        $data['image']=Product::uploadImg($request,'image');

        $product=Product::create($data);

        return response()->json(['message'=>'PRODUCT IS ADDED']);

    }

    public function update(Request $request,$id)
    {
        Gate::authorize('edit','products');

        $product=Product::find($id);
        if(!empty($product)){

            $data=$request->all();
            $validation=Validator::make($data,Product::$updateRules);

            if($validation->fails()){
                return response()->json(['error'=>true,'message'=>$validation->errors()]);
            }

            $data['main_image']=Product::uploadImg($request,'image',$product->image) ? Product::uploadImg($request,'image',$product->image) : $product->image;

            $product->update($data);
            return response()->json(['message'=>'PRODUCT IS UPDATED']);
        }

        return response()->json(['error'=>true,'message'=>'PRODCUT NOT FOUND']);
    }

    public function destroy($id)
    {
        Gate::authorize('edit','products');

        $product=Product::find($id);
        if(!empty($product)){
            Storage::delete($product->image);
            $product->delete();
            return response()->json(['message'=>'PRODUCT DELETED']);
        }

        return response()->json(['error'=>true,'message'=>'PRODCUT NOT FOUND']);
    }
}
