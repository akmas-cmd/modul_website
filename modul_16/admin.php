<?php
$level_akses = "admin"; // Tentukan level
include "cek.php";
?>

<title>Dashboard Halaman Admin</title>
<h2>Dashboard Halaman Admin</h2>
<p>Selamat datang, <?php echo $_SESSION['username'] ?></p>
<i>ISI MENU DAN KONTEN HALAMAN ADMIN DISINI</i><br>

<a href="logout.php">Logout</a>