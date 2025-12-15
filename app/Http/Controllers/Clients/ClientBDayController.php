<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientBankRequest;
use App\Jobs\SendBirthdayEmailJob;
use App\Models\ClientBirthdayMail;
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
            $fromDate = now()->format('Y-m-d');
        }

        if ($toDate == null) {
            $toDate = now()->addMonth()->format('Y-m-d');
        }

        $clients = $this->clientService->getBDayList($fromDate, $toDate);
        $clientFamilies = $this->clientFamilyService->getBDayList($fromDate, $toDate);

        // return $clients;
        return view('content.clients.bday-list', compact('clients', 'clientFamilies'));
    }

    public function sendBirthdayEmail(Request $request)
    {
        $clientId = $request->client_id;
        $client = $this->clientService->find($clientId);

        if (!$client || !$client->email) {
            return response()->json(['error' => 'Client not found or email not available'], 404);
        }

        $currentYear = now()->year;

        // Check if birthday email already sent this year
        $existingMail = ClientBirthdayMail::where('client_id', $clientId)
            ->where('mail_year', $currentYear)
            ->first();

        if ($existingMail) {
            return response()->json(['error' => 'Birthday email already sent this year'], 400);
        }

        try {
            // Create the birthday mail record first
            $birthdayMail = ClientBirthdayMail::create([
                'client_id' => $clientId,
                'birthday_date' => $client->dob,
                'mail_year' => $currentYear,
                'sent_at' => now(),
                'status' => 'queued'
            ]);

            // Dispatch the job with the record ID
            SendBirthdayEmailJob::dispatch($client, $birthdayMail->id);

            return response()->json(['success' => 'Birthday email queued successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to send email: ' . $e->getMessage()], 500);
        }
    }
}
