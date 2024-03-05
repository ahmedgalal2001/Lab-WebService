<?php

class City
{
    public function __construct()
    {
    }

    public function get_all_cities($country_name)
    {
        $country = "EG";
        if (!empty($country_name)) {
            // Sanitize and validate the input country name
            $country = strtoupper($country_name);
            // You might want to add more validation here
        }

        $city_file = __CITIES_FILE;

        if (!file_exists($city_file)) {
            return "City list file not found.";
        }


        $data = file_get_contents($city_file);

        // Decode the JSON data
        $cities = json_decode($data, true);

        // Filter cities by country code (EG for Egypt)
        $filtered_cities = array_filter($cities, function ($city) use ($country) {
            return $city['country'] === $country;
        });
        return $filtered_cities;
    }

    public function get_weather_city($city_id)
    {
        $apiKey = '3ff692fcb7adeda4b509c8ebd95c6db7';
        $apiUrl = str_replace("%cityid%", $city_id, __WEATHER_URL);
        $apiUrl = str_replace("%apikey%", $apiKey, $apiUrl);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        $data = json_decode($response, true);
        return $data;
    }

    public function get_current_time_data()
    {
        $current_time = date('l h:i a');
        $current_date = date('j F Y');
        return array("current_time" => $current_time, "current_date" => $current_date);
    }
}
