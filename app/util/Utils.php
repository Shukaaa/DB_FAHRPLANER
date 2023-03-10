<?php
class Utils {
    /**
     * @description Errormessages aktivieren
     * @return void
     */
    public static function enable_errors() {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
    
    /**
     * @description Shorthand zum formatieren vom var_dump()
     * @param mixed $var jeglicher Datensatz
     * @return void
     */
    public static function var_dump_pre($var) {
        echo '<pre>';
        var_dump($var);
        echo '</pre>';
    }

    /**
     * @description Erstellt ein Link zur Weiterleitung basierend auf der derzeitigen URL
     * @param string $page Seitenname
     * @return string URL
     */
    public static function getRedirectUrl($page) {
        $request_uri = substr($_SERVER["REQUEST_URI"], 0, strrpos($_SERVER["REQUEST_URI"], "/")) . "/";
        if (isset($_SERVER["HTTPS"])) {
            return "https://" . $_SERVER["HTTP_HOST"] . $request_uri . $page . ".php";
        } else {
            return "http://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] . $page . ".php";
        }
    }

    /**
     * @description Shorthand für console.log
     * @param mixed $log Datensatz oder Nachricht die geloggt werden soll
     * @return void
     */
    public static function logger($log) {
        echo "<script>console.log(" . json_encode($log) . ")</script>";
    }
}
?>