<?php
/**
 * admin/berita/index.php
 * Menampilkan data ASLI dari tabel `berita` (SELECT + search + filter + pagination).
 * Hapus diproses lewat hapus.php (dikonfirmasi via modal di admin.js).
 */
require_once '../../config/koneksi.php';
require_once '../includes/helpers.php';

$base = '../';
require_once '../includes/auth.php';
$activeMenu = 'berita';
$pageTitle = 'Berita';
$breadcrumb = ['Konten', 'Berita'];

// ---- Ambil parameter pencarian & filter ----
$cari = isset($_GET['cari']) ? trim($_GET['cari']) : '';
$filter_kategori = isset($_GET['kategori']) ? trim($_GET['kategori']) : '';
$filter_status = isset($_GET['status']) ? trim($_GET['status']) : '';

$where = [];
if ($cari !== '') {
    $cariEsc = mysqli_real_escape_string($koneksi, $cari);
    $searchParts = [];
    $searchParts[] = "judul LIKE '%" . $cariEsc . "%'";
    $searchParts[] = "penulis LIKE '%" . $cariEsc . "%'";

    $where[] = '(' . implode(' OR ', $searchParts) . ')';
}
if ($filter_kategori !== '') {
    $where[] = "kategori = '" . mysqli_real_escape_string($koneksi, $filter_kategori) . "'";
}
if ($filter_status !== '') {
    $where[] = "status = '" . mysqli_real_escape_string($koneksi, $filter_status) . "'";
}

$whereSql = count($where) > 0 ? 'WHERE ' . implode(' AND ', $where) : '';

// ---- Pagination ----
$limit = 10;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $limit;

$totalResult = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM berita $whereSql");
$totalRow = mysqli_fetch_assoc($totalResult);
$totalData = (int) $totalRow['total'];
$totalPage = max(1, (int) ceil($totalData / $limit));

$query = "SELECT * FROM berita $whereSql ORDER BY id DESC LIMIT $limit OFFSET $offset";
$result = mysqli_query($koneksi, $query);

include '../includes/header.php';
include '../includes/sidebar.php';
?>
<div class="main-area">
    <?php include '../includes/topbar.php'; ?>

    <div class="content">
        <?php if (isset($_GET['msg']) && $_GET['msg'] === 'tambah_sukses'): ?>
        <div class="alert-box alert-success">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="M22 4 12 14.01l-3-3"/></svg>
            Data Berita berhasil ditambahkan.
        </div>
        <?php elseif (isset($_GET['msg']) && $_GET['msg'] === 'edit_sukses'): ?>
        <div class="alert-box alert-success">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="M22 4 12 14.01l-3-3"/></svg>
            Data Berita berhasil diperbarui.
        </div>
        <?php elseif (isset($_GET['msg']) && $_GET['msg'] === 'hapus_sukses'): ?>
        <div class="alert-box alert-success">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="M22 4 12 14.01l-3-3"/></svg>
            Data Berita berhasil dihapus.
        </div>
        <?php elseif (isset($_GET['msg']) && $_GET['msg'] === 'not_found'): ?>
        <div class="alert-box alert-error">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
            Data tidak ditemukan.
        </div>
        <?php endif; ?>

        <div class="page-head">
            <div>
                <h2>Berita</h2>
                <p>Kelola artikel berita dan kegiatan sekolah yang tampil di halaman publik.</p>
            </div>
            <a href="tambah.php" class="btn btn-primary">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="15" height="15"><path d="M12 5v14M5 12h14"/></svg>
                Tambah Berita
            </a>
        </div>

        <form class="toolbar" method="get" action="index.php">
            <div class="toolbar-filters">
                <div class="search-box">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/></svg>
                    <input type="text" name="cari" value="<?php echo htmlspecialchars($cari); ?>" placeholder="Cari judul berita...">
                </div>
                <select class="filter-select" name="kategori" onchange="this.form.submit()">
                    <option value="">Semua Kategori</option>
                    <option value="Akademik" <?php echo ($filter_kategori === 'Akademik') ? 'selected' : ''; ?>>Akademik</option>
                    <option value="Kegiatan" <?php echo ($filter_kategori === 'Kegiatan') ? 'selected' : ''; ?>>Kegiatan</option>
                    <option value="Prestasi" <?php echo ($filter_kategori === 'Prestasi') ? 'selected' : ''; ?>>Prestasi</option>
                    <option value="Pengumuman" <?php echo ($filter_kategori === 'Pengumuman') ? 'selected' : ''; ?>>Pengumuman</option>
                </select>
                <select class="filter-select" name="status" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="Published" <?php echo ($filter_status === 'Published') ? 'selected' : ''; ?>>Published</option>
                    <option value="Draft" <?php echo ($filter_status === 'Draft') ? 'selected' : ''; ?>>Draft</option>
                </select>
            </div>
            <button type="submit" class="btn btn-outline btn-sm">Terapkan</button>
        </form>

        <div class="table-panel">
            <?php if ($totalData === 0): ?>
                <div class="alert-empty">Belum ada data.</div>
            <?php else: ?>
            <div class="table-scroll">
                <table class="data-table">
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Judul Berita</th>
                        <th>Kategori</th>
                        <th>Penulis</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th style="text-align:right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td>
                            <?php if (!empty($row['gambar'])): ?>
                                <img src="../uploads/berita/<?php echo htmlspecialchars($row['gambar']); ?>" class="thumb" alt="">
                            <?php else: ?>
                                <div class="thumb" style="display:flex;align-items:center;justify-content:center;font-size:1.1rem;">🖼️</div>
                            <?php endif; ?>
                        </td>
                        <td class="cell-title"><?php echo htmlspecialchars($row['judul']); ?></td>
                        <td class="cell-muted"><?php echo htmlspecialchars($row['kategori']); ?></td>
                        <td class="cell-muted"><?php echo htmlspecialchars($row['penulis']); ?></td>
                        <td class="cell-muted"><?php echo format_tanggal($row['tanggal']); ?></td>
                        <td><span class="badge <?php echo badge_class($row['status']); ?>"><?php echo htmlspecialchars($row['status']); ?></span></td>
                        <td class="cell-actions">
                            <a href="edit.php?id=<?php echo $row['id']; ?>" class="icon-btn" aria-label="Edit" title="Edit">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="15" height="15"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z"/></svg>
                            </a>
                            <button type="button" class="icon-btn danger" aria-label="Hapus" title="Hapus" data-delete-id="<?php echo $row['id']; ?>" data-delete-target="<?php echo htmlspecialchars($row['judul']); ?>">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="15" height="15"><path d="M3 6h18M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m3 0-1 14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2L4 6"/></svg>
                            </button>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
                </table>
            </div>
            <div class="table-footer">
                <span class="table-info">Menampilkan <?php echo ($totalData>0?($offset+1):0); ?>-<?php echo min($offset+$limit,$totalData); ?> dari <?php echo $totalData; ?> data</span>
                <div class="pagination">
                    <?php for ($i = 1; $i <= $totalPage; $i++): ?>
                        <a href="<?php echo build_page_url($i); ?>" class="<?php echo ($i === $page) ? 'active' : ''; ?>"><?php echo $i; ?></a>
                    <?php endfor; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>

    </div><!-- /.content -->
<?php include '../includes/footer.php'; ?>
