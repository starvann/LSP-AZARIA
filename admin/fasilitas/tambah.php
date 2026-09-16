<?php
/**
 * admin/fasilitas/tambah.php
 * UI + BACKEND - form ini sudah memproses INSERT ke database (dengan validasi & upload file).
 */
require_once '../../config/koneksi.php';
require_once '../includes/helpers.php';

$base = '../';
require_once '../includes/auth.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_fasilitas = trim($_POST['nama_fasilitas'] ?? '');
    $kategori = trim($_POST['kategori'] ?? '');
    $kondisi = trim($_POST['kondisi'] ?? '');
    $kapasitas = trim($_POST['kapasitas'] ?? '');
    $deskripsi = trim($_POST['deskripsi'] ?? '');
    $foto = handle_upload('foto', __DIR__ . '/../uploads/fasilitas/');
    if ($nama_fasilitas === '') {
        $errors[] = 'Nama Fasilitas wajib diisi.';
    }
    if ($kategori === '') {
        $errors[] = 'Kategori wajib diisi.';
    }
    if ($kondisi === '') {
        $errors[] = 'Kondisi wajib diisi.';
    }
    if (empty($errors)) {
        $stmt = mysqli_prepare($koneksi, "INSERT INTO fasilitas (nama_fasilitas, kategori, kondisi, kapasitas, foto, deskripsi) VALUES (?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssssss", $nama_fasilitas, $kategori, $kondisi, $kapasitas, $foto, $deskripsi);
        if (mysqli_stmt_execute($stmt)) {
            header('Location: index.php?msg=tambah_sukses');
            exit;
        } else {
            $errors[] = 'Gagal menyimpan data: ' . mysqli_error($koneksi);
        }
    }
}

$data = ($_SERVER['REQUEST_METHOD'] === 'POST') ? $_POST : [];

$activeMenu = 'fasilitas';
$pageTitle = 'Tambah Fasilitas';
$breadcrumb = ['Data Sekolah', 'Fasilitas', 'Tambah'];

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
                <h2>Tambah Fasilitas</h2>
                <p>Lengkapi form berikut untuk menambahkan data baru ke database.</p>
            </div>
        </div>

        <form class="form-panel" action="tambah.php" method="post" enctype="multipart/form-data" autocomplete="off">
            <div class="form-grid">
                <div class="form-group">
                    <label for="nama_fasilitas">Nama Fasilitas <span style="color:var(--danger);">*</span></label>
                    <input type="text" id="nama_fasilitas" name="nama_fasilitas" class="field-input" placeholder="Masukkan nama fasilitas" value="<?php echo htmlspecialchars($data['nama_fasilitas'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="kategori">Kategori <span style="color:var(--danger);">*</span></label>
                    <select id="kategori" name="kategori" class="field-input" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Ruang Kelas" <?php echo ((($data['kategori'] ?? '')) === 'Ruang Kelas') ? 'selected' : ''; ?>>Ruang Kelas</option>
                        <option value="Laboratorium" <?php echo ((($data['kategori'] ?? '')) === 'Laboratorium') ? 'selected' : ''; ?>>Laboratorium</option>
                        <option value="Olahraga" <?php echo ((($data['kategori'] ?? '')) === 'Olahraga') ? 'selected' : ''; ?>>Olahraga</option>
                        <option value="Umum" <?php echo ((($data['kategori'] ?? '')) === 'Umum') ? 'selected' : ''; ?>>Umum</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="kondisi">Kondisi <span style="color:var(--danger);">*</span></label>
                    <select id="kondisi" name="kondisi" class="field-input" required>
                        <option value="">-- Pilih Kondisi --</option>
                        <option value="Baik" <?php echo ((($data['kondisi'] ?? '')) === 'Baik') ? 'selected' : ''; ?>>Baik</option>
                        <option value="Perlu Perbaikan" <?php echo ((($data['kondisi'] ?? '')) === 'Perlu Perbaikan') ? 'selected' : ''; ?>>Perlu Perbaikan</option>
                        <option value="Rusak" <?php echo ((($data['kondisi'] ?? '')) === 'Rusak') ? 'selected' : ''; ?>>Rusak</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="kapasitas">Kapasitas</label>
                    <input type="text" id="kapasitas" name="kapasitas" class="field-input" placeholder="Contoh: 36 orang" value="<?php echo htmlspecialchars($data['kapasitas'] ?? ''); ?>">
                </div>
                <div class="form-group full">
                    <label>Foto Fasilitas</label>
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
                    <label for="deskripsi">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" class="field-input" placeholder="Deskripsi singkat fasilitas" rows="3"><?php echo htmlspecialchars($data['deskripsi'] ?? ''); ?></textarea>
                </div>
            </div>

            <div class="form-actions">
                <a href="index.php" class="btn btn-outline">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Data</button>
            </div>
        </form>

    </div><!-- /.content -->
<?php include '../includes/footer.php'; ?>
