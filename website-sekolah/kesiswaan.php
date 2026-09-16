<?php
require_once '../config/koneksi.php';
require_once 'includes/helpers.php';

$galeriResult = mysqli_query($koneksi, "SELECT * FROM galeri ORDER BY tanggal DESC LIMIT 6");
$prestasiResult = mysqli_query($koneksi, "SELECT * FROM prestasi ORDER BY tahun DESC, id DESC LIMIT 3");
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

<!-- ============ KESISWAAN ============ -->
<section id="kesiswaan" class="band">
  <div class="wrap">
    <div class="section-head">
      <span class="eyebrow-label">Kesiswaan</span>
      <h2>Ruang Berkembang bagi Setiap Siswa</h2>
      <p>Organisasi, kegiatan, dan karya siswa yang menjadi wadah aktualisasi bakat dan kepemimpinan.</p>
    </div>
 
    <div class="osis-card">
      <div>
        <span class="eyebrow-label" style="color:var(--sky)">OSIS &amp; MPK</span>
        <h3>Organisasi Siswa Intra Sekolah</h3>
        <p>OSIS dan Majelis Perwakilan Kelas (MPK) periode 2025/2026 menjalankan program kerja di bidang kerohanian, akademik, seni budaya, olahraga, dan lingkungan hidup, sebagai wadah aspirasi dan kepemimpinan siswa.</p>
        <p>Dibimbing langsung oleh Pembina OSIS dan Waka Kesiswaan, seluruh program dirancang untuk menumbuhkan jiwa kepemimpinan dan kepedulian sosial siswa.</p>
      </div>
      <div class="osis-struct">
        <div class="osis-struct-row"><span>Ketua OSIS</span><span>Raka Pratama Putra, XI MIPA 2</span></div>
        <div class="osis-struct-row"><span>Wakil Ketua</span><span>Anindya Kirana, XI IPS 1</span></div>
        <div class="osis-struct-row"><span>Sekretaris</span><span>Bilqis Ramadhani, X-3</span></div>
        <div class="osis-struct-row"><span>Bendahara</span><span>Fajar Nugroho, XI MIPA 1</span></div>
        <div class="osis-struct-row"><span>Ketua MPK</span><span>Zahra Amelia, XII IPS 2</span></div>
        <div class="osis-struct-row"><span>Seksi Bidang</span><span>8 Bidang Kegiatan</span></div>
      </div>
    </div>
 
    <div class="section-head">
      <span class="eyebrow-label">Galeri</span>
      <h2 style="font-size:1.5rem;">Dokumentasi Kegiatan Siswa</h2>
    </div>
    <div class="gallery-grid">
      <?php if (mysqli_num_rows($galeriResult) === 0): ?>
      <p style="color:#7c8b9a;font-size:.92rem;">Belum ada foto galeri.</p>
      <?php endif; ?>
      <?php $galIndex = 0; while ($g = mysqli_fetch_assoc($galeriResult)): $galIndex++; ?>
      <div class="gal-item<?php echo $galIndex === 1 ? ' tall' : ($galIndex === 2 ? ' wide' : ''); ?>">
        <?php if (!empty($g['foto'])): ?>
        <img src="../admin/uploads/galeri/<?php echo htmlspecialchars($g['foto']); ?>" alt="<?php echo htmlspecialchars($g['judul']); ?>">
        <?php else: ?>
        <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=500&q=80" alt="<?php echo htmlspecialchars($g['judul']); ?>">
        <?php endif; ?>
      </div>
      <?php endwhile; ?>
    </div>
 
    <div class="section-head">
      <span class="eyebrow-label">Karya &amp; Prestasi Siswa</span>
      <h2 style="font-size:1.5rem;">Hasil Karya yang Membanggakan</h2>
    </div>
    <div class="karya-grid">
      <?php if (mysqli_num_rows($prestasiResult) === 0): ?>
      <p style="color:#7c8b9a;font-size:.92rem;">Belum ada data prestasi.</p>
      <?php endif; ?>
      <?php while ($pr = mysqli_fetch_assoc($prestasiResult)): ?>
      <div class="karya-card">
        <span class="karya-tag"><?php echo htmlspecialchars($pr['tingkat']); ?></span>
        <h4><?php echo htmlspecialchars($pr['nama_prestasi']); ?></h4>
        <p><?php echo htmlspecialchars($pr['nama_siswa']); ?> &mdash; <?php echo htmlspecialchars($pr['deskripsi'] !== '' ? $pr['deskripsi'] : ('Tahun ' . $pr['tahun'])); ?></p>
      </div>
      <?php endwhile; ?>
    </div>
  </div>
</section>
</section>

<!-- ============ FOOTER ============ -->
<footer>
  <div class="wrap">
    <div class="foot-grid">
      <div class="foot-about">
        <div class="foot-logo">
          <div class="logo-mark"><<img src="../assets/LOGO SMK.png" alt="Education"></div>
          <h3>SMK Negeri 1 Kandeman</h3>
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
          <li><a href="kontak.php">PPDB 2026/2027</a></li>
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