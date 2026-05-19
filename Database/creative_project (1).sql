-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 22 Apr 2026 pada 15.39
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `creative_project`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `about_me`
--

CREATE TABLE `about_me` (
  `id` int(10) UNSIGNED NOT NULL,
  `judul` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `foto` varchar(255) NOT NULL,
  `visi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `about_me`
--

INSERT INTO `about_me` (`id`, `judul`, `deskripsi`, `foto`, `visi`) VALUES
(1, 'Profil Pimpinan', 'Reonal Ervianus Diaz merupakan tenaga profesional di bidang perencanaan dan pelaksanaan konstruksi yang memiliki latar belakang pendidikan di bidang teknik dan pengalaman dalam perencanaan, pengawasan, serta pelaksanaan proyek bangunan. Dengan dasar pendidikan yang sesuai dan pengalaman di lapangan, beliau berkomitmen untuk memberikan hasil pekerjaan yang berkualitas, tepat waktu, dan sesuai dengan standar teknis yang berlaku.', 'banner_img2.png', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `banner`
--

CREATE TABLE `banner` (
  `id` int(10) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `sub_judul` varchar(150) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `banner`
--

INSERT INTO `banner` (`id`, `judul`, `sub_judul`, `deskripsi`, `foto`) VALUES
(1, 'Selamat Datang di Website Resmi', 'RD DESIGN', 'Konsultan Perencanaan, Pengawasan & Pelaksanaan Konstruksi Bangunan', 'banner_img.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `contact`
--

CREATE TABLE `contact` (
  `id` int(10) UNSIGNED NOT NULL,
  `description` text NOT NULL,
  `alamat` text NOT NULL,
  `telepon` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `whatsapp` varchar(20) NOT NULL,
  `maps_embed` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `contact`
--

INSERT INTO `contact` (`id`, `description`, `alamat`, `telepon`, `email`, `whatsapp`, `maps_embed`) VALUES
(1, 'Silahkan menghubungi kami dengan alamat dibawah ini', 'Jln. Gajah Mada - no 6 , Maumere-Flores-NTT', '081-353-680-036', 'reonaldiaz@gmail.com', '', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `education`
--

CREATE TABLE `education` (
  `id` int(10) UNSIGNED NOT NULL,
  `jenjang` varchar(20) NOT NULL,
  `tahun_lulus` year(4) NOT NULL,
  `urutan` int(11) NOT NULL,
  `jurusan` varchar(100) NOT NULL,
  `institusi` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `education`
--

INSERT INTO `education` (`id`, `jenjang`, `tahun_lulus`, `urutan`, `jurusan`, `institusi`) VALUES
(1, 'SLTPK Frater Maumere', '1997', 93, '', ''),
(3, 'STM Teknik Bangunan', '2001', 90, '', ''),
(4, 'Sarjana Teknik Arsit', '2006', 100, '', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `foto_kualitas`
--

CREATE TABLE `foto_kualitas` (
  `id` int(11) NOT NULL,
  `id_kualitas` int(11) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `urutan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `foto_portofolio`
--

CREATE TABLE `foto_portofolio` (
  `id` int(11) NOT NULL,
  `id_portofolio` int(11) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `urutan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `item_layanan`
--

CREATE TABLE `item_layanan` (
  `id` int(11) NOT NULL,
  `id_kategori_layanan` int(11) NOT NULL,
  `nama_item` varchar(150) NOT NULL,
  `deskripsi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori_portofolio`
--

CREATE TABLE `kategori_portofolio` (
  `id` int(11) NOT NULL,
  `nama_kategori` varchar(50) NOT NULL,
  `deskripsi` text NOT NULL,
  `ikon` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `misi`
--

CREATE TABLE `misi` (
  `id` int(11) NOT NULL,
  `isi_misi` text NOT NULL,
  `urutan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `msg`
--

CREATE TABLE `msg` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telepon` varchar(20) NOT NULL,
  `pesan` text NOT NULL,
  `status_baca` varchar(10) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `msg`
--

INSERT INTO `msg` (`id`, `nama`, `email`, `telepon`, `pesan`, `status_baca`) VALUES
(1, 'RD Design', 'shajeebmahmud1947@gmail.com', '', 'Dhur faltu website . eder jonno ei deser aj ei obosta falao eigula re...tumi mia bhala hoo', '2'),
(2, 'RD Design', 'mdshojeb.official@gmail.com', '', 'VAloi to laglo mia ...tomar plm ace', '2');

-- --------------------------------------------------------

--
-- Struktur dari tabel `portfolio`
--

CREATE TABLE `portfolio` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_kategori_portofolio` int(11) NOT NULL,
  `judul` varchar(150) NOT NULL,
  `lokasi` varchar(150) NOT NULL,
  `tahun` year(4) NOT NULL,
  `deskripsi` text NOT NULL,
  `foto_cover` varchar(255) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `portfolio`
--

INSERT INTO `portfolio` (`id`, `id_kategori_portofolio`, `judul`, `lokasi`, `tahun`, `deskripsi`, `foto_cover`, `status`) VALUES
(13, 0, 'RD DESIGN', '', '0000', 'Proyek pembangunan rumah tinggal yang meliputi tahap perencanaan, pembuatan gambar kerja, serta pelaksanaan konstruksi dengan pengendalian mutu dan pengawasan pekerjaan.', '6.jpg', ''),
(14, 0, 'RD DESIGN', '', '0000', 'Proyek pembangunan rumah tinggal yang meliputi tahap perencanaan, pembuatan gambar kerja, serta pelaksanaan konstruksi dengan pengendalian mutu dan pengawasan pekerjaan.', 'Metro02.jpg', ''),
(15, 0, 'RD DESIGN', '', '0000', 'Proyek pembangunan rumah tinggal yang meliputi tahap perencanaan, pembuatan gambar kerja, serta pelaksanaan konstruksi dengan pengendalian mutu dan pengawasan pekerjaan.', 'Ekterior Cafe Resto Gym Aerobik.jpg', ''),
(16, 0, 'RD DESIGN', '', '0000', 'Proyek pembangunan rumah tinggal yang meliputi tahap perencanaan, pembuatan gambar kerja, serta pelaksanaan konstruksi dengan pengendalian mutu dan pengawasan pekerjaan.', 'IFTK_100.jpg', ''),
(17, 0, 'RD DESIGN', '', '0000', 'Proyek pembangunan rumah tinggal yang meliputi tahap perencanaan, pembuatan gambar kerja, serta pelaksanaan konstruksi dengan pengendalian mutu dan pengawasan pekerjaan.', '01.tampak-depan.03.01.jpg', ''),
(18, 0, 'RD DESIGN', '', '0000', 'Proyek pembangunan rumah tinggal yang meliputi tahap perencanaan, pembuatan gambar kerja, serta pelaksanaan konstruksi dengan pengendalian mutu dan pengawasan pekerjaan.', 'SD Bhaktyarsa 3d01.jpg', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `quality`
--

CREATE TABLE `quality` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_portofolio` int(11) NOT NULL,
  `judul_kegiatan` varchar(150) NOT NULL,
  `deskripsi` text NOT NULL,
  `foto` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `quality`
--

INSERT INTO `quality` (`id`, `id_portofolio`, `judul_kegiatan`, `deskripsi`, `foto`) VALUES
(14, 0, 'RUMAH', 'Proyek pembangunan rumah tinggal yang meliputi tahap perencanaan, pembuatan gambar kerja, serta pelaksanaan konstruksi dengan pengendalian mutu dan pengawasan pekerjaan.', '6.jpg'),
(15, 0, 'KANTOR', 'Proyek pembangunan rumah tinggal yang meliputi tahap perencanaan, pembuatan gambar kerja, serta pelaksanaan konstruksi dengan pengendalian mutu dan pengawasan pekerjaan.', 'Metro03.jpg'),
(16, 0, 'RESTORAN', 'Proyek pembangunan rumah tinggal yang meliputi tahap perencanaan, pembuatan gambar kerja, serta pelaksanaan konstruksi dengan pengendalian mutu dan pengawasan pekerjaan.', 'Ekterior Cafe Resto Gym Aerobik.jpg'),
(17, 0, 'KAMPUS', 'Proyek pembangunan rumah tinggal yang meliputi tahap perencanaan, pembuatan gambar kerja, serta pelaksanaan konstruksi dengan pengendalian mutu dan pengawasan pekerjaan.', 'IFTK_100.jpg'),
(18, 0, 'HOTEL', 'Proyek pembangunan rumah tinggal yang meliputi tahap perencanaan, pembuatan gambar kerja, serta pelaksanaan konstruksi dengan pengendalian mutu dan pengawasan pekerjaan.', '01.tampak-depan.03.01.jpg'),
(19, 0, 'SEKOLAH', 'Proyek pembangunan rumah tinggal yang meliputi tahap perencanaan, pembuatan gambar kerja, serta pelaksanaan konstruksi dengan pengendalian mutu dan pengawasan pekerjaan.', 'SD Bhaktyarsa 3d01.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `review`
--

CREATE TABLE `review` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_users` int(11) NOT NULL,
  `nama_pemberi` varchar(100) NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `isi_ulasan` text NOT NULL,
  `rating` int(11) NOT NULL,
  `user_status` varchar(100) NOT NULL,
  `foto` varchar(150) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1=not approved 2=approved'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `review`
--

INSERT INTO `review` (`id`, `id_users`, `nama_pemberi`, `jabatan`, `isi_ulasan`, `rating`, `user_status`, `foto`, `status`) VALUES
(1, 0, 'ONES BHOGAR', '', 'Designnya bagus dan elegan tanpa ribet memikirkan design mana yang cocok', 5, 'Mahasiswa', 'jaan.jpg', 2),
(2, 0, 'TOMI', '', 'Designnya bagus dan elegan tanpa ribet memikirkan design mana yang cocok', 4, 'Mahasiswa', 'images (1).jpg', 2),
(3, 0, 'ALDO', '', 'Designnya bagus dan elegan tanpa ribet memikirkan design mana yang cocok', 5, 'Mahasiswa', 'jaan.jpg', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `services`
--

CREATE TABLE `services` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama_layanan` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `urutan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `services`
--

INSERT INTO `services` (`id`, `nama_layanan`, `deskripsi`, `gambar`, `urutan`) VALUES
(14, 'KONSTRUKSI', 'Tahap pelaksanaan pekerjaan di lapangan sesuai dengan dokumen perencanaan dan kontrak kerja. Pada tahap ini dilakukan pengawasan mutu, pengendalian biaya, serta penerapan keselamatan kerja.', 'fal fa-headset', 0),
(15, 'PASCA KONSTRUKSI', 'Tahap akhir pekerjaan untuk memastikan hasil proyek sesuai dengan perencanaan dan siap digunakan. Pada tahap ini dilakukan pemeriksaan akhir, dokumentasi, serta serah terima pekerjaan.', 'fal fa-edit', 0),
(17, 'PRA KONSTRUKSI', 'Tahap awal yang meliputi proses perencanaan dan persiapan sebelum pelaksanaan proyek. Perencanaan yang matang bertujuan untuk memastikan pekerjaan dapat berjalan sesuai dengan desain, anggaran, dan waktu yang telah ditentukan.', 'fal fa-lightbulb-on', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `service_section`
--

CREATE TABLE `service_section` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_layanan` int(10) UNSIGNED NOT NULL,
  `deskripsi` text NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `urutan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `service_section`
--

INSERT INTO `service_section` (`id`, `id_layanan`, `deskripsi`, `nama_kategori`, `urutan`) VALUES
(1, 0, 'Kami memberikan', 'Pengalaman & Keahlian', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `social_media`
--

CREATE TABLE `social_media` (
  `id` int(11) UNSIGNED NOT NULL,
  `label` varchar(100) NOT NULL,
  `link` varchar(200) NOT NULL,
  `ikon` varchar(100) NOT NULL,
  `urutan` int(11) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `social_media`
--

INSERT INTO `social_media` (`id`, `label`, `link`, `ikon`, `urutan`, `status`) VALUES
(1, 'fab fa-facebook-f', 'https://facebook.com', '', 0, ''),
(2, 'fab fa-twitter', 'https://twitter.com', '', 0, ''),
(3, 'fab fa-linkedin-in', 'https://linkedin.com', '', 0, ''),
(4, 'fab fa-instagram', 'https://instagram.com', '', 0, '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=user 2=admin',
  `img` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `status`, `email`, `phone`, `password`, `role`, `img`) VALUES
(3, 'Shajeeb Mahmud', 'Web Designer', 'mdshojeb.official@gmail.com', '01700964568', '$2y$10$.s.NWF7KoSWbfcDSmXmbZ.F6vFgUHPAJg1WcsIWlabjqxy9J01hjO', 2, 'casual-photo2.jpg'),
(7, 'Zhao liying', 'Content Writer', 'zhao@gmail.com', '01533653785', '$2y$10$C.s9ujAtiN9P6Sisprd2xuj8qGItysg7.90Ze.5XdhCMkVfRG2x2C', 1, 'jaan.jpg'),
(8, 'Zacki chan', 'Web Devlepor', 'zack@gmail.com', '01700964562', '$2y$10$vx4EsvpuUqpfR8nAAAl5SuKURfd1kSEJeNkst00GCzTgiFdTGXh6i', 1, 'images (1).jpg');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `about_me`
--
ALTER TABLE `about_me`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `education`
--
ALTER TABLE `education`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `foto_kualitas`
--
ALTER TABLE `foto_kualitas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `foto_portofolio`
--
ALTER TABLE `foto_portofolio`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `item_layanan`
--
ALTER TABLE `item_layanan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kategori_portofolio`
--
ALTER TABLE `kategori_portofolio`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `misi`
--
ALTER TABLE `misi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `msg`
--
ALTER TABLE `msg`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `portfolio`
--
ALTER TABLE `portfolio`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `quality`
--
ALTER TABLE `quality`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `service_section`
--
ALTER TABLE `service_section`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `social_media`
--
ALTER TABLE `social_media`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `about_me`
--
ALTER TABLE `about_me`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `banner`
--
ALTER TABLE `banner`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `education`
--
ALTER TABLE `education`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `msg`
--
ALTER TABLE `msg`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `portfolio`
--
ALTER TABLE `portfolio`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `quality`
--
ALTER TABLE `quality`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `review`
--
ALTER TABLE `review`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `services`
--
ALTER TABLE `services`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `service_section`
--
ALTER TABLE `service_section`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `social_media`
--
ALTER TABLE `social_media`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
