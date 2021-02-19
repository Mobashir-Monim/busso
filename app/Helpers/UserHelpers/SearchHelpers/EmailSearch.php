<?php

namespace App\Helpers\UserHelpers\SearchHelpers;

use App\Helpers\Helper;
use App\Models\User;

class EmailSearch extends Helper
{
    protected $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function searchUsers($phrase)
    {
        if ($this->type == '@bracu.ac.bd' || $this->type == '@g.bracu.ac.bd') {
            return $this->getOrgUsers();
        } elseif ($this->type == 'non-bracu') {
            return $this->getNonOrgUsers();
        } else {
            return $this->getUser($phrase);
        }
    }

    public function getOrgUsers()
    {
        return User::where('email', 'like', "%$this->type")->paginate(30);
    }

    public function getNonOrgUsers()
    {
        return User::where('email', 'not like', "%@g.bracu.ac.bd")->where('email', 'not like', "%@g.bracu.ac.bd")->paginate(30);
    }

    public function getUser($phrase)
    {
        return User::where('email', $phrase)->paginate(30);
    }
}