<?php
// =====================================================
// proses_login.php - Proses Autentikasi User
// Menggunakan password_verify() untuk cek bcrypt hash
// =====================================================
session_start();
include "koneksi.php";

if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Validasi input
    if (empty($username) || empty($password)) {
        header("Location: login.php?error=Username dan password wajib diisi!");
        exit();
    }

    // Ambil data user dari database (prepared statement – anti SQL Injection)
    $stmt = $conn->prepare("SELECT * FROM tb_user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $data   = $result->fetch_assoc();

    if ($data) {
        // Verifikasi password menggunakan password_verify() (bcrypt)
        // Lebih aman dibanding == karena menangani timing attack
        if (password_verify($password, $data['password'])) {
            // Password cocok – simpan data ke SESSION
            $_SESSION['username'] = $data['username'];
            $_SESSION['level']    = $data['level'];
            $_SESSION['nama']     = isset($data['nama']) ? $data['nama'] : $data['username'];

            // Redirect sesuai level
            if ($data['level'] == 'admin') {
                header("Location: admin.php");
            } else if ($data['level'] == 'user') {
                header("Location: user.php");
            }
            exit();
        } else {
            // Password salah
            header("Location: login.php?error=Password yang Anda masukkan salah!");
            exit();
        }
    } else {
        // Username tidak ditemukan
        header("Location: login.php?error=Username tidak ditemukan!");
        exit();
    }
}

// Jika diakses langsung tanpa POST
header("Location: login.php");
exit();
?>