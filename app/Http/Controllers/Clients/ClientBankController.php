<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientBankRequest;
use App\Models\ClientBank;
use App\Services\ClientBankService;
use App\Services\ClientService;
use App\Services\FileStorageService;
use Illuminate\Http\Request;

class ClientBankController extends Controller
{
    public function __construct(
        private ClientBankService $clientBankService,
        private ClientService $clientService,
        private FileStorageService $fileStorageService
    ) {}

    public function index(Request $request)
    {
        if ($client_id = $request->client_id) {
            $client = $this->clientService->find($client_id);
            $clientBanks = $this->clientBankService->getByClientId($client_id);

            $clientBank = ClientBank::where('client_id', 14)->get();

            $clientBanks = $clientBank->map(function ($bank) {
                return $this->clientBankService->addFileUrls($bank);
            });
            // return $clientBanks;

            // $clientBanks = $this->clientBankService->addFileUrls($clientBanks);
            return view('content.clients.banks.index', compact('clientBanks', 'client'));
        } else {
            abort(404);
        }
    }

    public function create(Request $request)
    {
        if ($client_id = $request->client_id) {
            $client = $this->clientService->find($client_id);
            return view('content.clients.banks.create', compact('client'));
        } else {
            abort(404);
        }
    }

    public function store(ClientBankRequest $request)
    // public function store(Request $request)
    {
        // return $request;
        $this->clientBankService->create($request->validated());
        return redirect()->route('client-banks.index', ['client_id' => $request->client_id])->with('success', 'Client bank account created successfully');
    }

    public function edit($id)
    {
        $clientBank = $this->clientBankService->getById($id);
        $client = $this->clientService->find($clientBank->client_id);
        $clientBank = $this->clientBankService->addFileUrls($clientBank);
        // return $clientBank;
        return view('content.clients.banks.edit', compact('clientBank', 'client'));
    }

    public function update(ClientBankRequest $request, $id)
    {
        $clientBank = $this->clientBankService->getById($id);
        $this->clientBankService->update($clientBank, $request->validated());
        return redirect()->route('client-banks.index', ['client_id' => $clientBank->client_id])->with('success', 'Client bank account updated successfully');
    }

    public function destroy($id, Request $request)
    {
        if ($client_id = $request->client_id) {
            $this->clientBankService->delete($id);
            return redirect()->route('client-banks.index', ['client_id' => $client_id])->with('success', 'Client bank account deleted successfully');
        } else {
            abort(404);
        }
    }

    // private function addFileUrls($clientBank)
    // {
    //     $fileFields = [
    //         'attachment_cancelled_cheque',
    //     ];
    //     foreach ($fileFields as $field) {
    //         if ($clientBank->$field) {
    //             $clientBank->{$field . '_url'} = $this->fileStorageService->getTemporaryUrl($clientBank->$field);
    //         }
    //     }
    //     return $clientBank;
    // }
}
