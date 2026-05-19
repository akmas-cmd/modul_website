<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Login – Ekskul SMA Nusantara</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background: linear-gradient(135deg, #1a3c5e 0%, #0f2540 60%, #1e3a8a 100%);
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
            padding: 2.5rem 2rem; width: 100%; max-width: 420px;
            box-shadow: 0 30px 80px rgba(0,0,0,0.3);
            position: relative; z-index: 1;
        }
        .logo-icon {
            width: 64px; height: 64px; border-radius: 16px;
            background: linear-gradient(135deg, #1a3c5e, #2563eb);
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 1.8rem; color: #fff;
            box-shadow: 0 8px 20px rgba(26,60,94,.35);
        }
        .form-label { font-weight: 600; font-size: .85rem; color: #1e293b; }
        .form-control {
            border: 1.5px solid #e2e8f0; border-radius: 10px;
            padding: .6rem .9rem; font-size: .9rem; font-family: 'Outfit', sans-serif;
        }
        .form-control:focus {
            border-color: #1a3c5e;
            box-shadow: 0 0 0 3px rgba(26,60,94,.15);
        }
        .icon-input { position: relative; }
        .icon-input .bi { position: absolute; left: .85rem; top: 50%; transform: translateY(-50%); color: #94a3b8; }
        .icon-input .form-control { padding-left: 2.3rem; }
        .btn-login {
            background: linear-gradient(135deg, #1a3c5e, #2563eb);
            color: #fff; border: none; border-radius: 10px;
            padding: .75rem; font-size: .95rem; font-weight: 700;
            width: 100%; cursor: pointer; transition: opacity .2s, transform .1s;
            font-family: 'Outfit', sans-serif;
        }
        .btn-login:hover { opacity: .9; transform: translateY(-1px); }
        .link-switch { color: #2563eb; font-weight: 600; text-decoration: none; }
        .link-switch:hover { text-decoration: underline; }
        .info-box {
            background: #f0f9ff; border: 1px solid #bae6fd;
            border-radius: 10px; padding: .75rem 1rem; font-size: .8rem; color: #0369a1;
        }
    </style>
</head>
<body>
<div class="card-auth">
    <!-- Logo -->
    <div class="text-center mb-4">
        <div class="logo-icon mb-2"><i class="bi bi-mortarboard-fill"></i></div>
        <h4 class="fw-800 mb-0" style="color:#1a3c5e">Login Sistem</h4>
        <p class="text-muted" style="font-size:.83rem">Pendaftaran Ekskul – SMA Nusantara</p>
    </div>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger py-2 px-3 mb-3" style="font-size:.85rem;border-radius:10px">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <?= htmlspecialchars($_GET['error']) ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['logout'])): ?>
        <div class="alert alert-success py-2 px-3 mb-3" style="font-size:.85rem;border-radius:10px">
            <i class="bi bi-check-circle-fill me-2"></i>
            Anda telah berhasil logout.
        </div>
    <?php endif; ?>

    <form method="POST" action="proses_login.php">
        <div class="mb-3">
            <label class="form-label">Username</label>
            <div class="icon-input">
                <i class="bi bi-person"></i>
                <input type="text" name="username" class="form-control" placeholder="Masukkan username" required/>
            </div>
        </div>
        <div class="mb-4">
            <label class="form-label">Password</label>
            <div class="icon-input">
                <i class="bi bi-lock"></i>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password" required/>
            </div>
        </div>
        <button type="submit" name="login" class="btn-login">
            <i class="bi bi-box-arrow-in-right me-2"></i>Masuk ke Sistem
        </button>
    </form>

    <hr class="my-3" style="border-color:#e2e8f0"/>

    <p class="text-center text-muted mb-3" style="font-size:.85rem">
        Belum punya akun? <a href="register.php" class="link-switch">Daftar sekarang</a>
    </p>

    <!-- Info demo -->
    <div class="info-box">
        <strong><i class="bi bi-info-circle me-1"></i>Daftar dulu via register.php</strong><br>
        Buat akun dengan level <b>admin</b> atau <b>user</b> melalui halaman registrasi.
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>