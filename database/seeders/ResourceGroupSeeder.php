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
        // $types = ['saml', 'oauth', 'both'];
        $types = ['oauth'];
        
        for ($i = 1; $i <= 10; $i++) {
            $group = RG::create(['name' => "RG $i", 'url' => "http://127.0.0.1:800$i"]);
            $helper = new RGOnboarder($group);
            $helper->onboardGroup(json_decode(json_encode(
                ['name' => "RG $i",
                'url' => "http://127.0.0.1:800$i/oauth/callback",
                // "type" => $types[rand(0, 2)],
                "type" => $types[0],
                'endpoint' => "http://127.0.0.1:800$i/oauth/callback"]
            )));

            if (!is_null($group->saml)) {
                $entity = $group->saml;
                $entity->acs = "http://127.0.0.1:800$i/saml";
                $entity->save();
            }
        }
    }
}
