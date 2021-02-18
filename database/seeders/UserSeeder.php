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
            // ['name' => 'Mobashir Monim', 'email' => 'mobashir.monim@bracu.ac.bd', 'password' => bcrypt('lalaland')],
            // ['name' => 'Mobashir Monim', 'email' => 'ext.mobashir.monim@bracu.ac.bd', 'password' => bcrypt('lalaland')],
            // ['name' => 'Mahbub Majumdar', 'email' => 'majumdar@bracu.ac.bd', 'password' => bcrypt('lalaland')],
            // ['name' => 'Sadia Hamid Kazi', 'email' => 'skazi@bracu.ac.bd', 'password' => bcrypt('lalaland')],
            // ['name' => 'Matin Saad Abdullah', 'email' => 'mabdullah@bracu.ac.bd', 'password' => bcrypt('lalaland')],
            // ['name' => 'Arif Shakil', 'email' => 'arif.shakil@bracu.ac.bd', 'password' => bcrypt('lalaland')],
            // ['name' => 'Ahnaf Atef Choudhury', 'email' => 'ahnaf.atef@bracu.ac.bd', 'password' => bcrypt('lalaland')],
            // ['name' => 'Tester', 'email' => 'tester@email.com', 'password' => bcrypt('l6LL6vemXhCaSrt')],
        ];

        foreach ($users as $user) {
            User::create($user);
        }

        User::where('email', 'mobashirmonim@gmail.com')->first()->roles()->attach(Role::where('name', 'super-admin')->first()->id);
    }
}
