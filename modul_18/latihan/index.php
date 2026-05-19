<?php
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

$allowed = ['dashboard', 'user', 'berita'];

if (!in_array($page, $allowed)) {
    $page = 'dashboard';
}
?>

<?php include 'admin/templates/header.php'; ?>
<?php include 'admin/templates/sidebar.php'; ?>

<div class="main">
    <div class="content">
        <?php include "admin/pages/$page.php"; ?>
    </div>
    <?php include 'admin/templates/footer.php'; ?>
</div>