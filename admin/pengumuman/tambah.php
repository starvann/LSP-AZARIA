<?php
/**
 * admin/pengumuman/tambah.php
 * UI + BACKEND - form ini sudah memproses INSERT ke database (dengan validasi & upload file).
 */
require_once '../../config/koneksi.php';
require_once '../includes/helpers.php';

$base = '../';
require_once '../includes/auth.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = trim($_POST['judul'] ?? '');
    $kategori = trim($_POST['kategori'] ?? '');
    $status = trim($_POST['status'] ?? '');
    $tanggal_terbit = trim($_POST['tanggal_terbit'] ?? '');
    $berlaku_sampai = trim($_POST['berlaku_sampai'] ?? '');
    $isi = trim($_POST['isi'] ?? '');

    if ($judul === '') {
        $errors[] = 'Judul Pengumuman wajib diisi.';
    }
    if ($kategori === '') {
        $errors[] = 'Kategori wajib diisi.';
    }
    if ($status === '') {
        $errors[] = 'Status wajib diisi.';
    }
    if ($tanggal_terbit === '') {
        $errors[] = 'Tanggal Terbit wajib diisi.';
    }
    if ($isi === '') {
        $errors[] = 'Isi Pengumuman wajib diisi.';
    }
    if (empty($errors)) {
        $stmt = mysqli_prepare($koneksi, "INSERT INTO pengumuman (judul, kategori, status, tanggal_terbit, berlaku_sampai, isi) VALUES (?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssssss", $judul, $kategori, $status, $tanggal_terbit, $berlaku_sampai, $isi);
        if (mysqli_stmt_execute($stmt)) {
            header('Location: index.php?msg=tambah_sukses');
            exit;
        } else {
            $errors[] = 'Gagal menyimpan data: ' . mysqli_error($koneksi);
        }
    }
}

$data = ($_SERVER['REQUEST_METHOD'] === 'POST') ? $_POST : [];

$activeMenu = 'pengumuman';
$pageTitle = 'Tambah Pengumuman';
$breadcrumb = ['Konten', 'Pengumuman', 'Tambah'];

include '../includes/header.php';
include '../includes/sidebar.php';
?>
<div class="main-area">
    <?php include '../includes/topbar.php'; ?>

    <div class="content">
        <?php if (!empty($errors)): ?>
        <div class="alert-box alert-error">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
            <div><?php echo implode('<br>', array_map('htmlspecialchars', $errors)); ?></div>
        </div>
        <?php endif; ?>

        <div class="page-head">
            <div>
                <h2>Tambah Pengumuman</h2>
                <p>Lengkapi form berikut untuk menambahkan data baru ke database.</p>
            </div>
        </div>

        <form class="form-panel" action="tambah.php" method="post" enctype="multipart/form-data" autocomplete="off">
            <div class="form-grid">
                <div class="form-group">
                    <label for="judul">Judul Pengumuman <span style="color:var(--danger);">*</span></label>
                    <input type="text" id="judul" name="judul" class="field-input" placeholder="Masukkan judul pengumuman" value="<?php echo htmlspecialchars($data['judul'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="kategori">Kategori <span style="color:var(--danger);">*</span></label>
                    <select id="kategori" name="kategori" class="field-input" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Akademik" <?php echo ((($data['kategori'] ?? '')) === 'Akademik') ? 'selected' : ''; ?>>Akademik</option>
                        <option value="Umum" <?php echo ((($data['kategori'] ?? '')) === 'Umum') ? 'selected' : ''; ?>>Umum</option>
                        <option value="Kesiswaan" <?php echo ((($data['kategori'] ?? '')) === 'Kesiswaan') ? 'selected' : ''; ?>>Kesiswaan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="status">Status <span style="color:var(--danger);">*</span></label>
                    <select id="status" name="status" class="field-input" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="Aktif" <?php echo ((($data['status'] ?? '')) === 'Aktif') ? 'selected' : ''; ?>>Aktif</option>
                        <option value="Nonaktif" <?php echo ((($data['status'] ?? '')) === 'Nonaktif') ? 'selected' : ''; ?>>Nonaktif</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tanggal_terbit">Tanggal Terbit <span style="color:var(--danger);">*</span></label>
                    <input type="date" id="tanggal_terbit" name="tanggal_terbit" class="field-input" value="<?php echo htmlspecialchars($data['tanggal_terbit'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="berlaku_sampai">Berlaku Sampai</label>
                    <input type="date" id="berlaku_sampai" name="berlaku_sampai" class="field-input" value="<?php echo htmlspecialchars($data['berlaku_sampai'] ?? ''); ?>">
                </div>
                <div class="form-group full">
                    <label for="isi">Isi Pengumuman <span style="color:var(--danger);">*</span></label>
                    <textarea id="isi" name="isi" class="field-input" placeholder="Tulis isi lengkap pengumuman di sini..." rows="7" required><?php echo htmlspecialchars($data['isi'] ?? ''); ?></textarea>
                </div>
            </div>

            <div class="form-actions">
                <a href="index.php" class="btn btn-outline">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Data</button>
            </div>
        </form>

    </div><!-- /.content -->
<?php include '../includes/footer.php'; ?>
