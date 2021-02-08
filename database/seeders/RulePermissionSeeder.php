<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Rule;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RulePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions=Permission::all();

        $admin=Rule::where('name','=','Admin')->first();
        $editor=Rule::where('name','=','Editor')->first();
        $viewer=Rule::where('name','=','Viewer')->first();

        foreach ($permissions as $permission){
            DB::table('rule_permission')->insert([
                'rule_id'=>$admin->id,
                'permission_id'=>$permission->id
            ]);
        }


        foreach ($permissions as $permission){
            if(!in_array($permission->name,['edit_rules'])) {
                DB::table('rule_permission')->insert([
                    'rule_id' => $editor->id,
                    'permission_id' => $permission->id
                ]);
            }
        }

        foreach ($permissions as $permission){
            if(in_array($permission->name,['view_users','view_rules','view_products','view_orders'])) {
                DB::table('rule_permission')->insert([
                    'rule_id' => $viewer->id,
                    'permission_id' => $permission->id
                ]);
            }
        }



    }
}
