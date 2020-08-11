<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$roleSuperAdmin = Role::create(['id'=>1,'name' => 'Супер-Администратор']);
		$roleAdmin = Role::create(['id'=>2,'name' => 'Администратор']);
		$roleModerator = Role::create(['id'=>3,'name' => 'Модератор']);
		$roleUser = Role::create(['id'=>4,'name' => 'Пользователь','default' => '1']);
		
		$permission = Permission::create(['id'=>1,'name' => 'Полный доступ']);
		$roleSuperAdmin->givePermissionTo($permission); 
		
		$permission = Permission::create(['id'=>2,'name' => 'Полный доступ без админки']);	
		$roleSuperAdmin->givePermissionTo($permission); 
		$roleAdmin->givePermissionTo($permission); 	
		
		User::find(1)->assignRole(1); 
    }
}
