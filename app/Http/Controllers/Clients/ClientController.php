<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use App\Models\Client;
use App\Services\ClientService;
use App\Services\ClientBankService;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    public function __construct(
        private ClientService $clientService,
        private ClientBankService $clientBankService
    ) {}

    public function index()
    {
        $clients = Client::with('banks')->get();
        return view('content.clients.index', compact('clients'));
    }

    public function create()
    {
        return view('content.clients.create');
    }

    public function store(ClientRequest $request)
    {
        $client = null;
        DB::transaction(function () use ($request, &$client) {
            $client = $this->clientService->create($request->validated());

            if ($request->has('banks')) {
                foreach ($request->banks as $bankData) {
                    if (!empty($bankData['ifsc_code']) && !empty($bankData['account_number'])) {
                        $bankData['client_id'] = $client->id;
                        $this->clientBankService->create($bankData);
                    }
                }
            }
        });
        return redirect()->route('client-families.create', ['client_id' => $client->id])->with('success', 'Client created successfully');
    }

    public function edit(Client $client)
    {
        $client->load('banks');
        return view('content.clients.edit', compact('client'));
    }

    public function update(ClientRequest $request, Client $client)
    {
        DB::transaction(function () use ($request, $client) {
            $this->clientService->update($client, $request->validated());

            if ($request->has('banks')) {
                $client->banks()->delete();

                foreach ($request->banks as $bankData) {
                    if (!empty($bankData['ifsc_code']) && !empty($bankData['account_number'])) {
                        $bankData['client_id'] = $client->id;
                        $this->clientBankService->create($bankData);
                    }
                }
            }
        });

        return redirect()->route('clients.index')->with('success', 'Client updated successfully');
    }

    public function destroy(Client $client)
    {
        $this->clientService->delete($client);
        return redirect()->route('clients.index')->with('success', 'Client deleted successfully');
    }
}
