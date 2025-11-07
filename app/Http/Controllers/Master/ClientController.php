<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;

class ClientController extends Controller
{
    public function index()
    {
        return view('content.clients.index');
    }

    public function create()
    {
        return view('content.clients.create');
    }

    public function store()
    {
        return redirect()->route('clients.index');
    }

    public function edit($id)
    {
        return view('content.clients.edit');
    }

    public function update($id)
    {
        return redirect()->route('clients.index');
    }

    public function destroy($id)
    {
        return redirect()->route('clients.index');
    }
}
