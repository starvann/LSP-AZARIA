<?php
/**
 * admin/index.php - Dashboard Admin
 * Statistik kartu sudah terhubung ke database (COUNT dari tiap tabel).
 * "Aktivitas Terbaru" masih statis karena belum ada tabel log aktivitas.
 */
require_once '../config/koneksi.php';
require_once 'includes/helpers.php';

$base = '';
require_once 'includes/auth.php';
$activeMenu = 'dashboard';
$pageTitle = 'Dashboard';

function hitung_total($koneksi, $sql) {
    $result = mysqli_query($koneksi, $sql);
    if (!$result) return 0;
    $row = mysqli_fetch_assoc($result);
    return (int) $row['total'];
}

$totalBerita = hitung_total($koneksi, "SELECT COUNT(*) AS total FROM berita");
$totalPengumumanAktif = hitung_total($koneksi, "SELECT COUNT(*) AS total FROM pengumuman WHERE status = 'Aktif'");
$totalGuru = hitung_total($koneksi, "SELECT COUNT(*) AS total FROM guru");
$totalPrestasi = hitung_total($koneksi, "SELECT COUNT(*) AS total FROM prestasi");

include 'includes/header.php';
include 'includes/sidebar.php';
?>
<div class="main-area">
    <?php include 'includes/topbar.php'; ?>

    <div class="content">
        <div class="page-head">
            <div>
                <h2>Selamat datang, Admin 👋</h2>
                <p>Ringkasan konten website SMK Negeri 1 Kandeman.</p>
            </div>
        </div>

        <!-- Statistik: jumlah baris asli dari database -->
        <div class="stat-cards">
            <div class="stat-card">
                <div class="stat-card-top">
                    <div class="stat-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M7 8h10M7 12h10M7 16h6"/></svg>
                    </div>
                </div>
                <div class="stat-value"><?php echo $totalBerita; ?></div>
                <div class="stat-label">Total Berita</div>
            </div>
            <div class="stat-card">
                <div class="stat-card-top">
                    <div class="stat-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 11l18-5v12L3 14v-3z"/><path d="M7 14v4a2 2 0 0 0 2 2h1"/></svg>
                    </div>
                </div>
                <div class="stat-value"><?php echo $totalPengumumanAktif; ?></div>
                <div class="stat-label">Pengumuman Aktif</div>

            </div>
            <div class="stat-card">
                <div class="stat-card-top">
                    <div class="stat-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                </div>
                <div class="stat-value"><?php echo $totalGuru; ?></div>
                <div class="stat-label">Guru &amp; Tendik</div>
            </div>
            <div class="stat-card">
                <div class="stat-card-top">
                    <div class="stat-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="6"/><path d="M8.5 13.5 7 22l5-3 5 3-1.5-8.5"/></svg>
                    </div>
                </div>
                <div class="stat-value"><?php echo $totalPrestasi; ?></div>
                <div class="stat-label">Prestasi Tercatat</div>
            </div>
        </div>

        <div class="dash-grid">
            <div class="panel">
                <div class="panel-head">
                    <h3>Aktivitas Terbaru</h3>
                    <a href="#">Lihat semua</a>
                </div>
                <!-- Catatan: aktivitas di bawah ini masih data statis (dummy),
                     karena belum ada tabel log aktivitas di database. -->
                <div class="panel-body">
                    <div class="activity-item">
                        <div class="activity-dot"></div>
                        <div>
                            <div class="activity-text"><b>Admin</b> menambahkan berita "Lomba Karya Ilmiah Remaja 2026"</div>
                            <div class="activity-time">2 jam yang lalu</div>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-dot"></div>
                        <div>
                            <div class="activity-text"><b>Admin</b> memperbarui data guru "Siti Rahayu, S.Pd."</div>
                            <div class="activity-time">5 jam yang lalu</div>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-dot"></div>
                        <div>
                            <div class="activity-text"><b>Admin</b> menambahkan agenda "Pelepasan Siswa Angkatan XXVII"</div>
                            <div class="activity-time">1 hari yang lalu</div>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-dot"></div>
                        <div>
                            <div class="activity-text"><b>Admin</b> mengunggah 4 foto baru ke galeri "Pentas Seni"</div>
                            <div class="activity-time">2 hari yang lalu</div>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-dot"></div>
                        <div>
                            <div class="activity-text"><b>Admin</b> menghapus pengumuman "Libur Semester Ganjil"</div>
                            <div class="activity-time">3 hari yang lalu</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel">
                <div class="panel-head">
                    <h3>Akses Cepat</h3>
                </div>
                <div class="panel-body">
                    <div class="quicklink-grid">
                        <a class="quicklink" href="berita/tambah.php">
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
                            Tambah Berita
                        </a>
                        <a class="quicklink" href="pengumuman/tambah.php">
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
                            Tambah Pengumuman
                        </a>
                        <a class="quicklink" href="agenda/tambah.php">
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
                            Tambah Agenda
                        </a>
                        <a class="quicklink" href="galeri/tambah.php">
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
                            Unggah Foto
                        </a>
                    </div>
                </div>
            </div>
        </div>

<?php include 'includes/footer.php'; ?>
