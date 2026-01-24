-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 24, 2026 at 05:22 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zlibrary`
--

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `kategori` varchar(100) DEFAULT NULL,
  `gambar` varchar(255) NOT NULL,
  `tipe_layout` enum('square','large','wide') DEFAULT 'square',
  `tanggal_upload` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `judul`, `kategori`, `gambar`, `tipe_layout`, `tanggal_upload`, `is_active`) VALUES
(1, 'Peresmian Pojok Baca XX', 'info', 'gal_c7307d0282a05550.webp', 'square', '2026-01-19 15:11:01', 1);

-- --------------------------------------------------------

--
-- Table structure for table `navbar`
--

CREATE TABLE `navbar` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `nama_menu` varchar(100) NOT NULL,
  `url` varchar(255) DEFAULT '#',
  `urutan` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `navbar`
--

INSERT INTO `navbar` (`id`, `parent_id`, `nama_menu`, `url`, `urutan`) VALUES
(1, NULL, 'BERANDA', '#', 0),
(29, NULL, 'PROFIL', '#', 1),
(30, 31, 'SEJARAH', 'page.php?slug=sejarah', 0),
(31, NULL, 'ARSIP', '#', 3),
(32, 31, 'BERITA', 'archive.php?kategori=berita', 1),
(33, 31, 'ARTIKEL', 'archive.php?kategori=informasi', 2),
(34, 31, 'PENGUMUMAN', 'archive.php?kategori=pengumuman', 3);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `isi` text NOT NULL,
  `slug` varchar(100) NOT NULL,
  `is_standalone` tinyint(1) NOT NULL DEFAULT 1,
  `tanggal_dibuat` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `judul`, `isi`, `slug`, `is_standalone`, `tanggal_dibuat`) VALUES
(1, 'SEJARAH', '<h2>Menapaki Jejak Literasi: Sejarah Panjang Perpustakaan</h2><p>Perpustakaan bukan sekadar deretan rak berisi kertas, melainkan \"mesin waktu\" yang menyimpan memori kolektif peradaban manusia. Perjalanannya dimulai jauh sebelum kertas ditemukan, saat manusia pertama kali merasa perlu mengabadikan pemikiran mereka.</p><h3>1. Era Tanah Liat dan Papirus</h3><p>Ribuan tahun lalu, di wilayah Mesopotamia (sekarang Irak), perpustakaan pertama di dunia lahir dalam bentuk <strong>tablet tanah liat</strong>. Perpustakaan <strong>Ashurbanipal</strong> (sekitar 668–631 SM) adalah salah satu yang termasyhur, menyimpan ribuan teks mengenai hukum, sejarah, dan sains dalam tulisan paku (<i>cuneiform</i>).</p><p>Di tempat lain, Mesir Kuno mengembangkan <strong>Perpustakaan Besar Alexandria</strong>. Di sinilah pusat ilmu pengetahuan dunia berkumpul dalam bentuk gulungan papirus. Konon, setiap kapal yang berlabuh di Alexandria wajib menyerahkan buku mereka untuk disalin sebelum dikembalikan.</p><h3>2. Abad Pertengahan dan Peran Biara</h3><p>Setelah runtuhnya Kekaisaran Romawi, perpustakaan banyak dikelola oleh biara-biara di Eropa. Para biarawan menyalin buku secara manual dengan tangan (<i>manuscript</i>). Di dunia Islam, <strong>Baitul Hikmah</strong> (House of Wisdom) di Baghdad menjadi mercusuar ilmu pengetahuan, di mana karya-karya Yunani diterjemahkan ke dalam bahasa Arab, menyelamatkan banyak ilmu pengetahuan kuno dari kepunahan.</p><h3>3. Revolusi Mesin Cetak</h3><p>Titik balik terbesar terjadi pada abad ke-15 ketika <strong>Johannes Gutenberg</strong> menemukan mesin cetak.</p><p><strong>Aksesibilitas:</strong> Buku tidak lagi menjadi barang mewah yang hanya dimiliki kaum bangsawan.</p><p><strong>Literasi:</strong> Produksi massal buku memicu lonjakan tingkat literasi di seluruh dunia.</p><p><strong>Perpustakaan Umum:</strong> Konsep perpustakaan yang dibuka untuk masyarakat luas (bukan hanya sarjana atau elit) mulai menjamur.</p><h3>4. Perpustakaan di Era Digital</h3><p>Hari ini, dinding-dinding perpustakaan telah meluas hingga ke ruang digital. Perpustakaan modern tidak hanya meminjamkan buku fisik, tetapi juga menyediakan akses ke <i>e-book</i>, jurnal ilmiah daring, dan ruang kolaborasi kreatif (co-working space).</p><blockquote><p>\"Perpustakaan adalah tempat di mana masa lalu bertemu masa depan untuk menciptakan perubahan hari ini.\"</p></blockquote><h3>Ingin menggunakan tulisan ini?</h3><p>Anda bisa membaginya menjadi beberapa bagian untuk konten media sosial:</p><p><strong>Slide 1:</strong> Sejarah kuno (Tablet tanah liat).</p><p><strong>Slide 2:</strong> Kejayaan perpustakaan Islam dan Eropa.</p><p><strong>Slide 3:</strong> Dampak mesin cetak.</p><p><strong>Slide 4:</strong> Wajah perpustakaan masa kini.</p><p>Apakah Anda ingin saya membuatkan versi yang lebih ringkas untuk <strong>caption Instagram</strong> atau mungkin ingin fokus pada <strong>sejarah perpustakaan di Indonesia</strong>?</p>', 'sejarah', 0, '2026-01-24');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `isi` longtext NOT NULL,
  `kategori` enum('berita','informasi','artikel') NOT NULL,
  `status` enum('publish','draft') NOT NULL,
  `tags` text DEFAULT NULL,
  `author` varchar(100) DEFAULT NULL,
  `gambar` longtext DEFAULT NULL,
  `tanggal_dibuat` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `judul`, `slug`, `isi`, `kategori`, `status`, `tags`, `author`, `gambar`, `tanggal_dibuat`) VALUES
(1, 'Serunya Petualangan Imajinasi di Acara &quot;Sabtu Mendongeng&quot; Perpustakaan Kota', 'serunya-petualangan-imajinasi-di-acara-quotsabtu-mendongengquot-perpustakaan-kota', '<p>Suasana ruang baca anak di Perpustakaan Kota tampak lebih ramai dari biasanya pada Sabtu (17/01) pagi. Puluhan anak didampingi orang tua berkumpul untuk mengikuti kegiatan \"Sabtu Mendongeng\", sebuah program rutin untuk meningkatkan minat baca sejak dini.</p><p>Kali ini, Kak Aris selaku pendongeng membawakan kisah tentang pentingnya menjaga kebersihan lingkungan melalui media boneka tangan. Tidak hanya mendengarkan, anak-anak juga diajak berinteraksi dan menebak kelanjutan cerita, yang memicu gelak tawa di seluruh ruangan.</p><p>Kepala Perpustakaan menyampaikan bahwa kegiatan ini bertujuan untuk mengubah citra perpustakaan yang kaku menjadi tempat yang menyenangkan bagi anak-anak. Selain mendongeng, acara ditutup dengan sesi pemilihan buku bersama, di mana petugas perpustakaan membantu anak-anak menemukan bacaan yang sesuai dengan usia mereka.</p>', 'berita', 'publish', NULL, NULL, '', '2026-01-19 15:29:03'),
(2, 'Tingkatkan Layanan, Perpustakaan Daerah Luncurkan Aplikasi Pinjam Buku Digital', 'tingkatkan-layanan-perpustakaan-daerah-luncurkan-aplikasi-pinjam-buku-digital', '<p>Memasuki era digital, Perpustakaan Daerah resmi meluncurkan aplikasi \"Pustaka Klik\" guna mempermudah akses masyarakat terhadap koleksi buku tanpa harus datang ke lokasi. Peluncuran ini dilakukan langsung oleh Dinas Kearsipan dan Perpustakaan pada Senin pagi.</p><p>Aplikasi ini menyediakan lebih dari 5.000 judul e-book yang dapat dipinjam secara gratis oleh anggota perpustakaan yang telah terdaftar. Selain meminjam buku, pengguna juga dapat mengecek ketersediaan buku fisik di rak pusat melalui fitur katalog daring (OPAC).</p><p>\"Kami ingin literasi tetap berjalan di tengah kesibukan masyarakat. Dengan aplikasi ini, warga bisa membaca buku berkualitas kapan saja melalui smartphone mereka,\" ujar perwakilan pengelola. Masyarakat yang ingin mendaftar cukup mengunduh aplikasi dan melakukan verifikasi menggunakan NIK.</p>', 'berita', 'publish', NULL, NULL, '', '2026-01-19 15:29:31'),
(3, 'Perpustakaan Desa Gelar Workshop Menulis Kreatif Bagi Remaja', 'perpustakaan-desa-gelar-workshop-menulis-kreatif-bagi-remaja', '<p>Perpustakaan Desa \"Pelita Ilmu\" sukses menyelenggarakan workshop menulis kreatif bertajuk \"Tuangkan Ide Menjadi Karya\" pada Minggu (18/01). Acara ini diikuti oleh 20 remaja desa yang memiliki minat dalam dunia kepenulisan.</p><p>Dalam workshop ini, para peserta diajarkan teknik dasar membangun alur cerita dan cara mengatasi hambatan saat menulis (writer’s block). Narasumber yang merupakan penulis lokal menekankan bahwa perpustakaan adalah sumber inspirasi terbaik bagi seorang penulis.</p><p>Hasil dari workshop ini nantinya akan dikumpulkan dan diterbitkan dalam bentuk buku antologi cerpen yang akan dipajang di rak khusus karya lokal perpustakaan. Program ini diharapkan dapat mencetak penulis-penulis muda berbakat dari desa tersebut.</p>', 'berita', 'publish', NULL, NULL, '', '2026-01-19 15:30:06'),
(4, 'Raih Akreditasi A, Perpustakaan SMA Negeri 1 Jadi Rujukan Literasi Nasional', 'raih-akreditasi-a-perpustakaan-sma-negeri-1-jadi-rujukan-literasi-nasional', '<p>Perpustakaan \"Widya Pustaka\" SMA Negeri 1 berhasil meraih predikat Akreditasi A dari Perpustakaan Nasional RI (Perpusnas) pekan ini. Pencapaian ini merupakan buah dari transformasi besar-besaran yang dilakukan pihak sekolah selama dua tahun terakhir.</p><p>Perpustakaan ini dinilai unggul karena memiliki koleksi buku yang lengkap, manajemen berbasis digital, serta inovasi \"Pojok Baca Outdoor\" yang memanfaatkan area taman sekolah. Selain itu, keterlibatan aktif siswa dalam komunitas \"Duta Pustaka\" menjadi nilai tambah dalam penilaian tersebut.</p><p>Kepala Sekolah menyatakan bahwa predikat ini bukan akhir dari perjalanan, melainkan motivasi untuk terus berinovasi. \"Kami ingin perpustakaan bukan sekadar gudang buku, tapi pusat kreativitas dan riset bagi siswa kami,\" tuturnya.</p>', 'berita', 'publish', NULL, NULL, '', '2026-01-19 15:30:55'),
(5, 'Gerakan &quot;Satu Orang Satu Buku&quot;: Perpustakaan Komunitas Terima Ribuan Donasi', 'gerakan-quotsatu-orang-satu-bukuquot-perpustakaan-komunitas-terima-ribuan-donasi', '<p>Gerakan donasi buku bertajuk \"Satu Orang Satu Buku\" yang diinisiasi oleh Perpustakaan Komunitas Jendela Literasi berhasil mengumpulkan lebih dari 1.200 buku layak baca selama bulan Desember.</p><p>Buku-buku yang terkumpul terdiri dari berbagai jenis, mulai dari buku pelajaran, novel, hingga ensiklopedia anak. Relawan perpustakaan saat ini tengah melakukan proses kurasi dan penyampulan ulang sebelum buku-buku tersebut didistribusikan ke pojok-pojok baca di pelosok desa.</p><p>Koordinator gerakan menyampaikan rasa terima kasihnya kepada masyarakat yang antusias. Donasi ini sangat berarti untuk memperbarui koleksi bacaan yang sudah usang dan memberikan akses informasi yang lebih segar bagi anak-anak di daerah yang sulit terjangkau toko buku.</p>', 'berita', 'publish', NULL, NULL, '', '2026-01-19 15:31:20'),
(6, 'Perkuat Literasi Desa, Puluhan Pengelola Perpustakaan Lakukan Studi Banding', 'perkuat-literasi-desa-puluhan-pengelola-perpustakaan-lakukan-studi-banding', '<p>Sebanyak 30 pengelola perpustakaan desa dari Kabupaten Serang melakukan kunjungan studi banding ke Perpustakaan Pusat Kota pada Rabu (21/01). Kunjungan ini bertujuan untuk mempelajari sistem manajemen perpustakaan modern dan cara menarik minat pengunjung milenial.</p><p>Dalam kunjungan tersebut, para peserta diberikan pelatihan singkat mengenai sistem katalog digital dan cara menyelenggarakan acara komunitas yang rendah biaya namun berdampak besar. Para pengelola desa juga berkesempatan melihat langsung proses restorasi buku-buku tua yang dilakukan oleh tim ahli.</p><p>Diharapkan setelah kunjungan ini, setiap desa mampu menerapkan minimal satu inovasi baru di wilayah masing-masing, sehingga perpustakaan desa bisa menjadi jantung aktivitas masyarakat.</p>', 'berita', 'publish', NULL, NULL, '', '2026-01-19 15:31:51'),
(7, '5 Alasan Mengapa Membaca Buku Fisik Tetap Tak Tergantikan di Era Digital', '5-alasan-mengapa-membaca-buku-fisik-tetap-tak-tergantikan-di-era-digital', '<p>Di tengah gempuran layar <i>smartphone</i> dan tablet, buku fisik seringkali dianggap mulai tertinggal. Namun, tahukah Anda bahwa perpustakaan masih menjadi tempat favorit bagi banyak orang untuk memeluk aroma kertas dan membalik halaman demi halaman?</p><p>Ada beberapa alasan mengapa buku fisik tetap unggul:</p><p><strong>Kesehatan Mata:</strong> Membaca di kertas tidak memancarkan <i>blue light</i>, sehingga mata tidak cepat lelah dibandingkan menatap layar.</p><p><strong>Retensi Informasi yang Lebih Baik:</strong> Penelitian menunjukkan bahwa membaca di kertas membantu otak memahami alur cerita secara lebih mendalam dan kronologis.</p><p><strong>Pengalaman Sensorik:</strong> Aroma buku baru (atau buku lama yang khas) memberikan sensasi relaksasi yang tidak bisa diberikan oleh perangkat digital.</p><p><strong>Minim Distraski:</strong> Saat membaca buku, tidak ada notifikasi pesan singkat atau media sosial yang mengganggu fokus Anda.</p><p>Jadi, kapan terakhir kali Anda berkunjung ke perpustakaan dan meminjam buku? Mari kembali temukan keajaiban di antara barisan rak buku kami.</p>', 'artikel', 'publish', NULL, NULL, '', '2026-01-19 15:35:30'),
(8, 'Perpustakaan: Bukan Sekadar Gudang Buku, Tapi Jantung Komunitas', 'perpustakaan-bukan-sekadar-gudang-buku-tapi-jantung-komunitas', '<p>Selama bertahun-tahun, banyak orang membayangkan perpustakaan sebagai tempat yang gelap, berdebu, dan penuh dengan larangan untuk berbicara. Namun, persepsi itu harus segera kita hapus. Perpustakaan modern kini telah bertransformasi menjadi ruang ketiga bagi masyarakat—setelah rumah dan tempat kerja.</p><p>Kini, perpustakaan adalah pusat kreativitas. Di sini, kita bisa menemukan ruang diskusi yang hangat, koneksi internet untuk bekerja, hingga berbagai lokakarya keterampilan. Perpustakaan adalah tempat di mana seorang anak bisa bermimpi menjadi astronot melalui ensiklopedia, dan seorang lansia bisa tetap aktif dengan membaca surat kabar harian.</p><p>Menghidupkan perpustakaan berarti menghidupkan kecerdasan bangsa. Dengan mendatangi perpustakaan, kita tidak hanya meminjam buku, tetapi juga mendukung keberadaan ruang publik yang demokratis dan gratis untuk siapa saja.</p>', 'artikel', 'publish', NULL, NULL, '', '2026-01-19 15:35:55'),
(9, '&quot;Healing&quot; Hemat dan Berkualitas di Sudut Perpustakaan', 'quothealingquot-hemat-dan-berkualitas-di-sudut-perpustakaan', '', 'artikel', 'publish', NULL, NULL, '', '2026-01-19 15:36:09'),
(10, 'Teknik &quot;Deep Work&quot;: Bagaimana Perpustakaan Membantu Anda Menjadi Lebih Produktif', 'teknik-quotdeep-workquot-bagaimana-perpustakaan-membantu-anda-menjadi-lebih-produktif', '<p>Di dunia yang penuh dengan gangguan notifikasi ponsel, kemampuan untuk fokus secara mendalam atau <i>deep work</i> menjadi keterampilan yang sangat langka dan mahal. Banyak dari kita bekerja selama berjam-jam namun hanya sedikit yang benar-benar terselesaikan karena perhatian yang terpecah.</p><p>Perpustakaan menawarkan solusi alami untuk masalah ini. Lingkungan yang dirancang khusus untuk ketenangan menciptakan suasana \"sakral\" yang memicu otak untuk masuk ke mode fokus. Saat Anda duduk di perpustakaan, ada kontrak sosial yang tidak tertulis untuk saling menghargai ketenangan.</p><p>Cobalah metode ini: Simpan ponsel Anda di dalam tas, pilih satu meja di pojok perpustakaan, dan tentukan satu tugas besar untuk diselesaikan dalam 90 menit. Anda akan terkejut betapa jauh lebih produktifnya Anda dibandingkan saat bekerja di kafe yang bising atau di rumah yang penuh gangguan.</p>', 'informasi', 'publish', '', 'Tuan Admin', '', '2026-01-19 15:37:04'),
(11, 'Menumbuhkan &quot;Kutu Buku&quot; Kecil: Mengapa Rutinitas ke Perpustakaan Penting bagi Anak', 'menumbuhkan-quotkutu-bukuquot-kecil-mengapa-rutinitas-ke-perpustakaan-penting-bagi-anak', '<p>Minat baca tidak tumbuh secara ajaib saat anak dewasa; ia dipupuk sejak dini. Salah satu cara paling efektif dan murah untuk melakukannya adalah dengan menjadikan perpustakaan sebagai destinasi akhir pekan keluarga.</p><p>Mengapa perpustakaan?</p><p><strong>Kebebasan Memilih:</strong> Di perpustakaan, anak diberikan hak untuk memilih buku apa pun yang menarik perhatian mereka. Ini memberikan rasa percaya diri dan kemandirian dalam belajar.</p><p><strong>Membangun Tanggung Jawab:</strong> Meminjam buku mengajarkan anak tentang aturan, tenggat waktu, dan cara merawat barang yang bukan milik pribadi.</p><p><strong>Literasi Visual:</strong> Bagi anak yang belum bisa membaca, melihat ribuan buku di rak membantu mereka memahami bahwa informasi dan cerita adalah sesuatu yang berharga dan menyenangkan.</p><p>Jadikan kunjungan ke perpustakaan sebagai sebuah petualangan, bukan beban sekolah. Dengan begitu, buku akan menjadi sahabat mereka seumur hidup.</p>', 'berita', 'publish', NULL, NULL, '', '2026-01-19 15:37:29'),
(12, 'Masa Depan Literasi: Harmoni Antara Koleksi Fisik dan Akses Digital', 'masa-depan-literasi-harmoni-antara-koleksi-fisik-dan-akses-digital', '<p>Banyak yang memprediksi bahwa munculnya internet akan membunuh perpustakaan. Namun, yang terjadi justru sebaliknya: perpustakaan sedang mengalami evolusi besar. Perpustakaan masa kini bukan lagi sekadar tempat menyimpan kertas, melainkan sebuah hub teknologi.</p><p>Integrasi antara <i>E-book</i>, jurnal digital, dan koleksi fisik menciptakan ekosistem belajar yang tanpa batas. Seorang mahasiswa bisa mencari referensi buku langka di rak, sementara di meja yang sama, ia mengakses basis data penelitian internasional melalui portal digital perpustakaan.</p><p>Transformasi ini membuktikan bahwa inti dari perpustakaan bukanlah \"format\" bukunya, melainkan \"akses\" terhadap pengetahuan. Dengan teknologi, perpustakaan kini bisa hadir di kantong kita melalui aplikasi, namun tetap menyediakan ruang fisik bagi mereka yang membutuhkan kedalaman dan interaksi sosial.</p>', 'informasi', 'draft', 'education', 'Tuan Admin', 'thumbnail_8585da0966ae075a.webp', '2026-01-19 15:37:54'),
(13, 'hbbbb', 'hbbbb', '<p><img class=\"image_resized image-style-align-left\" style=\"width:360px;\">kljsss<img class=\"image-style-align-left\"></p>', 'berita', 'publish', 'library', 'Tuan Admin', 'post_9f342604a96ccd83.webp', '2026-01-19 16:33:05');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `setting_group` varchar(50) NOT NULL DEFAULT 'system',
  `setting_name` varchar(100) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `setting_type` enum('text','textarea','email','number','select','url','file') DEFAULT 'text',
  `is_private` tinyint(1) DEFAULT 0,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `setting_group`, `setting_name`, `setting_value`, `setting_type`, `is_private`, `updated_at`) VALUES
(1, 'system', 'default_language', 'id_ID', 'select', 0, '2026-01-24 15:15:13'),
(2, 'system', 'active_theme', 'default', 'select', 0, '2026-01-19 13:26:16'),
(3, 'system', 'maintenance_mode', '0', 'select', 0, '2026-01-19 13:26:16'),
(4, 'system', 'session_timeout', '3600', 'number', 0, '2026-01-19 13:26:16'),
(5, 'identity', 'site_title', 'Perpustakaan', 'text', 0, '2026-01-19 13:26:16'),
(6, 'identity', 'site_subtitle', 'Universitas Pantang Mundur', 'text', 0, '2026-01-19 13:56:26'),
(7, 'identity', 'site_tagline_main', 'Unlimited Access to', 'text', 0, '2026-01-24 16:08:32'),
(8, 'identity', 'site_tagline_submain', 'Global Knowledge', 'text', 0, '2026-01-24 16:08:32'),
(9, 'identity', 'site_description', 'Seamlessly integrating digital resources for modern learners.', 'textarea', 0, '2026-01-24 16:08:32'),
(10, 'library', 'site_npp', '1234567890', 'text', 0, '2026-01-19 14:54:04'),
(11, 'library', 'library_head', 'Nama Kepala Perpustakaan, S.IP.', 'text', 0, '2026-01-19 13:57:17'),
(12, 'library', 'opening_hours', 'Senin - Jumat: 08:00 - 16:00', 'textarea', 0, '2026-01-19 13:57:17'),
(13, 'contact', 'contact_email', 'perpustakaan@localhost', 'email', 0, '2026-01-19 13:56:26'),
(14, 'contact', 'site_phone', '+628123456789', 'text', 0, '2026-01-19 13:56:26'),
(15, 'contact', 'site_address', 'Jl. Raya Indonesia', 'textarea', 0, '2026-01-19 13:56:26'),
(16, 'identity', 'site_logo', 'site_logo.webp', 'file', 0, '2026-01-19 13:26:16'),
(17, 'identity', 'site_icon', 'site_icon.ico', 'file', 0, '2026-01-19 13:26:16'),
(18, 'identity', 'site_hero', 'site_hero.webp', 'file', 0, '2026-01-19 13:26:16'),
(784, 'security', 'csp_allowed_scripts', '', 'textarea', 0, '2026-01-24 15:35:07'),
(785, 'security', 'csp_allowed_styles', '', 'textarea', 0, '2026-01-24 15:35:07'),
(786, 'security', 'csp_allowed_images', '', 'textarea', 0, '2026-01-24 15:34:47'),
(787, 'security', 'csp_allowed_fonts', '', 'textarea', 0, '2026-01-24 15:34:47'),
(873, 'system', 'homepage_layout', '[{\"type\":\"widget\",\"id\":\"11\",\"title\":\"Icon Box\",\"widget_type\":\"home_link\",\"is_instance\":\"false\",\"show_title\":\"1\"},{\"type\":\"block\",\"id\":\"r1769268018762\",\"layout\":\"2-1-col\",\"columns\":{\"c1\":[{\"type\":\"block\",\"id\":\"r1769268024841\",\"layout\":\"2-col\",\"columns\":{\"c1\":[{\"type\":\"widget\",\"id\":\"12\",\"title\":\"Berita Utama\",\"widget_type\":\"home_news\",\"is_instance\":\"false\",\"show_title\":\"1\"}],\"c2\":[{\"type\":\"widget\",\"id\":\"7\",\"title\":\"Daftar Artikel\",\"widget_type\":\"home_articles\",\"is_instance\":\"false\",\"show_title\":\"1\"}]}},{\"type\":\"widget\",\"id\":\"13\",\"title\":\"Daftar Tombol Sejajar\",\"widget_type\":\"home_services\",\"is_instance\":\"false\",\"show_title\":\"1\"}],\"c2\":[{\"type\":\"widget\",\"id\":\"6\",\"title\":\"Pengumuman\",\"widget_type\":\"home_announcements\",\"is_instance\":\"false\",\"show_title\":\"1\"},{\"type\":\"widget\",\"id\":\"10\",\"title\":\"Jam Layanan\",\"widget_type\":\"home_hours\",\"is_instance\":\"false\",\"show_title\":\"1\"},{\"type\":\"widget\",\"id\":\"14\",\"title\":\"Statistik Perpustakaan\",\"widget_type\":\"home_stat\",\"is_instance\":\"false\",\"show_title\":\"1\"}]}},{\"type\":\"block\",\"id\":\"r1769268119685\",\"layout\":\"full\",\"columns\":{\"c1\":[{\"type\":\"widget\",\"id\":\"9\",\"title\":\"Gallery Kegiatan\",\"widget_type\":\"home_gallery\",\"is_instance\":\"false\",\"show_title\":\"1\"}]}}]', 'textarea', 0, '2026-01-24 16:02:38'),
(879, 'system', 'footer_layout', '[{\"type\":\"block\",\"id\":\"r1769270599149\",\"layout\":\"3-col\",\"columns\":{\"c1\":[{\"type\":\"widget\",\"id\":\"20\",\"title\":\"Site Description\",\"widget_type\":\"site_description\",\"is_instance\":\"false\",\"show_title\":\"1\"},{\"type\":\"widget\",\"id\":\"16\",\"title\":\"Nomor Pokok Perpustakaan\",\"widget_type\":\"npp\",\"is_instance\":\"false\",\"show_title\":\"1\"}],\"c2\":[{\"type\":\"widget\",\"id\":\"17\",\"title\":\"Quick Links\",\"widget_type\":\"quick_link\",\"is_instance\":\"false\",\"show_title\":\"1\"}],\"c3\":[{\"type\":\"widget\",\"id\":\"2\",\"title\":\"Contact Us\",\"widget_type\":\"contact_us\",\"is_instance\":\"false\",\"show_title\":\"1\"},{\"type\":\"widget\",\"id\":\"4\",\"title\":\"Footer Social Media\",\"widget_type\":\"footer_social\",\"is_instance\":\"false\",\"show_title\":\"1\"}]}}]', 'textarea', 0, '2026-01-24 16:03:43');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `role` enum('admin','operator') NOT NULL DEFAULT 'operator',
  `remember_token` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `nama_lengkap`, `role`, `remember_token`, `foto`, `last_login`) VALUES
(1, 'admin', '$2y$12$BUJypcUBcpm/pd3t/QLOheILDdndv9TntzsAhgfk9JmHxMgqvrFTm', 'Tuan Admin', 'admin', NULL, 'user_2b926df11584937a.webp', '2026-01-24 22:15:28');

-- --------------------------------------------------------

--
-- Table structure for table `widgets`
--

CREATE TABLE `widgets` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `widget_type` varchar(50) NOT NULL,
  `category` varchar(100) DEFAULT 'General',
  `description` text DEFAULT NULL,
  `content` text DEFAULT NULL,
  `layout_position` enum('library','left','center','right') DEFAULT 'library',
  `order_position` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 0,
  `show_title` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `widgets`
--

INSERT INTO `widgets` (`id`, `title`, `widget_type`, `category`, `description`, `content`, `layout_position`, `order_position`, `is_active`, `show_title`) VALUES
(1, 'Dynamic API List', 'api_list', 'Integration', 'Menampilkan data dari API publik/eksternal secara dinamis.', '{\r\n\"api_url\": { \"label\": \"Endpoint URL\", \"type\": \"text\", \"default\": \"https://jsonplaceholder.typicode.com/posts\" },\r\n\"limit\": { \"label\": \"Jumlah Data\", \"type\": \"number\", \"default\": \"5\" },\r\n\"accent_color\": { \"label\": \"Warna Tema\", \"type\": \"color\", \"default\": \"#4f46e5\" }\r\n}', 'library', 0, 1, 0),
(2, 'Contact Us', 'contact_us', 'Footer', 'Menampilkan info kontak dan daftar media sosial.', '{\r\n\"accent_color\": { \"label\": \"Warna Aksen\", \"type\": \"color\", \"default\": \"#facc15\" },\r\n\"address\": { \"label\": \"Alamat\", \"type\": \"textarea\", \"default\": \"Jl. Raya Nasional 3\" },\r\n\"email\": { \"label\": \"Email\", \"type\": \"text\", \"default\": \"library@localhost\" },\r\n\"social_1_name\": { \"label\": \"Nama Sosmed 1\", \"type\": \"text\", \"default\": \"Instagram\" },\r\n\"social_1_url\": { \"label\": \"URL Sosmed 1\", \"type\": \"text\", \"default\": \"#\" },\r\n\"social_2_name\": { \"label\": \"Nama Sosmed 2\", \"type\": \"text\", \"default\": \"YouTube\" },\r\n\"social_2_url\": { \"label\": \"URL Sosmed 2\", \"type\": \"text\", \"default\": \"#\" }\r\n}', 'library', 0, 1, 0),
(3, 'Currency Rates (IDR Base)', 'currency_rates', 'Sidebar Widget', 'Menampilkan kurs mata uang.', '', 'library', 0, 1, 0),
(4, 'Footer Social Media', 'footer_social', 'Footer', 'Daftar ikon media sosial untuk bagian footer.', '{\r\n    \"facebook_url\": { \"label\": \"Facebook URL\", \"type\": \"text\", \"default\": \"#\" },\r\n    \"instagram_url\": { \"label\": \"Instagram URL\", \"type\": \"text\", \"default\": \"#\" },\r\n    \"youtube_url\": { \"label\": \"YouTube URL\", \"type\": \"text\", \"default\": \"#\" },\r\n    \"twitter_url\": { \"label\": \"Twitter URL\", \"type\": \"text\", \"default\": \"#\" }\r\n }', 'library', 0, 1, 0),
(5, 'Google Trending Topics', 'google_trends', 'Sidebar Widget', 'Menampilkan tren pencarian harian dari Google Trends RSS.', '', 'library', 0, 1, 0),
(6, 'Pengumuman', 'home_announcements', 'General', '', '', 'library', 0, 1, 0),
(7, 'Artikel', 'home_articles', 'Blog', 'Menampilkan daftar artikel terbaru.', '', 'library', 0, 1, 0),
(8, 'Custom Content', 'home_custom', 'General', 'Digunakan untuk membuat widget secara mandiri dengan menyisipkan kode HTML/JS.', '', 'library', 0, 1, 0),
(9, 'Gallery Kegiatan', 'home_gallery', 'General', '', '', 'library', 0, 1, 0),
(10, 'Jam Layanan', 'home_hours', 'General', '', '', 'library', 0, 1, 0),
(11, 'Icon Box', 'home_link', 'Navigasi', 'Barisan tautan dengan akses cepat katalog, e-book, dll.', '{\r\n    \"item1_desc\": { \"label\": \"Desc 1\", \"type\": \"text\", \"default\": \"Buku di Perpustakaan\" },\r\n    \"item1_url\": { \"label\": \"URL 1\", \"type\": \"text\", \"default\": \"#\" },\r\n\r\n    \"item2_desc\": { \"label\": \"Desc 2\", \"type\": \"text\", \"default\": \"E-book Collection\" },\r\n    \"item2_url\": { \"label\": \"URL 2\", \"type\": \"text\", \"default\": \"#\" },\r\n\r\n    \"item3_desc\": { \"label\": \"Desc 3\", \"type\": \"text\", \"default\": \"Research\" },\r\n    \"item3_url\": { \"label\": \"URL 3\", \"type\": \"text\", \"default\": \"#\" },\r\n\r\n    \"item4_desc\": { \"label\": \"Desc 4\", \"type\": \"text\", \"default\": \"Journal fulltext access\" },\r\n    \"item4_url\": { \"label\": \"URL 4\", \"type\": \"text\", \"default\": \"#\" }\r\n }', 'library', 0, 1, 0),
(12, 'Berita Utama', 'home_news', 'Blog', 'Menampilkan daftar berita terbaru dengan desain artikel yang bersih.', '{\r\n\"limit\": { \"label\": \"Jumlah Berita\", \"type\": \"number\", \"default\": \"3\" },\r\n\"accent_color\": { \"label\": \"Warna Aksen\", \"type\": \"color\", \"default\": \"#2563eb\" },\r\n\"category\": { \"label\": \"Filter Kategori (ID)\", \"type\": \"text\", \"default\": \"\" }\r\n}', 'library', 0, 1, 0),
(13, 'Daftar Tombol Sejajar', 'home_services', 'Navigasi', 'Digunakan untuk menampilkan tombol tautan dengan posisi sejajar mendatar.', '{\r\n    \"item_1_desc\": { \"label\": \"Layanan 1\", \"type\": \"text\", \"default\": \"Turnitin\" },\r\n    \"item_1_url\": { \"label\": \"URL 1\", \"type\": \"text\", \"default\": \"#\" },\r\n    \"item_2_desc\": { \"label\": \"Layanan 2\", \"type\": \"text\", \"default\": \"Member Free\" },\r\n    \"item_2_url\": { \"label\": \"URL 2\", \"type\": \"text\", \"default\": \"#\" },\r\n    \"item_3_desc\": { \"label\": \"Layanan 3\", \"type\": \"text\", \"default\": \"Lecturer Report\" },\r\n    \"item_3_url\": { \"label\": \"URL 3\", \"type\": \"text\", \"default\": \"#\" },\r\n    \"item_4_desc\": { \"label\": \"Layanan 4\", \"type\": \"text\", \"default\": \"Book Request\" },\r\n    \"item_4_url\": { \"label\": \"URL 4\", \"type\": \"text\", \"default\": \"#\" },\r\n    \"item_5_desc\": { \"label\": \"Layanan 5\", \"type\": \"text\", \"default\": \"Renew A Book\" },\r\n    \"item_5_url\": { \"label\": \"URL 5\", \"type\": \"text\", \"default\": \"#\" }\r\n}', 'library', 0, 1, 0),
(14, 'Statistik Perpustakaan', 'home_stat', 'General', '', '', 'library', 0, 1, 0),
(15, 'Library Spotlight', 'library_spotlight', 'General', '', '', 'library', 0, 1, 0),
(16, 'Nomor Pokok Perpustakaan', 'npp', 'Footer', 'Menampilkan Nomor Pokok Perpustakaan secara Statis.', '', 'library', 0, 1, 0),
(17, 'Quick Links', 'quick_link', 'Footer', 'Daftar tautan cepat dengan ikon titik dekoratif yang bisa diubah.', '{\r\n    \"link_1_label\": { \"label\": \"Label Link 1\", \"type\": \"text\", \"default\": \"E-Journal\" },\r\n    \"link_1_url\": { \"label\": \"URL Link 1\", \"type\": \"text\", \"default\": \"#\" },\r\n    \"link_2_label\": { \"label\": \"Label Link 2\", \"type\": \"text\", \"default\": \"Clearance Procedure\" },\r\n    \"link_2_url\": { \"label\": \"URL Link 2\", \"type\": \"text\", \"default\": \"#\" },\r\n    \"link_3_label\": { \"label\": \"Label Link 3\", \"type\": \"text\", \"default\": \"Thesis Submission Guide\" },\r\n    \"link_3_url\": { \"label\": \"URL Link 3\", \"type\": \"text\", \"default\": \"#\" }\r\n }', 'library', 0, 1, 0),
(18, 'Realtime Clock (Compact)', 'realtime_clock', 'Footer', 'Tampilan Jam Realtime yang lebih ringkas dengan margin.', '', 'library', 0, 1, 0),
(19, 'Recent Posts', 'recents_post', 'General', '', '', 'library', 0, 1, 0),
(20, 'Site Description', 'site_description', 'Footer', 'Menampilkan Deskripsi Website secara Statis.', '', 'library', 0, 1, 0),
(21, 'Promo Slider Perpustakaan', 'slider', 'General', 'Promo Slider Perpustakaan', '{\r\n    \"image_url\": { \"label\": \"URL Gambar\", \"type\": \"text\", \"default\": \"https://images.unsplash.com/photo-1507842217343-583bb7270b66?q=80&w=1000\" },\r\n    \"headline\": { \"label\": \"Judul\", \"type\": \"text\", \"default\": \"Koleksi Buku Digital Terbaru\" },\r\n    \"button_text\": { \"label\": \"Teks Tombol\", \"type\": \"text\", \"default\": \"Baca Sekarang\" },\r\n    \"target_link\": { \"label\": \"Link Tujuan\", \"type\": \"text\", \"default\": \"#\" },\r\n    \"bg_color\": { \"label\": \"Warna Tema\", \"type\": \"color\", \"default\": \"#4f46e5\" }\r\n}', 'library', 0, 1, 0),
(22, 'Advanced Stat Counter', 'stat_counter', 'Sidebar', 'Tracking Harian, Bulanan, dan Geolocation Negara.', '', 'library', 0, 1, 0),
(23, 'Weather Forecast', 'weather', 'Integration', 'Deteksi cuaca otomatis berdasarkan lokasi pengunjung (IP Geolocation).', '{\r\n\"fallback_city\": { \"label\": \"Kota Cadangan\", \"type\": \"text\", \"default\": \"Jakarta\" },\r\n\"accent_color\": { \"label\": \"Warna Aksen\", \"type\": \"color\", \"default\": \"#0ea5e9\" }\r\n}', 'library', 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `widget_instances`
--

CREATE TABLE `widget_instances` (
  `id` int(11) NOT NULL,
  `widget_type` varchar(100) DEFAULT NULL,
  `widget_id` int(11) DEFAULT NULL,
  `instance_title` varchar(255) DEFAULT NULL,
  `instance_content` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `show_title` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `navbar`
--
ALTER TABLE `navbar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_slug` (`slug`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_name` (`setting_name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `widgets`
--
ALTER TABLE `widgets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `widget_instances`
--
ALTER TABLE `widget_instances`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `navbar`
--
ALTER TABLE `navbar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=924;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `widgets`
--
ALTER TABLE `widgets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `widget_instances`
--
ALTER TABLE `widget_instances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `navbar`
--
ALTER TABLE `navbar`
  ADD CONSTRAINT `navbar_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `navbar` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
