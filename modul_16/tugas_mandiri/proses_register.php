<?php
// =====================================================
// proses_register.php - Proses Pendaftaran User Baru
// Menggunakan password_hash() bcrypt (lebih aman dari MD5)
// =====================================================
include "koneksi.php";

if (isset($_POST['submit'])) {
    $nama     = trim($_POST['nama']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $level    = $_POST['level'];

    // Validasi field kosong
    if (empty($nama) || empty($username) || empty($password)) {
        header("Location: register.php?error=Semua field wajib diisi!");
        exit();
    }

    // Validasi panjang password
    if (strlen($password) < 6) {
        header("Location: register.php?error=Password minimal 6 karakter!");
        exit();
    }

    // Cek apakah username sudah digunakan (prepared statement – anti SQL Injection)
    $cek = $conn->prepare("SELECT * FROM tb_user WHERE username = ?");
    $cek->bind_param("s", $username);
    $cek->execute();
    $result = $cek->get_result();

    if ($result->num_rows > 0) {
        header("Location: register.php?error=Username sudah digunakan, pilih yang lain!");
        exit();
    } else {
        // Hash password menggunakan bcrypt (PASSWORD_DEFAULT)
        // Lebih aman dibanding MD5 karena dilengkapi salt otomatis
        $hash = password_hash($password, PASSWORD_DEFAULT);

        // Simpan ke database
        $stmt = $conn->prepare("INSERT INTO tb_user (username, password, level) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $hash, $level);

        if ($stmt->execute()) {
            header("Location: register.php?sukses=1");
        } else {
            header("Location: register.php?error=Registrasi gagal, coba lagi!");
        }
        exit();
    }
}

// Jika diakses langsung tanpa POST
header("Location: register.php");
exit();
?>