<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Services\InvestmentService;
use Illuminate\Http\Request;

class InvestmentController extends Controller
{
    protected $investmentService;

    public function __construct(InvestmentService $investmentService)
    {
        $this->investmentService = $investmentService;
    }

    public function getPayoutSchedule(Request $request)
    {
        $request->validate([
            'investment_amount' => 'required|numeric|min:0',
            'roi_percent' => 'required|numeric|min:0',
            'additional_roi_percent' => 'nullable|numeric|min:0',
            'frequency' => 'required|in:monthly,quarterly,half-yearly,yearly,lumpsum',
            'tenure_count' => 'required|integer|min:1',
            'tenure_type' => 'required|in:days,months,years',
            'investment_date' => 'required|date',
        ]);

        $data = $this->investmentService->calculateInvestmentParameters($request->all());

        return response()->json([
            'status' => true,
            'data' => $data,
        ]);
    }
}
