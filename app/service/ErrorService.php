<?php
 /**
 * @description Zeigt eine Error_Sektion an
 * @param string $title Fehlertitel für das h3 Element
 * @param string $msg Fehlernachricht für das p Element
 * @return void
 */
class ErrorService {
    public static function triggerError($title, $msg) {
        echo "<section class='error-section'>
            <h3>Error: $title</h3>
            <p>$msg</p>
        </section>";
    }
}
?>