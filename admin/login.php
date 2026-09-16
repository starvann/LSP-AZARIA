<?php
/**
 * admin/login.php
 * Memproses login asli: cek username ke tabel `admin`, verifikasi password
 * dengan password_verify(), lalu simpan sesi kalau berhasil.
 */
session_start();
require_once '../config/koneksi.php';

$base = '';

// Kalau sudah login, langsung lempar ke dashboard.
if (isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $errors[] = 'Username dan password wajib diisi.';
    } else {
        $stmt = mysqli_prepare($koneksi, "SELECT id, username, password, nama_lengkap FROM admin WHERE username = ? LIMIT 1");
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $admin = $result ? mysqli_fetch_assoc($result) : null;

        if ($admin && password_verify($password, $admin['password'])) {
            session_regenerate_id(true);
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            $_SESSION['admin_nama'] = $admin['nama_lengkap'];

            header('Location: index.php');
            exit;
        } else {
            $errors[] = 'Username atau password salah.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Admin — SMK Negeri 1 Kandeman</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?php echo $base; ?>assets/css/admin.css">
</head>
<body>

<div class="login-page">
    <div class="login-card">
        <div class="login-logo">
            <div class="logo-mark">
                <img src="../assets/LOGO SMK.png" alt="Logo SMK Negeri 1 Kandeman" style="width:100%;height:100%;object-fit:contain;">
            </div>
            <h1>SMK Negeri 1 Kandeman</h1>
            <span>Kabupaten Batang</span>
        </div>

        <span class="login-eyebrow">Admin Panel</span>

        <?php if (!empty($errors)): ?>
        <div class="alert-box alert-error" style="margin-bottom:18px;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
            <div><?php echo implode('<br>', array_map('htmlspecialchars', $errors)); ?></div>
        </div>
        <?php endif; ?>

        <form action="login.php" method="post" autocomplete="off">
            <div class="field-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" class="field-input" placeholder="Masukkan username" value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" required autofocus>
            </div>

            <div class="field-group">
                <label for="password">Password</label>
                <div class="field-with-icon">
                    <input type="password" id="password" name="password" class="field-input" placeholder="Masukkan password" required>
                    <button type="button" class="field-toggle" id="togglePassword" aria-label="Tampilkan password">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Masuk</button>
        </form>
    </div>
</div>

<script src="<?php echo $base; ?>assets/js/admin.js"></script>
</body>
</html>
