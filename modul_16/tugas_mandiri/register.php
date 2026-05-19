<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Register – Ekskul SMA Nusantara</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background: linear-gradient(135deg, #1a3c5e 0%, #0f2540 60%, #1e5799 100%);
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
        }
        body::before {
            content: '';
            position: fixed; inset: 0; pointer-events: none;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/svg%3E");
        }
        .card-auth {
            background: #fff; border-radius: 20px;
            padding: 2.5rem 2rem; width: 100%; max-width: 440px;
            box-shadow: 0 30px 80px rgba(0,0,0,0.3);
            position: relative; z-index: 1;
        }
        .logo-icon {
            width: 64px; height: 64px; border-radius: 16px;
            background: linear-gradient(135deg, #059669, #10b981);
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 1.8rem; color: #fff;
            box-shadow: 0 8px 20px rgba(5,150,105,.35);
        }
        .form-label { font-weight: 600; font-size: .85rem; color: #1e293b; }
        .form-control, .form-select {
            border: 1.5px solid #e2e8f0; border-radius: 10px;
            padding: .6rem .9rem; font-size: .9rem; font-family: 'Outfit', sans-serif;
        }
        .form-control:focus, .form-select:focus {
            border-color: #059669;
            box-shadow: 0 0 0 3px rgba(5,150,105,.15);
        }
        .icon-input { position: relative; }
        .icon-input .bi { position: absolute; left: .85rem; top: 50%; transform: translateY(-50%); color: #94a3b8; }
        .icon-input .form-control,
        .icon-input .form-select { padding-left: 2.3rem; }
        .btn-daftar {
            background: linear-gradient(135deg, #059669, #10b981);
            color: #fff; border: none; border-radius: 10px;
            padding: .75rem; font-size: .95rem; font-weight: 700;
            width: 100%; cursor: pointer; transition: opacity .2s, transform .1s;
            font-family: 'Outfit', sans-serif;
        }
        .btn-daftar:hover { opacity: .9; transform: translateY(-1px); }
        .link-switch { color: #059669; font-weight: 600; text-decoration: none; }
        .link-switch:hover { text-decoration: underline; }
        .divider { border-color: #e2e8f0; }
    </style>
</head>
<body>
<div class="card-auth">
    <!-- Logo -->
    <div class="text-center mb-4">
        <div class="logo-icon mb-2"><i class="bi bi-person-plus-fill"></i></div>
        <h4 class="fw-800 mb-0" style="color:#1a3c5e">Daftar Akun Baru</h4>
        <p class="text-muted" style="font-size:.83rem">Sistem Ekskul – SMA Nusantara</p>
    </div>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger py-2 px-3" style="font-size:.85rem;border-radius:10px">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <?= htmlspecialchars($_GET['error']) ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['sukses'])): ?>
        <div class="alert alert-success py-2 px-3" style="font-size:.85rem;border-radius:10px">
            <i class="bi bi-check-circle-fill me-2"></i>
            Registrasi berhasil! <a href="login.php" class="link-switch">Login sekarang →</a>
        </div>
    <?php endif; ?>

    <form method="POST" action="proses_register.php">
        <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <div class="icon-input">
                <i class="bi bi-person"></i>
                <input type="text" name="nama" class="form-control" placeholder="Nama lengkap Anda" required/>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Username</label>
            <div class="icon-input">
                <i class="bi bi-at"></i>
                <input type="text" name="username" class="form-control" placeholder="Buat username unik" required/>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <div class="icon-input">
                <i class="bi bi-lock"></i>
                <input type="password" name="password" class="form-control" placeholder="Min. 6 karakter" required/>
            </div>
        </div>
        <div class="mb-4">
            <label class="form-label">Level Akses</label>
            <div class="icon-input">
                <i class="bi bi-shield-check"></i>
                <select name="level" class="form-select">
                    <option value="user">User – Hanya lihat data</option>
                    <option value="admin">Admin – Kelola data</option>
                </select>
            </div>
        </div>
        <button type="submit" name="submit" class="btn-daftar">
            <i class="bi bi-person-check me-2"></i>Daftar Sekarang
        </button>
    </form>

    <hr class="divider my-3"/>
    <p class="text-center text-muted mb-0" style="font-size:.85rem">
        Sudah punya akun? <a href="login.php" class="link-switch">Login di sini</a>
    </p>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>