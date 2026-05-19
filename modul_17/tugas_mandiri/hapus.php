<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['level'] != 'admin') {
    header("Location: tampil.php");
    exit;
}
include "koneksi.php";

$id     = intval($_GET['id']);
$sql    = "SELECT image FROM news WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row   = $result->fetch_assoc();
    $image = $row['image'];

    if ($image && file_exists("upload/" . $image)) {
        unlink("upload/" . $image);
    }

    $sql_hapus = "DELETE FROM news WHERE id = $id";
    if ($conn->query($sql_hapus) === TRUE) {
        header("Location: tampil.php?success=Berita berhasil dihapus!");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "Data tidak ditemukan!";
}
?>