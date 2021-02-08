<?php

namespace App\Http\Controllers;

use App\Models\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class RuleController extends Controller
{
    public function index(){
        Gate::authorize('view','rules');
        return response()->json(Rule::with('permissions')->paginate(10));
    }


    public function store(Request $request){
        Gate::authorize('edit','rules');

        if($request->method()=='POST'){
            $validate=Validator::make($request->all(),Rule::$rules);
            if($validate->fails()){
                return response()->json(['error'=>true,'messages'=>$validate->errors()]);
            }
            $rule=Rule::create($request->all());
            if($permissions=$request->input('permissions')){
                foreach ($permissions as $permission_id) {
                    DB::table('rule_permission')->insert([
                        'rule_id'=>$rule->id,
                        'permission_id'=>$permission_id,
                    ]);
                }
            }
            return response()->json('RULES ADDED');
        }
    }

    public function show($id) {
        Gate::authorize('view','rules');

        $rule=Rule::where('id','=',$id)->with('permissions')->first();
        if(!empty($rule)){
            return response()->json($rule);
        }
        return response()->json('RULES NOT FOUND');
    }


    public function update(Request $request,$id) {
        Gate::authorize('edit','rules');

        if($request->method()=='PUT'){
            $rule=Rule::find($id);
            if(!empty($rule)){
                $validate=Validator::make($request->all(),Rule::$rules);

                if($validate->fails()){
                    return response()->json(['error'=>true,'messages'=>$validate->errors()]);
                }


                $rule->update($request->all());


                DB::table('rule_permission')->where('rule_id','=',$rule->id)->delete();

                if($permissions=$request->input('permissions')){
                    foreach ($permissions as $permission_id) {
                        DB::table('rule_permission')->insert([
                            'rule_id'=>$rule->id,
                            'permission_id'=>$permission_id,
                        ]);
                    }
                }
                return response()->json('RULES UPDATED');
            }
            return response()->json('RULES NOT FOUND');
        }
    }



    public function destroy($id){
        Gate::authorize('edit','rules');

        $rule=Rule::find($id);
        if(!empty($rule)) {
            DB::table('rule_permission')->where('rule_id','=',$id)->delete();
            $rule->delete();

        }
        return response()->json('RULES NOT FOUND');
    }


}
