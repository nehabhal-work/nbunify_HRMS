<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use App\Models\Client;
use App\Services\ClientService;
use App\Services\ClientBankService;
use App\Services\FileStorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    public function __construct(
        private ClientService $clientService,
        private ClientBankService $clientBankService,
        private FileStorageService $fileStorageService,
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
        // return $request;
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

    public function show(Client $client)
    {
        $client->load('banks');
        $client = $this->addFileUrls($client);
        return view('content.clients.show', compact('client'));
    }

    public function edit(Client $client)
    {
        $client->load('banks');
        $client = $this->addFileUrls($client);
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

    private function addFileUrls($client)
    {
        $fileFields = ['attachment_client_photo',
            'attachment_pan',
            'attachment_aadhar_front',
            'attachment_aadhar_back',
            'attachment_signature',
            'attachment_ckyc',
            'attachment_other_documents'
        ];

        foreach ($fileFields as $field) {
            if ($client->$field) {
                $client->{$field . '_url'} = $this->fileStorageService->getTemporaryUrl($client->$field);
            }
        }

        return $client;
    }
}
