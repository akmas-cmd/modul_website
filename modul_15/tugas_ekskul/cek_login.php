<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SESSION['status'] != "login") {
    header("location:login.php?pesan=belum_login");
    exit;
}
?>