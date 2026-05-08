<?php
session_start();


if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['kirim_form'])) {
    header("Location: TugasMandiri.php");
    exit();
}

$nis = trim($_POST['nis'] ?? '');
if ($nis === '') {
    header("Location: TugasMandiri.php");
    exit();
}

include "koneksi.php";

$hobby_arr  = $_POST['hobby'] ?? [];
$ekskul_arr = $_POST['ekskul'] ?? [];
$tgl_lahir  = trim($_POST['tgl'] ?? '') . '/' . trim($_POST['bln'] ?? '') . '/' . trim($_POST['thn'] ?? '');

$nis    = mysqli_real_escape_string($koneksi, $nis);
$nama   = mysqli_real_escape_string($koneksi, trim($_POST['nama'] ?? ''));
$kelas  = mysqli_real_escape_string($koneksi, trim($_POST['kelas'] ?? ''));
$ttl    = mysqli_real_escape_string($koneksi, $tgl_lahir);
$alamat = mysqli_real_escape_string($koneksi, trim($_POST['alamat'] ?? ''));
$kota   = mysqli_real_escape_string($koneksi, trim($_POST['kota'] ?? ''));
$jk     = mysqli_real_escape_string($koneksi, trim($_POST['jenis_kelamin'] ?? '-'));
$hobi   = mysqli_real_escape_string($koneksi, !empty($hobby_arr) ? implode(', ', $hobby_arr) : '-');
$ekskul = mysqli_real_escape_string($koneksi, !empty($ekskul_arr) ? implode(', ', $ekskul_arr) : '-');

$query = "INSERT INTO tb_siswaa (nis, nama, kelas, ttl, alamat, kota, jk, hobi, ekskul)
          VALUES ('$nis','$nama','$kelas','$ttl','$alamat','$kota','$jk','$hobi','$ekskul')";

$hasil = mysqli_query($koneksi, $query);

if ($hasil) {
    $_SESSION['pesan'] = "sukses";
} else {
    $_SESSION['pesan'] = "gagal: " . mysqli_error($koneksi);
}

header("Location: TugasMandiri.php");
exit();
?>