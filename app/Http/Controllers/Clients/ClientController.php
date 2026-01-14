<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use App\Models\Client;
use App\Models\ClientBank;
use App\Services\ClientService;
use App\Services\ClientBankService;
use App\Services\CompanyService;
use App\Services\FamilyRelationService;
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
        private FamilyRelationService $familyRelationService
    ) {}

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


    public function clientOnboarding()
    {
        $data = getCountries();
        $country = $data['country'] ?? null;
        $states = $data['states'] ?? [];
        $cities = $data['cities'] ?? [];
        $relations = $this->familyRelationService->getByGender('male');
        return view('content.clients.create-client-form', compact('country', 'states', 'cities', 'relations'));
    }

    public function saveClientOnboarding(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mobile' => 'required|string|max:15',
            'pan_number' => 'required|string|size:10',
            'aadhar_number' => 'required|string|size:12',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'pincode' => 'required|string|max:10',
        ], [], [
            'first_name' => 'content.clients.create-client-form.first_name',
            'last_name' => 'content.clients.create-client-form.last_name',
            'email' => 'content.clients.create-client-form.email',
            'mobile' => 'content.clients.create-client-form.mobile',
            'pan_number' => 'content.clients.create-client-form.pan_number',
            'aadhar_number' => 'content.clients.create-client-form.aadhar_number',
            'date_of_birth' => 'content.clients.create-client-form.date_of_birth',
            'gender' => 'content.clients.create-client-form.gender',
            'address' => 'content.clients.create-client-form.address',
            'city' => 'content.clients.create-client-form.city',
            'state' => 'content.clients.create-client-form.state',
            'country' => 'content.clients.create-client-form.country',
            'pincode' => 'content.clients.create-client-form.pincode',
        ]);

        return redirect()->route('client.form')->with('success', 'Thank you for submitting the client onboarding form.');
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

    public function welcomeLetter($id)
    {
        $client = $this->clientService->find($id);
        $client->load(['banks', 'families']);
        $company = $this->companyService->findFirstOrFail();
        // return $client;
        return view('content.clients.welcome-letter', compact('client', 'company'));
    }

    public function downloadKycPdf($id)
    {
        $client = $this->clientService->find($id);
        $client->load(['banks', 'families']);
        $client = $this->addFileUrls($client);
        $safeClientCode = preg_replace('/[\/\\\\]/', '-', $client->client_code);
        $fileName = 'KYC_' . $safeClientCode . '.pdf';
        $pdf = Pdf::loadView('content.clients.pdf.kyc', compact('client'))
            ->setPaper('A4', 'portrait');

        return $pdf->download($fileName);
    }

    public function kycBalnkForm()
    {
        $pdf = Pdf::loadView('content.clients.client-primary-info-print')
            ->setPaper('A4', 'portrait');
        return $pdf->download('client_primary_information.pdf');
        // return $pdf->stream('client_primary_information.pdf');
    }
}
