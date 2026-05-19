<?php
include '../../koneksi.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'list';

$row = null;
if ($action === 'detail' && isset($_GET['id'])) {
    $id   = (int)$_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM news WHERE id=?");
    $stmt->bind_param("i", $id); $stmt->execute();
    $row  = $stmt->get_result()->fetch_assoc();
    if (!$row) $action = 'list';
}

$list = null;
if ($action === 'list') {
    $list = $conn->query("SELECT * FROM news ORDER BY id DESC");
}
?>

<?php if ($action === 'list'): ?>
<div class="page-header">
    <h2>Daftar Berita</h2>
    <p>Baca semua berita terbaru yang tersedia</p>
</div>
<div class="card-dark">
    <table class="table-dark-custom">
        <thead>
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Author</th>
                <th>Gambar</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($list->num_rows === 0): ?>
                <tr>
                    <td colspan="6" class="empty-state">
                        <i class="bi bi-inbox"></i>Belum ada berita
                    </td>
                </tr>
            <?php else: $no = 1; while ($r = $list->fetch_assoc()): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars(substr($r['title'], 0, 55)) ?>...</td>
                <td><?= htmlspecialchars($r['author']) ?></td>
                <td><img src="../upload/<?= htmlspecialchars($r['image']) ?>" class="img-thumb" alt="img"></td>
                <td><?= $r['date'] ?></td>
                <td>
                    <a href="index.php?page=berita&action=detail&id=<?= $r['id'] ?>" class="aksi-btn btn-detail-sm">
                        <i class="bi bi-eye"></i> Baca
                    </a>
                </td>
            </tr>
            <?php endwhile; endif; ?>
        </tbody>
    </table>
</div>

<?php elseif ($action === 'detail' && $row): ?>
<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h2>Detail Berita</h2>
        <p>Baca berita secara lengkap</p>
    </div>
    <a href="index.php?page=berita" class="btn-back-sm"><i class="bi bi-arrow-left"></i> Kembali</a>
</div>
<div class="card-dark card-detail">
    <img src="../upload/<?= htmlspecialchars($row['image']) ?>" class="detail-img" alt="img">
    <div class="card-dark-pad">
        <h3 class="detail-title"><?= htmlspecialchars($row['title']) ?></h3>
        <div class="detail-meta">
            <span><i class="bi bi-person"></i><?= htmlspecialchars($row['author']) ?></span>
            <span><i class="bi bi-calendar3"></i><?= $row['date'] ?></span>
        </div>
        <p class="detail-body"><?= nl2br(htmlspecialchars($row['content'])) ?></p>
        <div class="detail-footer">
            <div class="detail-footer-note">
                <i class="bi bi-lock"></i> Kamu tidak memiliki akses untuk mengedit atau menghapus berita ini.
            </div>
        </div>
    </div>
</div>
<?php endif; ?>