<?php
require_once("service/ApiService.php");
require_once("util/Utils.php");

Utils::enable_errors();

// initiaize variables
$station_start = null;
$station_ziel = null;

// Überprüfe POST von der Form
if (isset($_POST["bahnhof_start"]) && isset($_POST["bahnhof_ziel"])) {
    // stationen suchen mit dem input der Form
    $station_start = ApiService::getStation($_POST["bahnhof_start"]);
    $station_ziel = ApiService::getStation($_POST["bahnhof_ziel"]);
    Utils::var_dump_pre($station_start);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta   charset="UTF-8">
    <meta   http-equiv="X-UA-Compatible" content="IE=edge">
    <meta   name="viewport" content="width=device-width, initial-scale=1.0">

    <link   rel="icon" type="image/x-icon" href="./assets/favicon.ico">
    <link   rel="stylesheet" href="./css/main.css">
    <link   href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" 
            rel="stylesheet" 
            integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" 
            crossorigin="anonymous">

    <title>Fluffiger Fahrplaner</title>
</head>
<body>
    <main class="center-hv">
        <section>
            <h1>Fluffiger Fahrplaner</h1>
            <p>Lassen sie sich einfach und fluffig ihre Fahrten planen mit dem <strong>Fluffigen Fahrplaner</strong>!!!</p>
            <img src="./assets/logo.png" alt="logo"><br>
        </section>
        <section>
            <form method="post">
                <label for="start" class="form-label">Start eingeben</label>
                <div class="input-group flex-nowrap">
                    <input required name="bahnhof_start" id="start" type="text" class="form-control" aria-describedby="addon-wrapping">
                </div>
                <label for="start" class="form-label last">Ziel eingeben</label>
                <div class="input-group flex-nowrap">
                    <input required name="bahnhof_ziel" id="start" type="text" class="form-control" aria-describedby="addon-wrapping">
                </div>
                <label for="start" class="form-label last">Zeit angeben</label>
                <div class="input-group flex-nowrap">
                    <input required name="date" id="start" type="datetime-local" class="form-control" aria-describedby="addon-wrapping">
                </div>
                <div class="flex">
                    <div class="input-group">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="AbAn" value="An" checked>
                            <label class="form-check-label" for="flexCheckDisabled">Ankunft</label>
                        </div>
                    </div>
                    <div class="input-group">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="AbAn" value="Ab">
                            <label class="form-check-label" for="flexCheckDisabled">Abfahrt</label>
                        </div>
                    </div>
                </div>
                <button class="btn btn-outline-dark submit-btn" type="submit">Verbindung Suchen</button>
            </form>
        </section>
        <?php
        if ($station_ziel != null && $station_start != null) {
            echo $station_start["names"]["DE"]["name"];
            echo $station_ziel["names"]["DE"]["name"];
        }
        ?>
    </main>
 
  
</div>
</body>
</html>