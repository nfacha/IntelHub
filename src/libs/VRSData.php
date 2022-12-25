<?php

namespace App\libs;

class VRSData
{
    public static function findAircraft(array $aircrafts, string $icao): ?array
    {
        foreach ($aircrafts as $aircraft) {
            if ($aircraft['Icao'] === $icao) {
                return $aircraft;
            }
        }
        return null;
    }

    /**
     * Makes a POST request to the VRS API endpoint and returns the data as a JSON array.
     *
     * @param string $icaosList A list of ICAO codes separated by a hyphen (-)
     *
     * @return array|null The data as a JSON array, or null if the request fails
     */
    public function getAircraftData(array $icaos): ?array
    {
        $icaosList = implode('-', $icaos);
        // create a cURL handle
        $ch = curl_init();

        // set the request URL
        $url = 'https://sdm.virtualradarserver.co.uk/Aircraft/GetAircraftByIcaos';

        // build the query string
        $queryString = http_build_query(['icaos' => $icaosList]);

        // set the request options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $queryString);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // execute the request
        $response = curl_exec($ch);

        // close the cURL handle
        curl_close($ch);

        // decode the response
        return json_decode($response, true);
    }
}
