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
  <title>Edit Data Siswa</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-4">
  <h4 class="fw-bold">Edit Data Siswa</h4>
  <form method="POST" action="proses_update.php">
    <table class="table">
      <tr>
        <td>NIS</td><td>:</td>
        <td><input type="text" name="nis" value="<?php echo $data['nis']; ?>" class="form-control" readonly></td>
      </tr>
      <tr>
        <td>Nama</td><td>:</td>
        <td><input type="text" name="nama" value="<?php echo $data['nama']; ?>" class="form-control"></td>
      </tr>
      <tr>
        <td>Kelas</td><td>:</td>
        <td>
          <select name="kelas" class="form-select">
            <?php foreach(['X','XI','XII'] as $k): ?>
              <option <?php echo $data['kelas']==$k ? 'selected' : ''; ?>><?php echo $k; ?></option>
            <?php endforeach; ?>
          </select>
        </td>
      </tr>
      <tr>
        <td>Tgl Lahir</td><td>:</td>
        <td><input type="date" name="ttl" value="<?php echo $data['ttl']; ?>" class="form-control"></td>
      </tr>
      <tr>
        <td>Alamat</td><td>:</td>
        <td><textarea name="alamat" class="form-control"><?php echo $data['alamat']; ?></textarea></td>
      </tr>
      <tr>
        <td>Kota</td><td>:</td>
        <td><input type="text" name="kota" value="<?php echo $data['kota']; ?>" class="form-control"></td>
      </tr>
      <tr>
        <td>Jenis Kelamin</td><td>:</td>
        <td>
          <input type="radio" name="jk" value="L" <?php echo $data['jk']=='L'?'checked':''; ?>> Laki-Laki &nbsp;
          <input type="radio" name="jk" value="P" <?php echo $data['jk']=='P'?'checked':''; ?>> Perempuan
        </td>
      </tr>
      <tr>
        <td>Hobby</td><td>:</td>
        <td>
          <?php
          $hobiList = ['Membaca','Olahraga','Menyanyi','Menari','Traveling'];
          $hobiSimpan = $data['hobi'];
          foreach ($hobiList as $h):
          ?>
            <input type="checkbox" name="hobi[]" value="<?php echo $h; ?>"
              <?php echo strpos($hobiSimpan, $h) !== false ? 'checked' : ''; ?>> <?php echo $h; ?><br>
          <?php endforeach; ?>
        </td>
      </tr>
      <tr>
        <td>Ekskul</td><td>:</td>
        <td>
          <?php
          $ekskulList = ['Pramuka','Basket','Volly','Band','Seni Tari','Robotic','Bulu Tangkis'];
          $ekskulSimpan = $data['ekskul'];
          ?>
          <select name="ekskul[]" multiple class="form-select" size="7">
            <?php foreach ($ekskulList as $e): ?>
              <option <?php echo strpos($ekskulSimpan, $e) !== false ? 'selected' : ''; ?>><?php echo $e; ?></option>
            <?php endforeach; ?>
          </select>
        </td>
      </tr>
      <tr>
        <td colspan="3">
          <input type="submit" name="submit" value="KIRIM" class="btn btn-warning">
          <input type="reset" value="RESET" class="btn btn-secondary">
        </td>
      </tr>
    </table>
  </form>
</body>
</html>