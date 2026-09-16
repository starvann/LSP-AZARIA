<?php
/**
 * admin/includes/auth.php
 * Penjaga sesi login. Di-include di paling atas setiap halaman admin
 * (setelah variabel $base didefinisikan).
 * Kalau belum login, langsung redirect ke halaman login.
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($base)) {
    $base = '';
}

if (!isset($_SESSION['admin_id'])) {
    header('Location: ' . $base . 'login.php');
    exit;
}
