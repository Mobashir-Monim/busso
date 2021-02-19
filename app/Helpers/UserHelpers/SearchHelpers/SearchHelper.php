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
            return (new EmailSearch($this->type[1]))->searchUsers($this->phrase);
        } elseif (in_array('role', $this->type)) {
            return (new RoleSearch($this->type[1]))->searchUsers($this->phrase);
        } else {
            return User::paginate(30);
        }
    }

    public static function getTypes()
    {
        return [
            ["email @bracu.ac.bd", "@bracu.ac.bd Email"],
            ["email @g.bracu.ac.bd", "@g.bracu.ac.bd Email"],
            ["email non-bracu", "Non BracU Email"],
            ["email specific", "Specific Email Address"],
            ["all", "All Users"],
            ["role application", "Application Role"],
            ["role system", "System Role"],
        ];
    }

    public static function getType($type)
    {
        $types = self::getTypes();

        foreach ($types as $searchType) {
            if ($type == $searchType[0]) {
                return $searchType;
            }
        }
    }
}