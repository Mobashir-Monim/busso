<?php

namespace App\Helpers\UserHelpers;

use App\Helpers\Helper;
use Laravel\Passport\Passport;
use Illuminate\Support\Str;

class AccessClientHelper extends Helper
{
    protected $client;
    protected $access_client;
    protected $status = ['client' => null, 'access_client' => null];

    public function __construct()
    {
        $this->client = Passport::client()->where('name', 'BuSSO')->first();
        $this->setStatus();
        $this->updateClients();
    }

    public function setStatus()
    {
        if (is_null($this->client)) {
            $this->status = ['client' => 'create', 'access_client' => 'create'];
        } else {
            if ($this->client->revoked)
                $this->status['client'] = 'unrevoke';

            $this->access_client = Passport::personalAccessClient()->where('client_id', $this->client->id)->first();

            if (is_null($this->access_client))
                $this->status['access_client'] = 'create';
        }
    }

    public function updateClients()
    {
        if ($this->status['client'] == 'create')
            $this->createClient();

        if ($this->status['client'] == 'unrevoke')
            $this->unrevokeClient();

        if ($this->status['access_client'] == 'create')
            $this->createAccessClient();
    }

    public function createClient()
    {
        $this->client = Passport::client()->create([
            'name' => 'BuSSO',
            'secret' => Str::random(rand(80, 100)),
            'personal_access_client' => true,
            'password_client' => true,
            'redirect' => 'http://localhost',
            'revoked' => false,
        ]);
    }

    public function unrevokeClient()
    {
        $this->client->secret = Str::random(rand(80, 100));
        $this->client->revoked = false;
        $this->client->save();
    }

    public function createAccessClient()
    {
        Passport::personalACcessClient()->create(['client_id' => $this->client->id]);
    }
}