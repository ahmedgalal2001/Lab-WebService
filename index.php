<?php
require_once("vendor/autoload.php");
ini_set("memory_limit", '-1');
$city = new City;
$cities = array();
$city_weather = array();
$current_data_time = array();

$cities = $city->get_all_cities("EG");
$current_data_time = $city->get_current_time_data();

if (($_SERVER["REQUEST_METHOD"] == "GET") && isset($_GET["city"])) {
    $city_weather = $city->get_weather_city($_GET["city"]);
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather Forecasting</title>
    <style>
        .main {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        select {
            padding: 6px;
            margin-top: 8px;
            font-size: 17px;
        }

        button {
            background-color: #04AA6D;
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="main">
        <div class="weather-city">
            <h1><?php echo  $city_weather["name"] . " Disuq Weather Status"?></h1>
            <p><?php echo  $current_data_time["current_time"] ?></p>
            <p><?php echo  $current_data_time["current_date"] ?></p>
            <p><?php echo  $city_weather["weather"][0]["description"] ?></p>
            <img src="<?php echo "http://openweathermap.org/img/w/" . $city_weather['weather'][0]['icon'] . ".png" ?>" alt="Weather Icon">
            <p><?php echo "Temperature: " . "\t" . $city_weather["main"]["temp"] . " °C" ?></p>
            <p><?php echo "Humidity: " . "\t" . $city_weather["main"]["humidity"] . " %" ?></p>
            <p><?php echo "Wind: " . "\t" . $city_weather["wind"]["speed"] . " Km/h" ?></p>
        </div>
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="get">
            <select name="city" id="city">
                <?php
                foreach ($cities as $city) {
                ?>
                    <option value="<?php echo $city['id'] ?>"><?php echo $city["country"] . "=>" . $city["name"] ?></option>
                <?php
                }
                ?>
            </select>
            <button type="submit">Get Weather</button>
        </form>
    </div>
</body>

</html>