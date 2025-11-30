<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientFamilyRequest;
use App\Models\Client;
use App\Services\ClientFamilyService;
use App\Services\ClientService;
use App\Services\FamilyRelationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ClientFamilyController extends Controller
{
    public function __construct(
        private ClientFamilyService $clientFamilyService,
        private ClientService $clientService,
        private FamilyRelationService $familyRelationService
    ) {}

    public function index(Request $request)
    {
        if ($client_id = $request->client_id) {
            $client = $this->clientService->find($client_id);
            $clientFamilies = $this->clientFamilyService->getByClient($client_id);
            return view('content.clients.families.index', compact('clientFamilies', 'client'));
        } else {
            abort(404);
        }
    }

    public function create(Request $request)
    {
        if ($client_id = $request->client_id) {
            $clients = $this->clientService->getAll();
            $client = $this->clientService->find($client_id);
            $relations = $this->familyRelationService->getByGender($client->gender);

            $data = getCountries();
            $country = $data['country'] ?? null;
            $states = $data['states'] ?? [];
            $cities  = $data['cities'] ?? [];

            return view('content.clients.families.create', compact('client', 'relations', 'clients', 'country', 'states', 'cities'));
        } else {
            abort(404);
        }
    }

    public function createFromExistingClient(Request $request)
    {
        // return $request;
        if ($client_id = $request->client_id) {
            $clients = $this->clientService->getAllExcept([$client_id]);
            $client = $this->clientService->find($client_id);
            $relations = $this->familyRelationService->getByGender($client->gender);

            return view('content.clients.families.create-existing', compact('client', 'relations', 'clients'));
        } else {
            abort(404);
        }
    }

    public function storeFromExistingClient(Request $request)
    {

        $request->validate([
            'existing_client_id' => 'required|exists:clients,id',
            'existing_relation_id' => 'required|exists:family_relations,id',
            'client_id' => 'required|exists:clients,id',
        ]);

        $client = $this->clientService->find($request->existing_client_id);

        $familyData = [
            'client_id' => $request->client_id,
            'client_code' => $client->client_code,
            'name' => $client->name,
            'gender' => $client->gender,
            'dob' => $client->dob,
            'live_status' => $client->live_status,
            'dod' => $client->dod,
            'marital_status' => $client->marital_status,
            'nationality' => $client->nationality,
            'occupation' => $client->occupation,
            'mobile_no' => $client->mobile_no,
            'whatsapp_no' => $client->whatsapp_no,
            'landline_no' => $client->landline_no,
            'email' => $client->email,
            'res_address' => $client->res_address,
            'res_country' => $client->res_country,
            'res_state' => $client->res_state,
            'res_city' => $client->res_city,
            'res_pincode' => $client->res_pincode,
            'office_address' => $client->office_address,
            'office_country' => $client->office_country,
            'office_state' => $client->office_state,
            'office_city' => $client->office_city,
            'office_pincode' => $client->office_pincode,
            'relation_id' => $request->existing_relation_id,
            'remarks' => $client->remarks,
        ];

        $this->clientFamilyService->create($familyData);
        return redirect()->route('client-families.index', ['client_id' => $request->client_id])->with('success', 'Client family member created successfully');
    }

    public function store(ClientFamilyRequest $request)
    {
        if ($request->family_source == 'existing') {
            $request->merge([
                'name' => Client::find($request->existing_client_id)->name,
                'relation_id' => $request->existing_relation_id,
            ]);
        } else {
            $request->merge([
                'name' => $request->new_name,
                'relation_id' => $request->new_relation_id,
            ]);
        }
        // return $request;

        $this->clientFamilyService->create($request->validated());
        return redirect()->route('client-families.index', ['client_id' => $request->client_id])->with('success', 'Client family member created successfully');
    }

    public function edit($id)
    {
        $clientFamily = $this->clientFamilyService->find($id);
        $client = $this->clientService->find($clientFamily->client_id);
        $relations = $this->familyRelationService->getByGender($client->gender);

        $data = getCountries();
        $country = $data['country'] ?? null;
        $states = $data['states'] ?? [];
        $cities  = $data['cities'] ?? [];

        return view('content.clients.families.edit', compact('clientFamily', 'client', 'relations', 'country', 'states', 'cities'));
    }

    public function update(ClientFamilyRequest $request, $id)
    {
        $clientFamily = $this->clientFamilyService->find($id);
        $this->clientFamilyService->update($clientFamily, $request->validated());
        return redirect()->route('client-families.index', ['client_id' => $clientFamily->client_id])->with('success', 'Client family member updated successfully');
    }

    public function destroy(Request $request, $id)
    {
        if ($client_id = $request->client_id) {

            $this->clientFamilyService->delete($id);

            return redirect()
                ->route('client-families.index', ['client_id' => $client_id])
                ->with('success', 'Family member deleted successfully.');
        }

        abort(404);
    }
}
