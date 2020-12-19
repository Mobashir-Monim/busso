<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ResourceGroup as RG;

class ResourceGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) {
            RG::create(['name' => "RG $i", 'url' => "http://127.0.0.1:800$i"]);
        }
    }
}
