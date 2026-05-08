<?php
session_start();

$namauser = $_POST['username'];
$password = $_POST['password'];

if ('login sukses') {
  $_SESSION['namauser'] = $namauser;
  echo "<p>Selamat datang <b>" . $_SESSION['namauser'] . "</b></p>";
  echo
    "<p>Berikut ini menu navigasi Anda</p>";
  echo
    "<p><a href='hal1.php'>Menu 1</a><br>";
  echo
    "<a href='hal2.php'>Menu 2</a><br>";
  echo
    "<a href='hal3.php'>Menu 3</a></p>";
}
?>