<?php
/**
 * admin/prestasi/tambah.php
 * UI + BACKEND - form ini sudah memproses INSERT ke database (dengan validasi & upload file).
 */
require_once '../../config/koneksi.php';
require_once '../includes/helpers.php';

$base = '../';
require_once '../includes/auth.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_prestasi = trim($_POST['nama_prestasi'] ?? '');
    $nama_siswa = trim($_POST['nama_siswa'] ?? '');
    $tingkat = trim($_POST['tingkat'] ?? '');
    $tahun = trim($_POST['tahun'] ?? '');
    $bidang = trim($_POST['bidang'] ?? '');
    $deskripsi = trim($_POST['deskripsi'] ?? '');

    if ($nama_prestasi === '') {
        $errors[] = 'Nama Prestasi wajib diisi.';
    }
    if ($nama_siswa === '') {
        $errors[] = 'Nama Siswa/Tim wajib diisi.';
    }
    if ($tingkat === '') {
        $errors[] = 'Tingkat wajib diisi.';
    }
    if ($tahun === '') {
        $errors[] = 'Tahun wajib diisi.';
    }
    if (empty($errors)) {
        $stmt = mysqli_prepare($koneksi, "INSERT INTO prestasi (nama_prestasi, nama_siswa, tingkat, tahun, bidang, deskripsi) VALUES (?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssssss", $nama_prestasi, $nama_siswa, $tingkat, $tahun, $bidang, $deskripsi);
        if (mysqli_stmt_execute($stmt)) {
            header('Location: index.php?msg=tambah_sukses');
            exit;
        } else {
            $errors[] = 'Gagal menyimpan data: ' . mysqli_error($koneksi);
        }
    }
}

$data = ($_SERVER['REQUEST_METHOD'] === 'POST') ? $_POST : [];

$activeMenu = 'prestasi';
$pageTitle = 'Tambah Prestasi';
$breadcrumb = ['Data Sekolah', 'Prestasi', 'Tambah'];

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
                <h2>Tambah Prestasi</h2>
                <p>Lengkapi form berikut untuk menambahkan data baru ke database.</p>
            </div>
        </div>

        <form class="form-panel" action="tambah.php" method="post" enctype="multipart/form-data" autocomplete="off">
            <div class="form-grid">
                <div class="form-group">
                    <label for="nama_prestasi">Nama Prestasi <span style="color:var(--danger);">*</span></label>
                    <input type="text" id="nama_prestasi" name="nama_prestasi" class="field-input" placeholder="Masukkan nama/judul prestasi" value="<?php echo htmlspecialchars($data['nama_prestasi'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="nama_siswa">Nama Siswa/Tim <span style="color:var(--danger);">*</span></label>
                    <input type="text" id="nama_siswa" name="nama_siswa" class="field-input" placeholder="Masukkan nama siswa atau tim" value="<?php echo htmlspecialchars($data['nama_siswa'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="tingkat">Tingkat <span style="color:var(--danger);">*</span></label>
                    <select id="tingkat" name="tingkat" class="field-input" required>
                        <option value="">-- Pilih Tingkat --</option>
                        <option value="Sekolah" <?php echo ((($data['tingkat'] ?? '')) === 'Sekolah') ? 'selected' : ''; ?>>Sekolah</option>
                        <option value="Kabupaten" <?php echo ((($data['tingkat'] ?? '')) === 'Kabupaten') ? 'selected' : ''; ?>>Kabupaten</option>
                        <option value="Provinsi" <?php echo ((($data['tingkat'] ?? '')) === 'Provinsi') ? 'selected' : ''; ?>>Provinsi</option>
                        <option value="Nasional" <?php echo ((($data['tingkat'] ?? '')) === 'Nasional') ? 'selected' : ''; ?>>Nasional</option>
                        <option value="Internasional" <?php echo ((($data['tingkat'] ?? '')) === 'Internasional') ? 'selected' : ''; ?>>Internasional</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tahun">Tahun <span style="color:var(--danger);">*</span></label>
                    <input type="text" id="tahun" name="tahun" class="field-input" placeholder="Contoh: 2026" value="<?php echo htmlspecialchars($data['tahun'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="bidang">Bidang</label>
                    <input type="text" id="bidang" name="bidang" class="field-input" placeholder="Contoh: Akademik / Non-Akademik" value="<?php echo htmlspecialchars($data['bidang'] ?? ''); ?>">
                </div>
                <div class="form-group full">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" class="field-input" placeholder="Deskripsi singkat prestasi" rows="3"><?php echo htmlspecialchars($data['deskripsi'] ?? ''); ?></textarea>
                </div>
            </div>

            <div class="form-actions">
                <a href="index.php" class="btn btn-outline">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Data</button>
            </div>
        </form>

    </div><!-- /.content -->
<?php include '../includes/footer.php'; ?>
