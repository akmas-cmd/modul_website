<?php
include "cek.php";

echo
  "<h1>Ini halaman pertama</h1>";
echo
  "<p>Anda login sebagai <b>" . $_SESSION['namauser'] . "</b></p>";
echo
  "<p>Berikut ini menu navigasi Anda</p>";
echo
  "<p><a href='hal1.php'>Menu 1</a><br>";
echo
  "<a href='hal2.php'>Menu 2</a><br>";
echo
  "<a href='hal3.php'>Menu 3</a></p>";
echo
  "<p><a href='logout.php'>Logout</a></p>";
?>