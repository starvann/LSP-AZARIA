<?php
/**
 * admin/berita/hapus.php
 * Memproses penghapusan data Berita dari database.
 * Diakses lewat tombol Hapus -> modal konfirmasi (admin.js) -> redirect ke sini.
 */
require_once '../../config/koneksi.php';
require_once '../includes/helpers.php';

$base = '../';
require_once '../includes/auth.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    // Hapus file upload lama (jika ada) supaya tidak jadi sampah di server
    $result = mysqli_query($koneksi, "SELECT gambar FROM berita WHERE id = " . $id . " LIMIT 1");
    $row = mysqli_fetch_assoc($result);
    if ($row && !empty($row['gambar'])) {
        $filePath = __DIR__ . '/../uploads/berita/' . $row['gambar'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
    $stmt = mysqli_prepare($koneksi, "DELETE FROM berita WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
}

header('Location: index.php?msg=hapus_sukses');
exit;
