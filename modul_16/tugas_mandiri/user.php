<?php
// =====================================================
// user.php - Halaman User (level: user)
// Akses: VIEW data saja – tidak bisa INSERT/UPDATE/DELETE
// =====================================================
$level_akses = "user";  // <-- Tentukan level SEBELUM include cek.php
include "cek.php";       // <-- Guard: cek session & level
include "koneksi.php";

// ── AMBIL DATA ────────────────────────────────────
$search = isset($_GET['q']) ? $conn->real_escape_string(trim($_GET['q'])) : '';
$where  = $search ? "WHERE nama_siswa LIKE '%$search%' OR ekskul LIKE '%$search%' OR kelas LIKE '%$search%'" : '';
$data   = $conn->query("SELECT * FROM tb_ekskul $where ORDER BY nama_siswa ASC");

// ── STATISTIK ─────────────────────────────────────
$total = $conn->query("SELECT COUNT(*) as c FROM tb_ekskul")->fetch_assoc()['c'];
$aktif = $conn->query("SELECT COUNT(*) as c FROM tb_ekskul WHERE status='Aktif'")->fetch_assoc()['c'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Dashboard User – Ekskul SMA Nusantara</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
    <style>
        :root { --primary:#0f766e; --accent:#f59e0b; }
        body { font-family:'Outfit',sans-serif; background:#f0fdf4; min-height:100vh; }

        /* ── NAVBAR ── */
        .navbar-custom {
            background: var(--primary); padding:.75rem 1.5rem;
            box-shadow: 0 4px 12px rgba(0,0,0,.15);
        }
        .navbar-brand-txt { font-weight:800; color:#fff; font-size:1.1rem; }
        .navbar-brand-txt span { color:#6ee7b7; }
        .badge-user { background:#6ee7b7; color:#065f46; border-radius:20px; padding:.2rem .75rem; font-size:.78rem; font-weight:700; }
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
        .table tbody tr:hover { background:#f0fdf4; }

        /* ── BADGES ── */
        .badge-ekskul { background:rgba(5,150,105,.12); color:#065f46; border-radius:20px; padding:.22rem .65rem; font-size:.76rem; font-weight:600; }
        .badge-aktif { background:#d1fae5; color:#065f46; border-radius:20px; padding:.22rem .65rem; font-size:.76rem; font-weight:600; }
        .badge-nonaktif { background:#fee2e2; color:#991b1b; border-radius:20px; padding:.22rem .65rem; font-size:.76rem; font-weight:600; }

        /* ── SEARCH ── */
        .search-box { position:relative; }
        .search-box .bi { position:absolute; left:.75rem; top:50%; transform:translateY(-50%); color:#94a3b8; }
        .search-box input { padding-left:2.2rem; border-radius:10px; border:1.5px solid #d1fae5; font-family:'Outfit',sans-serif; }
        .search-box input:focus { border-color:var(--primary); box-shadow:0 0 0 3px rgba(15,118,110,.1); outline:none; }

        /* ── INFO BANNER ── */
        .info-banner {
            background: linear-gradient(135deg,#d1fae5,#a7f3d0);
            border: 1px solid #6ee7b7; border-radius: 12px;
            padding: .9rem 1.2rem; font-size: .85rem; color: #065f46;
        }
        .wrapper { max-width:1100px; margin:0 auto; padding:1.5rem; }
        .page-header { margin-bottom:1.3rem; padding-bottom:.8rem; border-bottom:2px solid #d1fae5; }
        .page-header h4 { font-weight:800; color:var(--primary); }
    </style>
</head>
<body>

<!-- ── NAVBAR ── -->
<nav class="navbar-custom d-flex align-items-center justify-content-between">
    <div>
        <span class="navbar-brand-txt"><i class="bi bi-mortarboard-fill me-2" style="color:#6ee7b7"></i>SMA <span>Nusantara</span></span>
        <span class="badge-user ms-2"><i class="bi bi-person-fill me-1"></i>USER</span>
    </div>
    <div class="d-flex align-items-center gap-3">
        <span class="user-info"><i class="bi bi-person-circle me-1"></i><?= htmlspecialchars($_SESSION['username']) ?></span>
        <a href="logout.php" class="btn-logout-nav"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>
</nav>

<div class="wrapper">

    <!-- ── INFO READ-ONLY BANNER ── -->
    <div class="info-banner mb-4">
        <i class="bi bi-eye-fill me-2"></i>
        <strong>Mode Lihat Saja (Read Only)</strong> – Anda login sebagai <strong>User</strong>.
        Anda hanya dapat melihat data pendaftaran. Untuk mengelola data, hubungi Administrator.
    </div>

    <!-- ── STATISTIK ── -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-icon" style="background:#f0fdf4"><i class="bi bi-people-fill" style="color:var(--primary)"></i></div>
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
                <div class="stat-icon" style="background:#fef9c3"><i class="bi bi-trophy-fill" style="color:#ca8a04"></i></div>
                <div><div class="stat-val"><?=$total-$aktif?></div><div class="stat-lbl">Non-Aktif</div></div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-icon" style="background:#eff6ff"><i class="bi bi-journal-check" style="color:#2563eb"></i></div>
                <div><div class="stat-val"><?=date('Y')?></div><div class="stat-lbl">Tahun Ajaran</div></div>
            </div>
        </div>
    </div>

    <!-- ── TABEL DATA ── -->
    <div class="page-header">
        <h4><i class="bi bi-clipboard2-data me-2" style="color:var(--accent)"></i>Data Pendaftaran Ekstrakurikuler</h4>
    </div>

    <!-- Search -->
    <div class="row mb-3">
        <div class="col-md-5">
            <form method="GET" action="user.php">
                <div class="search-box">
                    <i class="bi bi-search"></i>
                    <input type="text" name="q" class="form-control" placeholder="Cari nama siswa / ekskul / kelas..." value="<?=htmlspecialchars($search)?>"/>
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
                        <th>Ekstrakurikuler</th>
                        <th>Tanggal Daftar</th>
                        <th>Status</th>
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
                    </tr>
                <?php endwhile; else: ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="bi bi-inbox me-2"></i>Tidak ada data ditemukan
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <p class="text-muted mt-2" style="font-size:.8rem">
        <i class="bi bi-info-circle me-1"></i>Menampilkan <?=$total?> data pendaftaran
    </p>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>