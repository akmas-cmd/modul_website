<html>

<head>
    <title>Insert Data Siswa</title>
</head>

<body>
    <form method="POST" action="">
        <table border="1">
            <tr>
                <td>NIS</td>
                <td> : </td>
                <td><input type="text" name="nis"></td>
            </tr>
            <tr>
                <td>Nama</td>
                <td> : </td>
                <td><input type="text" name="nama"></td>
            </tr>
            <tr>
                <td><input type="submit" name="submit" value="Submit"><input type="reset" name="reset" value="Reset">
                </td>
            </tr>
        </table>
    </form>
    <?php
    include "koneksi.php";

    if (isset($_POST['submit'])) {
        $nis = mysqli_real_escape_string($koneksi, $_POST['nis']);
        $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
        $kirim = $_POST['submit'];
        $query = "INSERT INTO tb_siswaa (nis, nama) VALUES ('$nis', '$nama')";

        $hasil = mysqli_query($koneksi, $query);
        if ($hasil) {
            echo "Data berhasil disimpan ";
            echo "<a href='tampil.php'>Lihat Data</a>";
        } else {
            echo "Gagal: " . mysqli_error($koneksi);
        }
    }
    ?>
</body>

</html>
<?php
echo "<a href='insert.php'>Daftar</a>";
?>