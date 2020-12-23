<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $table->string('name', 80);
        //     $table->string('display_name', 80);
        //     $table->boolean('is_system_role')->default(false);
        //     $table->string('description')->nullable();

        $roles = [
            ['name' => 'super-admin', 'display_name' => 'Super Admin', 'is_system_role' => true, 'description' => 'Super admin access to the entire application'],
            ['name' => 'user-admin', 'display_name' => 'User Admin', 'is_system_role' => true, 'description' => 'User admin access to the entire application'],
            ['name' => 'resource-admin', 'display_name' => 'Resource Admin', 'is_system_role' => true, 'description' => 'Resource admin access to the entire application'],
            ['name' => 'system-user', 'display_name' => 'System User', 'is_system_role' => true, 'description' => 'Normal system user'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
