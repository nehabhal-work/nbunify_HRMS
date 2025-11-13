<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientFamilyRequest;
use App\Models\Client;
use App\Models\ClientFamily;
use App\Services\ClientFamilyService;

class ClientFamilyController extends Controller
{
    public function __construct(private ClientFamilyService $clientFamilyService) {}

    public function index($client = null)
    {
        if ($client) {
            $clientFamilies = ClientFamily::with(['client', 'relation'])->where('client_id', $client)->get();
        } else {
            $clientFamilies = ClientFamily::with(['client', 'relation'])->get();
        }
        return view('content.clients.families.index', compact('clientFamilies', 'client'));
    }

    public function create($client = null)
    {
        return $client;
        $clientData = null;
        if ($client) {
            $clientData = Client::find($client);
            return 'if part';
        } else {
            return 'else part';
        }
        return $clientData;
        return view('content.clients.families.create', compact('client'));
    }

    public function store(ClientFamilyRequest $request)
    {
        $this->clientFamilyService->create($request->validated());
        return redirect()->route('client-families.index')->with('success', 'Client family member created successfully');
    }

    public function edit(ClientFamily $clientFamily)
    {
        return view('content.clients.families.edit', compact('clientFamily'));
    }

    public function update(ClientFamilyRequest $request, ClientFamily $clientFamily)
    {
        $this->clientFamilyService->update($clientFamily, $request->validated());
        return redirect()->route('client-families.index')->with('success', 'Client family member updated successfully');
    }

    public function destroy(ClientFamily $clientFamily)
    {
        $this->clientFamilyService->delete($clientFamily);
        return redirect()->route('client-families.index')->with('success', 'Client family member deleted successfully');
    }
}
