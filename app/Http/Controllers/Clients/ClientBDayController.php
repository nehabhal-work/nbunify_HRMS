<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientBankRequest;
use App\Services\ClientFamilyService;
use App\Services\ClientService;
use Illuminate\Http\Request;

class ClientBDayController extends Controller
{
    public function __construct(
        private ClientService $clientService,
        private ClientFamilyService $clientFamilyService,
    ) {}

    // TODO: Complete this
    public function index(Request $request)
    {
        // $fromDate = $request->from_date;
        // $toDate = $request->to_date;
        $fromDate = $request->from_date ?? now()->format('Y-m-d');
        $toDate   = $request->to_date ?? now()->addDays(30)->format('Y-m-d');

        if ($fromDate == null) {
            $fromDate = now()->subDays(7)->format('Y-m-d');
        }

        if ($toDate == null) {
            $toDate = now()->addDays(7)->format('Y-m-d');
        }

        $clients = $this->clientService->getBDayList($fromDate, $toDate);
        $clientFamilies = $this->clientFamilyService->getBDayList($fromDate, $toDate);

        return $clients;
        return view('content.clients.bday-list', compact('clients', 'clientFamilies'));
    }
}
