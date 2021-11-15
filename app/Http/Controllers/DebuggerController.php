<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Debugger;

class DebuggerController extends Controller
{
    public function index()
    {
        return view('debugger.index', [
            'debug_items' => Debugger::paginate(10)
        ]);
    }

    public function create()
    {
        return view('debugger.create');
    }

    public function store(Request $request)
    {
        Debugger::create(json_decode($request->config, true));

        flash('Debugger successfully created')->success();

        return redirect()->route('debugger');
    }

    public function show(Debugger $item, Request $request)
    {
        return view('debugger.show', [
            'item' => $item
        ]);
    }

    public function update(Debugger $item, Request $request)
    {
        $item->update(json_decode($request->config, true));

        flash('Debugger successfully updated')->success();

        return redirect()->route('debugger.settings', ['item' => $item->id]);
    }

    public function delete(Debugger $item, Request $request)
    {
        $item->delete();

        flash('Debugger successfully deleted')->success();

        return redirect()->route('debugger');

    }

    public function debug(Request $request)
    {
        return view('debugger.debug', [
            'debug_data' => $request->debug_data
        ]);
    }
}
