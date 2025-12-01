<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function checkPanExists(Request $request)
    {
        $request->validate([
            'pan_no' => 'required|string|size:10'
        ]);

        $panNo = strtoupper($request->pan_no);
        
        $exists = Client::where('pan_no', $panNo)->exists();

        return response()->json([
            'status' => true,
            'error' => null,
            'data' => [
                'pan_no' => $panNo,
                'exists' => $exists
            ],
        ]);
    }
}