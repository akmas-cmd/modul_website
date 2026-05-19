<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
include "koneksi.php";

$id     = intval($_GET['id']);
$sql    = "SELECT * FROM news WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>Berita tidak ditemukan!</div></div>";
    exit;
}

$row   = $result->fetch_assoc();
$level = $_SESSION['level'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Berita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f5f5f5; font-family: Arial, sans-serif; }
        .navbar { background-color: #dc3545 !important; }
        .navbar-brand { font-weight: bold; color: white !important; }
        .detail-card {
            background: white; border-radius: 8px;
            padding: 30px; max-width: 750px;
            margin: 30px auto;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .detail-card img {
            width: 100%; max-height: 380px;
            object-fit: cover; border-radius: 6px; margin-bottom: 20px;
        }
        .meta-info { color: #888; font-size: 13px; margin-bottom: 20px; }
        .content-text { font-size: 15px; line-height: 1.8; color: #333; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <span class="navbar-brand">🗞️ Portal Berita</span>
        <div class="ms-auto">
            <a href="tampil.php" class="btn btn-outline-light btn-sm">← Kembali</a>
        </div>
    </div>
</nav>

<div class="container">
    <div class="detail-card">
        <h2><?= htmlspecialchars($row['title']) ?></h2>
        <div class="meta-info">
            ✍️ <?= htmlspecialchars($row['author']) ?> &nbsp;|&nbsp;
            🕐 <?= date('d F Y, H:i', strtotime($row['date'])) ?>
        </div>

        <?php if ($row['image']): ?>
            <img src="upload/<?= $row['image'] ?>" alt="Gambar Berita">
        <?php endif; ?>

        <div class="content-text"><?= nl2br(htmlspecialchars($row['content'])) ?></div>

        <hr class="mt-4">
        <div class="d-flex gap-2">
            <a href="tampil.php" class="btn btn-secondary btn-sm">← Kembali</a>
            <?php if ($level == 'admin'): ?>
                <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">✏️ Edit</a>
                <a href="hapus.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm"
                   onclick="return confirm('Yakin hapus?')">🗑️ Hapus</a>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>