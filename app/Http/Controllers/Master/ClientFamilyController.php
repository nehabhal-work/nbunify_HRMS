<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;

class ClientFamilyController extends Controller
{
    public function index()
    {
        return view('content.clients.families.index');
    }

    public function create()
    {
        return view('content.clients.families.create');
    }

    public function store()
    {
        return redirect()->route('client-families.index');
    }

    public function edit($id)
    {
        return view('content.clients.families.edit');
    }

    public function update($id)
    {
        return redirect()->route('client-families.index');
    }

    public function destroy($id)
    {
        return redirect()->route('client-families.index');
    }
}
