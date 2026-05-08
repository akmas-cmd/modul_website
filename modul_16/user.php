<?php
$level_akses = "user"; // Tentukan level
include "cek.php";
?>

<title>Dashboard Halaman User</title>
<h2>Dashboard Halaman User</h2>
<p>Selamat datang, <?php echo $_SESSION['username'] ?></p>
<i>ISI MENU DAN KONTEN HALAMAN USER DISINI</i><br>

<a href="logout.php">Logout</a>