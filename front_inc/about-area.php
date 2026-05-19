<?php 
    // Selecting data from about_me Table
    $select = "SELECT * FROM about_me";
    $query = mysqli_query($db, $select);
    $assoc = mysqli_fetch_assoc($query);

    // Selecting data from education Table
    $sel = "SELECT * FROM education";
    $q = mysqli_query($db, $sel);
?>

<section id="about" class="about-section">
    <div class="about-bg">
        <div class="bg-shape shape-1"></div>
        <div class="bg-shape shape-2"></div>
    </div>

    <div class="container position-relative">
        <div class="row align-items-center g-5">
            <!-- Left: Image -->
            <div class="col-lg-5">
                <div class="about-image-wrap" data-aos="fade-right">
                    <div class="image-frame">
                        <div class="frame-glow"></div>
                        <img src="<?= htmlspecialchars('img/banner/'.$assoc['image']) ?>" 
                             alt="<?= htmlspecialchars($assoc['title'] ?? 'About') ?>" 
                             class="about-img">
                        <div class="experience-float">
                            <span class="exp-num">20</span>
                            <span class="exp-label">Tahun<br>Pengalaman</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Content -->
            <div class="col-lg-7">
                <div class="about-content-wrap" data-aos="fade-left">
                    <span class="section-label">Perkenalan Singkat</span>
                    <h2 class="about-title"><?= htmlspecialchars($assoc['title'] ?? 'Tentang Saya') ?></h2>
                    <div class="title-underline"></div>

                    <div class="about-description">
                        <?= nl2br(htmlspecialchars($assoc['description'] ?? '')) ?>
                    </div>

                    <!-- Education Section -->
                    <div class="education-section">
                        <h3 class="edu-title">
                            <i class="fas fa-graduation-cap"></i>
                            Riwayat Pendidikan
                        </h3>

                        <?php foreach ($q as $key => $value): ?>
                        <div class="education-item">
                            <div class="edu-year">
                                <span><?= htmlspecialchars($value['year']) ?></span>
                            </div>
                            <div class="edu-track">
                                <div class="edu-dot"></div>
                                <div class="edu-line"></div>
                            </div>
                            <div class="edu-info">
                                <h4><?= htmlspecialchars($value['name']) ?></h4>
                                <div class="progress-wrap">
                                    <div class="progress-bar-bg">
                                        <div class="progress-bar-fill" 
                                             style="width: <?= htmlspecialchars($value['result']) ?>%"></div>
                                    </div>
                                    <span class="progress-text"><?= htmlspecialchars($value['result']) ?>%</span>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- CTA Button -->
                    <div class="about-cta">
                        <a href="frontend/detail_about.php" class="btn-primary">
                            <span>Lihat Selengkapnya</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* ===== ABOUT SECTION - ELEGANT ===== */
.about-section {
    position: relative;
    padding: 120px 0;
    background: #131f33;
    overflow: hidden;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
}

.about-bg {
    position: absolute;
    inset: 0;
    pointer-events: none;
    overflow: hidden;
}

.bg-shape {
    position: absolute;
    border-radius: 50%;
    filter: blur(100px);
    opacity: 0.1;
}

.shape-1 {
    width: 400px;
    height: 400px;
    background: #6366f1;
    top: -100px;
    left: -100px;
}

.shape-2 {
    width: 300px;
    height: 300px;
    background: #ec4899;
    bottom: -100px;
    right: -50px;
}

/* Image Section */
.about-image-wrap {
    position: relative;
}

.image-frame {
    position: relative;
    display: inline-block;
}

.frame-glow {
    position: absolute;
    inset: -15px;
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.2), rgba(236, 72, 153, 0.15));
    border-radius: 30px;
    filter: blur(30px);
    opacity: 0.5;
    animation: glowPulse 4s ease-in-out infinite;
}

@keyframes glowPulse {
    0%, 100% { opacity: 0.3; transform: scale(1); }
    50% { opacity: 0.6; transform: scale(1.02); }
}

.about-img {
    position: relative;
    width: 100%;
    max-width: 420px;
    border-radius: 24px;
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.4);
    z-index: 2;
    display: block;
}

.experience-float {
    position: absolute;
    bottom: 30px;
    right: -20px;
    background: rgba(30, 41, 59, 0.95);
    border: 1px solid rgba(148, 163, 184, 0.15);
    border-radius: 20px;
    padding: 24px 28px;
    display: flex;
    align-items: center;
    gap: 16px;
    backdrop-filter: blur(20px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    z-index: 3;
}

.exp-num {
    font-size: 2.5rem;
    font-weight: 800;
    color: #818cf8;
    line-height: 1;
}

.exp-label {
    font-size: 12px;
    color: #94a3b8;
    font-weight: 600;
    line-height: 1.5;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Content Section */
.about-content-wrap {
    padding-left: 30px;
}

.section-label {
    display: inline-block;
    font-size: 12px;
    font-weight: 700;
    color: #818cf8;
    text-transform: uppercase;
    letter-spacing: 3px;
    margin-bottom: 16px;
    padding: 8px 20px;
    background: rgba(99, 102, 241, 0.1);
    border: 1px solid rgba(99, 102, 241, 0.2);
    border-radius: 50px;
}

.about-title {
    font-size: 2.8rem;
    font-weight: 800;
    color: #f8fafc;
    line-height: 1.2;
    margin-bottom: 0;
    letter-spacing: -0.02em;
}

.title-underline {
    width: 60px;
    height: 4px;
    background: linear-gradient(90deg, #6366f1, #ec4899);
    border-radius: 2px;
    margin: 24px 0 30px;
}

.about-description {
    font-size: 1.05rem;
    line-height: 1.9;
    color: #94a3b8;
    margin-bottom: 40px;
}

.about-description p {
    margin-bottom: 16px;
}

/* Education Section */
.education-section {
    margin-bottom: 40px;
}

.edu-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: #f8fafc;
    margin-bottom: 30px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.edu-title i {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 16px;
}

.education-item {
    display: flex;
    align-items: flex-start;
    gap: 20px;
    margin-bottom: 28px;
}

.edu-year {
    min-width: 80px;
    text-align: right;
}

.edu-year span {
    display: inline-block;
    background: rgba(99, 102, 241, 0.1);
    border: 1px solid rgba(99, 102, 241, 0.2);
    color: #818cf8;
    padding: 8px 16px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 700;
}

.edu-track {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding-top: 8px;
}

.edu-dot {
    width: 14px;
    height: 14px;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    border-radius: 50%;
    border: 3px solid #131f33;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.3);
}

.edu-line {
    width: 2px;
    height: calc(100% + 28px);
    background: linear-gradient(180deg, rgba(99, 102, 241, 0.3), transparent);
    margin-top: 8px;
}

.education-item:last-child .edu-line {
    display: none;
}

.edu-info {
    flex: 1;
    padding-top: 4px;
}

.edu-info h4 {
    font-size: 1rem;
    font-weight: 700;
    color: #f8fafc;
    margin-bottom: 12px;
}

.progress-wrap {
    display: flex;
    align-items: center;
    gap: 12px;
}

.progress-bar-bg {
    flex: 1;
    height: 8px;
    background: rgba(148, 163, 184, 0.1);
    border-radius: 4px;
    overflow: hidden;
}

.progress-bar-fill {
    height: 100%;
    background: linear-gradient(90deg, #6366f1, #8b5cf6);
    border-radius: 4px;
    transition: width 1s ease;
}

.progress-text {
    font-size: 12px;
    font-weight: 700;
    color: #818cf8;
    min-width: 35px;
}

/* CTA Button */
.about-cta {
    margin-top: 10px;
}

.btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
    color: #fff;
    padding: 16px 36px;
    border-radius: 14px;
    font-size: 14px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 10px 30px rgba(99, 102, 241, 0.3);
    border: none;
}

.btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 20px 40px rgba(99, 102, 241, 0.4);
    color: #fff;
    text-decoration: none;
}

.btn-primary i {
    transition: transform 0.3s;
}

.btn-primary:hover i {
    transform: translateX(4px);
}

/* Responsive */
@media (max-width: 991px) {
    .about-section {
        padding: 80px 0;
    }
    
    .about-content-wrap {
        padding-left: 0;
        margin-top: 40px;
    }
    
    .about-title {
        font-size: 2.2rem;
    }
    
    .experience-float {
        right: 10px;
        bottom: 20px;
    }
    
    .about-img {
        max-width: 100%;
    }
}

@media (max-width: 576px) {
    .about-title {
        font-size: 1.8rem;
    }
    
    .education-item {
        gap: 14px;
    }
    
    .edu-year {
        min-width: 60px;
    }
    
    .experience-float {
        padding: 18px 22px;
    }
    
    .exp-num {
        font-size: 2rem;
    }
}
</style>