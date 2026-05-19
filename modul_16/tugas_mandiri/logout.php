<?php
// =====================================================
// logout.php - Proses Logout (Session Destroy)
// Konsep: hapus variabel session dan hancurkan session
// =====================================================
session_start();

// Hapus semua data session
session_unset();

// Hancurkan session sepenuhnya
session_destroy();

// Redirect ke halaman login dengan pesan logout
header("Location: login.php?logout=1");
exit();
?>