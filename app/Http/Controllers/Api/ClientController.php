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

    public function checkAadharExists(Request $request)
    {
        $request->validate([
            'aadhar_no' => 'required|string|size:12'
        ]);

        $aadharNo = strtoupper($request->aadhar_no);
        
        $exists = Client::where('aadhar_no', $aadharNo)->exists();

        return response()->json([
            'status' => true,
            'error' => null,
            'data' => [
                'aadhar_no' => $aadharNo,
                'exists' => $exists
            ],
        ]);
    }

    public function checkCKYCExists(Request $request)
    {
        $request->validate([
            'ckyc_no' => 'required|string|size:14'
        ]);

        $ckycNo = strtoupper($request->ckyc_no);
        
        $exists = Client::where('ckyc_no', $ckycNo)->exists();

        return response()->json([
            'status' => true,
            'error' => null,
            'data' => [
                'ckyc_no' => $ckycNo,
                'exists' => $exists
            ],
        ]);
    }
}