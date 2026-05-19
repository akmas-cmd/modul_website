<?php
include '../../koneksi.php';
$total_berita   = $conn->query("SELECT COUNT(*) as c FROM news")->fetch_assoc()['c'];
$berita_terbaru = $conn->query("SELECT * FROM news ORDER BY id DESC LIMIT 4");
?>
<div class="page-header">
    <h2>Selamat Datang! 👋</h2>
    <p>Halo, <?= htmlspecialchars($_SESSION['nama_lengkap']) ?>! Kamu login sebagai <strong style="color:#34d399;">User</strong>. Kamu hanya dapat membaca berita.</p>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card-dark card-dark-pad d-flex align-items-center gap-3">
            <div class="stat-icon-green">
                <i class="bi bi-newspaper"></i>
            </div>
            <div>
                <div class="stat-value"><?= $total_berita ?></div>
                <div class="stat-label">Berita Tersedia</div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card-dark card-dark-pad info-card">
            <i class="bi bi-info-circle info-card-icon"></i>
            <div class="info-card-text">
                Sebagai <strong style="color:#fff;">User</strong>, kamu hanya bisa
                <strong style="color:#34d399;">membaca dan melihat detail</strong> berita.
                Untuk mengelola berita, diperlukan akses <strong style="color:#a5b4fc;">Admin</strong>.
            </div>
        </div>
    </div>
</div>

<div class="page-header">
    <h2 class="subtitle">Berita Terbaru</h2>
</div>
<div class="row g-3">
    <?php if ($berita_terbaru->num_rows === 0): ?>
        <div class="col-12">
            <div class="card-dark card-dark-pad">
                <div class="empty-state">
                    <i class="bi bi-inbox"></i>Belum ada berita
                </div>
            </div>
        </div>
    <?php else: while ($r = $berita_terbaru->fetch_assoc()): ?>
    <div class="col-md-6">
        <div class="card-dark" style="height:100%;">
            <img src="../upload/<?= htmlspecialchars($r['image']) ?>" class="news-card-img" alt="img">
            <div class="card-dark-pad">
                <div class="news-card-title"><?= htmlspecialchars(substr($r['title'], 0, 60)) ?>...</div>
                <div class="news-card-meta">
                    <i class="bi bi-person me-1"></i><?= htmlspecialchars($r['author']) ?> · <?= $r['date'] ?>
                </div>
                <a href="index.php?page=berita&action=detail&id=<?= $r['id'] ?>" class="aksi-btn btn-detail-sm aksi-btn-md">
                    <i class="bi bi-eye me-1"></i>Baca
                </a>
            </div>
        </div>
    </div>
    <?php endwhile; endif; ?>
</div>