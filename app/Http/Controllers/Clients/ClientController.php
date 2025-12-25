<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use App\Models\Client;
use App\Models\ClientBank;
use App\Services\ClientService;
use App\Services\ClientBankService;
use App\Services\CompanyService;
use App\Services\FileStorageService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ClientController extends Controller
{
    public function __construct(
        private ClientService $clientService,
        private ClientBankService $clientBankService,
        private FileStorageService $fileStorageService,
        private CompanyService $companyService,
    ) {
    }

    public function index()
    {
        $clients = $this->clientService->getAll()->sortByDesc('id');
        // return $clients;
        return view('content.clients.index', compact('clients'));
    }



    public function create()
    {
        $data = getCountries();
        $country = $data['country'] ?? null;
        $states = $data['states'] ?? [];
        $cities = $data['cities'] ?? [];
        // return $cities;
        return view('content.clients.create', compact('country', 'states', 'cities'));
    }

    public function show($id)
    {
        $client = $this->clientService->find($id);
        $client->load(['banks', 'families']);
        $client = $this->addFileUrls($client);

        // return $client;
        $clientBank = ClientBank::where('client_id', $id)->get();

        $clientBanks = $clientBank->map(function ($bank) {
            return $this->clientBankService->addFileUrls($bank);
        });
        // return $clientBank;
        // $client = $this->clientService->find($clientBank->client_id);
        // return $clientBank;
        return view('content.clients.view', compact('client', 'clientBank'));
    }



    // public function store(Request $request)
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
        $cities = $data['cities'] ?? [];

        // return $country;
        return view('content.clients.edit', compact('client', 'country', 'states', 'cities'));
    }

    public function update(ClientRequest $request, $id)
    {
        // return $request;
        $client = $this->clientService->find($id);
        unset($client['is_approved']);
        // return $client;
        DB::transaction(function () use ($request, $client) {
            $this->clientService->update($client, $request->validated());

            // if ($request->has('banks')) {
            //     $client->banks()->delete();

            //     foreach ($request->banks as $bankData) {
            //         if (!empty($bankData['ifsc_code']) && !empty($bankData['account_number'])) {
            //             $bankData['client_id'] = $client->id;
            //             $this->clientBankService->create($bankData);
            //         }
            //     }
            // }
        });

        return redirect()->route('clients.edit', $id)->with('success', 'Client updated successfully');
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
            'attachment_other_documents',
        ];

        foreach ($fileFields as $field) {
            if ($client->$field) {
                $client->{$field . '_url'} = $this->fileStorageService->getTemporaryUrl($client->$field);
            }
        }

        return $client;
    }



    public function approve($id)
    {
        // return 'approve';
        $this->clientService->approve($id);
        return redirect()->route('clients.index')->with('success', 'Client approved successfully');
    }

    public function sendFestivalMail(Request $request)
    {
        // return 'send festival mail';
        $clients = Client::get(); // or filter based on festival logic

        foreach ($clients as $client) {
            try {

                Mail::send(
                    'emails.christmas-wish',
                    compact('client'),
                    function ($message) use ($client) {
                        if (!empty($client->email)) {
                            $message->to($client->email);
                        }

                        $message->subject('Merry Christmas! 🎄');
                    }
                );


                // ✅ SUCCESS LOG
                Log::info('Festival mail sent successfully', [
                    'client_id' => $client->id,
                    'email' => $client->email,
                ]);
            } catch (\Exception $e) {

                // ❌ FAILURE LOG
                Log::error('Festival mail failed', [
                    'client_id' => $client->id,
                    'email' => $client->email,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return back()->with('success', 'Festival emails processed successfully.');
    }
}
