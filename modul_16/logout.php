<?php
session_start();
// Hapus semua data session
session_unset();
// Hancurkan session
session_destroy();
// Keterangan setelah logout
echo "Anda Sudah Logout <br>";
echo "<a href='login.php'>Login Kembali</a>";
// Langsung redirect ke halaman login
// header("Location: login.php");
exit();
?>