<?php
/**
 * config/koneksi.php
 * Koneksi database MySQL menggunakan MySQLi.
 * Environment default: XAMPP/Laragon lokal (root tanpa password).
 *
 * Cara pakai di halaman lain:
 *   require_once __DIR__ . '/../config/koneksi.php';
 *   (sesuaikan jumlah '../' dengan kedalaman folder halaman yang memanggil)
 */

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'db_smkn1kandeman';

$koneksi = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$koneksi) {
    die('Koneksi database gagal: ' . mysqli_connect_error());
}

mysqli_set_charset($koneksi, 'utf8mb4');
