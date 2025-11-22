<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use App\Models\Client;
use App\Services\ClientService;
use App\Services\ClientBankService;
use App\Services\FileStorageService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ClientController extends Controller
{
    public function __construct(
        private ClientService $clientService,
        private ClientBankService $clientBankService,
        private FileStorageService $fileStorageService,
    ) {}

    public function index()
    {
        $clients = Client::with(['banks', 'families'])->get();
        return view('content.clients.index', compact('clients'));
    }

    public function create()
    {

        $data = getCountries();
        $country = $data['country'] ?? null;
        $states = $data['states'] ?? [];
        $cities  = $data['cities'] ?? [];
        // return $country;
        return view('content.clients.create', compact('country', 'states', 'cities'));
    }

    public function show($id)
    {
        $client = $this->clientService->find($id);
        $client->load(['banks', 'families']);
        $client = $this->addFileUrls($client);
        return view('content.clients.view', compact('client'));
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

    public function edit($id)
    {
        $client = $this->clientService->find($id);
        $client->load(['banks', 'families']);
        $client = $this->addFileUrls($client);

        $data = getCountries();
        $country = $data['country'] ?? null;
        $states = $data['states'] ?? [];
        $cities  = $data['cities'] ?? [];

        return view('content.clients.edit', compact('client', 'country', 'states', 'cities'));
    }

    public function update(ClientRequest $request, $id)
    {
        $client = $this->clientService->find($id);
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

    public function destroy($id)
    {
        $client = $this->clientService->find($id);
        $this->clientService->delete($client);
        return redirect()->route('clients.index')->with('success', 'Client deleted successfully');
    }

    private function addFileUrls($client)
    {
        $fileFields = [
            'attachment_client_photo',
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
