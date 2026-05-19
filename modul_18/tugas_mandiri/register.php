<?php
session_start();
if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
include "koneksi.php";

$pesan = "";
$success = false;

if (isset($_POST['submit'])) {
    $nama = trim($_POST['nama_lengkap']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    if (empty($nama) || empty($username) || empty($password) || empty($confirm)) {
        $pesan = "Semua field wajib diisi!";
    } elseif ($password !== $confirm) {
        $pesan = "Konfirmasi password tidak cocok!";
    } elseif (strlen($password) < 6) {
        $pesan = "Password minimal 6 karakter!";
    } else {
        $cek = $conn->prepare("SELECT id FROM tb_user WHERE username = ?");
        $cek->bind_param("s", $username);
        $cek->execute();
        $cek->store_result();
        if ($cek->num_rows > 0) {
            $pesan = "Username sudah digunakan!";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $level = 'user';
            $stmt = $conn->prepare("INSERT INTO tb_user (nama_lengkap, username, password, level) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $nama, $username, $hash, $level);
            if ($stmt->execute()) {
                $success = true;
            } else {
                $pesan = "Gagal mendaftar: " . $conn->error;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar — Portal Berita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #0a0a0f 0%, #0d1b2a 40%, #0a1628 70%, #060d1a 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.12) 0%, transparent 70%);
            top: -100px;
            right: -100px;
            border-radius: 50%;
            pointer-events: none;
        }

        body::after {
            content: '';
            position: fixed;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.1) 0%, transparent 70%);
            bottom: -50px;
            left: -50px;
            border-radius: 50%;
            pointer-events: none;
        }

        .hero-title {
            font-size: 2.5rem;
            font-weight: 800;
            line-height: 1.2;
            color: #fff;
            margin-bottom: 1rem;
        }

        .hero-title span {
            background: linear-gradient(90deg, #818cf8, #60a5fa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-desc {
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.95rem;
            line-height: 1.8;
        }

        .card-register {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 1.6rem;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }

        .card-register h2 {
            font-size: 1.4rem;
            font-weight: 800;
            color: #fff;
            margin-bottom: 0.3rem;
        }

        .card-subtitle {
            font-size: 0.82rem;
            color: rgba(255, 255, 255, 0.4);
            margin-bottom: 1.2rem;
        }

        .form-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.7);
            letter-spacing: 0.03em;
            margin-bottom: 6px;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 10px;
            padding: 10px 14px;
            color: #fff;
            font-size: 0.9rem;
            font-family: 'Plus Jakarta Sans', sans-serif;
            transition: border-color 0.2s;
        }

        .form-control:focus {
            border-color: rgba(96, 165, 250, 0.5);
            background: rgba(255, 255, 255, 0.09);
            box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.1);
            color: #fff;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.25);
        }

        .input-group-text {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-right: none;
            color: rgba(255, 255, 255, 0.4);
            border-radius: 10px 0 0 10px;
        }

        .input-group .form-control {
            border-left: none;
            border-radius: 0 10px 10px 0;
        }

        .btn-register {
            width: 100%;
            background: linear-gradient(135deg, #6366f1, #3b82f6);
            border: none;
            border-radius: 10px;
            padding: 11px;
            color: #fff;
            font-size: 0.92rem;
            font-weight: 600;
            font-family: 'Plus Jakarta Sans', sans-serif;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.1s;
            margin-top: 0.8rem;
        }

        .btn-register:hover {
            opacity: 0.88;
            transform: translateY(-1px);
            color: #fff;
        }

        .login-link {
            text-align: center;
            margin-top: 1.2rem;
            font-size: 0.82rem;
            color: rgba(255, 255, 255, 0.4);
        }

        .login-link a {
            color: #60a5fa;
            text-decoration: none;
            font-weight: 600;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .alert-custom-danger {
            background: rgba(239, 68, 68, 0.12);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fca5a5;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 0.85rem;
            margin-bottom: 1.2rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .alert-custom-success {
            background: rgba(34, 197, 94, 0.12);
            border: 1px solid rgba(34, 197, 94, 0.3);
            color: #86efac;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 0.85rem;
            margin-bottom: 1.2rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        @media (max-width: 768px) {
            .hero-left {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid" style="max-width:960px;position:relative;z-index:1;">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 hero-left">
                <h1 class="hero-title">Buat Akun <span>Baru</span></h1>
                <p class="hero-desc">Daftarkan dirimu untuk mulai membaca berita terkini. Akun baru otomatis mendapatkan
                    level user.</p>
            </div>
            <div class="col-lg-6">
                <div class="card-register">
                    <h2>Daftar</h2>
                    <p class="card-subtitle">Isi data diri kamu untuk membuat akun</p>
                    <?php if ($success): ?>
                        <div class="alert-custom-success">
                            <i class="bi bi-check-circle"></i> Akun berhasil dibuat! <a href="login.php"
                                style="color:#86efac;font-weight:700;margin-left:4px;">Login sekarang</a>
                        </div>
                    <?php elseif (!empty($pesan)): ?>
                        <div class="alert-custom-danger"><i class="bi bi-exclamation-circle"></i><?= $pesan ?></div>
                    <?php endif; ?>
                    <?php if (!$success): ?>
                        <form method="POST" action="">
                            <div class="mb-2">
                                <label class="form-label">Nama Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control" name="nama_lengkap"
                                        placeholder="Masukkan nama lengkap"
                                        value="<?= isset($_POST['nama_lengkap']) ? htmlspecialchars($_POST['nama_lengkap']) : '' ?>"
                                        required>
                                </div>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-at"></i></span>
                                    <input type="text" class="form-control" name="username" placeholder="Buat username unik"
                                        value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>"
                                        required>
                                </div>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                    <input type="password" class="form-control" name="password"
                                        placeholder="Min. 6 karakter" required>
                                </div>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Konfirmasi Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                    <input type="password" class="form-control" name="confirm_password"
                                        placeholder="Ulangi password" required>
                                </div>
                            </div>
                            <button type="submit" name="submit" class="btn-register">
                                <i class="bi bi-person-plus me-1"></i> Buat Akun
                            </button>
                        </form>
                    <?php endif; ?>
                    <p class="login-link">Sudah punya akun? <a href="login.php">Login di sini</a></p>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>