<?php
require_once '../config/koneksi.php';
require_once 'includes/helpers.php';

$guruAktifRes = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM guru WHERE jabatan IN ('Guru','Kepala Sekolah')");
$guruAktif = $guruAktifRes ? (int) mysqli_fetch_assoc($guruAktifRes)['total'] : 0;

$tendikRes = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM guru WHERE jabatan = 'Tendik'");
$tendikTotal = $tendikRes ? (int) mysqli_fetch_assoc($tendikRes)['total'] : 0;

$fasilitasResult = mysqli_query($koneksi, "SELECT * FROM fasilitas ORDER BY nama_fasilitas ASC");
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

<!-- ============ PROFILE ============ -->
    <section id="profil" class="band">
  <div class="wrap">
    <div class="section-head">
      <span class="eyebrow-label">Profil Sekolah</span>
      <h2>Mengenal Lebih Dekat SMK Negeri 1 Kandeman</h2>
      <p>Sejarah, arah, dan struktur yang membentuk identitas sekolah dari 2003.</p>
    </div>

    <div class="accordion">
      <details open>
        <summary>Sejarah Singkat Sekolah<span class="plus">+</span></summary>
        <div class="acc-body">
          <p>Secara umur SMK Negeri 1 Kandeman merupakan sekolah yang telah berumur menengah bukan sekolah lama dan tidak terlalu baru. SMK Negeri 1 Kandeman berdiri pada Tahun 2003 dan pada tahun 2024 ini berarti telah berumur 21 tahun. Pada awalnya SMK Negeri 1 Kandeman dibuka dengan 3 (tiga) program keahlian yaitu Teknik Mekanik Otomotif (sekarang TKR), Teknik Mesin (sekarang Teknik Pemesinan), dan Teknik Audio Video. Kini SMK Negeri 1 Kandeman telah memiliki 7 (tujuh) paket keahlian yaitu, Teknik Kendaraan Ringan Otomotif (TKR)), Teknik Pemesinan (TP), Teknik Audio Video (TAV), Teknik Bisnis Sepeda Motor (TBSM), Teknik Elektronika Industri (TEI), Teknik Instalasi Tenaga Listrik (TITL), dan Rekayasa Perangkat Lunak (RPL). </p>
        </div>
      </details>
      <details>
        <summary>Visi dan Misi<span class="plus">+</span></summary>
        <div class="acc-body">
          <p><strong style="color:var(--navy)">Visi:</strong> Terwujudnya tamatan yang berahlak mulia, komperen, kompetitif dan berwawasan lingkungan.</p>
          <p><strong style="color:var(--navy)">Misi:</strong></p>
          <ul>
            <li>Meningkatkan kualitas peserta didik yang agamis dan berbudaya dalam setiap aktifitas.</li>
            <li>Melaksanakan proses pembelajaran secara optimal yang kondusif berdasarkan kurikulum yang berlaku.</li>
            <li>Meningkatkan hubungan kerjasama antara sekolah dengan dunia usaha (DU) dan dunia industri (DI) secara berkeseimbangan tahun.</li>
          </ul>
        </div>
      </details>
      <details>
        <summary>Struktur Organisasi<span class="plus">+</span></summary>
        <!-- <div class="acc-body">
          <div class="org-chart">
            <div class="org-row"><div class="org-box">Kepala Sekolah</div></div>
            <div class="org-row">
              <div class="org-box alt">Waka Kurikulum</div>
              <div class="org-box alt">Waka Kesiswaan</div>
              <div class="org-box alt">Waka Sarpras</div>
              <div class="org-box alt">Waka Humas</div>
            </div>
            <div class="org-row sub">
              <div class="org-box">Koordinator BK</div>
              <div class="org-box">Kepala Tata Usaha</div>
              <div class="org-box">Wali Kelas</div>
              <div class="org-box">Guru Mata Pelajaran</div>
            </div>
          </div>
        </div> -->
      </details>
      <details>
        <summary>Data Guru dan Tenaga Kependidikan<span class="plus">+</span></summary>
        <div class="acc-body">
          <p>Kualitas pendidikan kami ditopang oleh tenaga pengajar dan kependidikan yang kompeten di bidangnya.</p>
          <div class="stat-row">
            <div class="stat-box"><strong><?php echo $guruAktif; ?></strong><span>Guru Aktif</span></div>
            <div class="stat-box"><strong><?php echo $tendikTotal; ?></strong><span>Tenaga Kependidikan</span></div>
            <div class="stat-box"><strong>-</strong><span>Rasio Guru : Siswa</span></div>
            <div class="stat-box"><strong>-</strong><span>Guru Berpendidikan S2</span></div>
          </div>
        </div>
      </details>
      <details>
        <summary>Fasilitas Sekolah<span class="plus">+</span></summary>
        <div class="acc-body">
          <div class="fac-grid">
            <?php if (mysqli_num_rows($fasilitasResult) === 0): ?>
            <p style="color:#7c8b9a;font-size:.92rem;">Belum ada data fasilitas.</p>
            <?php endif; ?>
            <?php while ($fac = mysqli_fetch_assoc($fasilitasResult)): ?>
            <div class="fac-item"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke-width="1.8"><path d="M3 21h18M5 21V9l7-5 7 5v12M9 21v-6h6v6"/></svg><span><?php echo htmlspecialchars($fac['nama_fasilitas']); ?></span></div>
            <?php endwhile; ?>
          </div>
        </div>
      </details>
    </div>
  </div>
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