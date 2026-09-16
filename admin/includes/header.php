<?php
/**
 * admin/includes/header.php
 * Partial layout: bagian <head> dan pembuka <body>.
 * UI ONLY - belum ada session/auth check (akan ditambahkan pada tahap backend).
 *
 * Variabel yang perlu disiapkan sebelum include file ini:
 * $base       : path relatif ke folder admin/   ('' untuk admin root, '../' untuk sub-modul)
 * $pageTitle  : judul halaman (contoh: "Kelola Berita")
 */
if (!isset($base)) { $base = ''; }
if (!isset($pageTitle)) { $pageTitle = 'Admin Panel'; }
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo $pageTitle; ?> — Admin SMK Negeri 1 Kandeman</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?php echo $base; ?>assets/css/admin.css">
</head>
<body>
<div class="admin-wrapper">
