<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Spatie\Permission\Models\Role;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Nadia Yasin', 
            'email' => 'nadookh4@gmail.com',
            'password' => bcrypt('123456789'),
            // ["owner"] لازم قوسين المصفوفة لانه ممكن تتغير باكتر من خاصية وصلاحية
            'roles_name' => ["owner"],

            'Status' => 'مفعل',
            ]);
      
            $role = Role::create(['name' => 'owner']);
       
            $permissions = Permission::pluck('id','id')->all();
      
            $role->syncPermissions($permissions);
       
            $user->assignRole([$role->id]);
    
    }
}
