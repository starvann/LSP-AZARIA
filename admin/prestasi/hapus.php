<?php
/**
 * admin/prestasi/hapus.php
 * Memproses penghapusan data Prestasi dari database.
 * Diakses lewat tombol Hapus -> modal konfirmasi (admin.js) -> redirect ke sini.
 */
require_once '../../config/koneksi.php';
require_once '../includes/helpers.php';

$base = '../';
require_once '../includes/auth.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {

    $stmt = mysqli_prepare($koneksi, "DELETE FROM prestasi WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
}

header('Location: index.php?msg=hapus_sukses');
exit;
