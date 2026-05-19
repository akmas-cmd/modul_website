<div class="sidebar">
    <div class="sidebar-logo">
        <a href="index.php" class="brand">
            <div class="brand-icon"><i class="bi bi-newspaper" style="color:#fff;"></i></div>
            <span class="brand-name">Portal <span>Berita</span></span>
        </a>
    </div>
    <div class="sidebar-user">
        <div class="user-name"><?= htmlspecialchars($_SESSION['nama_lengkap']) ?></div>
        <span class="user-level-badge">User</span>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-label">Menu</div>
        <div class="nav-item">
            <a href="index.php?page=dashboard" class="<?= ($page === 'dashboard') ? 'active' : '' ?>">
                <i class="bi bi-house"></i> Dashboard
            </a>
        </div>
        <div class="nav-item">
            <a href="index.php?page=berita" class="<?= ($page === 'berita') ? 'active' : '' ?>">
                <i class="bi bi-newspaper"></i> Baca Berita
            </a>
        </div>
    </nav>
    <div class="sidebar-footer">
        <a href="../logout.php" class="btn-logout-side">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>
    </div>
</div>
<div class="main-content">
    <div class="topbar">
        <div class="topbar-left">
            <span class="topbar-title">
                <?php
                $titles = ['dashboard' => 'Dashboard', 'berita' => 'Baca Berita'];
                echo $titles[$page] ?? 'Portal Berita';
                ?>
            </span>
            <span class="read-only-badge"><i class="bi bi-eye me-1"></i>Read Only</span>
        </div>
        <span class="topbar-user">Halo, <strong><?= htmlspecialchars($_SESSION['nama_lengkap']) ?></strong></span>
    </div>
    <div class="content-area">