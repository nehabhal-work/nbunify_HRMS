<?php

namespace App\Http\Controllers;

use App\Http\Requests\PreClientRequest;
use App\Models\PreClient;
use App\Models\PreClientBank;
use App\Services\FamilyRelationService;
use App\Services\PreClientService;
use App\Services\PreClientBankService;
use App\Services\FileStorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PreClientController extends Controller
{
    public function __construct(
        private PreClientService $preClientService,
        private PreClientBankService $preClientBankService,
        private FileStorageService $fileStorageService,
        private FamilyRelationService $familyRelationService
    ) {}

    public function index()
    {
        $preclients = $this->preClientService->getAll()->sortByDesc('id');
        return view('content.clients.preclients.index', compact('preclients'));
    }





    public function create()
    {
        $data = getCountries();
        $country = $data['country'] ?? null;
        $states = $data['states'] ?? [];
        $cities = $data['cities'] ?? [];
        $relations = $this->familyRelationService->getByGender('male');
        return view('content.clients.create-client-form', compact('country', 'states', 'cities', 'relations'));
    }

    public function show($id)
    {
        $preclient = $this->preClientService->find($id);
        $preclient->load(['banks', 'families']);
        $preclient = $this->addFileUrls($preclient);
        // return $preclient;
        $preClientBanks = PreClientBank::where('preclient_id', $id)->get();
        $preClientBanks = $preClientBanks->map(function ($bank) {
            return $this->preClientBankService->addFileUrls($bank);
        });

        return view('content.clients.preclients.view', compact('preclient', 'preClientBanks'));
    }

    public function store(Request $request)
    // public function store(PreClientRequest $request)
    {
        // return $request;
        try {
            $preclient = null;
            DB::transaction(function () use ($request, &$preclient) {
                // Create PreClient
                $preClientData = $request->only([
                    'name',
                    'gender',
                    'dob',
                    'live_status',
                    'dod',
                    'marital_status',
                    'nationality',
                    'occupation',
                    'pan_no',
                    'aadhar_no',
                    'ckyc_no',
                    'mobile_no',
                    'whatsapp_no',
                    'landline_no',
                    'email',
                    'res_address',
                    'res_country',
                    'res_country_code',
                    'res_state',
                    'res_state_code',
                    'res_city',
                    'res_city_code',
                    'res_pincode',
                    'office_address',
                    'office_country',
                    'office_country_code',
                    'office_state',
                    'office_state_code',
                    'office_city',
                    'office_city_code',
                    'office_pincode',
                    'relation_manager_id',
                    'remarks'
                ]);
                $preclient = $this->preClientService->create($preClientData);

                // Create Family Member if data exists
                if ($request->filled('family_name')) {
                    $familyData = [
                        'name' => $request->family_name,
                        'gender' => $request->family_gender,
                        'dob' => $request->family_dob,
                        'live_status' => $request->family_live_status,
                        'dod' => $request->family_dod,
                        'marital_status' => $request->family_marital_status,
                        'nationality' => $request->family_nationality,
                        'occupation' => $request->family_occupation,
                        'mobile_no' => $request->family_mobile_no,
                        'whatsapp_no' => $request->family_whatsapp_no,
                        'landline_no' => $request->family_landline_no,
                        'pan_no' => $request->family_pan_no,
                        'aadhar_no' => $request->family_aadhar_no,
                        'email' => $request->family_email,
                        'relation_id' => $request->relation_id,
                    ];
                    $preclient->families()->create($familyData);
                }

                // Create Bank Details if data exists
                if ($request->filled('ifsc_code') && $request->filled('account_number')) {
                    $bankData = [
                        'preclient_id' => $preclient->id,
                        'ifsc_code' => $request->ifsc_code,
                        'account_number' => $request->account_number,
                        'account_type' => $request->account_type,
                        'operation_mode' => $request->operation_mode,
                        'holder_name_1' => $request->holder_name_1,
                        'holder_name_2' => $request->holder_name_2,
                        'holder_name_3' => $request->holder_name_3,
                        'micrcode' => $request->micrcode,
                        'bank_name' => $request->bank_name,
                        'branch_name' => $request->branch_name,
                        'bank_code' => $request->bank_code,
                    ];
                    $this->preClientBankService->create($bankData);
                }
            });

            return view('content.clients.preclients.thankyou');
            return response()->json([
                'message' => 'PreClient created successfully',
                'preclient' => $preclient,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error creating PreClient: ' . $e->getMessage(),
            ], 500);
        }

        // return redirect()->route('preclients.index')->with('success', 'PreClient created successfully');
    }


    // public function edit($id)
    // {
    //     $preclient = $this->preClientService->find($id);
    //     $preclient->load(['banks', 'families']);
    //     $preclient = $this->addFileUrls($preclient);

    //     $data = getCountries();
    //     $country = $data['country'] ?? null;
    //     $states = $data['states'] ?? [];
    //     $cities = $data['cities'] ?? [];

    //     return view('content.preclients.edit', compact('preclient', 'country', 'states', 'cities'));
    // }

    // public function update(PreClientRequest $request, $id)
    // {
    //     $preclient = $this->preClientService->find($id);

    //     DB::transaction(function () use ($request, $preclient) {
    //         $this->preClientService->update($preclient, $request->validated());
    //     });

    //     return redirect()->route('preclients.edit', $id)->with('success', 'PreClient updated successfully');
    // }

    public function destroy($id)
    {
        $preclient = $this->preClientService->find($id);
        $this->preClientService->delete($preclient);
        return redirect()->route('content.clients.preclients.index')->with('success', 'PreClient deleted successfully');
    }

    private function addFileUrls($preclient)
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
            if ($preclient->$field) {
                $preclient->{$field . '_url'} = $this->fileStorageService->getTemporaryUrl($preclient->$field);
            }
        }

        return $preclient;
    }
}
