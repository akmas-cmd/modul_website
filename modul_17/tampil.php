<?php
include "koneksi.php";
$sql = "SELECT * FROM news ORDER BY id DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Data Berita</title>
</head>

<body>
    <h2>Daftar Berita</h2>
    <a href="form_upload.php">+ Tambah Data</a>
    <br><br>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <td>No</td>
            <td>Judul</td>
            <td>Content</td>
            <td>Author</td>
            <td>Gambar</td>
            <td>Tanggal</td>
            <td>Aksi</td>
        </tr>

        <?php
        $no = 1;
        while ($row = $result->fetch_assoc()) {
            ?>

            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['title']; ?></td>
                <td>
                    <?= substr($row['content'], 0, 100); ?>...
                </td>
                <td><?= $row['author']; ?></td>
                <td>
                    <img src="upload/<?= $row['image']; ?>" width="100">
                </td>
                <td><?= $row['date']; ?></td>
                <td>
                    <a href="detail.php?id=<?= $row['id']; ?>">Detail</a>
                    <a href="edit.php?id=<?= $row['id']; ?>">Edit</a>
                    <a href="hapus.php?id=<?= $row['id']; ?>" onclick="return confirm('Yakin hapus?')">Hapus</a>
                </td>
            </tr>

        <?php } ?>

    </table>
</body>

</html>