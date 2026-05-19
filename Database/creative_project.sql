-- ============================================
-- SQL LENGKAP UNTUK DATABASE creative_project
-- ============================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 1. Tabel about_me
--

DROP TABLE IF EXISTS `about_me`;
CREATE TABLE `about_me` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `about_me` (`id`, `title`, `description`, `image`) VALUES
(1, 'Profil Pimpinan', 'Reonal Ervianus Diaz merupakan tenaga profesional di bidang perencanaan dan pelaksanaan konstruksi yang memiliki latar belakang pendidikan di bidang teknik dan pengalaman dalam perencanaan, pengawasan, serta pelaksanaan proyek bangunan. Dengan dasar pendidikan yang sesuai dan pengalaman di lapangan, beliau berkomitmen untuk memberikan hasil pekerjaan yang berkualitas, tepat waktu, dan sesuai dengan standar teknis yang berlaku.', 'banner_img2.png');

--
-- 2. Tabel banner
--

DROP TABLE IF EXISTS `banner`;
CREATE TABLE `banner` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title1` varchar(50) NOT NULL,
  `title2` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `banner` (`id`, `title1`, `title2`, `description`, `image`) VALUES
(1, 'Selamat Datang di Website Resmi', 'RD DESIGN', 'Konsultan Perencanaan, Pengawasan & Pelaksanaan Konstruksi Bangunan', 'banner_img.png');

--
-- 3. Tabel contact
--

DROP TABLE IF EXISTS `contact`;
CREATE TABLE `contact` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `description` text NOT NULL,
  `address` varchar(200) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `contact` (`id`, `description`, `address`, `phone`, `email`) VALUES
(1, 'Silahkan menghubungi kami dengan alamat dibawah ini', 'Jln. Gajah Mada - no 6 , Maumere-Flores-NTT', '081-353-680-036', 'reonaldiaz@gmail.com');

--
-- 4. Tabel detail_about
--

DROP TABLE IF EXISTS `detail_about`;
CREATE TABLE `detail_about` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `section_type` enum('experience','vision','mission','quality') NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(100) DEFAULT 'fa-check-circle',
  `sort_order` int(11) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `detail_about` (`id`, `section_type`, `title`, `description`, `icon`, `sort_order`, `status`, `created_at`) VALUES
(1, 'experience', 'Perencanaan Arsitektur', 'Memiliki pengalaman dalam bidang perencanaan arsitektur, pengawasan proyek, serta pelaksanaan konstruksi bangunan.', 'fa-drafting-compass', 1, 1, '2026-05-05 13:00:00'),
(2, 'experience', 'Pengawasan Proyek', 'Terlibat dalam berbagai pekerjaan yang meliputi penyusunan gambar kerja dan pengendalian mutu pekerjaan.', 'fa-hard-hat', 2, 1, '2026-05-05 13:00:00'),
(3, 'experience', 'Pelaksanaan Konstruksi', 'Koordinasi pelaksanaan proyek di lapangan dengan standar mutu yang tinggi.', 'fa-building', 3, 1, '2026-05-05 13:00:00'),
(4, 'experience', 'Rencana Anggaran Biaya', 'Penyusunan rencana anggaran biaya yang efisien dan tepat waktu.', 'fa-calculator', 4, 1, '2026-05-05 13:00:00'),
(5, 'vision', 'Visi', 'Menjadi konsultan perencanaan dan kontraktor konstruksi yang profesional, terpercaya, dan berkomitmen terhadap kualitas pekerjaan.', 'fa-eye', 1, 1, '2026-05-05 13:00:00'),
(6, 'mission', 'Memberikan layanan perencanaan dan konstruksi yang berkualitas', '', 'fa-check-circle', 1, 1, '2026-05-05 13:00:00'),
(7, 'mission', 'Mengutamakan ketepatan waktu dan efisiensi biaya', '', 'fa-clock', 2, 1, '2026-05-05 13:00:00'),
(8, 'mission', 'Menerapkan standar mutu dan keselamatan kerja', '', 'fa-shield-alt', 3, 1, '2026-05-05 13:00:00'),
(9, 'mission', 'Memberikan kepuasan kepada setiap klien', '', 'fa-smile', 4, 1, '2026-05-05 13:00:00'),
(10, 'quality', 'Komitmen Kualitas', 'Dalam setiap pekerjaan, kami menerapkan sistem pengendalian mutu melalui Quality Control dan Quality Assurance untuk memastikan hasil pekerjaan sesuai dengan spesifikasi teknis, aman, dan memenuhi standar yang berlaku. Kepuasan klien merupakan prioritas utama dalam setiap proyek yang kami kerjakan.', 'fa-award', 1, 1, '2026-05-05 13:00:00');

--
-- 5. Tabel education
--

DROP TABLE IF EXISTS `education`;
CREATE TABLE `education` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `year` int(11) NOT NULL,
  `result` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `education` (`id`, `name`, `year`, `result`) VALUES
(1, 'SLTPK Frater Maumere', 1997, '93'),
(3, 'STM Teknik Bangunan', 2001, '90'),
(4, 'Sarjana Teknik Arsitektur', 2006, '100');

--
-- 6. Tabel msg
--

DROP TABLE IF EXISTS `msg`;
CREATE TABLE `msg` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `msg` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `msg` (`id`, `name`, `email`, `msg`, `status`) VALUES
(1, 'RD Design', 'shajeebmahmud1947@gmail.com', 'Dhur faltu website . eder jonno ei deser aj ei obosta falao eigula re...tumi mia bhala hoo', 2),
(2, 'RD Design', 'mdshojeb.official@gmail.com', 'VAloi to laglo mia ...tomar plm ace', 2);

--
-- 7. Tabel portfolio (SUDAH LENGKAP DENGAN KOLOM BARU)
--

DROP TABLE IF EXISTS `portfolio`;
CREATE TABLE `portfolio` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `catagory` varchar(100) NOT NULL,
  `heading` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `img` varchar(100) NOT NULL,
  `service_type` varchar(100) DEFAULT 'Perencanaan dan Konstruksi',
  `location` varchar(100) DEFAULT 'Maumere',
  `year` int(4) DEFAULT 2023,
  `project_status` varchar(50) DEFAULT 'Selesai',
  `slug` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `portfolio` (`id`, `catagory`, `heading`, `description`, `img`, `service_type`, `location`, `year`, `project_status`, `slug`) VALUES
(13, 'RUMAH', 'RD DESIGN', 'Proyek pembangunan rumah tinggal yang meliputi tahap perencanaan, pembuatan gambar kerja, serta pelaksanaan konstruksi dengan pengendalian mutu dan pengawasan pekerjaan.', '6.jpg', 'Perencanaan dan Konstruksi', 'Maumere', 2023, 'Selesai', 'rumah-tinggal-1'),
(14, 'KANTOR', 'RD DESIGN', 'Proyek pembangunan kantor modern yang meliputi desain interior, pembuatan gambar kerja, serta pelaksanaan konstruksi dengan standar kualitas tinggi.', 'Metro02.jpg', 'Perencanaan dan Konstruksi', 'Maumere', 2023, 'Selesai', 'kantor-1'),
(15, 'RESTORAN', 'RD DESIGN', 'Proyek pembangunan restoran dengan konsep eksklusif yang meliputi desain interior, tata ruang dapur, serta pelaksanaan konstruksi lengkap.', 'Ekterior Cafe Resto Gym Aerobik.jpg', 'Perencanaan dan Konstruksi', 'Maumere', 2023, 'Selesai', 'restoran-1'),
(16, 'KAMPUS', 'RD DESIGN', 'Proyek pembangunan gedung kampus yang meliputi perencanaan ruang kelas, laboratorium, perpustakaan, serta fasilitas penunjang akademik.', 'IFTK_100.jpg', 'Perencanaan dan Konstruksi', 'Maumere', 2023, 'Selesai', 'kampus-1'),
(17, 'HOTEL', 'RD DESIGN', 'Proyek pembangunan hotel berbintang yang meliputi desain kamar, lobby, restoran, kolam renang, serta fasilitas pendukung lainnya.', '01.tampak-depan.03.01.jpg', 'Perencanaan dan Konstruksi', 'Maumere', 2023, 'Selesai', 'hotel-1'),
(18, 'SEKOLAH', 'RD DESIGN', 'Proyek pembangunan gedung sekolah yang meliputi ruang kelas, laboratorium, aula, lapangan olahraga, serta fasilitas pendidikan modern.', 'SD Bhaktyarsa 3d01.jpg', 'Perencanaan dan Konstruksi', 'Maumere', 2023, 'Selesai', 'sekolah-1');

--
-- 8. Tabel portfolio_images
--

DROP TABLE IF EXISTS `portfolio_images`;
CREATE TABLE `portfolio_images` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `portfolio_id` int(11) UNSIGNED NOT NULL,
  `image` varchar(100) NOT NULL,
  `caption` varchar(200) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `portfolio_id` (`portfolio_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 9. Tabel quality
--

DROP TABLE IF EXISTS `quality`;
CREATE TABLE `quality` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 10. Tabel quality_menu
--

CREATE TABLE `quality_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `main_category` varchar(100) NOT NULL,
  `sub_category` varchar(100) DEFAULT NULL,
  `title` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `description_full` text DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data awal
INSERT INTO `quality_menu` (`id`, `main_category`, `sub_category`, `title`, `description`, `description_full`, `image`, `sort_order`, `status`) VALUES
(1, '1. Proses Persiapan Lapangan', NULL, 'Pengukuran Lahan', 'Dokumentasi pengukuran lahan proyek.', 'Proses pengukuran lahan dilakukan dengan menggunakan alat survey modern untuk memastikan keakuratan dimensi dan elevasi. Tim surveyor kami akan melakukan pemetaan topografi, penentuan batas lahan, dan pembuatan titik kontrol yang akan menjadi acuan seluruh pekerjaan konstruksi.', '01.tampak-depan.03.01.jpg', 1, 1),
(2, '1. Proses Persiapan Lapangan', NULL, 'Pembersihan Area Proyek', 'Dokumentasi pembersihan area proyek.', 'Pembersihan area proyek mencakup pemotongan pohon, pengangkatan material organik, perataan tanah, dan pembuatan akses jalan masuk. Proses ini penting untuk memastikan area kerja siap untuk tahap konstruksi berikutnya.', 'Ekterior Cafe Resto Gym Aerobik.jpg', 2, 1),
(3, '2. Dokumentasi Tahapan Konstruksi', 'Tahap Pondasi', 'Pembesian Pondasi', 'Dokumentasi pembesian pondasi.', 'Pembesian pondasi menggunakan besi tulang berkualitas tinggi dengan diameter sesuai perhitungan struktur. Proses pembesian meliputi pemotongan, pembengkokan, pengikatan, dan pemasangan tulangan sesuai gambar kerja.', '01.tampak-depan.03.01.jpg', 1, 1),
(4, '2. Dokumentasi Tahapan Konstruksi', 'Tahap Pondasi', 'Pengecoran', 'Dokumentasi pengecoran pondasi.', 'Pengecoran pondasi menggunakan beton ready mix dengan mutu sesuai spesifikasi. Proses meliputi pemasangan bekisting, pemasangan tulangan, pengecekan slump test, dan pengecoran dengan pompa beton.', '01.tampak-depan.03.01.jpg', 2, 1),
(5, '2. Dokumentasi Tahapan Konstruksi', 'Tahap Struktur', 'Plat Lantai', 'Dokumentasi plat lantai.', 'Pembuatan plat lantai meliputi pemasangan bekisting bawah, pemasangan tulangan mesh dan tulangan pokok, pengecekan ketebalan, dan pengecoran beton dengan perataan menggunakan vibrator.', '01.tampak-depan.03.01.jpg', 3, 1),
(6, '2. Dokumentasi Tahapan Konstruksi', 'Tahap Struktur', 'Bekisting', 'Dokumentasi bekisting.', 'Bekisting menggunakan multiplek berkualitas dengan ketebalan sesuai beban. Pemasangan bekisting harus kuat, rata, dan kedap air untuk menghasilkan permukaan beton yang halus.', '01.tampak-depan.03.01.jpg', 4, 1),
(7, '2. Dokumentasi Tahapan Konstruksi', 'Tahap Dinding & Atap', 'Plester Aci', 'Dokumentasi plester aci.', 'Plester aci dilakukan setelah pemasangan bata selesai. Proses meliputi pengecekan kelurusan dinding, pembasahan permukaan, pengaplikasian plester dasar, dan plester aci finishing.', '01.tampak-depan.03.01.jpg', 5, 1),
(8, '2. Dokumentasi Tahapan Konstruksi', 'Tahap Dinding & Atap', 'Kuda-Kuda', 'Dokumentasi kuda-kuda.', 'Pemasangan kuda-kuda atap menggunakan kayu atau baja ringan sesuai desain. Proses meliputi pemotongan, perakitan di tanah, pengangkatan, dan pemasangan dengan baut yang kuat.', '01.tampak-depan.03.01.jpg', 6, 1),
(9, '2. Dokumentasi Tahapan Konstruksi', 'Tahap Finishing', 'Pengecatan', 'Dokumentasi pengecatan.', 'Pengecatan dilakukan setelah plester kering. Proses meliputi pembersihan permukaan, pengaplikasian dasar cat, pengisian retakan, dan pengecatan finishing dengan 2-3 lapis.', '01.tampak-depan.03.01.jpg', 7, 1),
(10, '2. Dokumentasi Tahapan Konstruksi', 'Tahap Finishing', 'Keramik', 'Dokumentasi pemasangan keramik.', 'Pemasangan keramik menggunakan perekat khusus dengan ketebalan spesifik. Proses meliputi pemotongan keramik, pengaplikasian adukan, pemasangan dengan waterpass, dan pengisian nat.', '01.tampak-depan.03.01.jpg', 8, 1),
(11, '2. Dokumentasi Tahapan Konstruksi', 'Tahap Finishing', 'Plafon', 'Dokumentasi pemasangan plafon.', 'Pemasangan plafon menggunakan rangka hollow atau kayu. Proses meliputi pemasangan rangka sesuai level, pemasangan plafon board, finishing compound, dan pengecatan.', 'SD Bhaktyarsa 3d01.jpg', 9, 1),
(12, '3. Pengendalian Mutu (Quality Control)', NULL, 'Pengecekan Instalasi Listrik', 'Dokumentasi pengecekan instalasi listrik proyek.', 'Pengecekan instalasi listrik meliputi pengukuran tahanan isolasi, pengukuran tegangan, pengecekan pemasangan MCB, dan pengujian sistem grounding untuk memastikan keamanan.', '01.tampak-depan.03.01.jpg', 1, 1),
(13, '3. Pengendalian Mutu (Quality Control)', NULL, 'Pengujian Kebocoran Pipa', 'Dokumentasi pengujian kebocoran pipa.', 'Pengujian kebocoran pipa menggunakan tekanan air 2-3 kali tekanan kerja. Proses meliputi penutupan ujung pipa, pengisian air, penambahan tekanan, dan pemantauan selama 24 jam.', '01.tampak-depan.03.01.jpg', 2, 1),
(14, '4. Material yang Digunakan', NULL, 'Jenis Semen', 'Dokumentasi jenis semen yang digunakan.', 'Semen yang digunakan adalah semen Portland tipe I atau tipe II sesuai spesifikasi. Semen harus segar, tidak menggumpal, dan disimpan di tempat kering untuk menjaga kualitas.', '01.tampak-depan.03.01.jpg', 1, 1),
(15, '4. Material yang Digunakan', NULL, 'Besi', 'Dokumentasi besi tulang yang digunakan.', 'Besi tulang menggunakan baja beton polos dan ulir sesuai SNI. Besi harus bebas karat, memiliki sertifikat mutu, dan disimpan di tempat yang tidak terkena air hujan.', '01.tampak-depan.03.01.jpg', 2, 1),
(16, '4. Material yang Digunakan', NULL, 'Keramik', 'Dokumentasi keramik yang digunakan.', 'Keramik dipilih berdasarkan daya serap air, kekerasan, dan estetika. Setiap batch keramik dicek keseragaman warna dan dimensi sebelum pemasangan.', '01.tampak-depan.03.01.jpg', 3, 1),
(17, '5. Standar Keselamatan Kerja', NULL, 'Pekerja Menggunakan Helm dan Sepatu Safety', 'Dokumentasi pekerja menggunakan APD lengkap.', 'Seluruh pekerja wajib menggunakan APD lengkap: helm safety, sepatu safety, sarung tangan, dan rompi reflektor. Pengecekan APD dilakukan setiap hari sebelum masuk area kerja.', '01.tampak-depan.03.01.jpg', 1, 1),
(18, '5. Standar Keselamatan Kerja', NULL, 'Scaffolding Aman', 'Dokumentasi scaffolding yang aman dan standar.', 'Scaffolding menggunakan pipa galvanis dengan kaki penyangga yang kuat. Setiap tingkat dilengkapi railing dan papan lantai yang kokoh. Pengecekan kekuatan dilakukan secara berkala.', '01.tampak-depan.03.01.jpg', 2, 1),
(19, '6. Progress Berkala', NULL, 'Progress 10%', 'Dokumentasi progress proyek 10%.', 'Progress 10% menandakan tahap persiapan lapangan dan pondasi telah selesai. Meliputi pengukuran, pembersihan, galian pondasi, dan pembesian pondasi.', '01.tampak-depan.03.01.jpg', 1, 1),
(20, '6. Progress Berkala', NULL, 'Progress 70%', 'Dokumentasi progress proyek 70%.', 'Progress 70% menandakan struktur bangunan telah selesai. Meliputi pemasangan dinding, plester, pemasangan atap, dan instalasi MEP (Mechanical, Electrical, Plumbing).', '01.tampak-depan.03.01.jpg', 2, 1);


--
-- 11. Tabel review
--

DROP TABLE IF EXISTS `review`;
CREATE TABLE `review` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `review` varchar(300) NOT NULL,
  `rating` int(11) NOT NULL,
  `user_status` varchar(100) NOT NULL,
  `img` varchar(150) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1=not approved 2=approved',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `review` (`id`, `name`, `review`, `rating`, `user_status`, `img`, `status`) VALUES
(1, 'ONES BHOGAR', 'Designnya bagus dan elegan tanpa ribet memikirkan design mana yang cocok', 5, 'Mahasiswa', 'jaan.jpg', 2),
(2, 'TOMI', 'Designnya bagus dan elegan tanpa ribet memikirkan design mana yang cocok', 4, 'Mahasiswa', 'images (1).jpg', 2),
(3, 'ALDO', 'Designnya bagus dan elegan tanpa ribet memikirkan design mana yang cocok', 5, 'Mahasiswa', 'jaan.jpg', 2);

--
-- 12. Tabel service_details
--

DROP TABLE IF EXISTS `service_details`;
CREATE TABLE `service_details` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `service_id` int(10) UNSIGNED NOT NULL,
  `layout_type` enum('text_left','text_right') NOT NULL DEFAULT 'text_left',
  `main_image` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `service_id` (`service_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `service_details` (`id`, `service_id`, `layout_type`, `main_image`, `description`, `created_at`, `updated_at`) VALUES
(1, 17, 'text_left', 'uploads/services/pra-konstruksi.jpg', 'Tahap awal yang meliputi proses perencanaan dan persiapan sebelum pelaksanaan proyek. Perencanaan yang matang bertujuan untuk memastikan pekerjaan dapat berjalan sesuai dengan desain, anggaran, dan waktu yang telah ditentukan.', '2026-05-05 13:00:00', '2026-05-05 13:00:00'),
(2, 14, 'text_right', 'uploads/services/konstruksi.jpg', 'Tahap pelaksanaan pekerjaan di lapangan sesuai dengan dokumen perencanaan dan kontrak kerja. Pada tahap ini dilakukan pengawasan mutu, pengendalian biaya, serta penerapan keselamatan kerja.', '2026-05-05 13:00:00', '2026-05-05 13:00:00'),
(3, 15, 'text_left', 'uploads/services/pasca-konstruksi.jpg', 'Tahap akhir pekerjaan untuk memastikan hasil proyek sesuai dengan perencanaan dan siap digunakan. Pada tahap ini dilakukan pemeriksaan akhir, dokumentasi, serta serah terima pekerjaan.', '2026-05-05 13:00:00', '2026-05-05 13:00:00');

--
-- 13. Tabel service_lists
--

DROP TABLE IF EXISTS `service_lists`;
CREATE TABLE `service_lists` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `service_detail_id` int(10) UNSIGNED NOT NULL,
  `list_item` varchar(255) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `service_detail_id` (`service_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `service_lists` (`id`, `service_detail_id`, `list_item`, `sort_order`) VALUES
(1, 1, 'Konsep desain arsitektur dan teknik', 1),
(2, 1, 'Pembuatan gambar kerja', 2),
(3, 1, 'Penyusunan RAB', 3),
(4, 1, 'Analisis kelayakan', 4),
(5, 1, 'Penyusunan jadwal', 5),
(6, 1, 'Pengurusan perizinan', 6),
(7, 2, 'Pelaksanaan pekerjaan konstruksi', 1),
(8, 2, 'Quality Control', 2),
(9, 2, 'Quality Assurance', 3),
(10, 2, 'Keselamatan kerja', 4),
(11, 2, 'Pengelolaan tenaga kerja', 5),
(12, 2, 'Pengendalian waktu dan biaya', 6),
(13, 3, 'Gambar akhir pekerjaan', 1),
(14, 3, 'Serah terima proyek', 2),
(15, 3, 'Dokumentasi teknis', 3),
(16, 3, 'Masa pemeliharaan', 4),
(17, 3, 'Garansi pekerjaan', 5);

--
-- 14. Tabel service_section
--

DROP TABLE IF EXISTS `service_section`;
CREATE TABLE `service_section` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `short_title` varchar(50) NOT NULL,
  `head_title` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `service_section` (`id`, `short_title`, `head_title`) VALUES
(1, 'Kami memberikan', 'Pengalaman & Keahlian');

--
-- 15. Tabel services
--

DROP TABLE IF EXISTS `services`;
CREATE TABLE `services` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `heading` text NOT NULL,
  `description` varchar(400) NOT NULL,
  `img` varchar(100) NOT NULL,
  `slug` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `services` (`id`, `heading`, `description`, `img`, `slug`, `created_at`) VALUES
(14, 'PRA KONSTRUKSI', 'Tahap awal yang meliputi proses perencanaan dan persiapan sebelum pelaksanaan proyek. Perencanaan yang matang bertujuan untuk memastikan pekerjaan dapat berjalan sesuai dengan desain, anggaran, dan waktu yang telah ditentukan.', 'fal fa-lightbulb-on', 'pra-konstruksi', '2026-05-05 13:00:00'),
(15, 'KONSTRUKSI', 'Tahap pelaksanaan pekerjaan di lapangan sesuai dengan dokumen perencanaan dan kontrak kerja. Pada tahap ini dilakukan pengawasan mutu, pengendalian biaya, serta penerapan keselamatan kerja.', 'fal fa-headset', 'konstruksi', '2026-05-05 13:00:00'),
(17, 'PASCA KONSTRUKSI', 'Tahap akhir pekerjaan untuk memastikan hasil proyek sesuai dengan perencanaan dan siap digunakan. Pada tahap ini dilakukan pemeriksaan akhir, dokumentasi, serta serah terima pekerjaan.', 'fal fa-edit', 'pasca-konstruksi', '2026-05-05 13:00:00');

--
-- 16. Tabel social_media
--

DROP TABLE IF EXISTS `social_media`;
CREATE TABLE `social_media` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `label` varchar(100) NOT NULL,
  `link` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `social_media` (`id`, `label`, `link`) VALUES
(1, 'fab fa-facebook-f', 'https://facebook.com'),
(2, 'fab fa-twitter', 'https://twitter.com'),
(3, 'fab fa-linkedin-in', 'https://linkedin.com'),
(4, 'fab fa-instagram', 'https://instagram.com');

--
-- 17. Tabel users
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `status` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=user 2=admin',
  `img` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users` (`id`, `name`, `status`, `email`, `phone`, `password`, `role`, `img`) VALUES
(3, 'Shajeeb Mahmud', 'Web Designer', 'mdshojeb.official@gmail.com', '01700964568', '$2y$10$.s.NWF7KoSWbfcDSmXmbZ.F6vFgUHPAJg1WcsIWlabjqxy9J01hjO', 2, 'casual-photo2.jpg'),
(7, 'Zhao liying', 'Content Writer', 'zhao@gmail.com', '01533653785', '$2y$10$C.s9ujAtiN9P6Sisprd2xuj8qGItysg7.90Ze.5XdhCMkVfRG2x2C', 1, 'jaan.jpg'),
(8, 'Zacki chan', 'Web Devlepor', 'zack@gmail.com', '01700964562', '$2y$10$vx4EsvpuUqpfR8nAAAl5SuKURfd1kSEJeNkst00GCzTgiFdTGXh6i', 1, 'images (1).jpg');

--
-- AUTO_INCREMENT UNTUK SEMUA TABEL
--

ALTER TABLE `about_me` AUTO_INCREMENT = 2;
ALTER TABLE `banner` AUTO_INCREMENT = 2;
ALTER TABLE `contact` AUTO_INCREMENT = 4;
ALTER TABLE `detail_about` AUTO_INCREMENT = 11;
ALTER TABLE `education` AUTO_INCREMENT = 5;
ALTER TABLE `quality_menu` AUTO_INCREMENT = 21;
ALTER TABLE `msg` AUTO_INCREMENT = 4;
ALTER TABLE `portfolio` AUTO_INCREMENT = 19;
ALTER TABLE `portfolio_images` AUTO_INCREMENT = 1;
ALTER TABLE `review` AUTO_INCREMENT = 4;
ALTER TABLE `service_details` AUTO_INCREMENT = 4;
ALTER TABLE `service_lists` AUTO_INCREMENT = 18;
ALTER TABLE `service_section` AUTO_INCREMENT = 2;
ALTER TABLE `services` AUTO_INCREMENT = 18;
ALTER TABLE `social_media` AUTO_INCREMENT = 5;
ALTER TABLE `users` AUTO_INCREMENT = 9;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;