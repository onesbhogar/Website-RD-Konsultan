<?php 
    require '../backend/db.php';
    
    // Fungsi untuk safe query - return null jika error
    function safe_query($db, $sql) {
        try {
            $result = mysqli_query($db, $sql);
            if ($result && mysqli_num_rows($result) > 0) {
                return mysqli_fetch_assoc($result);
            }
        } catch (Exception $e) {
            // Tabel tidak ada atau error lain
        }
        return null;
    }
    
    // Ambil data dengan safe query
    $experience = safe_query($db, "SELECT * FROM experience_skill ORDER BY id DESC LIMIT 1");
    $vision = safe_query($db, "SELECT * FROM vision_mission ORDER BY id DESC LIMIT 1");
    $quality = safe_query($db, "SELECT * FROM quality_commitment ORDER BY id DESC LIMIT 1");

    // Data default jika tabel kosong atau tidak ada
    if (!$experience) {
        $experience = [
            'title' => 'Pengalaman Profesional Kami',
            'description' => 'Kami memiliki pengalaman lebih dari 10 tahun dalam industri ini. Tim kami terdiri dari profesional berpengalaman yang siap memberikan solusi terbaik untuk kebutuhan Anda.',
            'skill_1' => 'Web Development', 'skill_1_percent' => 95,
            'skill_2' => 'UI/UX Design', 'skill_2_percent' => 90,
            'skill_3' => 'Digital Marketing', 'skill_3_percent' => 85,
            'skill_4' => 'Project Management', 'skill_4_percent' => 88,
            'image' => ''
        ];
    }
    
    if (!$vision) {
        $vision = [
            'main_title' => 'Arah dan Tujuan Perusahaan Kami',
            'vision_title' => 'Menjadi Pemimpin Industri',
            'vision_desc' => 'Menjadi perusahaan terdepan dalam memberikan solusi digital inovatif yang mengubah cara bisnis beroperasi dan berkembang di era digital.',
            'mission_title' => 'Memberikan Nilai Terbaik',
            'mission_desc' => "1. Memberikan layanan berkualitas tinggi dengan fokus pada kepuasan pelanggan.\n2. Mengembangkan solusi kreatif dan inovatif untuk setiap tantangan.\n3. Membangun hubungan jangka panjang dengan klien berdasarkan kepercayaan."
        ];
    }
    
    if (!$quality) {
        $quality = [
            'title' => 'Komitmen Kualitas Kami',
            'description' => 'Kami berkomitmen untuk memberikan standar kualitas tertinggi dalam setiap proyek yang kami kerjakan.',
            'commitment_1' => 'Kualitas Terjamin',
            'commitment_1_desc' => 'Setiap proyek melalui proses quality assurance yang ketat.',
            'commitment_2' => 'Tepat Waktu',
            'commitment_2_desc' => 'Kami memahami pentingnya deadline dan selalu berusaha tepat waktu.',
            'commitment_3' => 'Dukungan Berkelanjutan',
            'commitment_3_desc' => 'Layanan tidak berakhir setelah proyek selesai.'
        ];
    }

    // SELECTING DATA FROM USERS
    $sel = "SELECT * FROM users where role = 2";
    $q = mysqli_query($db, $sel);
    $user_data = mysqli_fetch_assoc($q);

    // selecting from social_media table
    $sel_icon = "SELECT * FROM social_media";
    $social = mysqli_query($db, $sel_icon);

    // selecting from contact form table
    $sel_con = "SELECT * FROM contact";
    $query_contact = mysqli_query($db, $sel_con);
    $contact_data = mysqli_fetch_assoc($query_contact);
?>

<!doctype html>
<html class="no-js" lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Tentang Kami Detail - Renol Diaz Website Portfolio</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" type="image/x-icon" href="../img/favicon.png">

    <!-- css here -->
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
    
    <style>
        .experience-skill-area { padding: 120px 0; }
        .vision-mission-area { padding: 120px 0; background: #f4f9fc; }
        .quality-commitment-area { padding: 120px 0; }
        .skill-item { margin-bottom: 25px; }
        .skill-item h6 { display: flex; justify-content: space-between; margin-bottom: 10px; }
        .progress { height: 8px; background: #e9ecef; border-radius: 4px; overflow: hidden; }
        .progress-bar { height: 100%; background: linear-gradient(90deg, #ff5f6d, #ffc371); border-radius: 4px; }
        .vision-box, .mission-box { 
            padding: 40px; 
            background: white; 
            border-radius: 10px; 
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            text-align: center;
            height: 100%;
        }
        .vision-icon, .mission-icon { 
            width: 80px; 
            height: 80px; 
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
        }
        .vision-icon i, .mission-icon i { font-size: 35px; color: white; }
        .quality-item { display: flex; gap: 20px; align-items: flex-start; margin-bottom: 30px; }
        .quality-icon { 
            flex-shrink: 0;
            width: 60px; 
            height: 60px; 
            background: #e8f5e9; 
            border-radius: 50%; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
        }
        .quality-icon i { font-size: 24px; color: #4caf50; }
        .section-title span { 
            color: #ff5f6d; 
            font-weight: 600; 
            text-transform: uppercase; 
            letter-spacing: 2px; 
            font-size: 14px; 
        }
        .section-title h2 { font-size: 36px; margin-top: 15px; margin-bottom: 20px; }
    </style>
</head>

<body class="theme-bg">

    <!-- preloader -->
    <div id="preloader">
        <div id="loading-center">
            <div id="loading-center-absolute">
                <div class="object" id="object_one"></div>
                <div class="object" id="object_two"></div>
                <div class="object" id="object_three"></div>
            </div>
        </div>
    </div>
    <!-- preloader-end -->

    <!-- header-start -->
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
                                        <li class="nav-item"><a class="nav-link" href="../index.php">Home</a></li>
                                        <li class="nav-item"><a class="nav-link" href="../index.php#about">Tentang</a></li>
                                        <li class="nav-item"><a class="nav-link" href="../index.php#service">Layanan</a></li>
                                        <li class="nav-item"><a class="nav-link" href="../index.php#portfolio">Portfolio</a></li>
                                        <li class="nav-item active"><a class="nav-link" href="about-detail.php">Tentang Detail</a></li>
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
                    <h4>Alamat Kantor</h4>
                    <p><?= isset($contact_data['address']) ? $contact_data['address'] : 'Alamat belum tersedia' ?></p>
                </div>
                <div class="contact-list mb-30">
                    <h4>Nomor Kontak</h4>
                    <p><?= isset($contact_data['phone']) ? $contact_data['phone'] : '-' ?></p>
                </div>
                <div class="contact-list mb-30">
                    <h4>Alamat Email</h4>
                    <p><?= isset($contact_data['email']) ? $contact_data['email'] : '-' ?></p>
                </div>
            </div>
            <div class="social-icon-right mt-20">
                <?php 
                    if($social && mysqli_num_rows($social) > 0) {
                        mysqli_data_seek($social, 0);
                        foreach ($social as $key => $value) {
                            ?>
                            <a href="<?= $value['link'] ?>"><i class="<?= $value['label'] ?>"></i></a>
                            <?php
                        }
                    }
                ?>
            </div>
        </div>
        <div class="offcanvas-overly"></div>
        <!-- offcanvas-end -->
    </header>
    <!-- header-end -->

    <!-- main-area -->
    <main>

        <!-- breadcrumb-area -->
        <section class="breadcrumb-area breadcrumb-bg d-flex align-items-center">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="breadcrumb-content text-center">
                            <h2>Tentang Kami Detail</h2>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb justify-content-center" style="background: none;">
                                    <li class="breadcrumb-item"><a href="../index.php" style="color: rgba(255,255,255,0.8);">Beranda</a></li>
                                    <li class="breadcrumb-item active" aria-current="page" style="color: white;">Tentang Detail</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- breadcrumb-area-end -->

        <!-- experience-skill-area -->
        <section class="experience-skill-area">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="section-title mb-30">
                            <span>Pengalaman & Keahlian</span>
                            <h2><?= htmlspecialchars($experience['title']) ?></h2>
                        </div>
                        <div class="experience-text">
                            <p style="color: #666; line-height: 1.8; margin-bottom: 30px;">
                                <?= nl2br(htmlspecialchars($experience['description'])) ?>
                            </p>
                            
                            <div class="skill-wrap">
                                <?php if(!empty($experience['skill_1'])): ?>
                                <div class="skill-item">
                                    <h6><?= htmlspecialchars($experience['skill_1']) ?> <span><?= intval($experience['skill_1_percent']) ?>%</span></h6>
                                    <div class="progress">
                                        <div class="progress-bar wow slideInLeft" data-wow-duration="1s" data-wow-delay=".3s" style="width: <?= intval($experience['skill_1_percent']) ?>%"></div>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <?php if(!empty($experience['skill_2'])): ?>
                                <div class="skill-item">
                                    <h6><?= htmlspecialchars($experience['skill_2']) ?> <span><?= intval($experience['skill_2_percent']) ?>%</span></h6>
                                    <div class="progress">
                                        <div class="progress-bar wow slideInLeft" data-wow-duration="1s" data-wow-delay=".4s" style="width: <?= intval($experience['skill_2_percent']) ?>%"></div>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <?php if(!empty($experience['skill_3'])): ?>
                                <div class="skill-item">
                                    <h6><?= htmlspecialchars($experience['skill_3']) ?> <span><?= intval($experience['skill_3_percent']) ?>%</span></h6>
                                    <div class="progress">
                                        <div class="progress-bar wow slideInLeft" data-wow-duration="1s" data-wow-delay=".5s" style="width: <?= intval($experience['skill_3_percent']) ?>%"></div>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <?php if(!empty($experience['skill_4'])): ?>
                                <div class="skill-item">
                                    <h6><?= htmlspecialchars($experience['skill_4']) ?> <span><?= intval($experience['skill_4_percent']) ?>%</span></h6>
                                    <div class="progress">
                                        <div class="progress-bar wow slideInLeft" data-wow-duration="1s" data-wow-delay=".6s" style="width: <?= intval($experience['skill_4_percent']) ?>%"></div>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="experience-img text-center">
                            <?php 
                            $exp_img = !empty($experience['image']) ? '../img/about/' . $experience['image'] : '';
                            if(!empty($exp_img) && file_exists($exp_img)):
                            ?>
                                <img src="<?= $exp_img ?>" alt="Experience Image" class="img-fluid" style="border-radius: 10px;">
                            <?php else: ?>
                                <div style="background: #f4f9fc; padding: 80px; border-radius: 10px;">
                                    <i class="fas fa-chart-line" style="font-size: 150px; color: #ff5f6d;"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- experience-skill-area-end -->

        <!-- vision-mission-area -->
        <section class="vision-mission-area">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="section-title text-center mb-60">
                            <span>Visi & Misi</span>
                            <h2><?= htmlspecialchars($vision['main_title']) ?></h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 mb-4">
                        <div class="vision-box">
                            <div class="vision-icon">
                                <i class="fas fa-eye"></i>
                            </div>
                            <h4><?= htmlspecialchars($vision['vision_title']) ?></h4>
                            <p style="color: #666; line-height: 1.8;">
                                <?= nl2br(htmlspecialchars($vision['vision_desc'])) ?>
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 mb-4">
                        <div class="mission-box">
                            <div class="mission-icon" style="background: linear-gradient(135deg, #1c36c6, #f5576c);">
                                <i class="fas fa-rocket"></i>
                            </div>
                            <h4><?= htmlspecialchars($vision['mission_title']) ?></h4>
                            <p style="color: #666; line-height: 1.8;">
                                <?= nl2br(htmlspecialchars($vision['mission_desc'])) ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- vision-mission-area-end -->

        <!-- quality-commitment-area -->
        <section class="quality-commitment-area">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 order-2 order-lg-1">
                        <div class="quality-img text-center">
                            <?php 
                            $qua_img = !empty($quality['image']) ? '../img/about/' . $quality['image'] : '';
                            if(!empty($qua_img) && file_exists($qua_img)):
                            ?>
                                <img src="<?= $qua_img ?>" alt="Quality Commitment" class="img-fluid" style="border-radius: 10px;">
                            <?php else: ?>
                                <div style="background: #f4f9fc; padding: 80px; border-radius: 10px;">
                                    <i class="fas fa-award" style="font-size: 150px; color: #4caf50;"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-lg-6 order-1 order-lg-2 mb-5 mb-lg-0">
                        <div class="pl-lg-30">
                            <div class="section-title mb-30">
                                <span>Komitmen Kualitas</span>
                                <h2><?= htmlspecialchars($quality['title']) ?></h2>
                            </div>
                            <p style="color: #666; line-height: 1.8; margin-bottom: 30px;">
                                <?= nl2br(htmlspecialchars($quality['description'])) ?>
                            </p>
                            
                            <div class="quality-features">
                                <?php if(!empty($quality['commitment_1'])): ?>
                                <div class="quality-item">
                                    <div class="quality-icon">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <div>
                                        <h5><?= htmlspecialchars($quality['commitment_1']) ?></h5>
                                        <p style="color: #666;"><?= htmlspecialchars($quality['commitment_1_desc']) ?></p>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <?php if(!empty($quality['commitment_2'])): ?>
                                <div class="quality-item">
                                    <div class="quality-icon" style="background: #e3f2fd;">
                                        <i class="fas fa-clock" style="color: #2196f3;"></i>
                                    </div>
                                    <div>
                                        <h5><?= htmlspecialchars($quality['commitment_2']) ?></h5>
                                        <p style="color: #666;"><?= htmlspecialchars($quality['commitment_2_desc']) ?></p>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <?php if(!empty($quality['commitment_3'])): ?>
                                <div class="quality-item">
                                    <div class="quality-icon" style="background: #fce4ec;">
                                        <i class="fas fa-headset" style="color: #e91e63;"></i>
                                    </div>
                                    <div>
                                        <h5><?= htmlspecialchars($quality['commitment_3']) ?></h5>
                                        <p style="color: #666;"><?= htmlspecialchars($quality['commitment_3_desc']) ?></p>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- quality-commitment-area-end -->

    </main>
    <!-- main-area-end -->

    <!-- footer -->
    <footer>
        <div class="copyright-wrap primary-bg">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-12">
                        <div class="copyright-text text-center">
                            <p>Copyright© <span><?= isset($user_data['name']) ? $user_data['name'] : 'ONES BHOGAR' ?></span> | Semua Hak Dilindungi Undang-Undang</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- footer-end -->

    <!-- JS here -->
    <script src="../js/vendor/jquery-1.12.4.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/isotope.pkgd.min.js"></script>
    <script src="../js/one-page-nav-min.js"></script>
    <script src="../js/slick.min.js"></script>
    <script src="../js/ajax-form.js"></script>
    <script src="../js/wow.min.js"></script>
    <script src="../js/aos.js"></script>
    <script src="../js/jquery.waypoints.min.js"></script>
    <script src="../js/jquery.counterup.min.js"></script>
    <script src="../js/jquery.scrollUp.min.js"></script>
    <script src="../js/imagesloaded.pkgd.min.js"></script>
    <script src="../js/jquery.magnific-popup.min.js"></script>
    <script src="../js/plugins.js"></script>
    <script src="../js/main.js"></script>
</body>

</html>