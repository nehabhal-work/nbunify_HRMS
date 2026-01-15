<?php

namespace App\Http\Controllers;

use App\Http\Requests\PreClientRequest;
use App\Models\PreClient;
use App\Models\PreClientBank;
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
        private FileStorageService $fileStorageService
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
        return view('content.preclients.create', compact('country', 'states', 'cities'));
    }

    public function show($id)
    {
        $preclient = $this->preClientService->find($id);
        $preclient->load(['banks', 'families']);
        $preclient = $this->addFileUrls($preclient);

        $preClientBanks = PreClientBank::where('preclient_id', $id)->get();
        $preClientBanks = $preClientBanks->map(function ($bank) {
            return $this->preClientBankService->addFileUrls($bank);
        });

        return view('content.preclients.view', compact('preclient', 'preClientBanks'));
    }

    // public function store(Request $request)
    public function store(PreClientRequest $request)
    {
        return $request;
        $preclient = null;
        DB::transaction(function () use ($request, &$preclient) {
            $preclient = $this->preClientService->create($request->validated());

            if ($request->has('banks')) {
                foreach ($request->banks as $bankData) {
                    if (!empty($bankData['ifsc_code']) && !empty($bankData['account_number'])) {
                        $bankData['preclient_id'] = $preclient->id;
                        $this->preClientBankService->create($bankData);
                    }
                }
            }
        });

        return redirect()->route('preclients.index')->with('success', 'PreClient created successfully');
    }

    public function edit($id)
    {
        $preclient = $this->preClientService->find($id);
        $preclient->load(['banks', 'families']);
        $preclient = $this->addFileUrls($preclient);

        $data = getCountries();
        $country = $data['country'] ?? null;
        $states = $data['states'] ?? [];
        $cities = $data['cities'] ?? [];

        return view('content.preclients.edit', compact('preclient', 'country', 'states', 'cities'));
    }

    public function update(PreClientRequest $request, $id)
    {
        $preclient = $this->preClientService->find($id);

        DB::transaction(function () use ($request, $preclient) {
            $this->preClientService->update($preclient, $request->validated());
        });

        return redirect()->route('preclients.edit', $id)->with('success', 'PreClient updated successfully');
    }

    public function destroy($id)
    {
        $preclient = $this->preClientService->find($id);
        $this->preClientService->delete($preclient);
        return redirect()->route('preclients.index')->with('success', 'PreClient deleted successfully');
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
