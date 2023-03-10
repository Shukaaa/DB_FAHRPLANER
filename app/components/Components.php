<?php
require_once("util/Utils.php");

class Components
{
    /**
     * @description Beinhält HTML Head Informationen
     * @param string $title Seitenname
     * @return string HTML-String
     */
    public static function head($title) { 
        return '<meta   charset="UTF-8">
        <meta   http-equiv="X-UA-Compatible" content="IE=edge">
        <meta   name="viewport" content="width=device-width, initial-scale=1.0">

        <link   rel="icon" type="image/x-icon" href="./assets/favicon.ico">
        <link   rel="stylesheet" href="./css/main.css">
        <link   href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" 
                rel="stylesheet" 
                integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" 
                crossorigin="anonymous">

        <script src="https://kit.fontawesome.com/5bf597b54b.js" crossorigin="anonymous"></script>

        <title>Fahrplaner | ' . $title . '</title>';
    }

    /**
     * @description Beinhält HTML-Code für das Breadcrump-Menu
     * @param boolean $home Check ob es der Breadcump für die Startseite ist
     * @param string $current_page Seitenname
     * @return string HTML-String
     */
    public static function breadcrump($home, $current_page = "") {
        if ($home) {
            return "
            <div class='breadcrump'>
                <span>
                    <i class='fa-solid fa-house'></i> /
                </span>
            </div>
            ";
        } else {
            return "
            <div class='breadcrump'>
                <span>
                    <a href='" . Utils::getRedirectUrl("index") . "'><i class='fa-solid fa-house'></i></a> / " . $current_page . "
                </span>
            </div>
            ";
        }
    }
}
?>