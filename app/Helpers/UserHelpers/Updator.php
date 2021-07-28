<?php

namespace App\Helpers\UserHelpers;

use App\Helpers\Helper;

class Updator extends Helper
{
    public $user;
    public $update_data;

    public function __construct($user, $update_data)
    {
        $this->user = $user;
        $this->update_data = $update_data;
    }

    public function update()
    {
        if (array_key_exists('name', $this->update_data))
            $this->user->name = $this->update_data['name'];

        if (array_key_exists('is_active', $this->update_data))
            $this->user->is_active = !$this->user->is_active;

        $this->user->save();
    }
}