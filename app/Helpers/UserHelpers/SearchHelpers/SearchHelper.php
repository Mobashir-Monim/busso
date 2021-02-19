<?php

namespace App\Helpers\UserHelpers\SearchHelpers;

use App\Helpers\Helper;
use App\Helpers\UserHelpers\SearchHelpers\EmailSearch;
use App\Helpers\UserHelpers\SearchHelpers\RoleSearch;
use App\Models\User;

class SearchHelper extends Helper
{
    protected $phrase;
    protected $type;

    public function __construct($request)
    {
        $this->phrase = $request->search_pharse;
        $this->type = explode(" ", $request->type);
    }

    public function searchUsers()
    {
        if (in_array('email', $this->type)) {
            
        } elseif (in_array('role', $this->type)) {

        } else {
            return User::paginate(30);
        }
    }
}

// <option value="email @bracu.ac.bd">@bracu.ac.bd Email</option>
// <option value="email @g.bracu.ac.bd">@g.bracu.ac.bd Email</option>
// <option value="email non-bracu">Non BracU Email</option>
// <option value="all">All email</option>
// <option value="email specific">Specific Email Address</option>
// <option value="role">Application Role</option>