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
    $station = ApiService::getStation($_SESSION["bahnhof"], $_SESSION["fahrplan"], date("h", strtotime($_SESSION["fahrplan_date"])));
    Utils::logger($station);
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
            if (array_key_exists("fahrplan", $station)) {
                foreach ($station["fahrplan"]->s as $s) {
                    $ars = explode("|", $s->ar["ppth"]);
                    $dps = explode("|", $s->dp["ppth"]);
                    echo "<div class='routes'><p>From <strong>" . $ars[0] . "</strong> to <strong>" . end($dps) . "</strong></p></div>";
                }
            }
        }
        ?>
    </main>
</body>
</html>