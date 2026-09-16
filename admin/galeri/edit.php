<?php
/**
 * admin/galeri/edit.php
 * UI + BACKEND - form ini sudah memproses UPDATE ke database (dengan validasi & upload file).
 */
require_once '../../config/koneksi.php';
require_once '../includes/helpers.php';

$base = '../';
require_once '../includes/auth.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : (isset($_POST['id']) ? intval($_POST['id']) : 0);
if ($id <= 0) {
    header('Location: index.php?msg=not_found');
    exit;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = trim($_POST['judul'] ?? '');
    $kategori = trim($_POST['kategori'] ?? '');
    $tanggal = trim($_POST['tanggal'] ?? '');
    $keterangan = trim($_POST['keterangan'] ?? '');
    $foto = handle_upload('foto', __DIR__ . '/../uploads/galeri/', $_POST['old_foto'] ?? null);
    if ($judul === '') {
        $errors[] = 'Judul Foto / Album wajib diisi.';
    }
    if ($kategori === '') {
        $errors[] = 'Kategori wajib diisi.';
    }
    if ($tanggal === '') {
        $errors[] = 'Tanggal wajib diisi.';
    }
    if (empty($errors)) {
        $stmt = mysqli_prepare($koneksi, "UPDATE galeri SET judul = ?, kategori = ?, tanggal = ?, foto = ?, keterangan = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "sssssi", $judul, $kategori, $tanggal, $foto, $keterangan, $id);
        if (mysqli_stmt_execute($stmt)) {
            header('Location: index.php?msg=edit_sukses');
            exit;
        } else {
            $errors[] = 'Gagal memperbarui data: ' . mysqli_error($koneksi);
        }
    }
    $data = $_POST;
} else {
    $result = mysqli_query($koneksi, "SELECT * FROM galeri WHERE id = " . $id . " LIMIT 1");
    $row = mysqli_fetch_assoc($result);
    if (!$row) {
        header('Location: index.php?msg=not_found');
        exit;
    }
    $data = $row;
}

$activeMenu = 'galeri';
$pageTitle = 'Edit Galeri';
$breadcrumb = ['Data Sekolah', 'Galeri', 'Edit'];

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
                <h2>Edit Galeri</h2>
                <p>Perbarui data yang sudah tersimpan di database.</p>
            </div>
        </div>

        <form class="form-panel" action="edit.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data" autocomplete="off">
            <div class="form-grid">
                <div class="form-group">
                    <label for="judul">Judul Foto / Album <span style="color:var(--danger);">*</span></label>
                    <input type="text" id="judul" name="judul" class="field-input" placeholder="Masukkan judul foto atau album" value="<?php echo htmlspecialchars($data['judul'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="kategori">Kategori <span style="color:var(--danger);">*</span></label>
                    <select id="kategori" name="kategori" class="field-input" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Kegiatan" <?php echo ((($data['kategori'] ?? '')) === 'Kegiatan') ? 'selected' : ''; ?>>Kegiatan</option>
                        <option value="Prestasi" <?php echo ((($data['kategori'] ?? '')) === 'Prestasi') ? 'selected' : ''; ?>>Prestasi</option>
                        <option value="Fasilitas" <?php echo ((($data['kategori'] ?? '')) === 'Fasilitas') ? 'selected' : ''; ?>>Fasilitas</option>
                        <option value="Umum" <?php echo ((($data['kategori'] ?? '')) === 'Umum') ? 'selected' : ''; ?>>Umum</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tanggal">Tanggal <span style="color:var(--danger);">*</span></label>
                    <input type="date" id="tanggal" name="tanggal" class="field-input" value="<?php echo htmlspecialchars($data['tanggal'] ?? ''); ?>" required>
                </div>
                <div class="form-group full">
                    <label>Foto <span style="color:var(--danger);">*</span></label>
                    <div class="upload-box">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><path d="M17 8l-5-5-5 5"/><path d="M12 3v12"/></svg>
                        <p>Klik untuk unggah atau tarik file ke sini</p>
                        <span>JPG, JPEG, PNG, atau WEBP hingga 2MB</span>
                        <input type="file" name="foto" accept=".jpg,.jpeg,.png,.webp" style="margin-top:12px;font-size:.78rem;">
                    </div>
                    <?php if (!empty($data['foto'] ?? ($data['old_foto'] ?? ''))): ?>
                    <p style="margin-top:10px;font-size:.78rem;color:var(--text-secondary);">File saat ini: <strong><?php echo htmlspecialchars($data['foto'] ?? ($data['old_foto'] ?? '')); ?></strong> (biarkan kosong jika tidak ingin mengganti)</p>
                    <input type="hidden" name="old_foto" value="<?php echo htmlspecialchars($data['foto'] ?? ($data['old_foto'] ?? '')); ?>">
                    <?php endif; ?>
                </div>
                <div class="form-group full">
                    <label for="keterangan">Keterangan</label>
                    <textarea id="keterangan" name="keterangan" class="field-input" placeholder="Keterangan singkat foto" rows="3"><?php echo htmlspecialchars($data['keterangan'] ?? ''); ?></textarea>
                </div>
            </div>

            <div class="form-actions">
                <a href="index.php" class="btn btn-outline">Batal</a>
                <button type="submit" class="btn btn-primary">Update Data</button>
            </div>
        </form>

    </div><!-- /.content -->
<?php include '../includes/footer.php'; ?>
