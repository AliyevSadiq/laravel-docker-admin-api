<?php

namespace Database\Seeders;

use App\Models\Rule;
use Illuminate\Database\Seeder;

class RuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Rule::create(['name'=>'Admin']);
        Rule::create(['name'=>'Editor']);
        Rule::create(['name'=>'Viewer']);
    }
}
