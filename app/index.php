<?php
// imports
require_once("service/ApiService.php");
require_once("util/Utils.php");
require_once("components/Components.php");

Utils::enable_errors();

// Überprüfe ob der POST / die Form abgesendet wurde
if (isset($_POST["bahnhof_start"]) && isset($_POST["bahnhof_ziel"])) {
    session_start();

    // schreibe die Bahnhof Inputs in die Session um später auf diese Daten zugreifen zu können (route.php)
    $_SESSION["bahnhof_start"] = $_POST["bahnhof_start"];
    $_SESSION["bahnhof_ziel"] = $_POST["bahnhof_ziel"];

    // Weiterleitung nach route.php
    header("Location: " . Utils::getRedirectUrl("route"));
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo Components::head("Home") ?>
</head>
<body>
    <main class="center-hv">
        <section>
            <h1>Fluffiger Fahrplaner</h1>
            <p>Lassen sie sich einfach und fluffig ihre Fahrten planen oder sich Bahnhofdetails und Fahrpläne anzeigen lassen mit dem <strong>Fluffigen Fahrplaner</strong>!!!</p>
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
    </main>
</body>
</html>