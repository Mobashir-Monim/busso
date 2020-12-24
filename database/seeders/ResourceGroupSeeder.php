<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ResourceGroup as RG;
use App\Helpers\SSOHelpers\RGOnboarder;

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
            $group = RG::create(['name' => "RG $i", 'url' => "http://127.0.0.1:800$i"]);
            $helper = new RGOnboarder($group);
            $helper->onboardGroup(json_decode(json_encode(['name' => "RG $i", 'url' => "http://127.0.0.1:800$i/oauth/callback"])));
            $entity = $group->saml;
            $entity->acs = "http://127.0.0.1:800$i/saml";
            $entity->save();
        }
    }
}
