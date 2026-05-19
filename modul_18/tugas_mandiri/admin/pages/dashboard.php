<?php
include 'koneksi.php';
$total_berita = $conn->query("SELECT COUNT(*) as c FROM news")->fetch_assoc()['c'];
$total_user = $conn->query("SELECT COUNT(*) as c FROM tb_user")->fetch_assoc()['c'];
$total_admin = $conn->query("SELECT COUNT(*) as c FROM tb_user WHERE level='admin'")->fetch_assoc()['c'];
$berita_terbaru = $conn->query("SELECT * FROM news ORDER BY id DESC LIMIT 5");
?>
<div class="page-header">
    <h2>Dashboard</h2>
    <p>Selamat datang kembali, <?= htmlspecialchars($_SESSION['nama_lengkap']) ?>!</p>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card-dark card-dark-pad d-flex align-items-center gap-3">
            <div class="stat-icon stat-icon-blue">
                <i class="bi bi-newspaper"></i>
            </div>
            <div>
                <div class="stat-value"><?= $total_berita ?></div>
                <div class="stat-label">Total Berita</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-dark card-dark-pad d-flex align-items-center gap-3">
            <div class="stat-icon stat-icon-green">
                <i class="bi bi-people"></i>
            </div>
            <div>
                <div class="stat-value"><?= $total_user ?></div>
                <div class="stat-label">Total User</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-dark card-dark-pad d-flex align-items-center gap-3">
            <div class="stat-icon stat-icon-indigo">
                <i class="bi bi-shield-check"></i>
            </div>
            <div>
                <div class="stat-value"><?= $total_admin ?></div>
                <div class="stat-label">Total Admin</div>
            </div>
        </div>
    </div>
</div>

<div class="page-header">
    <h2 class="subtitle">Berita Terbaru</h2>
</div>
<div class="card-dark">
    <table class="table-dark-custom">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Author</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($berita_terbaru->num_rows === 0): ?>
                <tr>
                    <td colspan="4" class="empty-state">
                        <i class="bi bi-inbox"></i>Belum ada berita
                    </td>
                </tr>
            <?php else: ?>
                <?php while ($row = $berita_terbaru->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars(substr($row['title'], 0, 50)) ?>...</td>
                        <td><?= htmlspecialchars($row['author']) ?></td>
                        <td><?= $row['date'] ?></td>
                        <td>
                            <a href="index.php?page=berita&action=detail&id=<?= $row['id'] ?>" class="aksi-btn btn-detail-sm">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>