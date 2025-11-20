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
        $clients = Client::with('banks')->get();
        return view('content.clients.index', compact('clients'));
    }

    public function create()
    {

        // curl_setopt_array($curl, array(
        //     CURLOPT_URL => "https://api.countrystatecity.in/v1/countries/{$countryCode}",
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_HTTPHEADER => array(
        //         'X-CSCAPI-KEY: Q2lrMzdpZ3FmZ2JGS29jczFLb0RRSkppZ0pqTUx0dFhyOHhsYzFlVg=='
        //     ),
        // ));

        // Call API
        $countryCode = 'IN';
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.countrystatecity.in/v1/countries/{$countryCode}/states",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'X-CSCAPI-KEY: Q2lrMzdpZ3FmZ2JGS29jczFLb0RRSkppZ0pqTUx0dFhyOHhsYzFlVg=='
            ],
        ]);

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($httpCode == 200) {
            $countries = json_decode($response, true);
        } else {
            $countries = "Country not found";
        }

        return $countries;
        return view('content.clients.create', compact('countries'));
    }

    public function show($id)
    {
        $client = $this->clientService->find($id);
        $client->load('banks');
        $client->load('families.relation');
        $client = $this->addFileUrls($client);
        return view('content.clients.view', compact('client'));
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

    public function edit($id)
    {
        $client = $this->clientService->find($id);
        $client->load('banks');
        $client = $this->addFileUrls($client);
        return view('content.clients.edit', compact('client'));
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
