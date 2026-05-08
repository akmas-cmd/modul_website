<?php
include "koneksi.php";

if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $level = "user"; // Otomatis setiap register dianggap sebagai user

    // Cek username sudah ada atau belum
    $cek = $conn->prepare("SELECT * FROM tb_user WHERE username=?");
    $cek->bind_param("s", $username);
    $cek->execute();
    $result = $cek->get_result();
    if ($result->num_rows > 0) {
        echo "Username sudah digunakan!";
    } else {
        // Hash password (bcrypt)
        $hash = password_hash($password, PASSWORD_DEFAULT);
        // Simpan ke database
        $stmt = $conn->prepare("INSERT INTO tb_user (username, password, level) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $hash, $level);
        if ($stmt->execute()) {
            echo "Register berhasil!";
        } else {
            echo "Register gagal!";
        }
    }
}
?>