<?php

class ApiService {
    public static $client_id = "4d211985a4a645cfd9357761e9e34099";
    public static $api_key = "5292225921defce1353f6804189d8505";

    /**
     * @description Die DB Ris-Api ansprechen und Response Daten verarbeiten
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

        $ch = curl_init($url);
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/vnd.de.db.ris+json ',
            'DB-Client-Id: ' . self::$client_id,
            'DB-Api-Key: ' . self::$api_key
        ));
    
        $response = curl_exec($ch);
    
        curl_close($ch);
    
        return json_decode($response, true);
    }

    public static function getStation($input) {
        return self::callRisApi(
            array(
                "endpoint" => "stop-places/by-name",
                "data" => urlencode($input)
            ),
            array(
                array(
                    "key" => "sortBy",
                    "value" => "QUERY_MATCH"
                ),
                array(
                    "key" => "onlyActive",
                    "value" => "true"
                ),
                array(
                    "key" => "limit",
                    "value" => "10"
                )
            )
        )["stopPlaces"][0];
    }
}
?>