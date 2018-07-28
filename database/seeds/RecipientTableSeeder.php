<?php

use Illuminate\Database\Seeder;

class RecipientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('recipients')->insert([
           'name' => 'Moses Adebayo',
           'email' => 'mos.adebayo@gmail.com',
           'created_at' => date("Y-m-d h:i:sa"),
        ]);
    }
}
