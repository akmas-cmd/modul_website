<?php
include "cek_login.php";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Pendaftaran Ekstrakurikuler</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h3 class="text-center text-purple fw-bold mb-3" style="color:#6f42c1;">Data Pendaftaran Ekstrakurikuler</h3>
    <a href="TugasMandiri.php" class="btn btn-success mb-3">+ Daftar Baru</a>

    <?php
    include "koneksi.php";
    $query  = "SELECT * FROM tb_siswaa";
    $hasil  = mysqli_query($koneksi, $query);
    if (!$hasil) {
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($koneksi) . "</div>";
        exit;
    }
    $jumlah = mysqli_num_rows($hasil);
    echo "<p>Total Data: <strong>$jumlah</strong></p>";
    ?>

    <div class="table-responsive">
    <table class="table table-bordered table-hover bg-white">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>NIS</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Tgl Lahir</th>
                <th>Kota</th>
                <th>JK</th>
                <th>Hobi</th>
                <th>Ekskul</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $no = 1;
        while ($data = mysqli_fetch_array($hasil)) {
            $jk_label = ($data['jk'] == 'L') ? 'Laki-laki' : 'Perempuan';
        ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $data['nis']; ?></td>
                <td><?php echo $data['nama']; ?></td>
                <td><?php echo $data['kelas']; ?></td>
                <td><?php echo $data['ttl']; ?></td>
                <td><?php echo $data['kota']; ?></td>
                <td><?php echo $jk_label; ?></td>
                <td><?php echo $data['hobi']; ?></td>
                <td><?php echo $data['ekskul']; ?></td>
                <td>
                    <a href="detail.php?nis=<?php echo $data['nis']; ?>" class="btn btn-info btn-sm">Detail</a>
                    <a href="form_update.php?nis=<?php echo $data['nis']; ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete.php?nis=<?php echo $data['nis']; ?>"
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    </div>
</div>
</body>
</html>