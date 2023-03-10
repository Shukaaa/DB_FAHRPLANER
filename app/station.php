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
    // API calls mit den Namen der Bahnhöfe machen und fahrpan flag mitgeben
    $station = ApiService::getStation($_SESSION["bahnhof"], $_SESSION["fahrplan"], date("h", strtotime($_SESSION["fahrplan_date"])));
    Utils::logger($station);
} else {
    // Zurück zur index.php falls keine Eingaben abgefangen werden konnten
    header("Location: " . Utils::getRedirectUrl("index"));
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo Components::head("Stationeninformation") ?>
</head>
<body>
    <?php echo Components::breadcrump(false, "Stationeninformation") ?>
    <main class="center-minor">
        <h1 class="meow"><u><?php echo $station["names"]["DE"]["name"] ?></u></h1>
            <?php
            if ($station != null) {
                // Addressbereich (+ iframe einbindung für openstreetmap anhand der longitude und latitude)
                echo "<h5><u>Addresse</u></h5>
                <ul class='route-details'>
                    <li>" . $station['address']['street'] . ' ' . $station['address']['houseNumber'] . "</li>
                    <li>" . $station['address']['city'] . ' ' . $station['address']['postalCode'] . "</li>
                </ul>
                <iframe width='500' 
                        height='300' 
                        frameborder='0' 
                        scrolling='no' 
                        marginheight='0' 
                        marginwidth='0' 
                        src='https://www.openstreetmap.org/export/embed.html?bbox=" . $station["position"]["longitude"] . "%2C" . $station["position"]["latitude"] . "%2C" . $station["position"]["longitude"] . "%2C" . $station["position"]["latitude"] . "&amp;layer=mapnik'>
                </iframe>";

                // Einrichtungsbereich
                if (array_key_exists("facilities", $station)) {
                    echo "<h5 class='meow'><u>Einrichtungen</u></h5>";
                    // basic loop durch alle facilityeinträge
                    foreach ($station["facilities"] as $facility) {
                        Utils::logger($facility);
                        echo "
                        <div class='facility'>
                            <p class='big-dick'><strong>" . ucfirst(strtolower($facility["type"])) . "</strong> " . $facility["description"] . "</p>
                            <ul class='route-details'>
                                <li>Status: " . ucfirst(strtolower($facility["state"])) . "</li>
                            </ul>
                        </div>
                        ";
                    }
                }

                // Fahrplanbereich
                if (array_key_exists("fahrplan", $station)) {
                    echo "<h5 class='meow'><u>Fahrplan</u></h5><div class='routes'>";

                    // Das Datum zu Stunden umändern
                    foreach ($station["fahrplan"]->s as $s) {
                        $s->dp["pt"] = substr($s->dp["pt"], 6);
                    }

                    // basic loop durch alle Fahrplaneinträge
                    foreach ($station["fahrplan"]->s as $s) {
                        // Die Ankunft- und Herkunftsbahnhöfe einzelnd in ein Array verlagern
                        $ars = explode("|", $s->ar["ppth"]);
                        $dps = explode("|", $s->dp["ppth"]);

                        // Falls der Bahnhof keine Zielbahnhöfe hat wird er nicht angezeigt da es eine Endstation ist
                        if (count($dps) <= 1) {
                            continue;
                        }

                        // Wenn der Herkunftsbahnhof leer ist, ist die 1. Station der Bahnhof selber
                        if (count($ars) == 1 && $ars[0] == '') {
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