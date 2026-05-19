<?php
include 'koneksi.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'list';
$pesan = '';
$pesan_type = '';

if ($action === 'tambah' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama_lengkap']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $level = $_POST['level'];

    if (empty($nama) || empty($username) || empty($password)) {
        $pesan = "Semua field wajib diisi!";
        $pesan_type = 'danger';
        $action = 'form_tambah';
    } elseif (strlen($password) < 6) {
        $pesan = "Password minimal 6 karakter!";
        $pesan_type = 'danger';
        $action = 'form_tambah';
    } else {
        $cek = $conn->prepare("SELECT id FROM tb_user WHERE username=?");
        $cek->bind_param("s", $username);
        $cek->execute();
        $cek->store_result();
        if ($cek->num_rows > 0) {
            $pesan = "Username sudah digunakan!";
            $pesan_type = 'danger';
            $action = 'form_tambah';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO tb_user (nama_lengkap, username, password, level) VALUES (?,?,?,?)");
            $stmt->bind_param("ssss", $nama, $username, $hash, $level);
            if ($stmt->execute()) {
                $pesan = "User berhasil ditambahkan!";
                $pesan_type = 'success';
                $action = 'list';
            } else {
                $pesan = "Error: " . $conn->error;
                $pesan_type = 'danger';
                $action = 'form_tambah';
            }
        }
    }
}

if ($action === 'edit' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int) $_POST['id'];
    $nama = trim($_POST['nama_lengkap']);
    $username = trim($_POST['username']);
    $level = $_POST['level'];
    $password = $_POST['password'];

    $cek = $conn->prepare("SELECT id FROM tb_user WHERE username=? AND id!=?");
    $cek->bind_param("si", $username, $id);
    $cek->execute();
    $cek->store_result();
    if ($cek->num_rows > 0) {
        $pesan = "Username sudah digunakan user lain!";
        $pesan_type = 'danger';
    } else {
        if (!empty($password)) {
            if (strlen($password) < 6) {
                $pesan = "Password minimal 6 karakter!";
                $pesan_type = 'danger';
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("UPDATE tb_user SET nama_lengkap=?, username=?, password=?, level=? WHERE id=?");
                $stmt->bind_param("ssssi", $nama, $username, $hash, $level, $id);
            }
        } else {
            $stmt = $conn->prepare("UPDATE tb_user SET nama_lengkap=?, username=?, level=? WHERE id=?");
            $stmt->bind_param("sssi", $nama, $username, $level, $id);
        }
        if (empty($pesan) && isset($stmt)) {
            if ($stmt->execute()) {
                $pesan = "User berhasil diperbarui!";
                $pesan_type = 'success';
                $action = 'list';
            } else {
                $pesan = "Error: " . $conn->error;
                $pesan_type = 'danger';
            }
        }
    }
    if (!empty($pesan) && $pesan_type === 'danger')
        $action = 'list';
}

if ($action === 'hapus' && isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    if ($id == $_SESSION['id']) {
        $pesan = "Tidak bisa menghapus akun sendiri!";
        $pesan_type = 'danger';
    } else {
        $d = $conn->prepare("DELETE FROM tb_user WHERE id=?");
        $d->bind_param("i", $id);
        $d->execute();
        $pesan = "User berhasil dihapus!";
        $pesan_type = 'success';
    }
    $action = 'list';
}

$row = null;
if (in_array($action, ['form_edit', 'detail']) && isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM tb_user WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    if (!$row)
        $action = 'list';
}

$list = null;
if ($action === 'list') {
    $list = $conn->query("SELECT * FROM tb_user ORDER BY id DESC");
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
            <h2>Manajemen User</h2>
            <p>Kelola semua akun user yang terdaftar</p>
        </div>
        <a href="index.php?page=user&action=form_tambah" class="btn-primary-dark">
            <i class="bi bi-person-plus"></i> Tambah User
        </a>
    </div>
    <div class="card-dark">
        <table class="table-dark-custom">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Lengkap</th>
                    <th>Username</th>
                    <th>Level</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($list->num_rows === 0): ?>
                    <tr>
                        <td colspan="5" class="empty-state">
                            <i class="bi bi-people"></i>Belum ada user
                        </td>
                    </tr>
                <?php else:
                    $no = 1;
                    while ($r = $list->fetch_assoc()): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($r['nama_lengkap']) ?></td>
                            <td><span class="username-mono">@<?= htmlspecialchars($r['username']) ?></span></td>
                            <td><span class="badge-<?= $r['level'] ?>"><?= ucfirst($r['level']) ?></span></td>
                            <td>
                                <a href="index.php?page=user&action=detail&id=<?= $r['id'] ?>" class="aksi-btn btn-detail-sm">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                                <a href="index.php?page=user&action=form_edit&id=<?= $r['id'] ?>" class="aksi-btn btn-edit-sm">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <?php if ($r['id'] != $_SESSION['id']): ?>
                                    <a href="index.php?page=user&action=hapus&id=<?= $r['id'] ?>" class="aksi-btn btn-hapus-sm"
                                        onclick="return confirm('Yakin hapus user ini?')">
                                        <i class="bi bi-trash"></i> Hapus
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; endif; ?>
            </tbody>
        </table>
    </div>

<?php elseif ($action === 'form_tambah'): ?>
    <div class="page-header d-flex align-items-center justify-content-between">
        <div>
            <h2>Tambah User</h2>
            <p>Buat akun user baru</p>
        </div>
        <a href="index.php?page=user" class="btn-back-sm"><i class="bi bi-arrow-left"></i> Kembali</a>
    </div>
    <div class="card-dark card-dark-pad card-max-sm">
        <form action="index.php?page=user&action=tambah" method="POST">
            <div class="mb-3">
                <label class="form-label-dark">Nama Lengkap</label>
                <input type="text" class="form-control-dark" name="nama_lengkap" placeholder="Masukkan nama lengkap"
                    value="<?= isset($_POST['nama_lengkap']) ? htmlspecialchars($_POST['nama_lengkap']) : '' ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label-dark">Username</label>
                <input type="text" class="form-control-dark" name="username" placeholder="Buat username unik"
                    value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label-dark">Password</label>
                <input type="password" class="form-control-dark" name="password" placeholder="Min. 6 karakter" required>
            </div>
            <div class="mb-3">
                <label class="form-label-dark">Level</label>
                <select class="form-control-dark" name="level">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <button type="submit" class="btn-primary-dark">
                <i class="bi bi-person-plus me-1"></i> Tambah User
            </button>
        </form>
    </div>

<?php elseif ($action === 'form_edit' && $row): ?>
    <div class="page-header d-flex align-items-center justify-content-between">
        <div>
            <h2>Edit User</h2>
            <p>Ubah data user yang sudah ada</p>
        </div>
        <a href="index.php?page=user" class="btn-back-sm"><i class="bi bi-arrow-left"></i> Kembali</a>
    </div>
    <div class="card-dark card-dark-pad card-max-sm">
        <form action="index.php?page=user&action=edit" method="POST">
            <input type="hidden" name="id" value="<?= $row['id'] ?>">
            <div class="mb-3">
                <label class="form-label-dark">Nama Lengkap</label>
                <input type="text" class="form-control-dark" name="nama_lengkap"
                    value="<?= htmlspecialchars($row['nama_lengkap']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label-dark">Username</label>
                <input type="text" class="form-control-dark" name="username"
                    value="<?= htmlspecialchars($row['username']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label-dark">
                    Password Baru <span class="form-label-hint">(kosongkan jika tidak ingin ganti)</span>
                </label>
                <input type="password" class="form-control-dark" name="password" placeholder="Masukkan password baru">
            </div>
            <div class="mb-3">
                <label class="form-label-dark">Level</label>
                <select class="form-control-dark" name="level">
                    <option value="user" <?= $row['level'] === 'user' ? 'selected' : '' ?>>User</option>
                    <option value="admin" <?= $row['level'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                </select>
            </div>
            <button type="submit" class="btn-primary-dark">
                <i class="bi bi-save me-1"></i> Simpan Perubahan
            </button>
        </form>
    </div>

<?php elseif ($action === 'detail' && $row): ?>
    <div class="page-header d-flex align-items-center justify-content-between">
        <div>
            <h2>Detail User</h2>
            <p>Informasi lengkap akun user</p>
        </div>
        <a href="index.php?page=user" class="btn-back-sm"><i class="bi bi-arrow-left"></i> Kembali</a>
    </div>
    <div class="card-dark card-dark-pad card-max-xs">
        <div class="user-profile">
            <div class="user-avatar">
                <?= strtoupper(substr($row['nama_lengkap'], 0, 1)) ?>
            </div>
            <div>
                <div class="user-profile-name"><?= htmlspecialchars($row['nama_lengkap']) ?></div>
                <div class="user-profile-username">@<?= htmlspecialchars($row['username']) ?></div>
            </div>
        </div>
        <table class="detail-table">
            <tr>
                <td class="td-label">ID</td>
                <td class="td-value">#<?= $row['id'] ?></td>
            </tr>
            <tr>
                <td class="td-label">Nama Lengkap</td>
                <td class="td-value"><?= htmlspecialchars($row['nama_lengkap']) ?></td>
            </tr>
            <tr>
                <td class="td-label">Username</td>
                <td class="td-value">@<?= htmlspecialchars($row['username']) ?></td>
            </tr>
            <tr>
                <td class="td-label">Level</td>
                <td class="td-value"><span
                        class="badge-<?= $r['level'] ?? $row['level'] ?>"><?= ucfirst($row['level']) ?></span></td>
            </tr>
        </table>
        <div class="detail-user-actions">
            <a href="index.php?page=user&action=form_edit&id=<?= $row['id'] ?>" class="aksi-btn btn-edit-sm aksi-btn-lg">
                <i class="bi bi-pencil me-1"></i>Edit
            </a>
            <?php if ($row['id'] != $_SESSION['id']): ?>
                <a href="index.php?page=user&action=hapus&id=<?= $row['id'] ?>" class="aksi-btn btn-hapus-sm aksi-btn-lg"
                    onclick="return confirm('Yakin hapus user ini?')">
                    <i class="bi bi-trash me-1"></i>Hapus
                </a>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>