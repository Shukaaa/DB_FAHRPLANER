<?php
// imports
require_once("service/ApiService.php");
require_once("util/Utils.php");
require_once("components/Components.php");

Utils::enable_errors();

// initialize variables
$station_start = null;
$station_ziel = null;

session_start();

// Überprüfe ob Session Variablen gesetzt wurden
if (isset($_SESSION["bahnhof_ziel"]) && isset($_SESSION["bahnhof_start"])) {
    // API calls mit den Namen der Bahnhöfe machen
    $station_start = ApiService::getStation($_SESSION["bahnhof_start"], true);
    $station_ziel = ApiService::getStation($_SESSION["bahnhof_ziel"], true);
} else {
    // Zurück zur index.php
    header("Location: " . Utils::getRedirectUrl("index"));
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo Components::head("Verbindung") ?>
</head>
<body>
    <?php echo Components::breadcrump(false, "Verbindungsdetails") ?>
    <main class="center-hv">
        <?php
        if ($station_ziel != null && $station_start != null) {
            echo $station_start["names"]["DE"]["name"];
            echo $station_ziel["names"]["DE"]["name"];
        }
        ?>
    </main>
</body>
</html>