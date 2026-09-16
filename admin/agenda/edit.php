<?php
/**
 * admin/agenda/edit.php
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
    $nama_kegiatan = trim($_POST['nama_kegiatan'] ?? '');
    $tanggal = trim($_POST['tanggal'] ?? '');
    $waktu = trim($_POST['waktu'] ?? '');
    $lokasi = trim($_POST['lokasi'] ?? '');
    $penanggung_jawab = trim($_POST['penanggung_jawab'] ?? '');
    $deskripsi = trim($_POST['deskripsi'] ?? '');

    if ($nama_kegiatan === '') {
        $errors[] = 'Nama Kegiatan wajib diisi.';
    }
    if ($tanggal === '') {
        $errors[] = 'Tanggal wajib diisi.';
    }
    if ($waktu === '') {
        $errors[] = 'Waktu wajib diisi.';
    }
    if ($lokasi === '') {
        $errors[] = 'Lokasi wajib diisi.';
    }
    if ($penanggung_jawab === '') {
        $errors[] = 'Penanggung Jawab wajib diisi.';
    }
    if (empty($errors)) {
        $stmt = mysqli_prepare($koneksi, "UPDATE agenda SET nama_kegiatan = ?, tanggal = ?, waktu = ?, lokasi = ?, penanggung_jawab = ?, deskripsi = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "ssssssi", $nama_kegiatan, $tanggal, $waktu, $lokasi, $penanggung_jawab, $deskripsi, $id);
        if (mysqli_stmt_execute($stmt)) {
            header('Location: index.php?msg=edit_sukses');
            exit;
        } else {
            $errors[] = 'Gagal memperbarui data: ' . mysqli_error($koneksi);
        }
    }
    $data = $_POST;
} else {
    $result = mysqli_query($koneksi, "SELECT * FROM agenda WHERE id = " . $id . " LIMIT 1");
    $row = mysqli_fetch_assoc($result);
    if (!$row) {
        header('Location: index.php?msg=not_found');
        exit;
    }
    $data = $row;
}

$activeMenu = 'agenda';
$pageTitle = 'Edit Agenda Kegiatan';
$breadcrumb = ['Konten', 'Agenda', 'Edit'];

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
                <h2>Edit Agenda Kegiatan</h2>
                <p>Perbarui data yang sudah tersimpan di database.</p>
            </div>
        </div>

        <form class="form-panel" action="edit.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data" autocomplete="off">
            <div class="form-grid">
                <div class="form-group">
                    <label for="nama_kegiatan">Nama Kegiatan <span style="color:var(--danger);">*</span></label>
                    <input type="text" id="nama_kegiatan" name="nama_kegiatan" class="field-input" placeholder="Masukkan nama kegiatan" value="<?php echo htmlspecialchars($data['nama_kegiatan'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="tanggal">Tanggal <span style="color:var(--danger);">*</span></label>
                    <input type="date" id="tanggal" name="tanggal" class="field-input" value="<?php echo htmlspecialchars($data['tanggal'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="waktu">Waktu <span style="color:var(--danger);">*</span></label>
                    <input type="text" id="waktu" name="waktu" class="field-input" placeholder="Contoh: 08:00 WIB" value="<?php echo htmlspecialchars($data['waktu'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="lokasi">Lokasi <span style="color:var(--danger);">*</span></label>
                    <input type="text" id="lokasi" name="lokasi" class="field-input" placeholder="Contoh: Aula Sekolah" value="<?php echo htmlspecialchars($data['lokasi'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="penanggung_jawab">Penanggung Jawab <span style="color:var(--danger);">*</span></label>
                    <input type="text" id="penanggung_jawab" name="penanggung_jawab" class="field-input" placeholder="Nama penanggung jawab" value="<?php echo htmlspecialchars($data['penanggung_jawab'] ?? ''); ?>" required>
                </div>
                <div class="form-group full">
                    <label for="deskripsi">Deskripsi Kegiatan</label>
                    <textarea id="deskripsi" name="deskripsi" class="field-input" placeholder="Deskripsi singkat kegiatan" rows="3"><?php echo htmlspecialchars($data['deskripsi'] ?? ''); ?></textarea>
                </div>
            </div>

            <div class="form-actions">
                <a href="index.php" class="btn btn-outline">Batal</a>
                <button type="submit" class="btn btn-primary">Update Data</button>
            </div>
        </form>

    </div><!-- /.content -->
<?php include '../includes/footer.php'; ?>
