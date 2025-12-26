<?php

namespace App\Http\Controllers\Investment;

use App\Http\Controllers\Controller;
use App\Http\Requests\InvestmentRequest;
use App\Models\InvestmentPayoutSchedule;
use App\Models\SchemesMaster;
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
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return 'index page called';
        $investments = $this->investmentService->getAll();
        return view('content.investment.index', compact('investments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $scheme = $this->schemeService->getAll();
        $clients = $this->clientService->getAll();
        $companyBanks = $this->companyService->getFirstCompanyBanks();

        return view('content.investment.create', compact('scheme', 'clients', 'companyBanks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InvestmentRequest $request)
    // public function store(Request $request)
    {
        // return $request;
        $this->investmentService->create($request->validated());
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
// return $bankInstrument;
        $scheme = $this->schemeService->getAll();
        $clients = $this->clientService->getAll();
        $companyBanks = $this->companyService->getFirstCompanyBanks();

        $inputBank = \DB::table('investment_input_banks')
            ->where('investment_id', $id)
            ->first();
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
        return view('content.investment.edit', compact('investment', 'scheme'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InvestmentRequest $request, string $id)
    {
        $investment = $this->investmentService->getById($id);
        $this->investmentService->update($investment, $request->validated());
        return redirect()->route('investment.els.index')->with('success', 'Investment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $investment = $this->investmentService->getById($id);
        $this->investmentService->delete($investment);
        return redirect()->route('investment.els.index')->with('success', 'Investment deleted successfully.');
    }

    public function renew()
    {
        // $client = $this->clientService->find($id);
        return view('content.investment.renew');
    }
    public function claim()
    {
        return view('content.investment.claim');
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
        $this->investmentService->approve($id);
        return redirect()->back()->with('success', 'Investment approved successfully.');
    }

    public function welcomeLetter($id)
    {
        // $client = $this->clientService->find($id);
        $company = $this->companyService->findFirstOrFail();
        $investment = $this->investmentService->getById($id);
        // return $investment;
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
        // return $request;
        $schedule = InvestmentPayoutSchedule::findOrFail($request->schedule_id);

        $schedule->update([
            'actual_payout_amount' => $request->actual_payout_amount,
            'actual_payout_date' => $request->actual_payout_date,
            'utr_no' => $request->utr_no,
            'remarks' => $request->remarks,
            'status' => 'done',
        ]);

        return back()->with('success', 'Payout marked as paid successfully.');
    }

    public function sendEmailPayout($id)
    {
        $schedule = InvestmentPayoutSchedule::with('investment.firstClient')->findOrFail($id);
        // return $schedule;
        // Mail::to($schedule->investment->firstClient->email)
        //     ->send(new PayoutCompletedMail($schedule));

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
        // return response()->json(['message' => 'testing', 'date' => $request->investment_date], 200);
        $date = $request->investment_date;

        $schemes = SchemesMaster::where('start_date', '<=', $date)->where('end_date', '>=', $date)->get();

        return response()->json($schemes);
    }
}
