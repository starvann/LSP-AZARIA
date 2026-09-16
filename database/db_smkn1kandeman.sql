-- =========================================================
-- DATABASE: db_smkn1kandeman
-- Website & Admin Panel - SMK Negeri 1 Kandeman
-- =========================================================
-- Cara pakai (XAMPP/Laragon):
-- 1. Buka phpMyAdmin -> tab "Import" -> pilih file ini -> Go
--    ATAU
-- 2. mysql -u root -p < db_smkn1kandeman.sql
-- =========================================================

CREATE DATABASE IF NOT EXISTS db_smkn1kandeman
  CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

USE db_smkn1kandeman;

-- =========================================================
-- TABEL: admin
-- Untuk login admin panel (tahap berikutnya: autentikasi)
-- =========================================================
CREATE TABLE IF NOT EXISTS admin (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nama_lengkap VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Akun default: username = admin | password = admin123
-- Password sudah di-hash dengan password_hash() (bcrypt), JANGAN simpan plain text.
INSERT INTO admin (username, password, nama_lengkap) VALUES
('admin', '$2y$10$PLvV36T/SNQOFTSkdd4pvuthwNbbBCdOkv6K85JVT8EQYUNp4zZRW', 'Admin Sekolah');
-- Hash di atas = admin123 (hash bcrypt valid, sudah diverifikasi cocok dengan password_verify()).
-- Ganti password ini setelah tahap login/autentikasi dibuat.

-- =========================================================
-- TABEL: berita
-- =========================================================
CREATE TABLE IF NOT EXISTS berita (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(200) NOT NULL,
    kategori ENUM('Akademik','Kegiatan','Prestasi','Pengumuman') NOT NULL DEFAULT 'Kegiatan',
    penulis VARCHAR(100) NOT NULL,
    tanggal DATE NOT NULL,
    gambar VARCHAR(255) DEFAULT NULL,
    ringkasan TEXT,
    isi LONGTEXT,
    status ENUM('Published','Draft') NOT NULL DEFAULT 'Draft',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO berita (judul, kategori, penulis, tanggal, gambar, ringkasan, isi, status) VALUES
('Lomba Karya Ilmiah Remaja 2026', 'Kegiatan', 'Admin Humas', '2026-09-12', NULL, 'Siswa SMK Negeri 1 Kandeman mengikuti Lomba Karya Ilmiah Remaja tingkat kabupaten.', 'Isi lengkap berita akan diisi melalui editor pada tahap berikutnya.', 'Published'),
('Pentas Seni Akhir Tahun Ajaran', 'Kegiatan', 'Rina Wulandari', '2026-09-08', NULL, 'Pentas seni akhir tahun menampilkan berbagai karya kreatif siswa.', 'Isi lengkap berita akan diisi melalui editor pada tahap berikutnya.', 'Published'),
('Pelepasan Siswa Angkatan XXVII', 'Akademik', 'Admin Humas', '2026-09-01', NULL, 'Acara pelepasan siswa kelas XII angkatan ke-27.', 'Isi lengkap berita akan diisi melalui editor pada tahap berikutnya.', 'Published'),
('Kunjungan Edukasi ke Fakultas Teknik ITB', 'Kegiatan', 'Budi Santoso', '2026-08-27', NULL, 'Kunjungan edukasi siswa kelas XII ke Fakultas Teknik ITB.', 'Isi lengkap berita akan diisi melalui editor pada tahap berikutnya.', 'Draft'),
('Juara 1 LKS Tingkat Provinsi', 'Prestasi', 'Admin Humas', '2026-08-20', NULL, 'Siswa SMK Negeri 1 Kandeman meraih juara 1 LKS tingkat provinsi.', 'Isi lengkap berita akan diisi melalui editor pada tahap berikutnya.', 'Published'),
('Pengumuman Libur Semester Ganjil', 'Pengumuman', 'Rina Wulandari', '2026-08-15', NULL, 'Informasi terkait jadwal libur semester ganjil tahun ajaran 2026/2027.', 'Isi lengkap berita akan diisi melalui editor pada tahap berikutnya.', 'Draft');

-- =========================================================
-- TABEL: pengumuman
-- =========================================================
CREATE TABLE IF NOT EXISTS pengumuman (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(200) NOT NULL,
    kategori ENUM('Akademik','Umum','Kesiswaan') NOT NULL DEFAULT 'Umum',
    tanggal_terbit DATE NOT NULL,
    berlaku_sampai DATE DEFAULT NULL,
    isi LONGTEXT,
    status ENUM('Aktif','Nonaktif') NOT NULL DEFAULT 'Aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO pengumuman (judul, kategori, tanggal_terbit, berlaku_sampai, isi, status) VALUES
('Pendaftaran Peserta Didik Baru 2027', 'Akademik', '2026-09-10', '2026-11-30', 'Informasi lengkap pendaftaran peserta didik baru tahun ajaran 2027/2028.', 'Aktif'),
('Jadwal Ujian Tengah Semester Ganjil', 'Akademik', '2026-09-05', '2026-09-20', 'Jadwal pelaksanaan UTS semester ganjil tahun ajaran 2026/2027.', 'Aktif'),
('Libur Semester Ganjil 2026/2027', 'Umum', '2026-09-01', '2027-01-10', 'Informasi jadwal libur semester ganjil.', 'Aktif'),
('Pengumpulan Berkas Beasiswa KIP', 'Kesiswaan', '2026-08-25', '2026-09-15', 'Batas akhir pengumpulan berkas beasiswa KIP.', 'Aktif'),
('Rapat Wali Murid Kelas XII', 'Umum', '2026-08-18', '2026-08-25', 'Undangan rapat wali murid kelas XII.', 'Nonaktif');

-- =========================================================
-- TABEL: agenda
-- =========================================================
CREATE TABLE IF NOT EXISTS agenda (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama_kegiatan VARCHAR(200) NOT NULL,
    tanggal DATE NOT NULL,
    waktu VARCHAR(50) DEFAULT NULL,
    lokasi VARCHAR(150) DEFAULT NULL,
    penanggung_jawab VARCHAR(100) DEFAULT NULL,
    deskripsi TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO agenda (nama_kegiatan, tanggal, waktu, lokasi, penanggung_jawab, deskripsi) VALUES
('Upacara Bendera Hari Senin', '2026-09-15', '07:00 WIB', 'Lapangan Utama', 'Waka Kesiswaan', 'Upacara bendera rutin setiap hari Senin.'),
('Lomba Karya Ilmiah Remaja', '2026-09-20', '08:00 WIB', 'Aula Sekolah', 'Panitia LKIR', 'Lomba karya ilmiah remaja tingkat sekolah.'),
('Ujian Tengah Semester Ganjil', '2026-09-22', '07:30 WIB', 'Ruang Kelas', 'Waka Kurikulum', 'Pelaksanaan UTS semester ganjil.'),
('Pentas Seni Akhir Tahun', '2026-10-02', '13:00 WIB', 'Aula Sekolah', 'OSIS', 'Pentas seni menampilkan karya siswa.'),
('Kunjungan Industri Kelas XII', '2026-10-10', '07:00 WIB', 'PT Astra Otoparts', 'Waka Humas', 'Kunjungan industri untuk kelas XII.');

-- =========================================================
-- TABEL: guru
-- =========================================================
CREATE TABLE IF NOT EXISTS guru (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(150) NOT NULL,
    nip VARCHAR(50) DEFAULT NULL,
    jabatan ENUM('Kepala Sekolah','Guru','Tendik') NOT NULL DEFAULT 'Guru',
    mapel VARCHAR(100) DEFAULT NULL,
    status_kepegawaian ENUM('PNS','PPPK','Honorer') NOT NULL DEFAULT 'Honorer',
    foto VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO guru (nama, nip, jabatan, mapel, status_kepegawaian, foto) VALUES
('Drs. Ahmad Fauzi, M.Pd.', '196805121994031005', 'Kepala Sekolah', NULL, 'PNS', NULL),
('Siti Rahayu, S.Pd.', '198203152006042012', 'Guru', 'Bahasa Indonesia', 'PNS', NULL),
('Budi Santoso, S.Kom.', '199001202015031004', 'Guru', 'Rekayasa Perangkat Lunak', 'PPPK', NULL),
('Rina Wulandari, S.Pd.', '4521769670220003', 'Guru', 'Bahasa Inggris', 'Honorer', NULL),
('Agus Prasetyo, A.Md.', '198511302010011003', 'Tendik', 'Tata Usaha', 'PNS', NULL),
('Dewi Kartika, S.Pd.', '3324768669220002', 'Guru', 'Matematika', 'PPPK', NULL);

-- =========================================================
-- TABEL: prestasi
-- =========================================================
CREATE TABLE IF NOT EXISTS prestasi (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama_prestasi VARCHAR(200) NOT NULL,
    nama_siswa VARCHAR(150) NOT NULL,
    tingkat ENUM('Sekolah','Kabupaten','Provinsi','Nasional','Internasional') NOT NULL DEFAULT 'Sekolah',
    tahun YEAR NOT NULL,
    bidang VARCHAR(100) DEFAULT NULL,
    deskripsi TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO prestasi (nama_prestasi, nama_siswa, tingkat, tahun, bidang, deskripsi) VALUES
('Juara 1 Lomba Kompetensi Siswa (LKS) - Web Technology', 'Muhammad Rizky', 'Provinsi', 2026, 'Akademik', 'Prestasi dalam ajang LKS tingkat provinsi bidang Web Technology.'),
('Juara 2 Lomba Karya Ilmiah Remaja', 'Tim KIR SMKN 1 Kandeman', 'Kabupaten', 2026, 'Akademik', 'Prestasi lomba karya ilmiah remaja tingkat kabupaten.'),
('Juara 3 Futsal Antar SMK se-Jawa Tengah', 'Tim Futsal Sekolah', 'Provinsi', 2025, 'Non-Akademik', 'Prestasi olahraga futsal tingkat provinsi.'),
('Medali Emas Olimpiade Matematika', 'Aisyah Putri', 'Nasional', 2025, 'Akademik', 'Meraih medali emas olimpiade matematika tingkat nasional.'),
('Juara 1 Lomba Debat Bahasa Inggris', 'Fajar Ramadhan', 'Kabupaten', 2025, 'Akademik', 'Juara debat bahasa Inggris tingkat kabupaten.');

-- =========================================================
-- TABEL: fasilitas
-- =========================================================
CREATE TABLE IF NOT EXISTS fasilitas (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama_fasilitas VARCHAR(150) NOT NULL,
    kategori ENUM('Ruang Kelas','Laboratorium','Olahraga','Umum') NOT NULL DEFAULT 'Umum',
    kondisi ENUM('Baik','Perlu Perbaikan','Rusak') NOT NULL DEFAULT 'Baik',
    kapasitas VARCHAR(50) DEFAULT NULL,
    foto VARCHAR(255) DEFAULT NULL,
    deskripsi TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO fasilitas (nama_fasilitas, kategori, kondisi, kapasitas, foto, deskripsi) VALUES
('Laboratorium Komputer 1', 'Laboratorium', 'Baik', '36 orang', NULL, 'Laboratorium komputer untuk praktik siswa.'),
('Ruang Praktik Teknik Kendaraan Ringan', 'Laboratorium', 'Baik', '30 orang', NULL, 'Ruang praktik untuk jurusan TKR.'),
('Lapangan Futsal Indoor', 'Olahraga', 'Baik', NULL, NULL, 'Lapangan futsal indoor untuk kegiatan olahraga.'),
('Perpustakaan Sekolah', 'Umum', 'Perlu Perbaikan', '60 orang', NULL, 'Perpustakaan sekolah dengan koleksi buku.'),
('Ruang Kelas XII RPL 1', 'Ruang Kelas', 'Baik', '36 orang', NULL, 'Ruang kelas untuk jurusan RPL.'),
('Aula Serbaguna', 'Umum', 'Baik', '300 orang', NULL, 'Aula untuk kegiatan sekolah berskala besar.');

-- =========================================================
-- TABEL: galeri
-- =========================================================
CREATE TABLE IF NOT EXISTS galeri (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(200) NOT NULL,
    kategori ENUM('Kegiatan','Prestasi','Fasilitas','Umum') NOT NULL DEFAULT 'Umum',
    tanggal DATE NOT NULL,
    foto VARCHAR(255) DEFAULT NULL,
    keterangan TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO galeri (judul, kategori, tanggal, foto, keterangan) VALUES
('Lomba Karya Ilmiah Remaja 2026', 'Kegiatan', '2026-09-12', NULL, 'Dokumentasi kegiatan LKIR 2026.'),
('Pentas Seni Akhir Tahun', 'Kegiatan', '2026-09-08', NULL, 'Dokumentasi pentas seni akhir tahun.'),
('Pelepasan Siswa Angkatan XXVII', 'Kegiatan', '2026-09-01', NULL, 'Dokumentasi acara pelepasan siswa.'),
('Suasana Laboratorium Komputer', 'Fasilitas', '2026-08-20', NULL, 'Dokumentasi suasana laboratorium komputer.'),
('Tim Futsal Juara Provinsi', 'Prestasi', '2026-08-15', NULL, 'Dokumentasi tim futsal juara provinsi.'),
('Kunjungan Edukasi ke ITB', 'Kegiatan', '2026-08-27', NULL, 'Dokumentasi kunjungan edukasi ke ITB.'),
('Upacara Bendera 17 Agustus', 'Kegiatan', '2026-08-17', NULL, 'Dokumentasi upacara HUT RI.'),
('Gedung Aula Sekolah', 'Fasilitas', '2026-08-10', NULL, 'Dokumentasi gedung aula sekolah.');
