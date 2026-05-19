<?php
$pw = "user123";

$hash = password_hash($pw, PASSWORD_DEFAULT);
echo $hash;
?>