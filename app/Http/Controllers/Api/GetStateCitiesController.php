<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class GetStateCitiesController extends Controller
{

    public function getCountries()
    {
        return $this->curlRequest("https://api.countrystatecity.in/v1/countries");
    }

    public function getStatesByCountry($countryCode)
    {
        return $this->curlRequest(
            "https://api.countrystatecity.in/v1/countries/{$countryCode}/states"
        );
    }

    public function getCitiesByState($countryCode, $stateCode)
    {
        return $this->curlRequest(
            "https://api.countrystatecity.in/v1/countries/{$countryCode}/states/{$stateCode}/cities"
        );
    }


    private function curlRequest($url)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'X-CSCAPI-KEY: ' . config('services.countrystatecity.api_key')
            ],
        ]);

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($httpCode === 200) {
            return response()->json(json_decode($response, true));
        }

        return response()->json([], 404);
    }
}
