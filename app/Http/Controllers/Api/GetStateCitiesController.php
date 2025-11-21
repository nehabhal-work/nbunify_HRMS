<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class GetStateCitiesController extends Controller
{

    private function getCountries()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.countrystatecity.in/v1/countries",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array(
                'X-CSCAPI-KEY: ' . env('CSC_API_KEY')
            ),
        ));

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($httpCode == 200) {
            return response()->json(json_decode($response, true));
        }

        return response()->json(['message' => 'Country not found'], 404);
    }
    public function getCitiesByState($countryCode, $stateCode)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.countrystatecity.in/v1/countries/{$countryCode}/states/{$stateCode}/cities",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array(
                'X-CSCAPI-KEY: ' . env('CSC_API_KEY')
            ),
        ));

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($httpCode == 200) {
            return response()->json(json_decode($response, true));
        }

        return response()->json(['message' => 'City not found'], 404);
    }
}
