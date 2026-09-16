<?php
require_once '../config/koneksi.php';
require_once 'includes/helpers.php';

$beritaHomeResult = mysqli_query($koneksi, "SELECT * FROM berita WHERE status = 'Published' ORDER BY tanggal DESC LIMIT 3");
$totalGuruHome = 0;
$guruCountRes = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM guru");
if ($guruCountRes) { $totalGuruHome = (int) mysqli_fetch_assoc($guruCountRes)['total']; }
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
    <a href="index.php" class="logo">
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

<!-- ============ HERO / BERANDA ============ -->
<section id="beranda">
  <div class="hero-banner">
    <img class="hero-banner-img" src="../assets/hero-banner.jpg" alt="Upacara bendera siswa SMK Negeri 1 Kandeman">
    <div class="hero-banner-overlay"></div>
    <div class="hero-banner-text">
      <h1>SMK Pusat Keunggulan</h1>
      <p>Terwujudnya tamatan yang berahlak mulia, kompeten, kompetitif dan berwawasan.</p>
    </div>
  </div>

  <div class="wrap">
    <div class="hero-highlight">
      <div class="hero-highlight-item">
        <div class="hh-icon">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke-width="1.8"><path d="M12 2l2.5 5 5.5.8-4 3.9.9 5.5L12 14.8 7.1 17.2 8 11.7 4 7.8l5.5-.8L12 2Z"/></svg>
          <h4>Terakreditasi A</h4>
        </div>
        <p>Menunjukkan komitmen sekolah terhadap kualitas penyelenggaraan pendidikan.</p>
      </div>
      <div class="hero-highlight-item">
        <div class="hh-icon">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke-width="1.8"><path d="M2 8L12 3l10 5-10 5-10-5Z"/><path d="M6 10.5V16c0 1.5 2.7 3 6 3s6-1.5 6-3v-5.5"/></svg>
          <h4>Lulusan Kompeten</h4>
        </div>
        <p>Membekali peserta didik dengan pengetahuan dan keterampilan sesuai bidang keahlian.</p>
      </div>
      <div class="hero-highlight-item">
        <div class="hh-icon">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke-width="1.8"><rect x="3" y="4" width="18" height="14" rx="2"/><path d="M7 21h10M12 18v3"/></svg>
          <h4>Mitra Industri</h4>
        </div>
        <p>Membangun hubungan dengan dunia usaha dan dunia industri untuk mendukung kesiapan kerja peserta didik.</p>
      </div>
    </div>
  </div>

  <div class="ticker-bar">
    <div class="ticker-inner">
      <span class="ticker-tag">Pengumuman</span>
      <div class="ticker-track-wrap">
        <div class="ticker-track">
          <span>Pendaftaran Peserta Didik Baru (PPDB) 2026/2027 resmi dibuka mulai 1 Oktober 2026</span>
          <span>Perubahan jadwal Ujian Tengah Semester Ganjil — cek kalender akademik</span>
          <span>Pengambilan rapor tengah semester dilaksanakan 24–25 Oktober 2026</span>
          <span>Pendaftaran Peserta Didik Baru (PPDB) 2026/2027 resmi dibuka mulai 1 Oktober 2026</span>
          <span>Perubahan jadwal Ujian Tengah Semester Ganjil — cek kalender akademik</span>
          <span>Pengambilan rapor tengah semester dilaksanakan 24–25 Oktober 2026</span>
        </div>
      </div>
    </div>
  </div>

  <div class="sambutan">
    <div class="wrap sambutan-grid">
      <div class="sambutan-photo">
        <img src="../assets/pak set.jpeg" alt="Kepala Sekolah" />
      </div>
      <div class="sambutan-text">
        <h2>Sambutan Kepala Sekolah</h2> <br>
        <div class="sambutan-quote">&ldquo;</div>
        <p>Website ini hadir sebagai media informasi dan komunikasi bagi seluruh warga sekolah maupun masyarakat. Melalui website ini, kami menyediakan berbagai informasi mengenai profil sekolah, program keahlian, kegiatan, prestasi, berita, serta berbagai layanan pendidikan di SMK Negeri 1 Kandeman.</p>
        <p>Sebagai lembaga pendidikan kejuruan, SMK Negeri 1 Kandeman berkomitmen untuk terus meningkatkan kualitas pendidikan dengan mengembangkan kompetensi, karakter, kreativitas, dan kemandirian peserta didik agar siap menghadapi perkembangan dunia kerja, dunia industri, maupun melanjutkan pendidikan ke jenjang yang lebih tinggi.</p>
        <p>Kami berharap website ini dapat menjadi sarana informasi yang mudah diakses dan memberikan manfaat bagi seluruh masyarakat.</p>
        <div class="sambutan-sign">
          <div class="line"></div>
          <div>
            <strong>Setiyanto S.pd, M.pd.</strong>
            <span>Kepala Sekolah SMK Negeri 1 Kandeman</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="keunggulan">
    <div class="wrap">
      <div class="section-head">
        <span class="eyebrow-label">Keunggulan Kami</span>
        <h2>SMK Pusat Keunggulan?</h2>
        <p>Komitmen kami terhadap mutu pendidikan tercermin dalam setiap aspek pembelajaran dan lingkungan sekolah.</p>
      </div>
      <div class="feat-grid">
        <div class="feat-card">
          <div class="feat-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke-width="1.8"><path d="M12 3l9 4.5-9 4.5-9-4.5L12 3Z"/><path d="M6.5 10v5c0 1.7 2.5 3 5.5 3s5.5-1.3 5.5-3v-5"/></svg></div>
          <h4>Akreditasi A</h4>
          <p>Terakreditasi A dengan standar mutu pendidikan yang terjaga setiap tahunnya.</p>
        </div>
        <div class="feat-card">
          <div class="feat-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke-width="1.8"><circle cx="12" cy="8" r="3.2"/><path d="M5 20c0-3.5 3-6 7-6s7 2.5 7 6"/></svg></div>
          <h4>Tenaga Pendidik Berkualitas</h4>
          <p><?php echo $totalGuruHome; ?> guru profesional yang berdedikasi di bidangnya masing-masing.</p>
        </div>
        <div class="feat-card">
          <div class="feat-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke-width="1.8"><rect x="3" y="4" width="18" height="14" rx="2"/><path d="M7 21h10M12 18v3"/></svg></div>
          <h4>Fasilitas Lengkap</h4>
          <p>Laboratorium, perpustakaan, dan sarana olahraga yang mendukung proses belajar optimal.</p>
        </div>
        <div class="feat-card">
          <div class="feat-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke-width="1.8"><path d="M12 15l-5.5 3 1.5-6L3 8l6-1L12 2l3 5 6 1-5 4 1.5 6z"/></svg></div>
          <h4>Prestasi Nasional</h4>
          <p>Konsisten meraih juara di ajang olimpiade dan kompetisi tingkat nasional.</p>
        </div>
      </div>
    </div>
  </div>

  <div class="berita-home">
    <div class="wrap">
      <div class="section-head">
        <span class="eyebrow-label">Berita &amp; Pengumuman Terkini</span>
        <h2>Kabar Terbaru dari Sekolah</h2>
      </div>
      <div class="news-grid">
        <?php if (mysqli_num_rows($beritaHomeResult) === 0): ?>
        <p style="color:#7c8b9a;font-size:.92rem;">Belum ada berita.</p>
        <?php endif; ?>
        <?php while ($bh = mysqli_fetch_assoc($beritaHomeResult)): ?>
        <div class="news-card">
          <div class="news-img">
            <?php if (!empty($bh['gambar'])): ?>
            <img src="../admin/uploads/berita/<?php echo htmlspecialchars($bh['gambar']); ?>" alt="<?php echo htmlspecialchars($bh['judul']); ?>">
            <?php else: ?>
            <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=600&q=80" alt="<?php echo htmlspecialchars($bh['judul']); ?>">
            <?php endif; ?>
          </div>
          <div class="news-body">
            <span class="news-date"><?php echo format_tanggal_panjang($bh['tanggal']); ?></span>
            <h4><?php echo htmlspecialchars($bh['judul']); ?></h4>
            <p><?php echo htmlspecialchars($bh['ringkasan']); ?></p>
          </div>
        </div>
        <?php endwhile; ?>
      </div>
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
