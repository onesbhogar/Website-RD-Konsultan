<?php
// File: frontend/portfolio-detail.php
// CSS FIXED - Pastikan semua asset ter-load

require '../backend/db.php';

// Get portfolio detail by slug
if (!isset($_GET['slug'])) {
    header('Location: ../index.php#portfolio');
    exit;
}

$slug = mysqli_real_escape_string($db, $_GET['slug']);
$query = "SELECT * FROM portfolio WHERE slug = '$slug'";
$result = mysqli_query($db, $query);
$portfolio = mysqli_fetch_assoc($result);

if (!$portfolio) {
    header('Location: ../index.php#portfolio');
    exit;
}

// Get gallery images
$img_query = "SELECT * FROM portfolio_images WHERE portfolio_id = {$portfolio['id']} ORDER BY sort_order ASC";
$img_result = mysqli_query($db, $img_query);
$images = mysqli_fetch_all($img_result, MYSQLI_ASSOC);

// Get contact & social data untuk header & footer
$select_site = "SELECT * FROM contact";
$query_con = mysqli_query($db, $select_site);
$contact = mysqli_fetch_assoc($query_con);

$sel_icon = "SELECT * FROM social_media";
$social = mysqli_query($db, $sel_icon);
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?= htmlspecialchars($portfolio['heading']) ?> - Portfolio Detail</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" type="image/x-icon" href="../img/logo.png">

    <!-- CSS here - pakai ../ untuk naik 1 level dari frontend/ -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/animate.min.css">
    <link rel="stylesheet" href="../css/magnific-popup.css">
    <link rel="stylesheet" href="../css/fontawesome-all.min.css">
    <link rel="stylesheet" href="../css/flaticon.css">
    <link rel="stylesheet" href="../css/slick.css">
    <link rel="stylesheet" href="../css/aos.css">
    <link rel="stylesheet" href="../css/default.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/responsive.css">
    
    <!-- Custom styles untuk portfolio detail -->
    <style>
        .portfolio-detail-area {
            padding-top: 150px;
            min-height: 100vh;
        }
        .category-badge {
            display: inline-block;
            background: #28a745;
            color: #fff;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            text-transform: uppercase;
            margin-bottom: 15px;
            letter-spacing: 1px;
        }
        .detail-content h2 {
            color: #fff;
            font-size: 32px;
            font-weight: 700;
        }
        .description-box h5,
        .info-table h5 {
            color: #28a745;
            margin-bottom: 15px;
            font-size: 18px;
            font-weight: 600;
        }
        .description-box p {
            color: #aaa;
            line-height: 1.8;
            font-size: 15px;
        }
        .info-table {
            background: rgba(255,255,255,0.05);
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }
        .info-table table {
            width: 100%;
            margin: 0;
        }
        .info-table table td {
            padding: 10px 0;
            color: #fff;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            font-size: 14px;
        }
        .info-table table td strong {
            color: #ddd;
        }
        .info-table table tr:last-child td {
            border-bottom: none;
        }
        .detail-image img {
            border-radius: 10px;
            width: 100%;
            height: auto;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            cursor: pointer;
            margin-bottom: 30px;
        }
        .gallery-item img {
            transition: transform 0.5s ease;
            width: 100%;
            height: 250px;
            object-fit: cover;
        }
        .gallery-item:hover img {
            transform: scale(1.1);
        }
        .gallery-caption {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0,0,0,0.7);
            color: #fff;
            padding: 10px;
            text-align: center;
            font-size: 14px;
        }
        .breadcrumb {
            background: transparent;
            padding: 0;
            margin-bottom: 30px;
        }
        .breadcrumb-item a {
            color: #28a745;
            text-decoration: none;
        }
        .breadcrumb-item.active {
            color: #fff;
        }
        .breadcrumb-item + .breadcrumb-item::before {
            color: #28a745;
            content: ">";
        }
        .section-title h3 {
            color: #fff;
            font-size: 28px;
            margin-bottom: 10px;
        }
        .section-title p {
            color: #aaa;
            font-size: 14px;
        }
        .mt-60 { margin-top: 60px; }
        .mt-30 { margin-top: 30px; }
        .mb-30 { margin-bottom: 30px; }
        .mt-20 { margin-top: 20px; }

        /* ===== FOOTER CTA / PROFILE SECTION ===== */
        .footer-cta-area {
            background: #1a1f2e;
            padding: 80px 0;
            position: relative;
            overflow: hidden;
        }
        .footer-cta-area::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(40,167,69,0.5), transparent);
        }
        .profile-card {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
        }
        .profile-image {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            overflow: hidden;
            border: 4px solid rgba(255,255,255,0.1);
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
            flex-shrink: 0;
        }
        .profile-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .profile-info {
            text-align: left;
        }
        .profile-info h3 {
            color: #fff;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .profile-info p.tagline {
            color: #aaa;
            font-size: 16px;
            margin-bottom: 20px;
        }
        .social-links {
            display: flex;
            gap: 12px;
        }
        .social-links a {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 16px;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        .social-links a.facebook { background: #3b5998; }
        .social-links a.twitter { background: #1da1f2; }
        .social-links a.linkedin { background: #0077b5; }
        .social-links a.instagram { background: #e4405f; }
        .social-links a:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }

        /* ===== COPYRIGHT FOOTER ===== */
        .copyright-footer {
            background: #111;
            padding: 25px 0;
            text-align: center;
            border-top: 1px solid rgba(255,255,255,0.05);
        }
        .copyright-footer p {
            color: #666;
            font-size: 14px;
            margin: 0;
        }
        .copyright-footer p span {
            color: #28a745;
            font-weight: 600;
        }
    </style>
</head>
<body class="theme-bg">

<!-- HEADER -->
<header>
    <div id="header-sticky" class="transparent-header">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="main-menu">
                        <nav class="navbar navbar-expand-lg">
                            <a href="../index.php" class="navbar-brand logo-sticky-none"><img src="../img/logo/white_logo.png" alt="Logo"></a>
                            <a href="../index.php" class="navbar-brand s-logo-none"><img src="../img/logo/green_logo.png" alt="Logo"></a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                                <span class="navbar-icon"></span>
                                <span class="navbar-icon"></span>
                                <span class="navbar-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarNav">
                                <ul class="navbar-nav ml-auto">
                                    <li class="nav-item"><a class="nav-link" href="../index.php#home">Home</a></li>
                                    <li class="nav-item"><a class="nav-link" href="../index.php#about">Tentang</a></li>
                                    <li class="nav-item"><a class="nav-link" href="../index.php#service">Layanan</a></li>
                                    <li class="nav-item active"><a class="nav-link" href="../index.php#portfolio">Portfolio</a></li>
                                    <li class="nav-item"><a class="nav-link" href="../index.php#quality">Kualitas</a></li>
                                    <li class="nav-item"><a class="nav-link" href="../index.php#contact">Kontak</a></li>
                                </ul>
                            </div>
                            <div class="header-btn">
                                <a href="#" class="off-canvas-menu menu-tigger"><i class="flaticon-menu"></i></a>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- offcanvas-start -->
    <div class="extra-info">
        <div class="close-icon menu-close">
            <button><i class="far fa-window-close"></i></button>
        </div>
        <div class="logo-side mb-30">
            <a href="../index.php"><img src="../img/logo/white_logo.png" alt="" /></a>
        </div>
        <div class="side-info mb-30">
            <div class="contact-list mb-30">
                <h4>Office Address</h4>
                <p><?= $contact['address'] ?? 'Jln. Gajah Mada - no 6 , Maumere-Flores-NTT' ?></p>
            </div>
            <div class="contact-list mb-30">
                <h4>Phone Number</h4>
                <p><?= $contact['phone'] ?? '081-353-680-036' ?></p>
            </div>
            <div class="contact-list mb-30">
                <h4>Email Address</h4>
                <p><?= $contact['email'] ?? 'reonaldiaz@gmail.com' ?></p>
            </div>
        </div>
        <div class="social-icon-right mt-20">
            <?php foreach ($social as $value): ?>
                <a href="<?= $value['link'] ?>"><i class="<?= $value['label'] ?>"></i></a>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="offcanvas-overly"></div>
    <!-- offcanvas-end -->
</header>

<!-- PORTFOLIO DETAIL CONTENT -->
<section class="portfolio-detail-area pt-120 pb-120">
    <div class="container">
        <!-- Breadcrumb -->
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="../index.php#portfolio">Portfolio</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($portfolio['heading']) ?></li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <!-- Left: Main Image -->
            <div class="col-lg-6 mb-30">
                <div class="detail-image">
                    <img src="../img/portfolio/<?= $portfolio['img'] ?>" alt="<?= htmlspecialchars($portfolio['heading']) ?>">
                </div>
            </div>

            <!-- Right: Description & Info -->
            <div class="col-lg-6 mb-30">
                <div class="detail-content">
                    <span class="category-badge"><?= $portfolio['catagory'] ?></span>
                    <h2><?= htmlspecialchars($portfolio['heading']) ?></h2>
                    
                    <div class="description-box mt-30">
                        <h5>Deskripsi:</h5>
                        <p><?= nl2br(htmlspecialchars($portfolio['description'])) ?></p>
                    </div>

                    <div class="info-table">
                        <h5>Informasi Proyek:</h5>
                        <table>
                            <tr>
                                <td width="35%"><strong>Kategori</strong></td>
                                <td>: <?= $portfolio['catagory'] ?></td>
                            </tr>
                            <tr>
                                <td><strong>Layanan</strong></td>
                                <td>: <?= $portfolio['service_type'] ?? 'Perencanaan dan Konstruksi' ?></td>
                            </tr>
                            <tr>
                                <td><strong>Lokasi</strong></td>
                                <td>: <?= $portfolio['location'] ?? 'Maumere' ?></td>
                            </tr>
                            <tr>
                                <td><strong>Tahun</strong></td>
                                <td>: <?= $portfolio['year'] ?? '2023' ?></td>
                            </tr>
                            <tr>
                                <td><strong>Status</strong></td>
                                <td>: <?= $portfolio['project_status'] ?? 'Selesai' ?></td>
                            </tr>
                        </table>
                    </div>

                    <a href="../index.php#portfolio" class="btn btn-success mt-30">← Kembali ke Portfolio</a>
                </div>
            </div>
        </div>

        <!-- Gallery Grid -->
        <?php if (count($images) > 0): ?>
        <div class="row mt-60">
            <div class="col-12">
                <div class="section-title mb-40">
                    <h3>Galeri Proyek</h3>
                    <p>Foto tampak depan, tampak samping, dan interior</p>
                </div>
            </div>
        </div>
        <div class="row gallery-grid">
            <?php foreach ($images as $img): ?>
            <div class="col-lg-4 col-md-6">
                <div class="gallery-item">
                    <a href="../img/portfolio/gallery/<?= $img['image'] ?>" class="gallery-popup">
                        <img src="../img/portfolio/gallery/<?= $img['image'] ?>" alt="<?= htmlspecialchars($img['caption'] ?? 'Gallery Image') ?>">
                        <?php if ($img['caption']): ?>
                        <div class="gallery-caption"><?= htmlspecialchars($img['caption']) ?></div>
                        <?php endif; ?>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- ===== FOOTER CTA / PROFILE SECTION ===== -->
<section class="footer-cta-area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="profile-card">
                    <!-- Foto Profil -->
                    <div class="profile-image">
                        <img src="../img/quality/3333.png" alt="RD-DESIGN">
                    </div>
                    
                    <!-- Info Profil -->
                    <div class="profile-info">
                        <h3>RD-DESIGN</h3>
                        <p class="tagline">
                            Jika ingin Desain Rumah Yang Nyaman, Modern & Tidak Ribet ? Hubungi Kami
                        </p>
                        
                        <!-- Social Links -->
                        <div class="social-links">
                            <?php 
                            // Reset pointer social media
                            mysqli_data_seek($social, 0);
                            foreach ($social as $value): 
                                $platform = strtolower($value['platform'] ?? 'facebook');
                                $icon = $value['label'] ?? 'fab fa-facebook-f';
                            ?>
                                <a href="<?= $value['link'] ?>" class="<?= $platform ?>" target="_blank" rel="noopener">
                                    <i class="<?= $icon ?>"></i>
                                </a>
                            <?php endforeach; ?>
                            
                            <?php if (mysqli_num_rows($social) == 0): ?>
                                <!-- Fallback jika tidak ada data social_media -->
                                <a href="#" class="facebook"><i class="fab fa-facebook-f"></i></a>
                                <a href="#" class="twitter"><i class="fab fa-twitter"></i></a>
                                <a href="#" class="linkedin"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#" class="instagram"><i class="fab fa-instagram"></i></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== COPYRIGHT FOOTER ===== -->
<footer class="copyright-footer">
    <div class="container">
        <p>Copyright© <span><?= htmlspecialchars($contact['company_name'] ?? 'ONES BHOGAR') ?></span> | Semua Hak Dilindungi Undang-Undang</p>
    </div>
</footer>

<!-- JS here -->
<script src="../js/vendor/jquery-1.12.4.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/isotope.pkgd.min.js"></script>
<script src="../js/slick.min.js"></script>
<script src="../js/jquery.meanmenu.min.js"></script>
<script src="../js/ajax-form.js"></script>
<script src="../js/wow.min.js"></script>
<script src="../js/aos.js"></script>
<script src="../js/paroller.js"></script>
<script src="../js/jquery.waypoints.min.js"></script>
<script src="../js/jquery.counterup.min.js"></script>
<script src="../js/jquery.nice-select.min.js"></script>
<script src="../js/jquery.scrollUp.min.js"></script>
<script src="../js/imagesloaded.pkgd.min.js"></script>
<script src="../js/jquery.magnific-popup.min.js"></script>
<script src="../js/plugins.js"></script>
<script src="../js/main.js"></script>

<script>
$(document).ready(function() {
    // Gallery popup
    $('.gallery-popup').magnificPopup({
        type: 'image',
        gallery: {
            enabled: true,
            navigateByImgClick: true,
            preload: [0,1]
        },
        image: {
            titleSrc: function(item) {
                return item.el.find('.gallery-caption').text() || '';
            }
        }
    });
});
</script>

</body>
</html>