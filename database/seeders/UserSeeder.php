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
        $users = [
            ['name' => 'Mobashir Monim', 'email' => 'mobashirmonim@gmail.com', 'password' => bcrypt('lalaland'), 'is_active' => true, 'force_reset' => false],
            ['name' => 'n_edunext_support', 'email' => 'support@edunext.co', 'password' => bcrypt("Qdpa5K'(<NK)_B#"), 'force_reset' => false],
        ];

        foreach ($users as $user) {
            User::create($user);
        }

        User::where('email', 'mobashirmonim@gmail.com')->first()->roles()->attach(Role::where('name', 'super-admin')->first()->id);
    }
}
