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
    <main class="center-minor">
        <h1 class="meow"><u><?php echo $station["names"]["DE"]["name"] ?></u></h1>
            <?php
            if ($station != null) {
                echo "<h5><u>Addresse</u></h5>
                <ul class='route-details'>
                    <li>" . $station['address']['street'] . ' ' . $station['address']['houseNumber'] . "</li>
                    <li>" . $station['address']['city'] . ' ' . $station['address']['postalCode'] . "</li>
                </ul>
                <iframe width='500' height='300' frameborder='0' scrolling='no' marginheight='0' marginwidth='0' src='https://www.openstreetmap.org/export/embed.html?bbox=" . $station["position"]["longitude"] . "%2C" . $station["position"]["latitude"] . "%2C" . $station["position"]["longitude"] . "%2C" . $station["position"]["latitude"] . "&amp;layer=mapnik'></iframe>";


                if (array_key_exists("facilities", $station))

                if (array_key_exists("fahrplan", $station)) {
                    echo "<h5 class='meow'><u>Fahrplan</u></h5><div class='routes'>";

                    foreach ($station["fahrplan"]->s as $s) {
                        $s->dp["pt"] = substr($s->dp["pt"], 6);
                    }

                    foreach ($station["fahrplan"]->s as $s) {
                        $ars = explode("|", $s->ar["ppth"]);
                        $dps = explode("|", $s->dp["ppth"]);

                        if (count($dps) <= 1) {
                            continue;
                        }

                        if (count($ars) <= 1) {
                            $ars[0] = $station["names"]["DE"]["name"];
                            $s->ar["pp"] = $s->dp["pp"];
                        }

                        
                        echo "  <div class='route'>
                                    <p class='big-dick'>Von <strong>" . $ars[0] . "</strong> nach <strong>" . end($dps) . "</strong></p>
                                    <ul class='route-details'>
                                        <li>Gleis: <strong>" . $s->ar["pp"] . "</strong></li>
                                        <li>Abfahrt: <strong>" . substr_replace($s->dp["pt"], ":", 2, 0) . "</strong></li>
                                        <li>Zug: <strong>" . $s->tl["c"] . " " . $s->tl["n"] . "</strong></li>
                                        <li>Nächste Stops: " . implode(" → ", $dps) . "</li>
                                    </ul>
                                </div>";
                    }
                    echo "</div>";
                }
            }
            ?>
    </main>
</body>
</html>