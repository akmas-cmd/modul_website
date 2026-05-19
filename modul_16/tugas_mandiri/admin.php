<?php
// =====================================================
// admin.php - Halaman Admin (level: admin)
// Akses: INSERT, UPDATE, DELETE, VIEW data ekskul
// =====================================================
$level_akses = "admin";  // <-- Tentukan level SEBELUM include cek.php
include "cek.php";        // <-- Guard: cek session & level
include "koneksi.php";

// ── PROSES HAPUS ─────────────────────────────────
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    $conn->query("DELETE FROM tb_ekskul WHERE id = $id");
    header("Location: admin.php?msg=hapus");
    exit();
}

// ── PROSES SIMPAN (INSERT / UPDATE) ──────────────
if (isset($_POST['simpan'])) {
    $nama      = $conn->real_escape_string(trim($_POST['nama_siswa']));
    $kelas     = $conn->real_escape_string($_POST['kelas']);
    $ekskul    = $conn->real_escape_string($_POST['ekskul']);
    $tgl       = $conn->real_escape_string($_POST['tgl_daftar']);
    $status    = $conn->real_escape_string($_POST['status']);
    $id_edit   = (int)$_POST['id_edit'];

    if ($id_edit > 0) {
        // UPDATE
        $conn->query("UPDATE tb_ekskul SET
            nama_siswa='$nama', kelas='$kelas', ekskul='$ekskul',
            tgl_daftar='$tgl', status='$status'
            WHERE id=$id_edit");
        header("Location: admin.php?msg=update");
    } else {
        // INSERT
        $conn->query("INSERT INTO tb_ekskul (nama_siswa, kelas, ekskul, tgl_daftar, status)
            VALUES ('$nama','$kelas','$ekskul','$tgl','$status')");
        header("Location: admin.php?msg=tambah");
    }
    exit();
}

// ── AMBIL DATA EDIT ───────────────────────────────
$edit_data = null;
if (isset($_GET['edit'])) {
    $id_edit   = (int)$_GET['edit'];
    $res       = $conn->query("SELECT * FROM tb_ekskul WHERE id=$id_edit");
    $edit_data = $res->fetch_assoc();
}

// ── AMBIL SEMUA DATA ──────────────────────────────
$search = isset($_GET['q']) ? $conn->real_escape_string(trim($_GET['q'])) : '';
$where  = $search ? "WHERE nama_siswa LIKE '%$search%' OR ekskul LIKE '%$search%'" : '';
$data   = $conn->query("SELECT * FROM tb_ekskul $where ORDER BY id DESC");

// ── STATISTIK ─────────────────────────────────────
$total  = $conn->query("SELECT COUNT(*) as c FROM tb_ekskul")->fetch_assoc()['c'];
$aktif  = $conn->query("SELECT COUNT(*) as c FROM tb_ekskul WHERE status='Aktif'")->fetch_assoc()['c'];
$rekap  = $conn->query("SELECT ekskul, COUNT(*) as jml FROM tb_ekskul GROUP BY ekskul ORDER BY jml DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Dashboard Admin – Ekskul SMA Nusantara</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
    <style>
        :root { --primary:#1a3c5e; --accent:#f59e0b; --green:#059669; }
        body { font-family:'Outfit',sans-serif; background:#f0f4f8; min-height:100vh; }

        /* ── NAVBAR ── */
        .navbar-custom {
            background: var(--primary); padding:.75rem 1.5rem;
            box-shadow: 0 4px 12px rgba(0,0,0,.15);
        }
        .navbar-brand-txt { font-weight:800; color:#fff; font-size:1.1rem; }
        .navbar-brand-txt span { color:var(--accent); }
        .badge-admin { background:var(--accent); color:#000; border-radius:20px; padding:.2rem .75rem; font-size:.78rem; font-weight:700; }
        .user-info { color:rgba(255,255,255,.85); font-size:.85rem; }
        .btn-logout-nav {
            background:rgba(239,68,68,.8); color:#fff; border:none;
            border-radius:8px; padding:.35rem .9rem; font-size:.82rem; font-weight:600;
            text-decoration:none; display:inline-flex; align-items:center; gap:.3rem;
            transition:background .2s;
        }
        .btn-logout-nav:hover { background:#dc2626; color:#fff; }

        /* ── STAT CARDS ── */
        .stat-card {
            background:#fff; border-radius:14px; padding:1.2rem 1.4rem;
            box-shadow:0 4px 15px rgba(0,0,0,.07);
            display:flex; align-items:center; gap:1rem;
        }
        .stat-icon { width:48px; height:48px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:1.3rem; }
        .stat-val { font-size:1.8rem; font-weight:800; color:var(--primary); line-height:1; }
        .stat-lbl { font-size:.78rem; color:#64748b; margin-top:.1rem; }

        /* ── TABLE ── */
        .table-card { background:#fff; border-radius:16px; overflow:hidden; box-shadow:0 4px 20px rgba(0,0,0,.07); }
        .table thead th { background:var(--primary); color:#fff; font-size:.8rem; text-transform:uppercase; letter-spacing:.04em; border:none; padding:.85rem 1rem; }
        .table tbody td { padding:.75rem 1rem; font-size:.88rem; vertical-align:middle; border-color:#f1f5f9; }
        .table tbody tr:hover { background:#f8fafc; }

        /* ── FORM CARD ── */
        .form-card { background:#fff; border-radius:16px; padding:1.5rem; box-shadow:0 4px 20px rgba(0,0,0,.07); }
        .form-card h5 { color:var(--primary); font-weight:700; margin-bottom:1.2rem; }
        .form-label { font-size:.83rem; font-weight:600; color:#1e293b; }
        .form-control, .form-select { border:1.5px solid #e2e8f0; border-radius:8px; font-size:.88rem; font-family:'Outfit',sans-serif; }
        .form-control:focus, .form-select:focus { border-color:var(--primary); box-shadow:0 0 0 3px rgba(26,60,94,.1); }

        /* ── BUTTONS ── */
        .btn-simpan { background:var(--primary); color:#fff; border:none; border-radius:8px; padding:.55rem 1.3rem; font-weight:600; font-family:'Outfit',sans-serif; }
        .btn-simpan:hover { background:#0f2540; color:#fff; }
        .btn-batal { background:#f1f5f9; color:#64748b; border:none; border-radius:8px; padding:.55rem 1.1rem; font-weight:600; font-family:'Outfit',sans-serif; }
        .btn-edit-tbl { background:rgba(245,158,11,.12); color:#d97706; border:1px solid rgba(245,158,11,.3); border-radius:6px; padding:.25rem .6rem; font-size:.78rem; font-weight:600; text-decoration:none; }
        .btn-edit-tbl:hover { background:rgba(245,158,11,.25); color:#d97706; }
        .btn-del-tbl { background:rgba(239,68,68,.1); color:#dc2626; border:1px solid rgba(239,68,68,.25); border-radius:6px; padding:.25rem .6rem; font-size:.78rem; font-weight:600; text-decoration:none; }
        .btn-del-tbl:hover { background:rgba(239,68,68,.22); color:#dc2626; }

        /* ── BADGES ── */
        .badge-ekskul { background:rgba(37,99,235,.1); color:#2563eb; border-radius:20px; padding:.22rem .65rem; font-size:.76rem; font-weight:600; }
        .badge-aktif { background:#d1fae5; color:#065f46; border-radius:20px; padding:.22rem .65rem; font-size:.76rem; font-weight:600; }
        .badge-nonaktif { background:#fee2e2; color:#991b1b; border-radius:20px; padding:.22rem .65rem; font-size:.76rem; font-weight:600; }

        /* ── SEARCH ── */
        .search-box { position:relative; }
        .search-box .bi { position:absolute; left:.75rem; top:50%; transform:translateY(-50%); color:#94a3b8; }
        .search-box input { padding-left:2.2rem; border-radius:10px; }

        /* ── ALERT ── */
        .alert-top { border-radius:10px; font-size:.85rem; padding:.6rem 1rem; }

        .page-header { margin-bottom:1.3rem; padding-bottom:.8rem; border-bottom:2px solid #e2e8f0; }
        .page-header h4 { font-weight:800; color:var(--primary); }
        .wrapper { max-width:1200px; margin:0 auto; padding:1.5rem; }
    </style>
</head>
<body>

<!-- ── NAVBAR ── -->
<nav class="navbar-custom d-flex align-items-center justify-content-between">
    <div>
        <span class="navbar-brand-txt"><i class="bi bi-mortarboard-fill me-2" style="color:var(--accent)"></i>SMA <span>Nusantara</span></span>
        <span class="badge-admin ms-2"><i class="bi bi-shield-fill me-1"></i>ADMIN</span>
    </div>
    <div class="d-flex align-items-center gap-3">
        <span class="user-info"><i class="bi bi-person-circle me-1"></i><?= htmlspecialchars($_SESSION['username']) ?></span>
        <a href="logout.php" class="btn-logout-nav"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>
</nav>

<div class="wrapper">

    <!-- ── ALERT PESAN ── -->
    <?php if (isset($_GET['msg'])): ?>
        <?php $msgs = ['tambah'=>['success','Data berhasil ditambahkan!'],'update'=>['success','Data berhasil diperbarui!'],'hapus'=>['danger','Data berhasil dihapus!']]; ?>
        <?php if (isset($msgs[$_GET['msg']])): [$type,$txt] = $msgs[$_GET['msg']]; ?>
            <div class="alert alert-<?=$type?> alert-top alert-dismissible fade show mb-3" role="alert">
                <i class="bi bi-<?=$type=='success'?'check-circle':'trash'?>-fill me-2"></i><?=$txt?>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <!-- ── STATISTIK ── -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-icon" style="background:#eff6ff"><i class="bi bi-people-fill" style="color:#2563eb"></i></div>
                <div><div class="stat-val"><?=$total?></div><div class="stat-lbl">Total Peserta</div></div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-icon" style="background:#f0fdf4"><i class="bi bi-check-circle-fill" style="color:#16a34a"></i></div>
                <div><div class="stat-val"><?=$aktif?></div><div class="stat-lbl">Status Aktif</div></div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-icon" style="background:#fff7ed"><i class="bi bi-trophy-fill" style="color:#ea580c"></i></div>
                <div><div class="stat-val"><?=$total-$aktif?></div><div class="stat-lbl">Non-Aktif</div></div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-icon" style="background:#fdf4ff"><i class="bi bi-person-badge-fill" style="color:#7c3aed"></i></div>
                <div>
                    <div class="stat-val"><?=$rekap->num_rows?></div>
                    <div class="stat-lbl">Jenis Ekskul</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- ── FORM INSERT / UPDATE ── -->
        <div class="col-lg-4">
            <div class="form-card">
                <h5>
                    <i class="bi bi-<?=$edit_data?'pencil':'plus-circle'?>-fill me-2" style="color:var(--<?=$edit_data?'accent':'green'?>)"></i>
                    <?=$edit_data?'Edit Data':'Tambah Data'?>
                </h5>
                <form method="POST" action="admin.php">
                    <input type="hidden" name="id_edit" value="<?=$edit_data?$edit_data['id']:0?>"/>
                    <div class="mb-2">
                        <label class="form-label">Nama Siswa</label>
                        <input type="text" name="nama_siswa" class="form-control" value="<?=$edit_data?htmlspecialchars($edit_data['nama_siswa']):''?>" placeholder="Nama lengkap" required/>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Kelas</label>
                        <select name="kelas" class="form-select" required>
                            <option value="">-- Pilih Kelas --</option>
                            <?php
                            $kelas_list = ['X-A','X-B','X-C','XI-A','XI-B','XI-C','XII-A','XII-B','XII-C'];
                            foreach ($kelas_list as $k):
                                $sel = ($edit_data && $edit_data['kelas']==$k) ? 'selected' : '';
                            ?>
                                <option value="<?=$k?>" <?=$sel?>><?=$k?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Ekstrakurikuler</label>
                        <select name="ekskul" class="form-select" required>
                            <option value="">-- Pilih Ekskul --</option>
                            <?php
                            $ekskul_list = ['Paskibra','PMR','OSIS','Basket','Voli','Futsal','Paduan Suara','Tari Tradisional','Robotika','English Club'];
                            foreach ($ekskul_list as $e):
                                $sel = ($edit_data && $edit_data['ekskul']==$e) ? 'selected' : '';
                            ?>
                                <option value="<?=$e?>" <?=$sel?>><?=$e?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Tanggal Daftar</label>
                        <input type="date" name="tgl_daftar" class="form-control" value="<?=$edit_data?$edit_data['tgl_daftar']:date('Y-m-d')?>" required/>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="Aktif" <?=($edit_data&&$edit_data['status']=='Aktif')?'selected':''?>>Aktif</option>
                            <option value="Non-Aktif" <?=($edit_data&&$edit_data['status']=='Non-Aktif')?'selected':''?>>Non-Aktif</option>
                        </select>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" name="simpan" class="btn-simpan btn">
                            <i class="bi bi-save me-1"></i><?=$edit_data?'Update':'Simpan'?>
                        </button>
                        <?php if ($edit_data): ?>
                            <a href="admin.php" class="btn-batal btn"><i class="bi bi-x-circle me-1"></i>Batal</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

        <!-- ── TABEL DATA ── -->
        <div class="col-lg-8">
            <div class="page-header">
                <h4><i class="bi bi-table me-2" style="color:var(--accent)"></i>Data Pendaftaran Ekskul</h4>
            </div>

            <!-- Search -->
            <div class="row mb-3">
                <div class="col-md-5">
                    <form method="GET" action="admin.php">
                        <div class="search-box">
                            <i class="bi bi-search"></i>
                            <input type="text" name="q" class="form-control" placeholder="Cari nama / ekskul..." value="<?=htmlspecialchars($search)?>"/>
                        </div>
                    </form>
                </div>
            </div>

            <div class="table-card">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Ekskul</th>
                                <th>Tgl. Daftar</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $no = 1;
                        if ($data->num_rows > 0):
                            while ($row = $data->fetch_assoc()):
                                $tgl_fmt = date('d M Y', strtotime($row['tgl_daftar']));
                        ?>
                            <tr>
                                <td><?=$no++?></td>
                                <td><strong><?=htmlspecialchars($row['nama_siswa'])?></strong></td>
                                <td><span class="badge bg-secondary"><?=$row['kelas']?></span></td>
                                <td><span class="badge-ekskul"><?=htmlspecialchars($row['ekskul'])?></span></td>
                                <td style="font-size:.82rem"><?=$tgl_fmt?></td>
                                <td>
                                    <span class="badge-<?=$row['status']=='Aktif'?'aktif':'nonaktif'?>">
                                        <?=$row['status']?>
                                    </span>
                                </td>
                                <td>
                                    <a href="admin.php?edit=<?=$row['id']?>" class="btn-edit-tbl me-1">
                                        <i class="bi bi-pencil-fill me-1"></i>Edit
                                    </a>
                                    <a href="admin.php?hapus=<?=$row['id']?>" class="btn-del-tbl"
                                       onclick="return confirm('Yakin hapus data <?=htmlspecialchars($row['nama_siswa'])?>?')">
                                        <i class="bi bi-trash-fill me-1"></i>Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; else: ?>
                            <tr><td colspan="7" class="text-center text-muted py-4"><i class="bi bi-inbox me-2"></i>Tidak ada data ditemukan</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <p class="text-muted mt-2" style="font-size:.8rem"><i class="bi bi-info-circle me-1"></i>Total <?=$total?> data tercatat</p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>