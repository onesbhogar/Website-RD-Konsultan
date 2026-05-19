<?php
// ============================================
// SETUP RELASI OTOMATIS UNTUK PHPMYADMIN DESIGNER
// File: setup_pma_relations.php
// Jalankan sekali untuk mengaktifkan Designer
// ============================================

// Konfigurasi database
$host = 'localhost';
$user = 'root';      // Ganti sesuai user Anda
$pass = '';          // Ganti sesuai password Anda
$db   = 'creative_project';

// Koneksi ke MySQL
$conn = new mysqli($host, $user, $pass);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

echo "<h2>Setup Relasi Otomatis phpMyAdmin Designer</h2>";
echo "<pre>";

// ============================================
// 1. BUAT DATABASE phpmyadmin (CONFIG STORAGE)
// ============================================

$sql = "CREATE DATABASE IF NOT EXISTS `phpmyadmin` 
        DEFAULT CHARACTER SET utf8mb4 
        COLLATE utf8mb4_general_ci";

if ($conn->query($sql) === TRUE) {
    echo "✅ Database phpmyadmin berhasil dibuat/ditemukan\n";
} else {
    echo "❌ Error: " . $conn->error . "\n";
}

// ============================================
// 2. BUAT TABEL-TABEL CONFIG STORAGE
// ============================================

$conn->select_db('phpmyadmin');

// Tabel pma__relation (untuk menyimpan relasi)
$sql = "CREATE TABLE IF NOT EXISTS `pma__relation` (
    `master_db` varchar(64) NOT NULL DEFAULT '',
    `master_table` varchar(64) NOT NULL DEFAULT '',
    `master_field` varchar(64) NOT NULL DEFAULT '',
    `foreign_db` varchar(64) NOT NULL DEFAULT '',
    `foreign_table` varchar(64) NOT NULL DEFAULT '',
    `foreign_field` varchar(64) NOT NULL DEFAULT '',
    PRIMARY KEY (`master_db`,`master_table`,`master_field`),
    KEY `foreign_field` (`foreign_db`,`foreign_table`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

$conn->query($sql);

// Tabel pma__table_info (untuk menyimpan posisi tabel di designer)
$sql = "CREATE TABLE IF NOT EXISTS `pma__table_info` (
    `db_name` varchar(64) NOT NULL DEFAULT '',
    `table_name` varchar(64) NOT NULL DEFAULT '',
    `display_field` varchar(64) NOT NULL DEFAULT '',
    PRIMARY KEY (`db_name`,`table_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

$conn->query($sql);

// Tabel pma__designer_coords (untuk menyimpan koordinat tabel)
$sql = "CREATE TABLE IF NOT EXISTS `pma__designer_coords` (
    `db_name` varchar(64) NOT NULL DEFAULT '',
    `table_name` varchar(64) NOT NULL DEFAULT '',
    `x` int(11) DEFAULT NULL,
    `y` int(11) DEFAULT NULL,
    `v` tinyint(4) DEFAULT NULL,
    `h` tinyint(4) DEFAULT NULL,
    PRIMARY KEY (`db_name`,`table_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

$conn->query($sql);

echo "✅ Tabel config storage berhasil dibuat\n";

// ============================================
// 3. HAPUS RELASI LAMA (JIKA ADA)
// ============================================

$conn->select_db($db);

// Disable foreign key checks
$conn->query("SET FOREIGN_KEY_CHECKS = 0");

// Drop existing foreign keys
$foreign_keys = [
    'portfolio_images' => 'fk_portfolio_images_portfolio',
    'service_details' => 'fk_service_details_service',
    'service_lists' => 'fk_service_lists_detail',
    'quality_menu' => 'fk_quality_menu_quality',
    'review' => 'fk_review_user',
    'msg' => 'fk_msg_user'
];

foreach ($foreign_keys as $table => $constraint) {
    $conn->query("ALTER TABLE `$table` DROP FOREIGN KEY IF EXISTS `$constraint`");
}

echo "✅ Foreign key lama dihapus\n";

// ============================================
// 4. TAMBAH KOLOM FOREIGN KEY YANG BELUM ADA
// ============================================

// Tambah quality_id ke quality_menu
$conn->query("ALTER TABLE `quality_menu` 
              ADD COLUMN IF NOT EXISTS `quality_id` INT(11) UNSIGNED NULL AFTER `id`");

// Tambah user_id ke review
$conn->query("ALTER TABLE `review` 
              ADD COLUMN IF NOT EXISTS `user_id` INT(10) UNSIGNED NULL AFTER `id`");

// Tambah user_id ke msg
$conn->query("ALTER TABLE `msg` 
              ADD COLUMN IF NOT EXISTS `user_id` INT(10) UNSIGNED NULL AFTER `id`");

echo "✅ Kolom foreign key ditambahkan\n";

// ============================================
// 5. UPDATE DATA FOREIGN KEY
// ============================================

// Update quality_id di quality_menu
$conn->query("UPDATE `quality_menu` qm
              JOIN `quality` q ON qm.`main_category` LIKE CONCAT('%', q.`title`, '%')
              SET qm.`quality_id` = q.`id`");

// Update user_id di review
$conn->query("UPDATE `review` r
              JOIN `users` u ON r.`name` = u.`name`
              SET r.`user_id` = u.`id`");

// Update user_id di msg
$conn->query("UPDATE `msg` m
              JOIN `users` u ON m.`name` = u.`name`
              SET m.`user_id` = u.`id`");

echo "✅ Data foreign key diupdate\n";

// ============================================
// 6. BUAT FOREIGN KEY CONSTRAINTS
// ============================================

$constraints = [
    // portfolio → portfolio_images
    "ALTER TABLE `portfolio_images`
     ADD CONSTRAINT `fk_portfolio_images_portfolio` 
     FOREIGN KEY (`portfolio_id`) REFERENCES `portfolio`(`id`)
     ON DELETE CASCADE ON UPDATE CASCADE",
    
    // services → service_details
    "ALTER TABLE `service_details`
     ADD CONSTRAINT `fk_service_details_service` 
     FOREIGN KEY (`service_id`) REFERENCES `services`(`id`)
     ON DELETE CASCADE ON UPDATE CASCADE",
    
    // service_details → service_lists
    "ALTER TABLE `service_lists`
     ADD CONSTRAINT `fk_service_lists_detail` 
     FOREIGN KEY (`service_detail_id`) REFERENCES `service_details`(`id`)
     ON DELETE CASCADE ON UPDATE CASCADE",
    
    // quality → quality_menu
    "ALTER TABLE `quality_menu`
     ADD CONSTRAINT `fk_quality_menu_quality` 
     FOREIGN KEY (`quality_id`) REFERENCES `quality`(`id`)
     ON DELETE SET NULL ON UPDATE CASCADE",
    
    // users → review
    "ALTER TABLE `review`
     ADD CONSTRAINT `fk_review_user` 
     FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)
     ON DELETE SET NULL ON UPDATE CASCADE",
    
    // users → msg
    "ALTER TABLE `msg`
     ADD CONSTRAINT `fk_msg_user` 
     FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)
     ON DELETE SET NULL ON UPDATE CASCADE"
];

foreach ($constraints as $sql) {
    if ($conn->query($sql) === TRUE) {
        echo "✅ Foreign key berhasil dibuat\n";
    } else {
        echo "⚠️ Warning: " . $conn->error . "\n";
    }
}

// Enable foreign key checks
$conn->query("SET FOREIGN_KEY_CHECKS = 1");

// ============================================
// 7. SIMPAN RELASI KE PMA CONFIG STORAGE
// ============================================

$conn->select_db('phpmyadmin');

// Hapus relasi lama untuk database ini
$conn->query("DELETE FROM `pma__relation` WHERE `master_db` = '$db'");

// Insert relasi ke pma__relation
$relations = [
    // portfolio_images → portfolio
    ['creative_project', 'portfolio_images', 'portfolio_id', 'creative_project', 'portfolio', 'id'],
    
    // service_details → services
    ['creative_project', 'service_details', 'service_id', 'creative_project', 'services', 'id'],
    
    // service_lists → service_details
    ['creative_project', 'service_lists', 'service_detail_id', 'creative_project', 'service_details', 'id'],
    
    // quality_menu → quality
    ['creative_project', 'quality_menu', 'quality_id', 'creative_project', 'quality', 'id'],
    
    // review → users
    ['creative_project', 'review', 'user_id', 'creative_project', 'users', 'id'],
    
    // msg → users
    ['creative_project', 'msg', 'user_id', 'creative_project', 'users', 'id'],
];

$stmt = $conn->prepare("INSERT INTO `pma__relation` 
    (`master_db`, `master_table`, `master_field`, `foreign_db`, `foreign_table`, `foreign_field`) 
    VALUES (?, ?, ?, ?, ?, ?)");

foreach ($relations as $rel) {
    $stmt->bind_param("ssssss", $rel[0], $rel[1], $rel[2], $rel[3], $rel[4], $rel[5]);
    $stmt->execute();
}

echo "✅ Relasi disimpan ke phpMyAdmin config storage\n";

// ============================================
// 8. SIMPAN POSISI TABEL DI DESIGNER
// ============================================

// Hapus posisi lama
$conn->query("DELETE FROM `pma__designer_coords` WHERE `db_name` = '$db'");

// Insert posisi tabel
$table_positions = [
    // Baris 1
    ['creative_project', 'about_me', 50, 50],
    ['creative_project', 'banner', 300, 50],
    ['creative_project', 'contact', 550, 50],
    ['creative_project', 'education', 800, 50],
    
    // Baris 2
    ['creative_project', 'portfolio', 50, 250],
    ['creative_project', 'portfolio_images', 350, 250],
    ['creative_project', 'quality', 700, 250],
    ['creative_project', 'quality_menu', 950, 250],
    
    // Baris 3
    ['creative_project', 'services', 50, 450],
    ['creative_project', 'service_details', 350, 450],
    ['creative_project', 'service_lists', 650, 450],
    ['creative_project', 'service_section', 950, 450],
    
    // Baris 4
    ['creative_project', 'detail_about', 50, 650],
    ['creative_project', 'review', 350, 650],
    ['creative_project', 'users', 600, 650],
    ['creative_project', 'msg', 850, 650],
    
    // Baris 5
    ['creative_project', 'social_media', 50, 850],
];

$stmt = $conn->prepare("INSERT INTO `pma__designer_coords` 
    (`db_name`, `table_name`, `x`, `y`, `v`, `h`) 
    VALUES (?, ?, ?, ?, 1, 1)");

foreach ($table_positions as $pos) {
    $stmt->bind_param("ssii", $pos[0], $pos[1], $pos[2], $pos[3]);
    $stmt->execute();
}

echo "✅ Posisi tabel di Designer disimpan\n";

// ============================================
// 9. SIMPAN DISPLAY FIELD
// ============================================

$conn->query("DELETE FROM `pma__table_info` WHERE `db_name` = '$db'");

$display_fields = [
    ['creative_project', 'about_me', 'title'],
    ['creative_project', 'banner', 'title2'],
    ['creative_project', 'contact', 'email'],
    ['creative_project', 'education', 'name'],
    ['creative_project', 'portfolio', 'heading'],
    ['creative_project', 'portfolio_images', 'caption'],
    ['creative_project', 'quality', 'title'],
    ['creative_project', 'quality_menu', 'title'],
    ['creative_project', 'services', 'heading'],
    ['creative_project', 'service_details', 'description'],
    ['creative_project', 'service_lists', 'list_item'],
    ['creative_project', 'service_section', 'head_title'],
    ['creative_project', 'detail_about', 'title'],
    ['creative_project', 'review', 'name'],
    ['creative_project', 'users', 'name'],
    ['creative_project', 'msg', 'name'],
    ['creative_project', 'social_media', 'label'],
];

$stmt = $conn->prepare("INSERT INTO `pma__table_info` 
    (`db_name`, `table_name`, `display_field`) 
    VALUES (?, ?, ?)");

foreach ($display_fields as $df) {
    $stmt->bind_param("sss", $df[0], $df[1], $df[2]);
    $stmt->execute();
}

echo "✅ Display field disimpan\n";

// ============================================
// 10. VERIFIKASI
// ============================================

echo "\n========================================\n";
echo "VERIFIKASI RELASI\n";
echo "========================================\n";

$conn->select_db('phpmyadmin');

$result = $conn->query("SELECT 
    `master_table`, `master_field`, 
    `foreign_table`, `foreign_field`
    FROM `pma__relation` 
    WHERE `master_db` = '$db'");

echo "\nRelasi di Designer:\n";
while ($row = $result->fetch_assoc()) {
    echo "  {$row['master_table']}.{$row['master_field']} → {$row['foreign_table']}.{$row['foreign_field']}\n";
}

$conn->select_db($db);

$result = $conn->query("SELECT 
    TABLE_NAME, COLUMN_NAME, 
    REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME
    FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
    WHERE TABLE_SCHEMA = '$db' 
    AND REFERENCED_TABLE_NAME IS NOT NULL");

echo "\nForeign Key di Database:\n";
while ($row = $result->fetch_assoc()) {
    echo "  {$row['TABLE_NAME']}.{$row['COLUMN_NAME']} → {$row['REFERENCED_TABLE_NAME']}.{$row['REFERENCED_COLUMN_NAME']}\n";
}

echo "\n========================================\n";
echo "✅ SETUP SELESAI!\n";
echo "========================================\n";
echo "\nLangkah selanjutnya:\n";
echo "1. Buka phpMyAdmin\n";
echo "2. Pilih database 'creative_project'\n";
echo "3. Klik tab 'Desainer' atau 'Designer'\n";
echo "4. Relasi akan terlihat secara otomatis!\n";

$conn->close();
?>