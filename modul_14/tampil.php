<html>
    <head>
        <title>Tampil Data</title></head>
        <table border="1">
            <tr>
                <th>No</th>
                <th>NIS</th>
                <th>Nama</th>
                <th colspan="3">action</th>
            </tr>

<?php
include "koneksi.php"; //panggil file koneksi
$query = "SELECT * FROM tb_siswaa"; //buat query sql
$hasil = mysqli_query($koneksi, $query); //jalankan query sql
$no = 1; //untuk pengurutan nomor
$jum = mysqli_num_rows($hasil); //menghitung banyak row/baris data
?>
    <tr>
        <td colspan="6">Banyak Data : <?php echo $jum; ?></td>
    </tr>
<?php
//perulangan untuk menampilkan data dari database
while ($data = mysqli_fetch_array($hasil)) {
?>
    <tr>
        <td><?php echo $no++; ?></td>
        <td><?php echo $data['nis']; ?></td>
        <td><?php echo $data['nama']; ?></td>
        <td><a href="detail.php?nis=<?php echo $data['nis']; ?>">Detail</a></td>
        <td><a href="form_update.php?nis=<?php echo $data['nis']; ?>">Update</a></td>
        <td><a href="delete.php?nis=<?php echo $data['nis']; ?>" onclick="return confirm('Yakin ingin menghapus data?')">Delete</a></td>
    </tr>
    <?php
}
?>
</table>
<p><a href='insert.php'>Daftar</a></p>
</html>