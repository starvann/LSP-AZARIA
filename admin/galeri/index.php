<?php
/**
 * admin/galeri/index.php
 * Menampilkan data ASLI dari tabel `galeri` (SELECT + search + filter + pagination).
 * Hapus diproses lewat hapus.php (dikonfirmasi via modal di admin.js).
 */
require_once '../../config/koneksi.php';
require_once '../includes/helpers.php';

$base = '../';
require_once '../includes/auth.php';
$activeMenu = 'galeri';
$pageTitle = 'Galeri';
$breadcrumb = ['Data Sekolah', 'Galeri'];

// ---- Ambil parameter pencarian & filter ----
$cari = isset($_GET['cari']) ? trim($_GET['cari']) : '';
$filter_kategori = isset($_GET['kategori']) ? trim($_GET['kategori']) : '';

$where = [];
if ($cari !== '') {
    $cariEsc = mysqli_real_escape_string($koneksi, $cari);
    $searchParts = [];
    $searchParts[] = "judul LIKE '%" . $cariEsc . "%'";

    $where[] = '(' . implode(' OR ', $searchParts) . ')';
}
if ($filter_kategori !== '') {
    $where[] = "kategori = '" . mysqli_real_escape_string($koneksi, $filter_kategori) . "'";
}

$whereSql = count($where) > 0 ? 'WHERE ' . implode(' AND ', $where) : '';

// ---- Pagination ----
$limit = 10;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $limit;

$totalResult = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM galeri $whereSql");
$totalRow = mysqli_fetch_assoc($totalResult);
$totalData = (int) $totalRow['total'];
$totalPage = max(1, (int) ceil($totalData / $limit));

$query = "SELECT * FROM galeri $whereSql ORDER BY id DESC LIMIT $limit OFFSET $offset";
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
            Data Galeri berhasil ditambahkan.
        </div>
        <?php elseif (isset($_GET['msg']) && $_GET['msg'] === 'edit_sukses'): ?>
        <div class="alert-box alert-success">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="M22 4 12 14.01l-3-3"/></svg>
            Data Galeri berhasil diperbarui.
        </div>
        <?php elseif (isset($_GET['msg']) && $_GET['msg'] === 'hapus_sukses'): ?>
        <div class="alert-box alert-success">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="M22 4 12 14.01l-3-3"/></svg>
            Data Galeri berhasil dihapus.
        </div>
        <?php elseif (isset($_GET['msg']) && $_GET['msg'] === 'not_found'): ?>
        <div class="alert-box alert-error">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
            Data tidak ditemukan.
        </div>
        <?php endif; ?>

        <div class="page-head">
            <div>
                <h2>Galeri</h2>
                <p>Kelola koleksi foto kegiatan dan dokumentasi sekolah.</p>
            </div>
            <a href="tambah.php" class="btn btn-primary">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="15" height="15"><path d="M12 5v14M5 12h14"/></svg>
                Tambah Galeri
            </a>
        </div>

        <form class="toolbar" method="get" action="index.php">
            <div class="toolbar-filters">
                <div class="search-box">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/></svg>
                    <input type="text" name="cari" value="<?php echo htmlspecialchars($cari); ?>" placeholder="Cari judul foto/album...">
                </div>
                <select class="filter-select" name="kategori" onchange="this.form.submit()">
                    <option value="">Semua Kategori</option>
                    <option value="Kegiatan" <?php echo ($filter_kategori === 'Kegiatan') ? 'selected' : ''; ?>>Kegiatan</option>
                    <option value="Prestasi" <?php echo ($filter_kategori === 'Prestasi') ? 'selected' : ''; ?>>Prestasi</option>
                    <option value="Fasilitas" <?php echo ($filter_kategori === 'Fasilitas') ? 'selected' : ''; ?>>Fasilitas</option>
                    <option value="Umum" <?php echo ($filter_kategori === 'Umum') ? 'selected' : ''; ?>>Umum</option>
                </select>
            </div>
            <button type="submit" class="btn btn-outline btn-sm">Terapkan</button>
        </form>

        <div class="table-panel">
            <?php if ($totalData === 0): ?>
                <div class="alert-empty">Belum ada foto.</div>
            <?php else: ?>
            <div class="gallery-admin-grid">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="gallery-admin-card">
                <?php if (!empty($row['foto'])): ?>
                    <img src="../uploads/galeri/<?php echo htmlspecialchars($row['foto']); ?>" class="gallery-admin-thumb" alt="">
                <?php else: ?>
                    <div class="gallery-admin-thumb" style="display:flex;align-items:center;justify-content:center;font-size:2rem;">🖼️</div>
                <?php endif; ?>
                <div class="gallery-admin-body">
                    <h4><?php echo htmlspecialchars($row['judul']); ?></h4>
                    <p><span class="badge badge-sky"><?php echo htmlspecialchars($row['kategori']); ?></span> &nbsp; <?php echo format_tanggal($row['tanggal']); ?></p>
                    <div class="gallery-admin-actions">
                        <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-outline btn-sm" style="flex:1;">Edit</a>
                        <button type="button" class="btn btn-danger-soft btn-sm" style="flex:1;" data-delete-id="<?php echo $row['id']; ?>" data-delete-target="<?php echo htmlspecialchars($row['judul']); ?>">Hapus</button>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
            </div>
            <div class="table-footer">
                <span class="table-info">Menampilkan <?php echo ($totalData>0?($offset+1):0); ?>-<?php echo min($offset+$limit,$totalData); ?> dari <?php echo $totalData; ?> foto</span>
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
