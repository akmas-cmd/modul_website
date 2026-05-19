<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
include "koneksi.php";

$level    = $_SESSION['level'];
$username = $_SESSION['user'];

$sql    = "SELECT * FROM news ORDER BY id DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Berita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f5f5f5; font-family: Arial, sans-serif; }
        .navbar { background-color: #dc3545 !important; }
        .navbar-brand { font-weight: bold; color: white !important; }
        thead { background-color: #dc3545; color: white; }
        .img-berita { width: 80px; height: 55px; object-fit: cover; border-radius: 4px; }
        .badge-admin { background: #ffc107; color: #333; padding: 2px 8px; border-radius: 3px; font-size: 12px; }
        .badge-user  { background: #0dcaf0; color: #fff; padding: 2px 8px; border-radius: 3px; font-size: 12px; }
        .btn-logout  { background: white; color: #dc3545; border: none; padding: 5px 15px; border-radius: 4px; font-size: 14px; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <span class="navbar-brand">🗞️ Portal Berita</span>
        <div class="ms-auto d-flex align-items-center gap-3">
            <span class="text-white" style="font-size:14px;">
                Halo, <b><?= $username ?></b>
                <?php if ($level == 'admin'): ?>
                    <span class="badge-admin ms-1">Admin</span>
                <?php else: ?>
                    <span class="badge-user ms-1">User</span>
                <?php endif; ?>
            </span>
            <a href="logout.php" class="btn-logout">Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold">📋 Daftar Berita</h5>
        <?php if ($level == 'admin'): ?>
            <a href="form_upload.php" class="btn btn-danger btn-sm">+ Tambah Berita</a>
        <?php endif; ?>
    </div>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success py-2">✅ <?= htmlspecialchars($_GET['success']) ?></div>
    <?php endif; ?>

    <div class="table-responsive shadow-sm">
        <table class="table table-bordered table-hover bg-white mb-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Content</th>
                    <th>Author</th>
                    <th>Gambar</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $no = 1;
            if ($result->num_rows > 0):
                while ($row = $result->fetch_assoc()):
            ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($row['title']) ?></td>
                    <td><?= substr(strip_tags($row['content']), 0, 80) ?>...</td>
                    <td><?= htmlspecialchars($row['author']) ?></td>
                    <td>
                        <?php if ($row['image']): ?>
                            <img src="upload/<?= $row['image'] ?>" class="img-berita">
                        <?php else: ?>-<?php endif; ?>
                    </td>
                    <td><?= date('d-m-Y H:i', strtotime($row['date'])) ?></td>
                    <td>
                        <a href="detail.php?id=<?= $row['id'] ?>" class="btn btn-info btn-sm text-white">Detail</a>
                        <?php if ($level == 'admin'): ?>
                            <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="hapus.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm"
                               onclick="return confirm('Yakin hapus?')">Hapus</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; else: ?>
                <tr><td colspan="7" class="text-center text-muted py-4">Belum ada berita.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>