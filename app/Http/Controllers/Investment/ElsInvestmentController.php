<?php

namespace App\Http\Controllers\Investment;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\ClientBank;
use App\Models\ClientFamily;
use App\Services\ClientService;
use Illuminate\Http\Request;

class ElsInvestmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('content.investment.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $client = Client::with('ClientBank', 'ClientFamily')->get();

        return $client;
        return view('content.investment.create', compact('client'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
