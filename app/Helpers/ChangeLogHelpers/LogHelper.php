<?php

namespace App\Helpers\ChangeLogHelpers;

use App\Helpers\Helper;

class LogHelper extends Helper
{
    protected $request;
    public $x = 'App\Helpers\ChangeLogHelpers\UserLogHelper';

    public function __construct()
    {
        dd(request()->route()->getName(), new $this->x());
        $this->request = request();
    }
}