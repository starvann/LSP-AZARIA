<?php
/**
 * website-sekolah/includes/helpers.php
 * Kumpulan fungsi bantu untuk menampilkan data database di halaman publik.
 */

/** Ubah tanggal 'Y-m-d' jadi format Indonesia panjang, contoh: "12 September 2026". */
function format_tanggal_panjang($tanggal) {
    if (empty($tanggal) || $tanggal === '0000-00-00') return '-';
    $bulan = ['01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni',
              '07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'];
    $parts = explode('-', $tanggal);
    if (count($parts) !== 3) return htmlspecialchars($tanggal);
    list($y, $m, $d) = $parts;
    $bulanNama = isset($bulan[$m]) ? $bulan[$m] : $m;
    return intval($d) . ' ' . $bulanNama . ' ' . $y;
}

/** Ambil [hari, bulan-singkat-huruf-besar] dari tanggal 'Y-m-d', untuk kotak tanggal pengumuman. */
function format_tanggal_kotak($tanggal) {
    if (empty($tanggal) || $tanggal === '0000-00-00') return ['-', '-'];
    $bulan = ['01'=>'JAN','02'=>'FEB','03'=>'MAR','04'=>'APR','05'=>'MEI','06'=>'JUN',
              '07'=>'JUL','08'=>'AGU','09'=>'SEP','10'=>'OKT','11'=>'NOV','12'=>'DES'];
    $parts = explode('-', $tanggal);
    if (count($parts) !== 3) return [$tanggal, ''];
    list($y, $m, $d) = $parts;
    return [intval($d), isset($bulan[$m]) ? $bulan[$m] : $m];
}

/** True jika tanggal masih dalam N hari terakhir (dipakai untuk badge "Baru"). */
function is_baru($tanggal, $hari = 5) {
    if (empty($tanggal)) return false;
    $batas = strtotime('-' . $hari . ' days');
    return strtotime($tanggal) >= $batas;
}
