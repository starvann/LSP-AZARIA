<?php
/**
 * admin/guru/edit.php
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
    $nama = trim($_POST['nama'] ?? '');
    $nip = trim($_POST['nip'] ?? '');
    $jabatan = trim($_POST['jabatan'] ?? '');
    $mapel = trim($_POST['mapel'] ?? '');
    $status_kepegawaian = trim($_POST['status_kepegawaian'] ?? '');
    $foto = handle_upload('foto', __DIR__ . '/../uploads/guru/', $_POST['old_foto'] ?? null);
    if ($nama === '') {
        $errors[] = 'Nama Lengkap wajib diisi.';
    }
    if ($nip === '') {
        $errors[] = 'NIP / NUPTK wajib diisi.';
    }
    if ($jabatan === '') {
        $errors[] = 'Jabatan wajib diisi.';
    }
    if ($status_kepegawaian === '') {
        $errors[] = 'Status Kepegawaian wajib diisi.';
    }
    if (empty($errors)) {
        $stmt = mysqli_prepare($koneksi, "UPDATE guru SET nama = ?, nip = ?, jabatan = ?, mapel = ?, status_kepegawaian = ?, foto = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "ssssssi", $nama, $nip, $jabatan, $mapel, $status_kepegawaian, $foto, $id);
        if (mysqli_stmt_execute($stmt)) {
            header('Location: index.php?msg=edit_sukses');
            exit;
        } else {
            $errors[] = 'Gagal memperbarui data: ' . mysqli_error($koneksi);
        }
    }
    $data = $_POST;
} else {
    $result = mysqli_query($koneksi, "SELECT * FROM guru WHERE id = " . $id . " LIMIT 1");
    $row = mysqli_fetch_assoc($result);
    if (!$row) {
        header('Location: index.php?msg=not_found');
        exit;
    }
    $data = $row;
}

$activeMenu = 'guru';
$pageTitle = 'Edit Data Guru & Tendik';
$breadcrumb = ['Data Sekolah', 'Guru &amp; Tendik', 'Edit'];

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
                <h2>Edit Data Guru & Tendik</h2>
                <p>Perbarui data yang sudah tersimpan di database.</p>
            </div>
        </div>

        <form class="form-panel" action="edit.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data" autocomplete="off">
            <div class="form-grid">
                <div class="form-group">
                    <label for="nama">Nama Lengkap <span style="color:var(--danger);">*</span></label>
                    <input type="text" id="nama" name="nama" class="field-input" placeholder="Masukkan nama lengkap beserta gelar" value="<?php echo htmlspecialchars($data['nama'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="nip">NIP / NUPTK <span style="color:var(--danger);">*</span></label>
                    <input type="text" id="nip" name="nip" class="field-input" placeholder="Masukkan NIP atau NUPTK" value="<?php echo htmlspecialchars($data['nip'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="jabatan">Jabatan <span style="color:var(--danger);">*</span></label>
                    <select id="jabatan" name="jabatan" class="field-input" required>
                        <option value="">-- Pilih Jabatan --</option>
                        <option value="Kepala Sekolah" <?php echo ((($data['jabatan'] ?? '')) === 'Kepala Sekolah') ? 'selected' : ''; ?>>Kepala Sekolah</option>
                        <option value="Guru" <?php echo ((($data['jabatan'] ?? '')) === 'Guru') ? 'selected' : ''; ?>>Guru</option>
                        <option value="Tendik" <?php echo ((($data['jabatan'] ?? '')) === 'Tendik') ? 'selected' : ''; ?>>Tendik</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="mapel">Mata Pelajaran</label>
                    <input type="text" id="mapel" name="mapel" class="field-input" placeholder="Contoh: Matematika (kosongkan jika tendik)" value="<?php echo htmlspecialchars($data['mapel'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label for="status_kepegawaian">Status Kepegawaian <span style="color:var(--danger);">*</span></label>
                    <select id="status_kepegawaian" name="status_kepegawaian" class="field-input" required>
                        <option value="">-- Pilih Status Kepegawaian --</option>
                        <option value="PNS" <?php echo ((($data['status_kepegawaian'] ?? '')) === 'PNS') ? 'selected' : ''; ?>>PNS</option>
                        <option value="PPPK" <?php echo ((($data['status_kepegawaian'] ?? '')) === 'PPPK') ? 'selected' : ''; ?>>PPPK</option>
                        <option value="Honorer" <?php echo ((($data['status_kepegawaian'] ?? '')) === 'Honorer') ? 'selected' : ''; ?>>Honorer</option>
                    </select>
                </div>
                <div class="form-group full">
                    <label>Foto Profil</label>
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
            </div>

            <div class="form-actions">
                <a href="index.php" class="btn btn-outline">Batal</a>
                <button type="submit" class="btn btn-primary">Update Data</button>
            </div>
        </form>

    </div><!-- /.content -->
<?php include '../includes/footer.php'; ?>
