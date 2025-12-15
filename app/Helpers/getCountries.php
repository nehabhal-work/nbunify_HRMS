<?php

use Illuminate\Support\Facades\Http;

if (!function_exists('getCountries')) {

    function getCountries($countryCode = 'IN', $stateCode = 'MH')
    {
        $headers = [
            'X-CSCAPI-KEY' => config('services.countrystatecity.api_key'),
            'content-type' => 'application/json',
        ];

        $responseCountry = Http::withHeaders($headers)
            ->get("https://api.countrystatecity.in/v1/countries");

        $responseStates = Http::withHeaders($headers)
            ->get("https://api.countrystatecity.in/v1/countries/{$countryCode}/states");

        $responseCity = Http::withHeaders($headers)
            ->get("https://api.countrystatecity.in/v1/countries/{$countryCode}/states/{$stateCode}/cities");

        if ($responseCountry->successful() && $responseStates->successful()) {
            return [
                'country' => $responseCountry->json(),
                'states'  => $responseStates->json(),
                'cities'  => $responseCity->json(),
            ];
        }

        return [
            'country' => [],
            'states'  => [],
            'cities'  => [],
        ];
    }
}
