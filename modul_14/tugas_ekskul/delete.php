<?php
session_start();
include "koneksi.php";
$nis = mysqli_real_escape_string($koneksi, $_GET['nis'] ?? '');
$query = "DELETE FROM tb_siswaa WHERE nis='$nis'";
$hasil = mysqli_query($koneksi, $query);

if ($hasil) {
    $_SESSION['pesan'] = 'sukses';
    header("Location: tugasmandiri.php");
} else {
    $_SESSION['pesan'] = "gagal: " . mysqli_error($koneksi);
    header("Location: tugasmandiri.php");
}
exit();
?>