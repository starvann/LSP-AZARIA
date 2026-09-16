<?php
/**
 * admin/berita/tambah.php
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
    $tanggal = trim($_POST['tanggal'] ?? '');
    $penulis = trim($_POST['penulis'] ?? '');
    $status = trim($_POST['status'] ?? '');
    $ringkasan = trim($_POST['ringkasan'] ?? '');
    $isi = trim($_POST['isi'] ?? '');
    $gambar = handle_upload('gambar', __DIR__ . '/../uploads/berita/');
    if ($judul === '') {
        $errors[] = 'Judul Berita wajib diisi.';
    }
    if ($kategori === '') {
        $errors[] = 'Kategori wajib diisi.';
    }
    if ($tanggal === '') {
        $errors[] = 'Tanggal Publikasi wajib diisi.';
    }
    if ($penulis === '') {
        $errors[] = 'Penulis wajib diisi.';
    }
    if ($status === '') {
        $errors[] = 'Status wajib diisi.';
    }
    if ($ringkasan === '') {
        $errors[] = 'Ringkasan Singkat wajib diisi.';
    }
    if ($isi === '') {
        $errors[] = 'Isi Berita wajib diisi.';
    }
    if (empty($errors)) {
        $stmt = mysqli_prepare($koneksi, "INSERT INTO berita (judul, kategori, tanggal, penulis, status, gambar, ringkasan, isi) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssssssss", $judul, $kategori, $tanggal, $penulis, $status, $gambar, $ringkasan, $isi);
        if (mysqli_stmt_execute($stmt)) {
            header('Location: index.php?msg=tambah_sukses');
            exit;
        } else {
            $errors[] = 'Gagal menyimpan data: ' . mysqli_error($koneksi);
        }
    }
}

$data = ($_SERVER['REQUEST_METHOD'] === 'POST') ? $_POST : [];

$activeMenu = 'berita';
$pageTitle = 'Tambah Berita';
$breadcrumb = ['Konten', 'Berita', 'Tambah'];

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
                <h2>Tambah Berita</h2>
                <p>Lengkapi form berikut untuk menambahkan data baru ke database.</p>
            </div>
        </div>

        <form class="form-panel" action="tambah.php" method="post" enctype="multipart/form-data" autocomplete="off">
            <div class="form-grid">
                <div class="form-group">
                    <label for="judul">Judul Berita <span style="color:var(--danger);">*</span></label>
                    <input type="text" id="judul" name="judul" class="field-input" placeholder="Masukkan judul berita" value="<?php echo htmlspecialchars($data['judul'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="kategori">Kategori <span style="color:var(--danger);">*</span></label>
                    <select id="kategori" name="kategori" class="field-input" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Akademik" <?php echo ((($data['kategori'] ?? '')) === 'Akademik') ? 'selected' : ''; ?>>Akademik</option>
                        <option value="Kegiatan" <?php echo ((($data['kategori'] ?? '')) === 'Kegiatan') ? 'selected' : ''; ?>>Kegiatan</option>
                        <option value="Prestasi" <?php echo ((($data['kategori'] ?? '')) === 'Prestasi') ? 'selected' : ''; ?>>Prestasi</option>
                        <option value="Pengumuman" <?php echo ((($data['kategori'] ?? '')) === 'Pengumuman') ? 'selected' : ''; ?>>Pengumuman</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tanggal">Tanggal Publikasi <span style="color:var(--danger);">*</span></label>
                    <input type="date" id="tanggal" name="tanggal" class="field-input" value="<?php echo htmlspecialchars($data['tanggal'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="penulis">Penulis <span style="color:var(--danger);">*</span></label>
                    <input type="text" id="penulis" name="penulis" class="field-input" placeholder="Nama penulis" value="<?php echo htmlspecialchars($data['penulis'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="status">Status <span style="color:var(--danger);">*</span></label>
                    <select id="status" name="status" class="field-input" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="Published" <?php echo ((($data['status'] ?? '')) === 'Published') ? 'selected' : ''; ?>>Published</option>
                        <option value="Draft" <?php echo ((($data['status'] ?? '')) === 'Draft') ? 'selected' : ''; ?>>Draft</option>
                    </select>
                </div>
                <div class="form-group full">
                    <label>Gambar Sampul</label>
                    <div class="upload-box">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><path d="M17 8l-5-5-5 5"/><path d="M12 3v12"/></svg>
                        <p>Klik untuk unggah atau tarik file ke sini</p>
                        <span>JPG, JPEG, PNG, atau WEBP hingga 2MB</span>
                        <input type="file" name="gambar" accept=".jpg,.jpeg,.png,.webp" style="margin-top:12px;font-size:.78rem;">
                    </div>
                    <?php if (!empty($data['gambar'] ?? ($data['old_gambar'] ?? ''))): ?>
                    <p style="margin-top:10px;font-size:.78rem;color:var(--text-secondary);">File saat ini: <strong><?php echo htmlspecialchars($data['gambar'] ?? ($data['old_gambar'] ?? '')); ?></strong> (biarkan kosong jika tidak ingin mengganti)</p>
                    <input type="hidden" name="old_gambar" value="<?php echo htmlspecialchars($data['gambar'] ?? ($data['old_gambar'] ?? '')); ?>">
                    <?php endif; ?>
                </div>
                <div class="form-group full">
                    <label for="ringkasan">Ringkasan Singkat <span style="color:var(--danger);">*</span></label>
                    <textarea id="ringkasan" name="ringkasan" class="field-input" placeholder="Ringkasan singkat yang tampil di daftar berita" rows="3" required><?php echo htmlspecialchars($data['ringkasan'] ?? ''); ?></textarea>
                </div>
                <div class="form-group full">
                    <label for="isi">Isi Berita <span style="color:var(--danger);">*</span></label>
                    <textarea id="isi" name="isi" class="field-input" placeholder="Tulis isi lengkap berita di sini..." rows="7" required><?php echo htmlspecialchars($data['isi'] ?? ''); ?></textarea>
                </div>
            </div>

            <div class="form-actions">
                <a href="index.php" class="btn btn-outline">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Data</button>
            </div>
        </form>

    </div><!-- /.content -->
<?php include '../includes/footer.php'; ?>
