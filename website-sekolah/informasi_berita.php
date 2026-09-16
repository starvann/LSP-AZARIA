<?php
require_once '../config/koneksi.php';
require_once 'includes/helpers.php';

$pengumumanResult = mysqli_query($koneksi, "SELECT * FROM pengumuman WHERE status = 'Aktif' ORDER BY tanggal_terbit DESC LIMIT 5");
$agendaResult = mysqli_query($koneksi, "SELECT * FROM agenda WHERE tanggal >= CURDATE() ORDER BY tanggal ASC LIMIT 4");
if (mysqli_num_rows($agendaResult) === 0) {
    $agendaResult = mysqli_query($koneksi, "SELECT * FROM agenda ORDER BY tanggal DESC LIMIT 4");
}
$beritaResult = mysqli_query($koneksi, "SELECT * FROM berita WHERE status = 'Published' ORDER BY tanggal DESC LIMIT 6");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SMK Negeri 1 Kandeman</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <!-- ============ HEADER ============ -->
<header>
  <div class="nav-inner">
    <a href="#beranda" class="logo">
      <div class="logo-mark">
       <img src="../assets/LOGO SMK.png" alt="Education">
      </div>
      <div class="logo-text">
        <h3>SMK Negeri 1 Kandeman</h3>
        <span>Kabupaten Batang</span>
      </div>
    </a>
    <nav class="main-nav">
      <a href="index.php">Beranda</a>
      <a href="profil.php">Profil Sekolah</a>
      <a href="akademik.php">Akademik</a>
      <a href="kesiswaan.php">Kesiswaan</a>
      <a href="informasi_berita.php">Informasi &amp; Berita</a>
      <a href="kontak.php">Kontak</a>
    </nav>
  </div>
</header>

<!-- ============ INFORMASI & BERITA ============ -->
<section id="informasi" class="band band-alt">
  <div class="wrap">
    <div class="section-head">
      <span class="eyebrow-label">Informasi &amp; Berita</span>
      <h2>Tetap Terhubung dengan Kegiatan Sekolah</h2>
      <p>Pengumuman resmi, artikel kegiatan, dan agenda mendatang yang perlu diketahui siswa dan orang tua.</p>
    </div>

    <div class="info-grid">
      <div>
        <h3 style="font-size:1.15rem;margin-bottom:18px;">Pengumuman Resmi</h3>
        <?php if (mysqli_num_rows($pengumumanResult) === 0): ?>
        <p style="color:#7c8b9a;font-size:.92rem;">Belum ada pengumuman aktif.</p>
        <?php endif; ?>
        <?php while ($p = mysqli_fetch_assoc($pengumumanResult)): list($hariP, $bulanP) = format_tanggal_kotak($p['tanggal_terbit']); ?>
        <div class="pengumuman-item">
          <div class="peng-date"><strong><?php echo $hariP; ?></strong><span><?php echo $bulanP; ?></span></div>
          <div class="peng-body"><h4><?php echo htmlspecialchars($p['judul']); ?><?php if (is_baru($p['tanggal_terbit'])): ?><span class="badge-new">Baru</span><?php endif; ?></h4><p><?php echo htmlspecialchars(mb_strimwidth(strip_tags($p['isi']), 0, 140, '...')); ?></p></div>
        </div>
        <?php endwhile; ?>
      </div>

      <div>
        <h3 style="font-size:1.15rem;margin-bottom:18px;">Agenda Kegiatan Mendatang</h3>
        <?php if (mysqli_num_rows($agendaResult) === 0): ?>
        <p style="color:#7c8b9a;font-size:.92rem;">Belum ada agenda.</p>
        <?php endif; ?>
        <?php while ($a = mysqli_fetch_assoc($agendaResult)): ?>
        <div class="agenda-item">
          <div class="agenda-dot"></div>
          <div class="agenda-body"><h4><?php echo format_tanggal_panjang($a['tanggal']); ?> &mdash; <?php echo htmlspecialchars($a['nama_kegiatan']); ?></h4><p><?php echo htmlspecialchars($a['deskripsi'] !== '' ? $a['deskripsi'] : $a['lokasi']); ?></p></div>
        </div>
        <?php endwhile; ?>
      </div>
    </div>

    <h3 style="font-size:1.15rem;margin-bottom:22px;">Berita &amp; Artikel Kegiatan Sekolah</h3>
    <div class="artikel-grid">
      <?php if (mysqli_num_rows($beritaResult) === 0): ?>
      <p style="color:#7c8b9a;font-size:.92rem;">Belum ada berita.</p>
      <?php endif; ?>
      <?php while ($b = mysqli_fetch_assoc($beritaResult)): ?>
      <div class="news-card">
        <div class="news-img">
          <?php if (!empty($b['gambar'])): ?>
          <img src="../admin/uploads/berita/<?php echo htmlspecialchars($b['gambar']); ?>" alt="<?php echo htmlspecialchars($b['judul']); ?>">
          <?php else: ?>
          <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=600&q=80" alt="<?php echo htmlspecialchars($b['judul']); ?>">
          <?php endif; ?>
        </div>
        <div class="news-body"><span class="news-date"><?php echo format_tanggal_panjang($b['tanggal']); ?></span><h4><?php echo htmlspecialchars($b['judul']); ?></h4><p><?php echo htmlspecialchars($b['ringkasan']); ?></p></div>
      </div>
      <?php endwhile; ?>
    </div>
  </div>
</section>

<!-- ============ FOOTER ============ -->
<footer>
  <div class="wrap">
    <div class="foot-grid">
      <div class="foot-about">
        <div class="foot-logo">
          <a href="index.php"><div class="logo-mark"><<img src="../assets/LOGO SMK.png" alt="Education" href="index.php"></div>
          </a>
        </div>
        <p>Terwujudnya tamatan yang berahlak mulia, kompeten, kompetitif dan berwawasan.</p>
      </div>
      <div>
        <h4>Navigasi</h4>
        <ul>
          <li><a href="index.php">Beranda</a></li>
          <li><a href="profil.php">Profil Sekolah</a></li>
          <li><a href="akademik.php">Akademik</a></li>
          <li><a href="kesiswaan.php">Kesiswaan</a></li>
        </ul>
      </div>
      <div>
        <h4>Informasi</h4>
        <ul>
          <li><a href="informasi_berita.php">Pengumuman</a></li>
          <li><a href="informasi_berita.php">Berita Sekolah</a></li>
          <li><a href="kontak.php">Kontak</a></li>
        </ul>
      </div>
      <div>
        <h4>Kontak Singkat</h4>
        <ul>
          <li>Jl. Raya Kandeman KM. 04 Kecamatan Kandeman, Kabupaten Batang, Jawa Tengah 51261</li>
          <li>(0285)392274</li>
          <li>smkn1kandeman@yahoo.com</li>
        </ul>
      </div>
    </div>
    <div class="foot-bottom">
      <span>© 2026 SMK Negeri 1 Kandeman. Seluruh hak cipta dilindungi.</span>
      <span>Desain oleh Azaria Adila Putri</span>
    </div>
  </div>
</footer>
<button class="back-to-top" id="backToTop" aria-label="Kembali ke atas">
  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M12 19V5M5 12l7-7 7 7"/></svg>
</button>
<script src="../js/script.js"></script>
</body>
</html>
