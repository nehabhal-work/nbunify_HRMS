<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;

class EmployeeController extends Controller
{
    public function index()
    {
        return view('content.master.employees.index');
    }

    public function create()
    {
        return view('content.master.employees.create');
    }

    public function store()
    {
        return redirect()->route('master.employees.index');
    }

    // public function show($id)
    // {
    //     return view('content.master.employees.show');
    // }

    public function edit($id)
    {
        return view('content.master.employees.edit');
    }

    public function update($id)
    {
        return redirect()->route('master.employees.index');
    }

    public function destroy($id)
    {
        return redirect()->route('master.employees.index');
    }
}
