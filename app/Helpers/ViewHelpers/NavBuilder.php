<?php

namespace App\Helpers\ViewHelpers;

use App\Helpers\Helper;

class NavBuilder extends Helper
{
    protected $navItems = [
        'super-admin' => [
            'resource-group',
            'role',
            'scope',
            'user-attribute',
            'user-attribute-value',
            'user',
            'claim'
        ],
        'user-admin' => [
            'user',
            'role',
            'user-attribute',
            'user-attribute-value',
        ],
        'resource-admin' => [
            'resource-group',
            'scope',
            'claim',
            'user-attribute-value',
        ],
        'system-user' => [
            
        ]
    ];

    public function getNavItems()
    {
        return $this->navItems[auth()->user()->roles->where('is_system_role', true)->first()->name];
    }
}