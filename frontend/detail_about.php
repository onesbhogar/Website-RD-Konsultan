<?php 
    require '../backend/db.php';
    
    // Fetch Experience
    $exp_result = mysqli_query($db, "SELECT * FROM detail_about WHERE section_type='experience' AND status=1 ORDER BY sort_order ASC");
    $experiences = [];
    while ($row = mysqli_fetch_assoc($exp_result)) $experiences[] = $row;
    
    // Fetch Vision
    $vision_result = mysqli_query($db, "SELECT * FROM detail_about WHERE section_type='vision' AND status=1 LIMIT 1");
    $vision = mysqli_fetch_assoc($vision_result);
    
    // Fetch Mission
    $mission_result = mysqli_query($db, "SELECT * FROM detail_about WHERE section_type='mission' AND status=1 ORDER BY sort_order ASC");
    $missions = [];
    while ($row = mysqli_fetch_assoc($mission_result)) $missions[] = $row;
    
    // Fetch Quality
    $quality_result = mysqli_query($db, "SELECT * FROM detail_about WHERE section_type='quality' AND status=1 LIMIT 1");
    $quality = mysqli_fetch_assoc($quality_result);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Tentang Kami - RD Design</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/detail-about.css">
</head>
<body>

    <!-- Navigation -->
    <header class="header-area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-3">
                    <div class="logo">
                        <a href="../index.php"><img src="../img/logo/logo.png" alt="RD Design"></a>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="main-menu">
                        <nav>
                            <ul>
                                <li><a href="../index.php">Home</a></li>
                                <li><a href="../index.php#about">Tentang</a></li>
                                <li><a href="../index.php#services">Layanan</a></li>
                                <li><a href="../index.php#portfolio">Portfolio</a></li>
                                <li><a href="../index.php#quality">Kualitas</a></li>
                                <li><a href="../index.php#contact">Kontak</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Banner Header -->
    <section class="detail-banner">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1>Tentang Kami</h1>
                    <div class="breadcrumb">
                        <a href="../index.php">Home</a>
                        <span>/</span>
                        <span>Detail Tentang</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Experience Section -->
    <section class="experience-area" id="pengalaman">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <span class="sub-title">Profesional & Berpengalaman</span>
                    <h2 class="main-title">Pengalaman dan Keahlian</h2>
                </div>
            </div>
            <div class="row">
                <?php foreach ($experiences as $exp): ?>
                <div class="col-lg-3 col-md-6">
                    <div class="experience-item">
                        <div class="icon">
                            <i class="fas <?php echo $exp['icon']; ?>"></i>
                        </div>
                        <h3><?php echo $exp['title']; ?></h3>
                        <p><?php echo nl2br($exp['description']); ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Vision & Mission Section -->
    <section class="vision-mission-area" id="visi-misi">
        <div class="container">
            <div class="row">
                <!-- Vision -->
                <div class="col-lg-6">
                    <div class="vision-box">
                        <div class="box-header">
                            <i class="fas fa-eye"></i>
                            <h3><?php echo $vision['title']; ?></h3>
                        </div>
                        <p><?php echo nl2br($vision['description']); ?></p>
                    </div>
                </div>
                <!-- Mission -->
                <div class="col-lg-6">
                    <div class="mission-box">
                        <div class="box-header">
                            <i class="fas fa-bullseye"></i>
                            <h3>Misi</h3>
                        </div>
                        <ul class="mission-list">
                            <?php foreach ($missions as $mission): ?>
                            <li>
                                <i class="fas <?php echo $mission['icon']; ?>"></i>
                                <span><?php echo $mission['title']; ?></span>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Quality Section -->
    <section class="quality-commitment-area" id="komitmen">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="quality-image">
                        <i class="fas fa-award"></i>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="quality-content">
                        <span class="sub-title">Jaminan Kualitas</span>
                        <h2 class="main-title"><?php echo $quality['title']; ?></h2>
                        <p><?php echo nl2br($quality['description']); ?></p>
                        <div class="quality-features">
                            <div class="feature">
                                <i class="fas fa-check-double"></i>
                                <span>Quality Control (QC)</span>
                            </div>
                            <div class="feature">
                                <i class="fas fa-check-double"></i>
                                <span>Quality Assurance (QA)</span>
                            </div>
                            <div class="feature">
                                <i class="fas fa-check-double"></i>
                                <span>Kepuasan Klien Prioritas</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-area">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h2>Tertarik Bekerja Sama?</h2>
                    <p>Hubungi kami untuk diskusi lebih lanjut mengenai proyek Anda</p>
                    <div class="cta-buttons">
                        <a href="../index.php#contact" class="btn btn-primary">Hubungi Kami</a>
                        <a href="../index.php" class="btn btn-outline">Kembali ke Beranda</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer-area">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <p>Copyright© <span>RD Design</span> | All Rights Reserved</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="../js/vendor/jquery-1.12.4.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>