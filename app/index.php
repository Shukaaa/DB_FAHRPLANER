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

if (isset($_POST["bahnhof"])) {
    session_start();

    // schreibe die Bahnhof Inputs in die Session um später auf diese Daten zugreifen zu können (station.php)
    $_SESSION["bahnhof"] = $_POST["bahnhof"];
    if (isset($_POST["fahrplan"])) {
        $_SESSION["fahrplan"] = true;
    } else {
        $_SESSION["fahrplan"] = false;
    }  

    // Weiterleitung nach station.php
    header("Location: " . Utils::getRedirectUrl("station"));
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo Components::head("Home") ?>
    <script src="./js/tabsTrigger.js" defer></script>
    <script src="./js/checkboxChangeForm.js" defer></script>
</head>
<body>
    <main class="center-hv">
        <section>
            <h1>Fluffiger Fahrplaner</h1>
            <p>Lassen sie sich einfach und fluffig ihre Fahrten planen oder sich Bahnhofdetails und Fahrpläne anzeigen lassen mit dem <strong>Fluffigen Fahrplaner</strong>!!!</p>
            <img src="./assets/logo.png" alt="logo"><br>
        </section>
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" id="tab-verbindung" onclick="triggerTab('verbindung')">Verbindung suchen</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab-station" onclick="triggerTab('station')">Bahnhof und Fahrplaninformationen</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab-projektinfo" onclick="triggerTab('projektinfo')">Projektinfo</a>
            </li>
        </ul>
        <section id="section-verbindung" class="section">
            <form method="post">
                <label for="start" class="form-label">Start eingeben</label>
                <div class="input-group flex-nowrap">
                    <input required name="bahnhof_start" type="text" class="form-control" aria-describedby="addon-wrapping">
                </div>
                <label for="start" class="form-label last">Ziel eingeben</label>
                <div class="input-group flex-nowrap">
                    <input required name="bahnhof_ziel" type="text" class="form-control" aria-describedby="addon-wrapping">
                </div>
                <label for="start" class="form-label last">Zeit angeben</label>
                <div class="input-group flex-nowrap">
                    <input required name="date" type="datetime-local" class="form-control" aria-describedby="addon-wrapping">
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
        <section id="section-station" class="hide section">
            <form method="post">
                <label class="form-label">Bahnhof / Station eingeben</label>
                <div class="input-group flex-nowrap">
                    <input required name="bahnhof" type="text" class="form-control" aria-describedby="addon-wrapping">
                </div>
                <div class="form-check">
                    <input onchange="checkForCheckbox()" class="form-check-input" type="checkbox" name="fahrplan" value="true" id="fahrplanCheckbox">
                    <label class="form-check-label left" for="flexCheckDefault">Fahrplan ausgeben</label>
                </div>
                <div id="fahrplanOnlyForm" style="display: none;">
                    <div class="input-group flex-nowrap">
                        <input name="date" id="fahrplanDate" type="datetime-local" class="form-control" aria-describedby="addon-wrapping">
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
                </div>
                <button class="btn btn-outline-dark submit-btn" type="submit">Informationen anzeigen</button>
            </form>
        </section>
        <section id="section-projektinfo" class="hide section">
            <h5 class="mt">Projekt von <strong>Lucas Bernard</strong> und <strong>Connor Nagy</strong></h5>
            <p>Das Programm ist größtenteils von Lucas geschrieben und die Dokumentation ist von Connor</p>
        </section>
    </main>
</body>
</html>