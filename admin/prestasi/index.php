<?php
/**
 * admin/prestasi/index.php
 * Menampilkan data ASLI dari tabel `prestasi` (SELECT + search + filter + pagination).
 * Hapus diproses lewat hapus.php (dikonfirmasi via modal di admin.js).
 */
require_once '../../config/koneksi.php';
require_once '../includes/helpers.php';

$base = '../';
require_once '../includes/auth.php';
$activeMenu = 'prestasi';
$pageTitle = 'Prestasi';
$breadcrumb = ['Data Sekolah', 'Prestasi'];

// ---- Ambil parameter pencarian & filter ----
$cari = isset($_GET['cari']) ? trim($_GET['cari']) : '';
$filter_tingkat = isset($_GET['tingkat']) ? trim($_GET['tingkat']) : '';

$where = [];
if ($cari !== '') {
    $cariEsc = mysqli_real_escape_string($koneksi, $cari);
    $searchParts = [];
    $searchParts[] = "nama_prestasi LIKE '%" . $cariEsc . "%'";
    $searchParts[] = "nama_siswa LIKE '%" . $cariEsc . "%'";

    $where[] = '(' . implode(' OR ', $searchParts) . ')';
}
if ($filter_tingkat !== '') {
    $where[] = "tingkat = '" . mysqli_real_escape_string($koneksi, $filter_tingkat) . "'";
}

$whereSql = count($where) > 0 ? 'WHERE ' . implode(' AND ', $where) : '';

// ---- Pagination ----
$limit = 10;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $limit;

$totalResult = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM prestasi $whereSql");
$totalRow = mysqli_fetch_assoc($totalResult);
$totalData = (int) $totalRow['total'];
$totalPage = max(1, (int) ceil($totalData / $limit));

$query = "SELECT * FROM prestasi $whereSql ORDER BY id DESC LIMIT $limit OFFSET $offset";
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
            Data Prestasi berhasil ditambahkan.
        </div>
        <?php elseif (isset($_GET['msg']) && $_GET['msg'] === 'edit_sukses'): ?>
        <div class="alert-box alert-success">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="M22 4 12 14.01l-3-3"/></svg>
            Data Prestasi berhasil diperbarui.
        </div>
        <?php elseif (isset($_GET['msg']) && $_GET['msg'] === 'hapus_sukses'): ?>
        <div class="alert-box alert-success">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="M22 4 12 14.01l-3-3"/></svg>
            Data Prestasi berhasil dihapus.
        </div>
        <?php elseif (isset($_GET['msg']) && $_GET['msg'] === 'not_found'): ?>
        <div class="alert-box alert-error">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
            Data tidak ditemukan.
        </div>
        <?php endif; ?>

        <div class="page-head">
            <div>
                <h2>Prestasi</h2>
                <p>Kelola daftar prestasi siswa dan sekolah di berbagai bidang dan tingkat.</p>
            </div>
            <a href="tambah.php" class="btn btn-primary">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="15" height="15"><path d="M12 5v14M5 12h14"/></svg>
                Tambah Prestasi
            </a>
        </div>

        <form class="toolbar" method="get" action="index.php">
            <div class="toolbar-filters">
                <div class="search-box">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/></svg>
                    <input type="text" name="cari" value="<?php echo htmlspecialchars($cari); ?>" placeholder="Cari nama siswa/prestasi...">
                </div>
                <select class="filter-select" name="tingkat" onchange="this.form.submit()">
                    <option value="">Semua Tingkat</option>
                    <option value="Sekolah" <?php echo ($filter_tingkat === 'Sekolah') ? 'selected' : ''; ?>>Sekolah</option>
                    <option value="Kabupaten" <?php echo ($filter_tingkat === 'Kabupaten') ? 'selected' : ''; ?>>Kabupaten</option>
                    <option value="Provinsi" <?php echo ($filter_tingkat === 'Provinsi') ? 'selected' : ''; ?>>Provinsi</option>
                    <option value="Nasional" <?php echo ($filter_tingkat === 'Nasional') ? 'selected' : ''; ?>>Nasional</option>
                    <option value="Internasional" <?php echo ($filter_tingkat === 'Internasional') ? 'selected' : ''; ?>>Internasional</option>
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
                        <th>Nama Prestasi</th>
                        <th>Nama Siswa/Tim</th>
                        <th>Tingkat</th>
                        <th>Tahun</th>
                        <th style="text-align:right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td class="cell-title"><?php echo htmlspecialchars($row['nama_prestasi']); ?></td>
                        <td class="cell-muted"><?php echo htmlspecialchars($row['nama_siswa']); ?></td>
                        <td><span class="badge <?php echo badge_class($row['tingkat']); ?>"><?php echo htmlspecialchars($row['tingkat']); ?></span></td>
                        <td class="cell-muted"><?php echo htmlspecialchars($row['tahun']); ?></td>
                        <td class="cell-actions">
                            <a href="edit.php?id=<?php echo $row['id']; ?>" class="icon-btn" aria-label="Edit" title="Edit">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="15" height="15"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z"/></svg>
                            </a>
                            <button type="button" class="icon-btn danger" aria-label="Hapus" title="Hapus" data-delete-id="<?php echo $row['id']; ?>" data-delete-target="<?php echo htmlspecialchars($row['nama_prestasi']); ?>">
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
