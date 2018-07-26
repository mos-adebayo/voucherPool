<?php

use Illuminate\Database\Seeder;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('status')->insert([
           'name' => 'Active',
           'created_at' => date("Y-m-d h:i:sa"),
        ]);
         DB::table('status')->insert([
           'name' => 'Used',
           'created_at' => date("Y-m-d h:i:sa"),
         ]);
         DB::table('status')->insert([
           'name' => 'Expire',
           'created_at' => date("Y-m-d h:i:sa"),
        ]);
    }
}
