<?php
/**
 * admin/pengumuman/edit.php
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
        $stmt = mysqli_prepare($koneksi, "UPDATE pengumuman SET judul = ?, kategori = ?, status = ?, tanggal_terbit = ?, berlaku_sampai = ?, isi = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "ssssssi", $judul, $kategori, $status, $tanggal_terbit, $berlaku_sampai, $isi, $id);
        if (mysqli_stmt_execute($stmt)) {
            header('Location: index.php?msg=edit_sukses');
            exit;
        } else {
            $errors[] = 'Gagal memperbarui data: ' . mysqli_error($koneksi);
        }
    }
    $data = $_POST;
} else {
    $result = mysqli_query($koneksi, "SELECT * FROM pengumuman WHERE id = " . $id . " LIMIT 1");
    $row = mysqli_fetch_assoc($result);
    if (!$row) {
        header('Location: index.php?msg=not_found');
        exit;
    }
    $data = $row;
}

$activeMenu = 'pengumuman';
$pageTitle = 'Edit Pengumuman';
$breadcrumb = ['Konten', 'Pengumuman', 'Edit'];

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
                <h2>Edit Pengumuman</h2>
                <p>Perbarui data yang sudah tersimpan di database.</p>
            </div>
        </div>

        <form class="form-panel" action="edit.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data" autocomplete="off">
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
                <button type="submit" class="btn btn-primary">Update Data</button>
            </div>
        </form>

    </div><!-- /.content -->
<?php include '../includes/footer.php'; ?>
