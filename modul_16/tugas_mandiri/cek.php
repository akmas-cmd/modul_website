<?php
// =====================================================
// cek.php - Middleware penjaga session (guard)
// Di-include di setiap halaman yang butuh login
// =====================================================
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Cek level akses (opsional, tergantung halaman)
// $level_akses didefinisikan SEBELUM include file ini
if (isset($level_akses)) {
    if ($_SESSION['level'] != $level_akses) {
        // Jika level tidak sesuai, redirect ke halaman yang sesuai
        if ($_SESSION['level'] == 'admin') {
            header("Location: admin.php");
        } else {
            header("Location: user.php");
        }
        exit();
    }
}
?>