<?php
include 'koneksi.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'list';
$pesan = '';
$pesan_type = '';

if ($action === 'tambah' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $author = trim($_POST['author']);

    if (empty($title) || empty($content) || empty($author)) {
        $pesan = "Semua field wajib diisi!";
        $pesan_type = 'danger';
        $action = 'form_tambah';
    } elseif (empty($_FILES['image']['name'])) {
        $pesan = "Gambar wajib diupload!";
        $pesan_type = 'danger';
        $action = 'form_tambah';
    } else {
        $image_baru = time() . '_' . basename($_FILES['image']['name']);
        $target = '../../upload/' . $image_baru;
        $ext = strtolower(pathinfo($target, PATHINFO_EXTENSION));
        if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
            $pesan = "Format gambar tidak valid!";
            $pesan_type = 'danger';
            $action = 'form_tambah';
        } elseif (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $stmt = $conn->prepare("INSERT INTO news (title, content, author, image) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $title, $content, $author, $image_baru);
            if ($stmt->execute()) {
                $pesan = "Berita berhasil ditambahkan!";
                $pesan_type = 'success';
                $action = 'list';
            } else {
                $pesan = "Error: " . $conn->error;
                $pesan_type = 'danger';
                $action = 'form_tambah';
            }
        } else {
            $pesan = "Gagal upload gambar!";
            $pesan_type = 'danger';
            $action = 'form_tambah';
        }
    }
}

if ($action === 'edit' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int) $_POST['id'];
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $author = trim($_POST['author']);
    $image_lama = $_POST['image_lama'];

    if (!empty($_FILES['image']['name'])) {
        $image_baru = time() . '_' . basename($_FILES['image']['name']);
        $target = '../../upload/' . $image_baru;
        $ext = strtolower(pathinfo($target, PATHINFO_EXTENSION));
        if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
            $pesan = "Format gambar tidak valid!";
            $pesan_type = 'danger';
        } elseif (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $old = '../../upload/' . $image_lama;
            if (file_exists($old))
                unlink($old);
            $image_final = $image_baru;
        } else {
            $pesan = "Gagal upload gambar!";
            $pesan_type = 'danger';
        }
    } else {
        $image_final = $image_lama;
    }

    if (empty($pesan)) {
        $stmt = $conn->prepare("UPDATE news SET title=?, content=?, author=?, image=? WHERE id=?");
        $stmt->bind_param("ssssi", $title, $content, $author, $image_final, $id);
        if ($stmt->execute()) {
            $pesan = "Berita berhasil diperbarui!";
            $pesan_type = 'success';
            $action = 'list';
        } else {
            $pesan = "Error: " . $conn->error;
            $pesan_type = 'danger';
        }
    }
}

if ($action === 'hapus' && isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $stmt = $conn->prepare("SELECT image FROM news WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    if ($res) {
        $imgfile = '../../upload/' . $res['image'];
        if (file_exists($imgfile))
            unlink($imgfile);
        $d = $conn->prepare("DELETE FROM news WHERE id=?");
        $d->bind_param("i", $id);
        $d->execute();
        $pesan = "Berita berhasil dihapus!";
        $pesan_type = 'success';
    }
    $action = 'list';
}

$row = null;
if (in_array($action, ['form_edit', 'detail']) && isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM news WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    if (!$row)
        $action = 'list';
}

$list = null;
if ($action === 'list') {
    $list = $conn->query("SELECT * FROM news ORDER BY id DESC");
}
?>

<?php if (!empty($pesan)): ?>
    <div class="alert-<?= $pesan_type ?>-dark mb-3">
        <i class="bi bi-<?= $pesan_type === 'success' ? 'check-circle' : 'exclamation-circle' ?>"></i>
        <?= $pesan ?>
    </div>
<?php endif; ?>

<?php if ($action === 'list'): ?>
    <div class="page-header d-flex align-items-center justify-content-between">
        <div>
            <h2>Manajemen Berita</h2>
            <p>Kelola semua berita yang tersedia</p>
        </div>
        <a href="index.php?page=berita&action=form_tambah" class="btn-primary-dark">
            <i class="bi bi-plus-lg"></i> Tambah Berita
        </a>
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
                <?php else:
                    $no = 1;
                    while ($r = $list->fetch_assoc()): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars(substr($r['title'], 0, 55)) ?>...</td>
                            <td><?= htmlspecialchars($r['author']) ?></td>
                            <td><img src="upload/<?= htmlspecialchars($r['image']) ?>" class="img-thumb" alt="img"></td>
                            <td><?= $r['date'] ?></td>
                            <td>
                                <a href="index.php?page=berita&action=detail&id=<?= $r['id'] ?>" class="aksi-btn btn-detail-sm">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                                <a href="index.php?page=berita&action=form_edit&id=<?= $r['id'] ?>" class="aksi-btn btn-edit-sm">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <a href="index.php?page=berita&action=hapus&id=<?= $r['id'] ?>" class="aksi-btn btn-hapus-sm"
                                    onclick="return confirm('Yakin hapus berita ini?')">
                                    <i class="bi bi-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; endif; ?>
            </tbody>
        </table>
    </div>

<?php elseif ($action === 'form_tambah'): ?>
    <div class="page-header d-flex align-items-center justify-content-between">
        <div>
            <h2>Tambah Berita</h2>
            <p>Isi form untuk menambah berita baru</p>
        </div>
        <a href="index.php?page=berita" class="btn-back-sm"><i class="bi bi-arrow-left"></i> Kembali</a>
    </div>
    <div class="card-dark card-dark-pad card-max-md">
        <form action="index.php?page=berita&action=tambah" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label-dark">Judul</label>
                <input type="text" class="form-control-dark" name="title" placeholder="Masukkan judul berita"
                    value="<?= isset($_POST['title']) ? htmlspecialchars($_POST['title']) : '' ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label-dark">Konten</label>
                <textarea class="form-control-dark" name="content" placeholder="Tulis isi berita..."
                    required><?= isset($_POST['content']) ? htmlspecialchars($_POST['content']) : '' ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label-dark">Author</label>
                <input type="text" class="form-control-dark" name="author" placeholder="Nama penulis"
                    value="<?= isset($_POST['author']) ? htmlspecialchars($_POST['author']) : '' ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label-dark">Gambar</label>
                <input type="file" class="form-control-dark" name="image" accept="image/*" required>
            </div>
            <button type="submit" class="btn-primary-dark">
                <i class="bi bi-upload me-1"></i> Upload Berita
            </button>
        </form>
    </div>

<?php elseif ($action === 'form_edit' && $row): ?>
    <div class="page-header d-flex align-items-center justify-content-between">
        <div>
            <h2>Edit Berita</h2>
            <p>Ubah data berita yang sudah ada</p>
        </div>
        <a href="index.php?page=berita" class="btn-back-sm"><i class="bi bi-arrow-left"></i> Kembali</a>
    </div>
    <div class="card-dark card-dark-pad card-max-md">
        <form action="index.php?page=berita&action=edit" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $row['id'] ?>">
            <input type="hidden" name="image_lama" value="<?= $row['image'] ?>">
            <div class="mb-3">
                <label class="form-label-dark">Judul</label>
                <input type="text" class="form-control-dark" name="title" value="<?= htmlspecialchars($row['title']) ?>"
                    required>
            </div>
            <div class="mb-3">
                <label class="form-label-dark">Konten</label>
                <textarea class="form-control-dark" name="content"
                    required><?= htmlspecialchars($row['content']) ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label-dark">Author</label>
                <input type="text" class="form-control-dark" name="author" value="<?= htmlspecialchars($row['author']) ?>"
                    required>
            </div>
            <div class="mb-3">
                <label class="form-label-dark">Gambar Saat Ini</label>
                <img src="upload/<?= htmlspecialchars($row['image']) ?>" class="img-preview" alt="img">
                <label class="form-label-dark form-label-hint">Ganti gambar (opsional)</label>
                <input type="file" class="form-control-dark" name="image" accept="image/*">
            </div>
            <button type="submit" class="btn-primary-dark">
                <i class="bi bi-save me-1"></i> Simpan Perubahan
            </button>
        </form>
    </div>

<?php elseif ($action === 'detail' && $row): ?>
    <div class="page-header d-flex align-items-center justify-content-between">
        <div>
            <h2>Detail Berita</h2>
            <p>Informasi lengkap berita</p>
        </div>
        <a href="index.php?page=berita" class="btn-back-sm"><i class="bi bi-arrow-left"></i> Kembali</a>
    </div>
    <div class="card-dark card-detail">
        <img src="upload/<?= htmlspecialchars($row['image']) ?>" class="detail-img" alt="img">
        <div class="card-dark-pad">
            <h3 class="detail-title"><?= htmlspecialchars($row['title']) ?></h3>
            <div class="detail-meta">
                <span><i class="bi bi-person"></i><?= htmlspecialchars($row['author']) ?></span>
                <span><i class="bi bi-calendar3"></i><?= $row['date'] ?></span>
            </div>
            <p class="detail-body"><?= nl2br(htmlspecialchars($row['content'])) ?></p>
            <div class="detail-actions">
                <a href="index.php?page=berita&action=form_edit&id=<?= $row['id'] ?>"
                    class="aksi-btn btn-edit-sm aksi-btn-lg">
                    <i class="bi bi-pencil me-1"></i>Edit
                </a>
                <a href="index.php?page=berita&action=hapus&id=<?= $row['id'] ?>" class="aksi-btn btn-hapus-sm aksi-btn-lg"
                    onclick="return confirm('Yakin hapus berita ini?')">
                    <i class="bi bi-trash me-1"></i>Hapus
                </a>
            </div>
        </div>
    </div>
<?php endif; ?>