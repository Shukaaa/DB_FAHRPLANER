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
}
?>