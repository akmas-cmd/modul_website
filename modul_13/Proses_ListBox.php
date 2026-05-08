<?php
if (isset($_POST['color'])) {
    $az = $_POST['color'];
    foreach ($az as $a) {
        echo "$a <br>";
    }
}
?>