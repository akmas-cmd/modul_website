<?php
session_start();
if (isset($_SESSION['username'])) {
    if ($_SESSION['level'] === 'admin') {
        header("Location: index.php");
    } else {
        header("Location: user_area/index.php");
    }
    exit();
}
include "koneksi.php";

$pesan = "";

if (isset($_POST['submit'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $pesan = "Username dan password wajib diisi!";
    } else {
        $stmt = $conn->prepare("SELECT * FROM tb_user WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
                $_SESSION['level'] = $user['level'];
                if ($user['level'] === 'admin') {
                    header("Location: index.php");
                } else {
                    header("Location: user_area/index.php");
                }
                exit();
            } else {
                $pesan = "Password salah!";
            }
        } else {
            $pesan = "Username tidak ditemukan!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Portal Berita</title>
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
            background: radial-gradient(circle, rgba(59, 130, 246, 0.12) 0%, transparent 70%);
            top: -100px;
            left: -100px;
            border-radius: 50%;
            pointer-events: none;
        }

        body::after {
            content: '';
            position: fixed;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.1) 0%, transparent 70%);
            bottom: -50px;
            right: -50px;
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
            background: linear-gradient(90deg, #60a5fa, #818cf8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-desc {
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.95rem;
            line-height: 1.8;
        }

        .card-login {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 1.6rem;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }

        .card-login h2 {
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
            transition: border-color 0.2s, background 0.2s;
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

        .btn-login {
            width: 100%;
            background: linear-gradient(135deg, #3b82f6, #6366f1);
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

        .btn-login:hover {
            opacity: 0.88;
            transform: translateY(-1px);
            color: #fff;
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .register-link {
            text-align: center;
            margin-top: 1.2rem;
            font-size: 0.82rem;
            color: rgba(255, 255, 255, 0.4);
        }

        .register-link a {
            color: #60a5fa;
            text-decoration: none;
            font-weight: 600;
        }

        .register-link a:hover {
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

        @media (max-width: 768px) {
            .hero-left {
                display: none;
            }

            .card-login {
                padding: 1.8rem 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid" style="max-width:960px;position:relative;z-index:1;">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 hero-left">
                <h1 class="hero-title">Selamat Datang di <span>Portal Berita</span></h1>
                <p class="hero-desc">Masuk untuk mengelola dan membaca berita terkini. Admin dapat menambah, mengedit,
                    dan menghapus berita & data user.</p>
            </div>
            <div class="col-lg-6">
                <div class="card-login">
                    <h2>Masuk</h2>
                    <p class="card-subtitle">Masukkan kredensial akun kamu</p>
                    <?php if (!empty($pesan)): ?>
                        <div class="alert-custom-danger"><i class="bi bi-exclamation-circle"></i><?= $pesan ?></div>
                    <?php endif; ?>
                    <form method="POST" action="">
                        <div class="mb-2">
                            <label class="form-label">Username</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-at"></i></span>
                                <input type="text" class="form-control" name="username" placeholder="Masukkan username"
                                    value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>"
                                    required>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" class="form-control" name="password"
                                    placeholder="Masukkan password" required>
                            </div>
                        </div>
                        <button type="submit" name="submit" class="btn-login">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
                        </button>
                    </form>
                    <p class="register-link">Belum punya akun? <a href="register.php">Daftar di sini</a></p>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>