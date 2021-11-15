<?php

namespace App\Debuggers;

use App\Models\Debugger as DM;

class Debugger
{
    protected $debugger_model;
    protected $debug_data;
    protected $interrupt_count = 0;

    public function __construct($identifier, $debug_data)
    {
        $this->debugger_model = DM::where('identifier', $identifier)->first();
        $this->debug_data = $debug_data;
    }

    public function interrupt()
    {
        if ($this->debugger_model->is_active) {
            $this->interrupt_count += 1;
            abort(302, '', ['Location' => route('debugger.debug') . "?debug_data=" . urlencode(json_encode($this->debug_data))]);
        }
    }
}