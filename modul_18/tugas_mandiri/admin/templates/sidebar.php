<div class="sidebar">
    <div class="sidebar-logo">
        <a href="index.php" class="brand">
            <div class="brand-icon"><i class="bi bi-newspaper" style="color:#fff;"></i></div>
            <span class="brand-name">Portal <span>Berita</span></span>
        </a>
    </div>
    <div class="sidebar-user">
        <div class="user-name"><?= htmlspecialchars($_SESSION['nama_lengkap']) ?></div>
        <span class="user-level">Admin</span>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-label">Menu</div>
        <div class="nav-item">
            <a href="index.php?page=dashboard" class="<?= ($page === 'dashboard') ? 'active' : '' ?>">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </div>
        <div class="nav-item">
            <a href="index.php?page=berita" class="<?= ($page === 'berita') ? 'active' : '' ?>">
                <i class="bi bi-newspaper"></i> Berita
            </a>
        </div>
        <div class="nav-item">
            <a href="index.php?page=user" class="<?= ($page === 'user') ? 'active' : '' ?>">
                <i class="bi bi-people"></i> User
            </a>
        </div>
    </nav>
    <div class="sidebar-footer">
        <a href="logout.php" class="btn-logout-side">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>
    </div>
</div>
<div class="main-content">
    <div class="topbar">
        <span class="topbar-title">
            <?php
            $titles = ['dashboard' => 'Dashboard', 'berita' => 'Manajemen Berita', 'user' => 'Manajemen User'];
            echo $titles[$page] ?? 'Admin Panel';
            ?>
        </span>
        <div class="topbar-right">
            <span class="topbar-user">Halo, <strong><?= htmlspecialchars($_SESSION['nama_lengkap']) ?></strong></span>
        </div>
    </div>
    <div class="content-area">