<?php
// Detail
include "koneksi.php";
$nis = $_GET['nis'];
$query = "SELECT * FROM tb_siswaa WHERE nis = '$nis'";
$hasil = mysqli_query($koneksi, $query);
$data = mysqli_fetch_array($hasil);
?>
<table border="1">
    <tr>
        <td>NIS</td>
        <td> : </td>
        <td><?php echo $data['nis']; ?></td>
    </tr>
    <tr>
        <td>NIS</td>
        <td> : </td>
        <td>
            <?php echo $data['nama']; ?>
        </td>
    </tr>
</table>