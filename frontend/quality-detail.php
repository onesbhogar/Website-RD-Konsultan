<?php
// ============================================
// QUALITY DETAIL - Halaman Detail Dokumentasi
// File: frontend/quality-detail.php
// ============================================

ini_set('display_errors', 1);
error_reporting(E_ALL);

require '../backend/db.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    header('Location: ../index.php#quality');
    exit;
}

$query = mysqli_query($db, "SELECT * FROM quality_menu WHERE id = $id AND status = 1");
$item = mysqli_fetch_assoc($query);

if (!$item) {
    header('Location: ../index.php#quality');
    exit;
}

// Item terkait
$related = mysqli_query($db, "SELECT * FROM quality_menu 
    WHERE main_category = '".mysqli_real_escape_string($db, $item['main_category'])."' 
    AND id != $id AND status = 1
    ORDER BY sort_order ASC LIMIT 6");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($item['title']) ?> - Dokumentasi Proyek | RD DESIGN</title>
    <meta name="description" content="<?= htmlspecialchars(substr($item['description'], 0, 160)) ?>">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #6366f1;
            --primary-light: #818cf8;
            --primary-dark: #4f46e5;
            --dark: #0f172a;
            --darker: #030712;
            --card-bg: #1e293b;
            --border: rgba(148, 163, 184, 0.1);
        }
        
        * { font-family: 'Inter', sans-serif; }
        
        body { 
            background: #131f33; 
            color: #e2e8f0;
            line-height: 1.7;
        }
        
        /* Header */
        .detail-header {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            padding: 60px 0 40px;
            position: relative;
            overflow: hidden;
        }
        
        .detail-header::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 50%;
            height: 100%;
            background: radial-gradient(circle at 80% 50%, rgba(99, 102, 241, 0.08) 0%, transparent 60%);
            pointer-events: none;
        }
        
        .breadcrumb-custom {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 13px;
            margin-bottom: 24px;
        }
        
        .breadcrumb-custom a {
            color: #94a3b8;
            text-decoration: none;
            transition: color 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .breadcrumb-custom a:hover { 
            color: var(--primary-light); 
        }
        
        .breadcrumb-sep {
            color: #475569;
            font-size: 10px;
        }
        
        .detail-title {
            font-size: 2.4rem;
            font-weight: 800;
            color: #f8fafc;
            margin-bottom: 12px;
            line-height: 1.2;
            letter-spacing: -0.02em;
        }
        
        .detail-subtitle {
            display: flex;
            align-items: center;
            gap: 20px;
            color: #94a3b8;
            font-size: 14px;
        }
        
        .detail-subtitle span {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .detail-subtitle i {
            color: var(--primary-light);
        }
        
        /* Main Content - GAMBAR KIRI DESKRIPSI KANAN */
        .detail-main {
            margin-top: 40px;
        }
        
        .image-column {
            position: sticky;
            top: 30px;
        }
        
        .main-image-container {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,0.4);
            border: 1px solid var(--border);
            cursor: zoom-in;
        }
        
        .main-image {
            width: 100%;
            height: 500px;
            object-fit: cover;
            object-position: center;
            display: block;
            background: var(--dark);
        }
        
        .image-overlay-btn {
            position: absolute;
            bottom: 20px;
            right: 20px;
            background: rgba(15, 23, 42, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid var(--border);
            color: #f8fafc;
            padding: 12px 24px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s;
        }
        
        .image-overlay-btn:hover {
            background: var(--primary);
            border-color: var(--primary);
        }
        
        /* Content Column */
        .content-column {
            padding-left: 20px;
        }
        
        .content-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 40px;
            height: 100%;
        }
        
        .content-card::before {
            content: '';
            display: block;
            width: 60px;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), #ec4899);
            border-radius: 2px;
            margin-bottom: 30px;
        }
        
        .content-label {
            font-size: 12px;
            font-weight: 700;
            color: var(--primary-light);
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 12px;
        }
        
        .content-title {
            font-size: 1.6rem;
            font-weight: 700;
            color: #f8fafc;
            margin-bottom: 25px;
            line-height: 1.3;
        }
        
        /* Meta */
        .content-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 30px;
            padding-bottom: 25px;
            border-bottom: 1px solid var(--border);
        }
        
        .meta-item {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(15, 23, 42, 0.5);
            padding: 10px 18px;
            border-radius: 10px;
            color: #94a3b8;
            font-size: 13px;
            font-weight: 600;
        }
        
        .meta-item i { 
            color: var(--primary-light);
            font-size: 14px;
        }
        
        /* Description */
        .description-text {
            font-size: 1rem;
            line-height: 1.9;
            color: #cbd5e1;
        }
        
        .description-text p {
            margin-bottom: 18px;
        }
        
        /* Info Box */
        .info-box {
            background: rgba(15, 23, 42, 0.5);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 30px;
            margin-top: 30px;
        }
        
        .info-box-title {
            font-size: 1rem;
            font-weight: 700;
            color: #f8fafc;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .info-box-title i {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 14px;
        }
        
        .info-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .info-list li {
            padding: 14px 0;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }
        
        .info-list li:last-child { 
            border-bottom: none; 
        }
        
        .info-list .label {
            color: #94a3b8;
            font-size: 13px;
            flex-shrink: 0;
        }
        
        .info-list .value {
            color: #f8fafc;
            font-weight: 600;
            font-size: 13px;
            text-align: right;
            max-width: 60%;
        }
        
        /* Related Section */
        .related-section {
            margin-top: 80px;
        }
        
        .section-header {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 40px;
        }
        
        .section-header h3 {
            font-size: 1.4rem;
            font-weight: 700;
            color: #f8fafc;
            margin: 0;
        }
        
        .section-header i {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, var(--primary), #ec4899);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 18px;
        }
        
        .related-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.4s ease;
            text-decoration: none;
            color: inherit;
            display: block;
            height: 100%;
        }
        
        .related-card:hover {
            transform: translateY(-6px);
            border-color: rgba(99, 102, 241, 0.3);
            box-shadow: 0 20px 50px rgba(0,0,0,0.3);
            text-decoration: none;
            color: inherit;
        }
        
        .related-img-wrap {
            position: relative;
            overflow: hidden;
        }
        
        .related-img {
            height: 180px;
            object-fit: cover;
            width: 100%;
            transition: transform 0.5s ease;
        }
        
        .related-card:hover .related-img {
            transform: scale(1.08);
        }
        
        .related-content {
            padding: 20px;
        }
        
        .related-category {
            display: inline-block;
            background: rgba(99, 102, 241, 0.1);
            border: 1px solid rgba(99, 102, 241, 0.2);
            color: var(--primary-light);
            padding: 5px 14px;
            border-radius: 50px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }
        
        .related-title {
            font-size: 1rem;
            font-weight: 700;
            color: #f8fafc;
            line-height: 1.4;
            margin: 0;
        }
        
        /* Back Button */
        .back-section {
            margin-top: 60px;
            text-align: center;
        }
        
        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            background: transparent;
            color: #94a3b8;
            padding: 16px 36px;
            border-radius: 14px;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            border: 2px solid var(--border);
            transition: all 0.3s ease;
        }
        
        .btn-back:hover {
            background: var(--primary);
            border-color: var(--primary);
            color: #fff;
            text-decoration: none;
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(99, 102, 241, 0.3);
        }
        
        /* Footer */
        .detail-footer {
            margin-top: 80px;
            padding: 40px 0;
            border-top: 1px solid var(--border);
            text-align: center;
        }
        
        .detail-footer p {
            color: #64748b;
            font-size: 14px;
            margin: 0;
        }
        
        .detail-footer span {
            color: var(--primary-light);
            font-weight: 600;
        }
        
        /* Lightbox */
        .lightbox {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(3, 7, 18, 0.98);
            z-index: 9999;
            justify-content: center;
            align-items: center;
            cursor: zoom-out;
            backdrop-filter: blur(20px);
        }
        
        .lightbox.active { 
            display: flex; 
        }
        
        .lightbox img {
            max-width: 90%;
            max-height: 90%;
            object-fit: contain;
            border-radius: 16px;
            box-shadow: 0 30px 80px rgba(0,0,0,0.5);
        }
        
        .lightbox-close {
            position: absolute;
            top: 30px; 
            right: 40px;
            color: #94a3b8;
            font-size: 1.5rem;
            cursor: pointer;
            width: 50px;
            height: 50px;
            background: rgba(30, 41, 59, 0.8);
            border: 1px solid var(--border);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }
        
        .lightbox-close:hover {
            background: var(--primary);
            border-color: var(--primary);
            color: #fff;
        }
        
        /* Responsive */
        @media (max-width: 991px) {
            .detail-header {
                padding: 50px 0 30px;
            }
            
            .detail-title {
                font-size: 1.8rem;
            }
            
            .image-column {
                position: relative;
                top: 0;
                margin-bottom: 30px;
            }
            
            .main-image {
                height: 400px;
            }
            
            .content-column {
                padding-left: 0;
            }
            
            .content-card {
                padding: 30px;
            }
        }
        
        @media (max-width: 768px) {
            .detail-title {
                font-size: 1.6rem;
            }
            
            .detail-subtitle {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
            
            .main-image {
                height: 300px;
            }
            
            .content-card { 
                padding: 25px;
            }
            
            .content-title { 
                font-size: 1.3rem; 
            }
            
            .content-meta { 
                flex-direction: column;
                gap: 10px;
            }
            
            .meta-item {
                width: 100%;
            }
            
            .info-box {
                padding: 20px;
            }
            
            .related-img {
                height: 160px;
            }
        }
    </style>
</head>
<body>

    <header class="detail-header">
        <div class="container position-relative">
            <nav class="breadcrumb-custom">
                <a href="../index.php"><i class="fas fa-home"></i> Beranda</a>
                <i class="fas fa-chevron-right breadcrumb-sep"></i>
                <a href="../index.php#quality">Dokumentasi Proyek</a>
                <i class="fas fa-chevron-right breadcrumb-sep"></i>
                <span style="color: #64748b;"><?= htmlspecialchars($item['title']) ?></span>
            </nav>
            
            <h1 class="detail-title"><?= htmlspecialchars($item['title']) ?></h1>
            
            <div class="detail-subtitle">
                <span><i class="fas fa-layer-group"></i> <?= htmlspecialchars($item['main_category']) ?></span>
                <?php if (!empty($item['sub_category'])): ?>
                <span><i class="fas fa-tag"></i> <?= htmlspecialchars($item['sub_category']) ?></span>
                <?php endif; ?>
                <span><i class="fas fa-sort-numeric-down"></i> Urutan #<?= $item['sort_order'] ?></span>
            </div>
        </div>
    </header>

    <!-- MAIN CONTENT: GAMBAR KIRI, DESKRIPSI KANAN -->
    <div class="container detail-main">
        <div class="row">
            <!-- Left: Image -->
            <div class="col-lg-6">
                <div class="image-column">
                    <div class="main-image-container" onclick="openLightbox()">
                        <?php 
                        $img_path = '../img/quality/' . $item['image'];
                        $img_exists = file_exists($img_path) && !empty($item['image']);
                        ?>
                        <?php if ($img_exists): ?>
                        <img src="<?= $img_path ?>" alt="<?= htmlspecialchars($item['title']) ?>" class="main-image" id="mainImage">
                        <div class="image-overlay-btn">
                            <i class="fas fa-expand"></i> Klik untuk Perbesar
                        </div>
                        <?php else: ?>
                        <div class="main-image d-flex align-items-center justify-content-center" style="min-height: 400px; background: var(--dark);">
                            <i class="fas fa-image text-secondary" style="font-size: 5rem;"></i>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Right: Description -->
            <div class="col-lg-6">
                <div class="content-column">
                    <div class="content-card">
                        <div class="content-label">Detail Dokumentasi</div>
                        <h2 class="content-title"><?= htmlspecialchars($item['title']) ?></h2>
                        
                        <div class="content-meta">
                            <div class="meta-item">
                                <i class="fas fa-folder"></i>
                                <span><?= htmlspecialchars($item['main_category']) ?></span>
                            </div>
                            <?php if (!empty($item['sub_category'])): ?>
                            <div class="meta-item">
                                <i class="fas fa-tag"></i>
                                <span><?= htmlspecialchars($item['sub_category']) ?></span>
                            </div>
                            <?php endif; ?>
                            <div class="meta-item">
                                <i class="fas fa-sort-numeric-down"></i>
                                <span>Urutan #<?= $item['sort_order'] ?></span>
                            </div>
                        </div>
                        
                        <div class="description-text">
                            <?php 
                            $full_desc = !empty($item['description_full']) ? $item['description_full'] : $item['description'];
                            $paragraphs = explode("\n", $full_desc);
                            foreach ($paragraphs as $para) {
                                if (trim($para)) {
                                    echo '<p>' . htmlspecialchars(trim($para)) . '</p>';
                                }
                            }
                            ?>
                        </div>
                        
                        <div class="info-box">
                            <div class="info-box-title">
                                <i class="fas fa-info-circle"></i>
                                Informasi Lengkap
                            </div>
                            <ul class="info-list">
                                <li>
                                    <span class="label">Kategori Utama</span>
                                    <span class="value"><?= htmlspecialchars($item['main_category']) ?></span>
                                </li>
                                <li>
                                    <span class="label">Sub Kategori</span>
                                    <span class="value"><?= !empty($item['sub_category']) ? htmlspecialchars($item['sub_category']) : '-' ?></span>
                                </li>
                                <li>
                                    <span class="label">Judul</span>
                                    <span class="value"><?= htmlspecialchars($item['title']) ?></span>
                                </li>
                                <li>
                                    <span class="label">Deskripsi Singkat</span>
                                    <span class="value"><?= htmlspecialchars($item['description']) ?></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if (mysqli_num_rows($related) > 0): ?>
    <div class="container related-section">
        <div class="section-header">
            <i class="fas fa-th-large"></i>
            <h3>Dokumentasi Terkait</h3>
        </div>
        <div class="row g-4">
            <?php while ($rel = mysqli_fetch_assoc($related)): ?>
            <div class="col-lg-4 col-md-6">
                <a href="quality-detail.php?id=<?= $rel['id'] ?>" class="related-card">
                    <div class="related-img-wrap">
                        <?php 
                        $rel_img = '../img/quality/' . $rel['image'];
                        $rel_exists = file_exists($rel_img) && !empty($rel['image']);
                        ?>
                        <?php if ($rel_exists): ?>
                        <img src="<?= $rel_img ?>" alt="<?= htmlspecialchars($rel['title']) ?>" class="related-img">
                        <?php else: ?>
                        <div class="related-img d-flex align-items-center justify-content-center" style="background: var(--dark);">
                            <i class="fas fa-image text-secondary" style="font-size: 2rem;"></i>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="related-content">
                        <div class="related-category"><?= htmlspecialchars($rel['main_category']) ?></div>
                        <div class="related-title"><?= htmlspecialchars($rel['title']) ?></div>
                    </div>
                </a>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
    <?php endif; ?>

    <div class="container back-section">
        <a href="../index.php#quality" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali ke Dokumentasi
        </a>
    </div>

    <footer class="detail-footer">
        <div class="container">
            <p>RD Design &copy; <?= date('Y') ?> | <span>Dokumentasi Kualitas Pekerjaan</span></p>
        </div>
    </footer>

    <div class="lightbox" id="lightbox" onclick="closeLightbox()">
        <div class="lightbox-close"><i class="fas fa-times"></i></div>
        <img src="" alt="Full Image" id="lightboxImage">
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function openLightbox() {
            const mainImg = document.getElementById('mainImage');
            const lightbox = document.getElementById('lightbox');
            const lightboxImg = document.getElementById('lightboxImage');
            if (mainImg) {
                lightboxImg.src = mainImg.src;
                lightbox.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
        }
        function closeLightbox() {
            document.getElementById('lightbox').classList.remove('active');
            document.body.style.overflow = '';
        }
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeLightbox();
        });
    </script>
</body>
</html>