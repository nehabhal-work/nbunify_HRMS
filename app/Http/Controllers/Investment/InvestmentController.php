<?php

namespace App\Http\Controllers\Investment;

use App\Http\Controllers\Controller;
use App\Http\Requests\InvestmentRequest;
use App\Models\InvestmentInputBank;
use App\Models\InvestmentPayoutSchedule;
use App\Services\ClientService;
use App\Services\CompanyService;
use App\Services\InvestmentService;
use App\Services\SchemeService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class InvestmentController extends Controller
{
    public function __construct(
        private InvestmentService $investmentService,
        private SchemeService $schemeService,
        private ClientService $clientService,
        private CompanyService $companyService,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = [
            'from_date' => $request->get('from_date'),
            'to_date' => $request->get('to_date'),
            'scheme_id' => $request->get('scheme_id'),
            'status' => $request->get('status'),
            'action_status' => $request->get('action_status'),
            'client_search' => $request->get('client_search')
        ];

        $investments = $this->investmentService->getAllWithFilters($filters);
        $schemes = $this->schemeService->getAll();

        return view('content.investment.index', compact('investments', 'schemes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = $this->clientService->getAllApproved();
        $companyBanks = $this->companyService->getFirstCompanyBanks();
        return view('content.investment.create', compact('clients', 'companyBanks'));
    }

    // public function store(Request $request)
    public function store(InvestmentRequest $request)
    {
        // return $request;
        try {
            $this->investmentService->create($request->validated());
        } catch (\Exception $e) {
            \Log::error('Error creating investment: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
        return redirect()->route('investment.els.index')->with('success', 'Investment created successfully.');
    }

    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    //     $investment = $this->investmentService->getById($id);
    //     $paySchdeule = $this->investmentService->getPaymentSchedule($id);
    //     // return $paySchdeule;
    //     return view('content.investment.view', compact('investment', 'paySchdeule'));
    //     // return view('investments.payment-schedule', compact('investment'));
    // }

    public function show(string $id)
    {
        $investment = $this->investmentService->getById($id);
        $paySchdeule = $this->investmentService->getPaymentSchedule($id);
        $scheme = $this->schemeService->getAllApproved();
        $clients = $this->clientService->getAllApproved();
        $companyBanks = $this->companyService->getFirstCompanyBanks();

        // $inputBank = \DB::table('investment_input_banks')
        //     ->where('investment_id', $id)
        //     ->first();
        $inputBank = InvestmentInputBank::with('fromClientBank', 'toCompanyBank')->where('investment_id', $id)->first();
        // return $investment;
        return view(
            'content.investment.view',
            compact(
                'investment',
                'paySchdeule',
                'scheme',
                'clients',
                'companyBanks',
                'inputBank'
            )
        );
    }



    public function show_standingInstruction(string $id)
    {
        $investment = $this->investmentService->getById($id);
        $paySchdeule = $this->investmentService->getPaymentSchedule($id);
        // return $paySchdeule;
        return view('content.investment.view', compact('investment', 'paySchdeule'));
        // return view('investments.payment-schedule', compact('investment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $investment = $this->investmentService->getById($id);
        $scheme = $this->schemeService->getAll();
        $clients = $this->clientService->getAllApproved();
        $companyBanks = $this->companyService->getFirstCompanyBanks();
        $clientBanks = $this->clientService->getClientBanks($investment->first_client_id);
        // return $investment;
        return view('content.investment.edit', compact('investment', 'scheme', 'clients', 'companyBanks', 'clientBanks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InvestmentRequest $request, string $id)
    {
        $investment = $this->investmentService->getModelById($id);
        $this->investmentService->update($investment, $request->validated());
        return redirect()->route('investment.els.index')->with('success', 'Investment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $investment = $this->investmentService->getModelById($id);
        $this->investmentService->delete($investment);
        return redirect()->route('investment.els.index')->with('success', 'Investment deleted successfully.');
    }

    public function renew()
    {
        // $client = $this->clientService->find($id);
        return view('content.investment.renew');
    }

    public function claim(Request $request)
    {
        $investment = $this->investmentService->getModelById($request->investment_id);
        return view('content.investment.claim', compact('investment'));
    }
    public function merge()
    {
        return view('content.investment.merge');
    }
    public function maturity()
    {
        return view('content.investment.maturity');
    }
    public function maturityLetter()
    {
        return view('content.investment.letters.maturity-letter');
    }
    public function maturityKYC()
    {
        return view('content.investment.maturity-kyc');
    }

    public function approve(string $id)
    {
        try {
            $this->investmentService->approve($id);
            return redirect()->back()->with('success', 'Investment approved successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error approving investment: ' . $e->getMessage());
        }
    }

    public function approvePayouts(string $id)
    {
        try {
            $this->investmentService->approvePayouts($id);
            return redirect()->back()->with('success', 'Investment schedule approved successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error approving investment: ' . $e->getMessage());
        }
    }

    public function welcomeLetter($id)
    {
        $company = $this->companyService->findFirstOrFail();
        $investment = $this->investmentService->getById($id);
        return view('content.investment.letters.welcome-letter', compact('investment', 'company'));
    }



    public function welcomeLetterDownloadPdf($investmentId)
    {
        // return 'pdf function called';
        $company = $this->companyService->findFirstOrFail();
        $investment = $this->investmentService->getById($investmentId);

        $pdf = Pdf::loadView('content.investment.pdf.welcome-letter-pdf', compact(
            'investment',
            'company'
        ))->setPaper('A4', 'portrait');

        return $pdf->download('Investment-Welcome-Letter.pdf');
    }

    public function sendEmailWithPdf($investmentId)
    {
        $company = $this->companyService->findFirstOrFail();
        $investment = $this->investmentService->getById($investmentId);


        $pdf = Pdf::loadView('content.investment.pdf.welcome-letter-pdf', compact(
            'investment',
            'company'
        ));
        // return $investment;

        Mail::send('content.investment.emails.welcome-letter-email', compact(
            'investment',
            'company'
        ), function ($message) use ($investment, $pdf) {
            $message->to(['bhalchandrahrs@gmail.com', 'chitrashedge@kandkfinserv.com', 'maddy2008@gmail.com'])
                ->subject('Investment Confirmation Letter -' . $investment->id)
                ->attachData(
                    $pdf->output(),
                    'Investment-Welcome-Letter.pdf'
                );
        });
        return back()->with('success', 'Email sent successfully with PDF attached.');
    }

    public function markPaid(Request $request)
    {
        try {
            $message = $this->investmentService->markPaid($request->schedule_id, [
                'actual_payout_amount' => $request->actual_payout_amount,
                'actual_payout_date' => $request->actual_payout_date,
                'utr_no' => $request->utr_no,
                'remarks' => $request->remarks,
            ]);
            return back()->with('success', $message);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    private function sendEmailPayout($id)
    {
        $schedule = InvestmentPayoutSchedule::with('investment.firstClient')->findOrFail($id);

        Mail::send(
            'content.investment.emails.payout-template',
            compact('schedule'),
            function ($message) use ($schedule) {
                $message->to(['bhalchandrahrs@gmail.com', 'chitrashedge@kandkfinserv.com', 'maddy2008@gmail.com'])
                    ->subject('Investment-Payout Done -' . $schedule->id);
            }
        );

        return back()->with('success', 'Payout mail sent to client.');
    }

    public function getSchemesByDate(Request $request)
    {
        $schemes = $this->schemeService->getApprovedByDate($request->investment_date);
        return response()->json($schemes);
    }

    public function addPayoutSchedule(Request $request)
    {
        // return $request;
        try {
            $this->investmentService->addPayoutSchedule($request->investment_id, $request->all());
            return back()->with('success', 'Payout schedule added successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
