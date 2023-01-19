<?php
class ApiService {
    public static $client_id = "4d211985a4a645cfd9357761e9e34099";
    public static $api_key = "5292225921defce1353f6804189d8505";

    /**
     * @description Sendet eine Anfrage mit der übergebenen URL
     * @param string $url URL die angesprochen werden soll
     * @param string $response_type Header Information des Return Types
     * @return array API-Response
     */
    private static function sendRequest($url, $response_type) {
        $ch = curl_init($url);
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: ' . $response_type,
            'DB-Client-Id: ' . self::$client_id,
            'DB-Api-Key: ' . self::$api_key
        ));
    
        $response = curl_exec($ch);
    
        curl_close($ch);
    
        return json_decode($response, true);
    }

    /**
     * @description Baut die URL für die RIS:API und sendet eine Request
     * @param array $request Der Array muss endpoint und data enthalten
     * @param array $additional_data [OPTIONAL] Multidimensionaler Array der Information zu additionellen Einstellungen enthält, z.b. length=10
     * @return array API-Response
     */
    public static function callRisApi($request, $additional_data = null) {
        $url = 'https://apis.deutschebahn.com/db-api-marketplace/apis/ris-stations/v1/' . $request['endpoint'] . "/" . $request['data'];

        if ($additional_data != null) {
            $additional_data_string = "?";

            foreach ($additional_data as $data) {
                $additional_data_string .= $data['key'] . "=" . $data['value'] . "&";
            }

            $additional_data_string = rtrim($additional_data_string, "&");
            $url .= $additional_data_string;
        }

        return self::sendRequest($url, "application/vnd.de.db.ris+json");
    }

    /**
     * @description Baut die URL für die FaSta API und sendet eine Request
     * @param array $request Der Array muss endpoint und data enthalten
     * @return array API-Response
     */
    public static function callFastaApi($request) {
        $url = 'https://apis.deutschebahn.com/db-api-marketplace/apis/fasta/v2/' . $request['endpoint'] . "/" . $request['data'];

        return self::sendRequest($url, "application/json");
    }

    /**
     * @description Anhand eines Inputs die Station ermitteln und daten ausgeben (Es werden außerdem noch Facitily-Daten mit eigebunden von einer anderen API)
     * @param string $input String für den Query der Station
     * @return array API-Response
     */
    public static function getStation($input) {
        $stop_place = self::callRisApi(
            array(
                "endpoint" => "stop-places/by-name",
                "data" => urlencode($input)
            ),
            array(
                array(
                    "key" => "sortBy",
                    "value" => "RELEVANCE"
                ),
                array(
                    "key" => "onlyActive",
                    "value" => "true"
                ),
                array(
                    "key" => "limit",
                    "value" => "1"
                )
            )
        )["stopPlaces"][0];

        $station = self::callRisApi(
            array(
                "endpoint" => "stations",
                "data" => urlencode($stop_place["stationID"])
            )
        );

        $facility_details = self::callFastaApi(
            array(
                "endpoint" => "stations",
                "data" => urlencode($stop_place["stationID"])
            )
        )["facilities"];

        $merged_array = array_merge($stop_place, $station);
        $merged_array["facilities"] = $facility_details;

        return $merged_array;
    }
}
?>