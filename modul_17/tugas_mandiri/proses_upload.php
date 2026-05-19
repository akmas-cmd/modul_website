<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['level'] != 'admin') {
    header("Location: tampil.php");
    exit;
}
include "koneksi.php";

$title   = $_POST['title'];
$content = $_POST['content'];
$author  = $_POST['author'];

$image      = $_FILES['image']['name'];
$tmp        = $_FILES['image']['tmp_name'];
$size       = $_FILES['image']['size'];
$error_file = $_FILES['image']['error'];

if ($error_file !== 0 || empty($image)) {
    die("Gagal upload: tidak ada file yang dipilih.");
}

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
    $sql = "INSERT INTO news (title, content, author, image) 
            VALUES ('$title', '$content', '$author', '$image_baru')";

    if ($conn->query($sql) === TRUE) {
        header("Location: tampil.php?success=Berita berhasil ditambahkan!");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "Gagal upload! Pastikan folder 'upload' sudah dibuat.";
}
?>