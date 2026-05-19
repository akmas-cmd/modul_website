<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['level'] != 'admin') {
    header("Location: tampil.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Berita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f5f5f5; font-family: Arial, sans-serif; }
        .navbar { background-color: #dc3545 !important; }
        .navbar-brand { font-weight: bold; color: white !important; }
        .form-card {
            background: white; border-radius: 8px;
            padding: 25px; max-width: 650px;
            margin: 30px auto;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .form-card h4 { color: #dc3545; font-weight: bold; margin-bottom: 20px; }
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
    <div class="form-card">
        <h4>📝 Tambah Berita Baru</h4>
        <form action="proses_upload.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label fw-bold">Judul Berita</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Konten</label>
                <textarea name="content" class="form-control" rows="5" required></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Author</label>
                <input type="text" name="author" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Gambar</label>
                <input type="file" name="image" class="form-control" accept="image/*" required>
                <div class="form-text">Format: JPG, PNG, GIF. Maks 2MB.</div>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-danger">Upload Berita</button>
                <a href="tampil.php" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>