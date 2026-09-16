<?php
/**
 * admin/includes/sidebar.php
 * Variabel yang perlu disiapkan sebelum include:
 * $base       : path relatif ke folder admin/
 * $activeMenu : slug menu aktif -> dashboard, berita, pengumuman, agenda,
 *               guru, prestasi, fasilitas, galeri
 */
if (!isset($base)) { $base = ''; }
if (!isset($activeMenu)) { $activeMenu = ''; }

function nav_active($menu, $activeMenu) {
    return $menu === $activeMenu ? ' active' : '';
}
?>
<div class="sidebar-backdrop" id="sidebarBackdrop"></div>
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="logo-mark">
            <img src="<?php echo $base; ?>../assets/LOGO SMK.png" alt="Logo SMK Negeri 1 Kandeman" style="width:100%;height:100%;object-fit:contain;">
        </div>
        <div class="sidebar-brand-text">
            <h3>SMKN 1 Kandeman</h3>
            <span>Admin Panel</span>
        </div>
        <button class="sidebar-close" id="sidebarCloseBtn" aria-label="Tutup menu">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18M6 6l12 12"/></svg>
        </button>
    </div>

    <nav class="sidebar-nav">
        <a href="<?php echo $base; ?>index.php" class="<?php echo trim('nav-dash'.nav_active('dashboard', $activeMenu)); ?>">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><rect x="3" y="3" width="7" height="9" rx="1"/><rect x="14" y="3" width="7" height="5" rx="1"/><rect x="14" y="12" width="7" height="9" rx="1"/><rect x="3" y="16" width="7" height="5" rx="1"/></svg>
            Dashboard
        </a>

        <div class="nav-section-label">Konten</div>
        <a href="<?php echo $base; ?>berita/index.php" class="<?php echo nav_active('berita', $activeMenu); ?>">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M7 8h10M7 12h10M7 16h6"/></svg>
            Berita
        </a>
        <a href="<?php echo $base; ?>pengumuman/index.php" class="<?php echo nav_active('pengumuman', $activeMenu); ?>">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M3 11l18-5v12L3 14v-3z"/><path d="M7 14v4a2 2 0 0 0 2 2h1"/></svg>
            Pengumuman
        </a>
        <a href="<?php echo $base; ?>agenda/index.php" class="<?php echo nav_active('agenda', $activeMenu); ?>">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M8 3v4M16 3v4M3 10h18"/></svg>
            Agenda
        </a>

        <div class="nav-section-label">Data Sekolah</div>
        <a href="<?php echo $base; ?>guru/index.php" class="<?php echo nav_active('guru', $activeMenu); ?>">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            Guru &amp; Tendik
        </a>
        <a href="<?php echo $base; ?>prestasi/index.php" class="<?php echo nav_active('prestasi', $activeMenu); ?>">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><circle cx="12" cy="8" r="6"/><path d="M8.5 13.5 7 22l5-3 5 3-1.5-8.5"/></svg>
            Prestasi
        </a>
        <a href="<?php echo $base; ?>fasilitas/index.php" class="<?php echo nav_active('fasilitas', $activeMenu); ?>">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M3 21h18M5 21V9l7-5 7 5v12M9 21v-6h6v6"/></svg>
            Fasilitas
        </a>
        <a href="<?php echo $base; ?>galeri/index.php" class="<?php echo nav_active('galeri', $activeMenu); ?>">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="9" r="1.7"/><path d="m21 16-5.5-5.5L4 21"/></svg>
            Galeri
        </a>
    </nav>

    <div class="sidebar-footer">
        <a href="<?php echo $base; ?>logout.php">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="M16 17l5-5-5-5M21 12H9"/></svg>
            Logout
        </a>
    </div>
</aside>
