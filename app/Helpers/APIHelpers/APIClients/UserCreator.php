<?php

namespace App\Helpers\APIHelpers\APIClients;

use App\Helpers\Helper;
use App\Models\User;

class UserCreator extends Helper
{
    protected $client;
    protected $resource_group;

    public function __construct($resource_group, $client)
    {
        $this->client = $client;
        $this->resource_group = $resource_group;

        if (!$this->client->user_attached) {
            $this->attachUser();
        }
    }

    public function attachUser()
    {
        $user = User::create([
            'name' => $this->getUserName(),
            'email' => $this->resource_group->id . "@eauth.eveneer.xyz",
            'password' => bcrypt($this->resource_group->id),
            'force_reset' => false,
            'is_client' => true
        ]);

        $this->client->user_attached = true;
        $this->client->save();
    }

    public function getUserName()
    {
        if (strlen($this->resource_group->name) > 230)
            return substr($this->resource_group->name, 0, 230) . "... client user";

        return $this->resource_group->name . " client user";
    }
}