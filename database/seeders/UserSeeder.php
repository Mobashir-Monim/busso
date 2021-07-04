<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            Role::where('name', 'super-admin')->first()->id,
            Role::where('name', 'user-admin')->first()->id,
            Role::where('name', 'resource-admin')->first()->id,
            Role::where('name', 'system-user')->first()->id
        ];
        $users = [
            ['name' => 'Mobashir Monim', 'email' => 'mobashirmonim@gmail.com', 'password' => bcrypt('lalaland'), 'is_active' => true, 'force_reset' => false],
            ['name' => 'n_edunext_support', 'email' => 'support@edunext.co', 'password' => bcrypt("Qdpa5K'(<NK)_B#"), 'force_reset' => false],
        ];
        
        // for ($i = 0; $i <= rand(1000, 10000); $i++) {
        //     $users[] = [
        //         'name' => "User $i",
        //         'email' => "user$i@gmail.com",
        //         'password' => bcrypt('lalaland'),
        //         'is_active' => true,
        //         'force_reset' => false
        //     ];
        // }

        foreach ($users as $user) {
            $attach = [rand(0, 1), rand(0, 1), rand(0, 1), rand(0, 1)];
            $user = User::create($user);

            foreach ($roles as $key => $role) {
                if ($attach[$key] >= 0.5)
                    $user->roles()->attach($role);
            }
        }

        User::where('email', 'mobashirmonim@gmail.com')->first()->roles()->attach($roles[0]);
        User::where('email', 'mobashirmonim@gmail.com')->first()->roles()->attach($roles[3]);
        User::where('email', 'support@edunext.co')->first()->roles()->attach($roles[3]);
    }
}
