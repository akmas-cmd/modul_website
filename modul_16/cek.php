<?php
session_start();

// Cek apakah sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Cek level (opsional, tergantung halaman)
if (isset($level_akses)) {
    if ($_SESSION['level'] != $level_akses) {
        echo "Akses ditolak!";
        exit();
    }
}
?>