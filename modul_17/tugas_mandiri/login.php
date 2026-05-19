<?php
session_start();
include "koneksi.php";

if (isset($_SESSION['user'])) {
    header("Location: tampil.php");
    exit;
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user['username'];
            $_SESSION['level'] = $user['level'];
            header("Location: tampil.php");
            exit;
        } else {
            $error = "Username atau password salah!";
        }
    } else {
        $error = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Portal Berita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f0f2f5; font-family: Arial, sans-serif; }
        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: white;
            border-radius: 8px;
            padding: 30px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .login-card h2 { color: #333; font-size: 24px; }
        .btn-login {
            background-color: #0d6efd;
            color: white;
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
        }
        .btn-login:hover { background-color: #0b5ed7; }
        .info-akun {
            background: #e7f3ff;
            border: 1px solid #b6d4fe;
            border-radius: 5px;
            padding: 12px;
            margin-top: 15px;
            font-size: 13px;
        }
    </style>
</head>
<body>
<div class="login-wrapper">
    <div class="login-card">
        <h2>🗞️ Portal Berita</h2>
        <p class="text-muted" style="font-size:14px;">Silakan login untuk melanjutkan</p>

        <?php if ($error): ?>
            <div class="alert alert-danger py-2"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn-login">Login</button>
        </form>

        <div class="info-akun">
            <strong>Info Akun Demo:</strong><br>
            Admin → username: <b>admin</b> / pass: <b>admin123</b><br>
            User &nbsp;→ username: <b>user</b> / pass: <b>user123</b>
        </div>
    </div>
</div>
</body>
</html>