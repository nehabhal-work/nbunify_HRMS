<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientFamilyRequest;
use App\Services\ClientFamilyService;
use App\Services\ClientService;
use Illuminate\Http\Request;

class ClientFamilyController extends Controller
{
    public function __construct(
        private ClientFamilyService $clientFamilyService,
        private ClientService $clientService) {}

    public function index(Request $request)
    {
        if ($client_id = $request->client_id) {
            $client = $this->clientService->find($client_id);
            $clientFamilies = $this->clientFamilyService->getByClient($client_id);
            return view('content.clients.families.index', compact('clientFamilies', 'client'));
        } else {
            abort(401);
        }
    }

    public function create(Request $request)
    {
        if($client_id = $request->client_id) {
            $client = $this->clientService->find($client_id);
            return view('content.clients.families.create', compact('client'));
        } else {
            abort(401);
        }
    }

    public function store(ClientFamilyRequest $request)
    {
        $this->clientFamilyService->create($request->validated());
        return redirect()->route('client-families.index',['client_id' => $request->client_id])->with('success', 'Client family member created successfully');
    }

    public function edit($id)
    {
        $clientFamily = $this->clientFamilyService->find($id);
        return view('content.clients.families.edit', compact('clientFamily'));
    }

    public function update(ClientFamilyRequest $request, $id)
    {
        $this->clientFamilyService->update($id, $request->validated());
        return redirect()->route('client-families.index')->with('success', 'Client family member updated successfully');
    }

    public function destroy($id)
    {
        $this->clientFamilyService->delete($id);
        return redirect()->route('client-families.index')->with('success', 'Client family member deleted successfully');
    }
}
