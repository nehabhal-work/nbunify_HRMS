<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
class BankController extends Controller
{
    public function validateIfsc(Request $request)
    {
        // Check server
        $request->validate([
            'ifsc' => 'required|string|size:11'
        ]);

        $ifscCode = strtoupper($request->ifsc);

        // Fetch from API
        $response = Http::get("https://ifsc.razorpay.com/{$ifscCode}");

        if ($response->successful()) {
            return response()->json([
                'status' => true,
                'error' => null,
                'data' => $response->json(),
            ]);
        }

        return response()->json([
            'status' => false,
            'error' => 'IFSC code not found',
            'data' => null,
        ], 404);
    }
}
