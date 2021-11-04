<?php

namespace App\Debuggers;

use App\Models\Debugger as DM;

class Debugger
{
    protected $debugger_model;

    public function __construct($identifier)
    {
        $this->debugger_model = DM::where('identifier', $identifier)->first();
    }
}