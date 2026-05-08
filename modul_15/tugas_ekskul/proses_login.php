<?php
session_start();
include "koneksi.php";

$username = $_POST['username'];
$password = $_POST['password'];

// Contoh validasi sederhana sesuai modul
if ($username == "admin" && $password == "123") {
    $_SESSION['status'] = "login";
    $_SESSION['user'] = $username;
    header("location:tampil.php");
} else {
    header("location:login.php?pesan=gagal");
}
?>