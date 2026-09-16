<?php
/**
 * admin/includes/helpers.php
 * Kumpulan fungsi bantu yang dipakai di semua modul CRUD admin.
 */

/** Ubah tanggal 'Y-m-d' dari database jadi format Indonesia "12 Sep 2026". */
function format_tanggal($tanggal) {
    if (empty($tanggal) || $tanggal === '0000-00-00') return '-';
    $bulan = ['01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'Mei','06'=>'Jun',
              '07'=>'Jul','08'=>'Agu','09'=>'Sep','10'=>'Okt','11'=>'Nov','12'=>'Des'];
    $parts = explode('-', $tanggal);
    if (count($parts) !== 3) return htmlspecialchars($tanggal);
    list($y, $m, $d) = $parts;
    $bulanNama = isset($bulan[$m]) ? $bulan[$m] : $m;
    return intval($d) . ' ' . $bulanNama . ' ' . $y;
}

/** Kelas CSS badge berdasarkan nilai status/kondisi/tingkat. */
function badge_class($value) {
    $v = strtolower(trim($value));
    $success = ['published', 'aktif', 'baik', 'pns'];
    $warning = ['draft', 'nonaktif', 'perlu perbaikan', 'honorer'];
    $muted   = ['rusak'];
    if (in_array($v, $success)) return 'badge-success';
    if (in_array($v, $warning)) return 'badge-warning';
    if (in_array($v, $muted)) return 'badge-muted';
    return 'badge-sky';
}

/**
 * Proses upload file (gambar/foto).
 * $fileField   : nama field input file (mis. 'gambar')
 * $targetDir   : path folder tujuan di server (mis. __DIR__.'/../uploads/berita/')
 * $oldFile     : nama file lama (dipakai kalau tidak ada file baru diunggah, saat edit)
 * return       : nama file (string) yang akan disimpan ke database, atau null jika tidak ada file sama sekali
 */
function handle_upload($fileField, $targetDir, $oldFile = null) {
    if (!isset($_FILES[$fileField]) || $_FILES[$fileField]['error'] === UPLOAD_ERR_NO_FILE) {
        return $oldFile;
    }
    if ($_FILES[$fileField]['error'] !== UPLOAD_ERR_OK) {
        return $oldFile;
    }

    $allowedExt = ['jpg', 'jpeg', 'png', 'webp'];
    $originalName = $_FILES[$fileField]['name'];
    $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

    if (!in_array($ext, $allowedExt)) {
        return $oldFile;
    }

    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    $newName = uniqid(date('YmdHis') . '_') . '.' . $ext;
    $targetPath = rtrim($targetDir, '/') . '/' . $newName;

    if (move_uploaded_file($_FILES[$fileField]['tmp_name'], $targetPath)) {
        return $newName;
    }

    return $oldFile;
}

/** Bangun ulang query string GET saat ini, tapi ganti/tambahkan parameter 'page'. */
function build_page_url($page) {
    $params = $_GET;
    $params['page'] = $page;
    return '?' . http_build_query($params);
}
