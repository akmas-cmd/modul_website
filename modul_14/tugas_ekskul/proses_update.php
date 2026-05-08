<?php
session_start();
include "koneksi.php";

$nis    = mysqli_real_escape_string($koneksi, $_POST['nis'] ?? '');
$nama   = mysqli_real_escape_string($koneksi, $_POST['nama'] ?? '');
$kelas  = mysqli_real_escape_string($koneksi, $_POST['kelas'] ?? '');
$ttl    = mysqli_real_escape_string($koneksi, $_POST['ttl'] ?? '');
$alamat = mysqli_real_escape_string($koneksi, $_POST['alamat'] ?? '');
$kota   = mysqli_real_escape_string($koneksi, $_POST['kota'] ?? '');
$jk     = mysqli_real_escape_string($koneksi, $_POST['jk'] ?? '');
$hobi   = mysqli_real_escape_string($koneksi, isset($_POST['hobi']) ? implode(", ", $_POST['hobi']) : "-");
$ekskul = mysqli_real_escape_string($koneksi, isset($_POST['ekskul']) ? implode(", ", $_POST['ekskul']) : "-");

$query = "UPDATE tb_siswaa SET
  nama='$nama', kelas='$kelas', ttl='$ttl',
  alamat='$alamat', kota='$kota', jk='$jk',
  hobi='$hobi', ekskul='$ekskul'
  WHERE nis='$nis'";

$hasil = mysqli_query($koneksi, $query);

if ($hasil) {
    $_SESSION['pesan'] = 'sukses';
    header('Location: tugasmandiri.php');
} else {
    $_SESSION['pesan'] = "gagal: " . mysqli_error($koneksi);
    header('Location: tugasmandiri.php');
}
exit();
?>