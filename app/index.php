<?php
require_once("service/ApiService.php");
require_once("util/Utils.php");

Utils::enable_errors();

// initiaize variables
$stations = null;

// Überprüfe POST
if (isset($_POST["bahnhof"])) {
    // stations enthält min 1 max 10 Stationen von den möglichen gesuchten Bahnstationen
    $stations = ApiService::callRisApi(
        array(
            "endpoint" => "stop-places/by-name",
            "data" => urlencode($_POST["bahnhof"])
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
    )["stopPlaces"];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" type="image/x-icon" href="./assets/favicon.ico">
    <link rel="stylesheet" href="./css/main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <title>DB Fahrplan</title>
</head>
<body>
    <main class="center-hv">
        <h1>Fluffiger Fahrplaner</h1>
        <p>Lassen sie sich einfach und fluffig ihre Fahrten planen mit dem <strong>Fluffigen Fahrplaner</strong>!!!</p>
        <img src="./assets/logo.png" alt="logo"><br>
        <form method="post">
            <label for="start" class="form-label">Bahnstation</label>
            <div class="input-group flex-nowrap">
                <input required name="bahnhof" id="start" type="text" class="form-control" aria-describedby="addon-wrapping">
            </div>
            <button class="btn btn-outline-dark submit-btn" type="submit">Suchen</button>
        </form>
        <h1>Wähle den Bahnhof: <?php  ?></h1>
        <?php
        if ($stations != null) { 
            foreach ($stations as $station) {
                //Utils::var_dump_pre($station);
                echo $station["names"]["DE"]["nameLong"];
            }
        }
        ?>
    </main>
 
  
</div>
</body>
</html>