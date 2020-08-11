<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$lastInsertId = DB::table('users')->insertGetId([
			'id'=>1,
            'name' => 'yanzlatov',
            'email' => 'yanzlatov@gmail.com',
            'roles' => '1',
            'password' => bcrypt('zlatov2626'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'), 
            'info' => json_encode(array()), 
        ]);
    }
}
