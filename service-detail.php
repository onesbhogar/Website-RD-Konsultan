<?php
// ============================================
// PASTIKAN PATH INI SESUAI DENGAN LOKASI db.php
// ============================================
require 'backend/db.php';  // Path ke database

// Ambil slug dari URL
$slug = isset($_GET['slug']) ? mysqli_real_escape_string($db, $_GET['slug']) : '';

if (empty($slug)) {
    header('Location: index.php');
    exit;
}

// Ambil data layanan berdasarkan slug
$service_query = "SELECT * FROM services WHERE slug = '$slug'";
$service_result = mysqli_query($db, $service_query);
$service = mysqli_fetch_assoc($service_result);

if (!$service) {
    header('Location: index.php');
    exit;
}

// Ambil detail layanan
$detail_query = "SELECT * FROM service_details WHERE service_id = {$service['id']}";
$detail_result = mysqli_query($db, $detail_query);
$detail = mysqli_fetch_assoc($detail_result);

// Ambil list layanan (bullet points)
$lists = [];
if ($detail) {
    $list_query = "SELECT * FROM service_lists WHERE service_detail_id = {$detail['id']} ORDER BY sort_order ASC";
    $list_result = mysqli_query($db, $list_query);
    while ($row = mysqli_fetch_assoc($list_result)) {
        $lists[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($service['heading']); ?> - RD Design</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            background: #1a1f2e;
            color: #fff;
            font-family: 'Segoe UI', sans-serif;
        }
        .service-detail-section {
            padding: 100px 0;
            min-height: 100vh;
        }
        .detail-container {
            background: rgba(255,255,255,0.05);
            border-radius: 15px;
            padding: 50px;
            margin-bottom: 40px;
            border: 1px solid rgba(255,255,255,0.1);
        }
        .detail-image {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
        .detail-image-placeholder {
            width: 100%;
            height: 400px;
            background: #2c3e50;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #7f8c8d;
            font-size: 1.1rem;
        }
        .detail-heading {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            color: #fff;
            text-transform: uppercase;
        }
        .detail-description {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #b0b8c9;
            margin-bottom: 25px;
        }
        .service-list {
            list-style: none;
            padding: 0;
        }
        .service-list li {
            padding: 10px 0;
            padding-left: 30px;
            position: relative;
            color: #d0d8e8;
            font-size: 1rem;
        }
        .service-list li:before {
            content: "▸";
            position: absolute;
            left: 0;
            color: #28a745;
            font-weight: bold;
            font-size: 1.2rem;
        }
        .layanan-title {
            color: #28a745;
            font-weight: 600;
            margin-bottom: 15px;
            font-size: 1.2rem;
        }
        .back-btn {
            display: inline-block;
            margin-top: 30px;
            padding: 12px 30px;
            background: #28a745;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s;
        }
        .back-btn:hover {
            background: #218838;
            color: #fff;
            text-decoration: none;
        }
        /* Layout variations */
        .text-left-layout .text-content { order: 1; }
        .text-left-layout .image-content { order: 2; }
        .text-right-layout .text-content { order: 2; }
        .text-right-layout .image-content { order: 1; }
        
        .breadcrumb {
            background: transparent;
            padding: 0;
        }
        .breadcrumb-item a {
            color: #28a745;
        }
        .breadcrumb-item.active {
            color: #fff;
        }
        /* Navbar styling */
        .navbar-custom {
            background: #fff;
            padding: 15px 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .navbar-custom .navbar-brand img {
            height: 50px;
        }
        .navbar-custom .nav-link {
            color: #333;
            font-weight: 500;
            margin: 0 15px;
        }
        .navbar-custom .nav-link:hover {
            color: #28a745;
        }
        /* Footer styling */
        .footer-custom {
            background: #1a1a2e;
            color: #fff;
            padding: 40px 0 20px;
            margin-top: 50px;
        }
        .footer-custom a {
            color: #28a745;
        }
    </style>
</head>
<body>

<!-- ==================== HEADER MANUAL (TANPA INCLUDE) ==================== -->
<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="img/logo/logo.png" alt="RD Design">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php#about">Tentang</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php#service">Layanan</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php#portfolio">Portfolio</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php#quality">Kualitas</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php#contact">Kontak</a></li>
            </ul>
        </div>
    </div>
</nav>

<section class="service-detail-section">
    <div class="container">
        <!-- Breadcrumb -->
        <div class="row mb-4">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="index.php#service">Layanan</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($service['heading']); ?></li>
                    </ol>
                </nav>
            </div>
        </div>

        <?php if ($detail): ?>
        <div class="row align-items-center detail-container <?php echo $detail['layout_type'] == 'text_left' ? 'text-left-layout' : 'text-right-layout'; ?>">
            <!-- Text Content -->
            <div class="col-lg-6 text-content">
                <h1 class="detail-heading"><?php echo htmlspecialchars($service['heading']); ?></h1>
                <p class="detail-description">
                    <?php echo nl2br(htmlspecialchars($detail['description'])); ?>
                </p>
                
                <?php if (!empty($lists)): ?>
                <div class="layanan-section">
                    <h4 class="layanan-title">Layanan meliputi:</h4>
                    <ul class="service-list">
                        <?php foreach ($lists as $list): ?>
                        <li><?php echo htmlspecialchars($list['list_item']); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>
                
                <a href="index.php#service" class="back-btn">← Kembali ke Layanan</a>
            </div>
            
            <!-- Image Content -->
            <div class="col-lg-6 image-content">
                <?php if ($detail['main_image'] && file_exists($detail['main_image'])): ?>
                <img src="<?php echo htmlspecialchars($detail['main_image']); ?>" 
                     alt="<?php echo htmlspecialchars($service['heading']); ?>" 
                     class="detail-image">
                <?php else: ?>
                <div class="detail-image-placeholder">
                    <span><i class="fas fa-image"></i> Gambar tidak tersedia</span>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php else: ?>
        <!-- Fallback jika belum ada detail -->
        <div class="row">
            <div class="col-12 text-center py-5">
                <h2>Detail layanan sedang dalam pengembangan</h2>
                <p class="mt-3 text-muted"><?php echo htmlspecialchars($service['description']); ?></p>
                <a href="index.php#service" class="back-btn mt-3">← Kembali</a>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- ==================== FOOTER MANUAL (TANPA INCLUDE) ==================== -->
<footer class="footer-custom">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h5>RD Design</h5>
                <p>Konsultan Perencanaan, Pengawasan & Pelaksanaan Konstruksi Bangunan</p>
            </div>
            <div class="col-md-6 text-right">
                <p>&copy; 2026 RD Design. All rights reserved.</p>
            </div>
        </div>
    </div>
</footer>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>