<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	
        for($i = 2; $i < 100; $i++){
	        DB::table('users')->insert([
	        	'id' => $i,
	            'name' => Str::random(10),
	            'firstname' => Str::random(10),
	            'tel' => Str::random(10),
	            'email' => Str::random(10).'@gmail.com',
	            'type' => 'PRO',
	            'password' => Hash::make('password'),
	        ]);
    	}

    }
}
