<?php
/**
 * admin/includes/topbar.php
 * Variabel yang perlu disiapkan sebelum include:
 * $pageTitle      : judul halaman
 * $breadcrumb     : (opsional) array label breadcrumb, contoh: ['Konten', 'Berita']
 */
if (!isset($pageTitle)) { $pageTitle = 'Dashboard'; }
if (!isset($breadcrumb)) { $breadcrumb = []; }
?>
<header class="topbar">
    <div class="topbar-left">
        <button class="menu-toggle-btn" id="menuToggleBtn" aria-label="Buka menu">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M3 12h18M3 18h18"/></svg>
        </button>
        <div class="topbar-title">
            <h1><?php echo $pageTitle; ?></h1>
            <?php if (!empty($breadcrumb)): ?>
            <div class="topbar-breadcrumb">
                <a href="#">Admin</a>
                <?php foreach ($breadcrumb as $crumb): ?>
                    &nbsp;/&nbsp;<?php echo $crumb; ?>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="topbar-right">
        <div class="topbar-admin">
            <?php
                $adminNama = $_SESSION['admin_nama'] ?? 'Admin';
                $initials = '';
                foreach (explode(' ', trim($adminNama)) as $w) {
                    if ($w !== '') $initials .= strtoupper($w[0]);
                    if (strlen($initials) >= 2) break;
                }
                if ($initials === '') $initials = 'AD';
            ?>
            <div class="topbar-avatar"><?php echo htmlspecialchars($initials); ?></div>
            <div>
                <div class="topbar-admin-name"><?php echo htmlspecialchars($adminNama); ?></div>
                <div class="topbar-admin-role">Administrator</div>
            </div>
        </div>
    </div>
</header>
