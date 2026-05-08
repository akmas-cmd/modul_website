<?php
session_start();
include "koneksi.php";

// Ambil pesan notifikasi
$pesan = $_SESSION['pesan'] ?? '';
unset($_SESSION['pesan']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pendaftaran Ekstrakurikuler</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-4">

<div class="d-flex justify-content-between mb-3">
    <h4 class="fw-bold" style="color:purple">Pendaftaran Ekstrakurikuler</h4>
    <a href="login.php?logout=1" class="btn btn-danger btn-sm">Logout</a>
</div>

<?php if ($pesan === 'sukses'): ?>
    <div class="alert alert-success">Data berhasil disimpan!</div>
<?php elseif ($pesan !== ''): ?>
    <div class="alert alert-danger">Gagal: <?= htmlspecialchars($pesan) ?></div>
<?php endif; ?>

<!-- TABEL DATA DARI DATABASE -->
<h5>Data Siswa Terdaftar</h5>
<?php
$query  = "SELECT * FROM tb_siswaa";
$hasil  = mysqli_query($koneksi, $query);

if (!$hasil) {
    echo "<div class='alert alert-danger'>Error: " . htmlspecialchars(mysqli_error($koneksi)) . "</div>";
    exit;
}

$jumlah = mysqli_num_rows($hasil);
echo "<p>Banyak Data: <b>$jumlah</b></p>";
?>
<table class="table table-bordered table-striped mb-5">
    <thead class="table-dark">
        <tr>
            <th>No</th><th>NIS</th><th>Nama</th><th>Kelas</th>
            <th>JK</th><th>Ekskul</th><th>Aksi</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $no = 1;
    while ($data = mysqli_fetch_array($hasil)):
    ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($data['nis'] ?? '-') ?></td>
            <td><?= htmlspecialchars($data['nama'] ?? '-') ?></td>
            <td><?= htmlspecialchars($data['kelas'] ?? '-') ?></td>
            <td><?= htmlspecialchars($data['jk'] ?? '-') ?></td>
            <td><?= htmlspecialchars($data['ekskul'] ?? '-') ?></td>
            <td>
                <a href="detail.php?nis=<?= urlencode($data['nis'] ?? '') ?>" class="btn btn-info btn-sm">Detail</a>
                <a href="form_update.php?nis=<?= urlencode($data['nis'] ?? '') ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="delete.php?nis=<?= urlencode($data['nis'] ?? '') ?>" class="btn btn-danger btn-sm"
                   onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>

<!-- FORM PENDAFTARAN -->
<h5>Form Pendaftaran Baru</h5>
<form method="post" action="proses.php" onsubmit="return validasi()">
    <table class="table w-75">
        <tr>
            <td>NIS</td>
            <td>: <input type="text" name="nis" id="nis" class="form-control d-inline w-auto">
                <span class="text-danger">*</span></td>
        </tr>
        <tr>
            <td>Nama</td>
            <td>: <input type="text" name="nama" class="form-control"></td>
        </tr>
        <tr>
            <td>Kelas</td>
            <td>:
                <select name="kelas" class="form-select w-auto">
                    <option value="X">X</option>
                    <option value="XI">XI</option>
                    <option value="XII">XII</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Tgl Lahir</td>
            <td>:
                <input type="text" name="tgl" size="3" placeholder="Tgl" class="form-control d-inline w-auto">
                /
                <input type="text" name="bln" size="8" placeholder="Bulan" class="form-control d-inline w-auto">
                /
                <input type="text" name="thn" size="5" placeholder="Tahun" class="form-control d-inline w-auto">
            </td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>: <textarea name="alamat" rows="3" cols="30" class="form-control"></textarea></td>
        </tr>
        <tr>
            <td>Kota</td>
            <td>: <input type="text" name="kota" class="form-control"></td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>:
                <input type="radio" name="jenis_kelamin" value="L"> Laki-Laki;
                <input type="radio" name="jenis_kelamin" value="P"> Perempuan
            </td>
        </tr>
        <tr>
            <td valign="top">Hobby</td>
            <td>:
                <input type="checkbox" name="hobby[]" value="Membaca"> Membaca<br>
                <input type="checkbox" name="hobby[]" value="Olahraga"> Olahraga<br>
                <input type="checkbox" name="hobby[]" value="Menyanyi"> Menyanyi<br>
                <input type="checkbox" name="hobby[]" value="Menari"> Menari<br>
                <input type="checkbox" name="hobby[]" value="Traveling"> Traveling
            </td>
        </tr>
        <tr>
            <td valign="top">Pilihan Ekskul</td>
            <td>:
                <select name="ekskul[]" multiple size="7" class="form-select w-auto">
                    <option value="Pramuka">Pramuka</option>
                    <option value="Basket">Basket</option>
                    <option value="Volly">Volly</option>
                    <option value="Band">Band</option>
                    <option value="Seni Tari">Seni Tari</option>
                    <option value="Robotic">Robotic</option>
                    <option value="Bulu Tangkis">Bulu Tangkis</option>
                    <option value="Futsal">Futsal</option>
                    <option value="Renang">Renang</option>
                </select>
                <small class="text-muted">Tahan Ctrl untuk pilih lebih dari satu</small>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="submit" name="kirim_form" value="Kirim" class="btn btn-primary">
                <input type="reset" value="Cancel" class="btn btn-secondary">
            </td>
        </tr>
    </table>
    <span class="text-danger">* Harus Di isi</span>
</form>

<script>
function validasi() {
    if (document.getElementById('nis').value.trim() === '') {
        alert('NIS harus diisi!');
        return false;
    }
    return true;
}
</script>
</body>
</html>