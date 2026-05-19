<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
if ($_SESSION['level'] !== 'admin') {
    header("Location: user_area/index.php");
    exit();
}

$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
$allowed = ['dashboard', 'user', 'berita'];
if (!in_array($page, $allowed))
    $page = 'dashboard';
?>
<?php include 'admin/templates/header.php'; ?>
<?php include 'admin/templates/sidebar.php'; ?>
<?php include "admin/pages/{$page}.php"; ?>
<?php include 'admin/templates/footer.php'; ?>
<?php include 'admin/templates/scripts.php'; ?>