<?php
/**
 * admin/logout.php
 * Menghapus sesi login lalu redirect ke halaman login.
 */
session_start();
$_SESSION = [];
session_unset();
session_destroy();

header('Location: login.php');
exit;
