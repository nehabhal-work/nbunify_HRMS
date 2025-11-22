<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;

class EmployeeController extends Controller
{
    public function index()
    {
        return view('content.master.employees.index');
    }

    public function create()
    {
        $data = getCountries();
        $country = $data['country'] ?? null;
        $states = $data['states'] ?? [];
        $cities = $data['cities'] ?? [];
        return view('content.master.employees.create', compact('country', 'states', 'cities'));
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
        $data = getCountries();
        $country = $data['country'] ?? null;
        $states = $data['states'] ?? [];
        $cities = $data['cities'] ?? [];
        return view('content.master.employees.edit', compact('country', 'states', 'cities'));
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
