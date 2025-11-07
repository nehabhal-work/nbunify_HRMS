<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;

class ClientController extends Controller
{
    public function index()
    {
        return view('content.master.clients.index');
    }

    public function create()
    {
        return view('content.master.clients.create');
    }

    public function store()
    {
        return redirect()->route('master.clients.index');
    }

    public function edit($id)
    {
        return view('content.master.clients.edit');
    }

    public function update($id)
    {
        return redirect()->route('master.clients.index');
    }

    public function destroy($id)
    {
        return redirect()->route('master.clients.index');
    }
}