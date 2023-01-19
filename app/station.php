<?php
// imports
require_once("service/ApiService.php");
require_once("util/Utils.php");
require_once("components/Components.php");

Utils::enable_errors();

// initialize variables
$station = null;
$fahrplan = null;

session_start();

// Überprüfe ob Session Variablen gesetzt wurden
if (isset($_SESSION["bahnhof"]) && isset($_SESSION["fahrplan"])) {
    // API calls mit den Namen der Bahnhöfe machen
    $station = ApiService::getStation($_SESSION["bahnhof"]);
    $fahrplan = $_SESSION["fahrplan"];
    Utils::var_dump_pre($station);
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
    <main class="center-hv">
        <?php
        if ($station != null) {
            echo $station["names"]["DE"]["name"];
            echo $fahrplan;
        }
        ?>
    </main>
</body>
</html>