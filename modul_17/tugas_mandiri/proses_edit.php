<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['level'] != 'admin') {
    header("Location: tampil.php");
    exit;
}
include "koneksi.php";

$id         = intval($_POST['id']);
$title      = $_POST['title'];
$content    = $_POST['content'];
$author     = $_POST['author'];
$image_lama = $_POST['image_lama'];

if ($_FILES['image']['error'] == 0 && !empty($_FILES['image']['name'])) {
    $image = $_FILES['image']['name'];
    $tmp   = $_FILES['image']['tmp_name'];
    $size  = $_FILES['image']['size'];

    $ext     = strtolower(pathinfo($image, PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];

    if (!in_array($ext, $allowed)) {
        die("Format gambar tidak valid!");
    }
    if ($size > 2 * 1024 * 1024) {
        die("Ukuran file terlalu besar! Maks 2MB.");
    }

    $image_baru = time() . '_' . basename($image);
    $target     = "upload/" . $image_baru;

    if (move_uploaded_file($tmp, $target)) {
        if ($image_lama && file_exists("upload/" . $image_lama)) {
            unlink("upload/" . $image_lama);
        }
        $image_simpan = $image_baru;
    } else {
        die("Gagal upload gambar baru!");
    }
} else {
    $image_simpan = $image_lama;
}

$sql = "UPDATE news SET title='$title', content='$content', author='$author', image='$image_simpan' WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    header("Location: tampil.php?success=Berita berhasil diperbarui!");
    exit;
} else {
    echo "Error: " . $conn->error;
}
?>