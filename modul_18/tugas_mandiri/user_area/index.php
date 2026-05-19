<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}
if ($_SESSION['level'] === 'admin') {
    header("Location: ../index.php");
    exit();
}

$page    = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
$allowed = ['dashboard', 'berita'];
if (!in_array($page, $allowed)) $page = 'dashboard';
?>
<?php include 'templates/header.php'; ?>
<?php include 'templates/sidebar.php'; ?>
<?php include "pages/{$page}.php"; ?>
<?php include 'templates/footer.php'; ?>
<?php include 'templates/scripts.php'; ?>