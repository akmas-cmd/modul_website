<?php
// Form edit atau update
include "koneksi.php";
$nis = $_GET['nis'];
$query = "SELECT * FROM tb_siswaa WHERE nis='$nis'";
$hasil = mysqli_query($koneksi, $query);
$data = mysqli_fetch_array($hasil);
?>
<form method="POST" action="proses_update.php">
    <table border="1">
        <tr>
            <td>NIS</td>
            <td> : </td>
            <td><input type="text" name="nis" value="<?php echo $data['nis']; ?>" readonly="readonly"></td>
        </tr>
        <tr>
            <td>Nama</td>
            <td> : </td>
            <td><input type="text" name="nama" value="<?php echo $data['nama']; ?>"></td>
        </tr>
        <tr>
            <td><input type="submit" name="submit" value="KIRIM"></td>
            <td></td>
            <td><input type="reset" name="reset" value="RESET"></td>
        </tr>
    </table>
</form>