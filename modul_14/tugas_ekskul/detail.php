<?php
session_start();
include "koneksi.php";
$nis = mysqli_real_escape_string($koneksi, $_GET['nis'] ?? '');
$query = "SELECT * FROM tb_siswaa WHERE nis='$nis'";
$hasil = mysqli_query($koneksi, $query);
$data = mysqli_fetch_array($hasil);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Detail Siswa</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-4">
  <h4 class="fw-bold">Detail Data Siswa</h4>
  <table class="table table-bordered w-50">
    <tr><td>NIS</td><td><?php echo $data['nis']; ?></td></tr>
    <tr><td>Nama</td><td><?php echo $data['nama']; ?></td></tr>
    <tr><td>Kelas</td><td><?php echo $data['kelas']; ?></td></tr>
    <tr><td>Tgl Lahir</td><td><?php echo $data['ttl']; ?></td></tr>
    <tr><td>Alamat</td><td><?php echo $data['alamat']; ?></td></tr>
    <tr><td>Kota</td><td><?php echo $data['kota']; ?></td></tr>
    <tr><td>Jenis Kelamin</td><td><?php echo $data['jk']=='L' ? 'Laki-Laki' : 'Perempuan'; ?></td></tr>
    <tr><td>Hobby</td><td><?php echo $data['hobi']; ?></td></tr>
    <tr><td>Ekskul</td><td><?php echo $data['ekskul']; ?></td></tr>
  </table>
  <a href="tugasmandiri.php" class="btn btn-secondary">← Kembali</a>
</body>
</html>