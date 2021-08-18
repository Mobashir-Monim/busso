<?php

namespace App\Helpers\UserHelpers;

use App\Helpers\Helper;
use App\Helpers\ChangeLogHelpers\User\LogHelper;

class Updator extends Helper
{
    public $user;
    public $update_data;

    public function __construct($user, $update_data)
    {
        $this->user = $user;

        if (array_key_exists('is_active', $update_data))
            $update_data['is_active'] = !$user->is_active;
    
        $this->update_data = $update_data;
        }

    public function update()
    {
        new LogHelper($this->user, 'update', $this->update_data);
        
        foreach (['name', 'is_active'] as $attribute) {
            if (array_key_exists($attribute, $this->update_data))
                $this->user->$attribute = $this->update_data[$attribute];
        }
        
        $this->user->save();
    }
}