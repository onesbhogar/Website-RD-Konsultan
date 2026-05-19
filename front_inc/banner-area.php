<?php 
    $select = "SELECT * FROM banner";
    $query = mysqli_query($db, $select);
    $assoc = mysqli_fetch_assoc($query);
    
    $sel = "SELECT * FROM social_media";
    $q = mysqli_query($db, $sel);
?>

<section id="home" class="hero-section">
    <div class="hero-bg-effect"></div>

    <div class="container position-relative">
        <div class="row align-items-center">
            <!-- Content -->
            <div class="col-lg-6">
                <div class="hero-content">
                    <div class="hero-badge">
                        <span class="pulse-dot"></span>
                        <?= htmlspecialchars($assoc['title1'] ?? 'Selamat Datang') ?>
                    </div>

                    <h1 class="hero-title">
                        <?= htmlspecialchars($assoc['title2'] ?? 'RD Design') ?>
                    </h1>

                    <div class="title-underline"></div>

                    <p class="hero-desc">
                        <?= htmlspecialchars($assoc['description'] ?? 'Konsultan Perencanaan, Pengawasan & Pelaksanaan Konstruksi Bangunan') ?>
                    </p>

                    <div class="hero-buttons">
                        <a href="#portfolio" class="btn-main">
                            LIHAT
                            <i class="fas fa-arrow-right"></i>
                        </a>
                        <a href="#contact" class="btn-ghost">
                            Hubungi Kami
                        </a>
                    </div>

                    <div class="social-row">
                        <span class="social-text">Follow</span>
                        <div class="social-sep"></div>
                        <?php foreach ($q as $key => $value): ?>
                            <a href="<?= htmlspecialchars($value['link']) ?>" 
                               class="social-icon"
                               target="_blank"
                               rel="noopener noreferrer">
                                <i class="<?= htmlspecialchars($value['label']) ?>"></i>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Image -->
            <div class="col-lg-6">
                <div class="hero-image-wrap">
                    <div class="image-container">
                        <div class="image-glow"></div>
                        <img src="<?= htmlspecialchars('img/banner/'.$assoc['image']) ?>" 
                             alt="RD Design" 
                             class="hero-img">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* ===== HERO SECTION - #131f33 ===== */
.hero-section {
    position: relative;
    min-height: 100vh;
    background: #131f33;
    overflow: hidden;
    display: flex;
    align-items: center;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    padding: 80px 0 60px;
}

/* Background Effect */
.hero-bg-effect {
    position: absolute;
    inset: 0;
    background: 
        radial-gradient(circle at 80% 20%, rgba(99, 102, 241, 0.08) 0%, transparent 40%),
        radial-gradient(circle at 20% 80%, rgba(236, 72, 153, 0.06) 0%, transparent 40%);
    pointer-events: none;
}

/* Content */
.hero-content {
    position: relative;
    z-index: 2;
    padding: 60px 0 40px;
}

/* Badge - DITURUNKAN */
.hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: rgba(99, 102, 241, 0.1);
    border: 1px solid rgba(99, 102, 241, 0.2);
    color: #818cf8;
    padding: 10px 24px;
    border-radius: 50px;
    font-size: 13px;
    font-weight: 600;
    letter-spacing: 1px;
    margin-bottom: 35px;
    margin-top: 20px;
}

.pulse-dot {
    width: 8px;
    height: 8px;
    background: #22c55e;
    border-radius: 50%;
    animation: pulse 2s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.4); }
    50% { box-shadow: 0 0 0 8px rgba(34, 197, 94, 0); }
}

/* Title */
.hero-title {
    font-size: 4rem;
    font-weight: 900;
    color: #f8fafc;
    line-height: 1.1;
    margin-bottom: 0;
    letter-spacing: -0.03em;
}

/* Underline */
.title-underline {
    width: 70px;
    height: 4px;
    background: linear-gradient(90deg, #6366f1, #ec4899);
    border-radius: 2px;
    margin: 25px 0 30px;
}

/* Description */
.hero-desc {
    font-size: 1.15rem;
    color: #94a3b8;
    line-height: 1.8;
    margin-bottom: 40px;
    max-width: 480px;
}

/* Buttons */
.hero-buttons {
    display: flex;
    gap: 16px;
    margin-bottom: 55px;
    align-items: center;
}

.btn-main {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    background: #4f46e5;
    color: #ffffff;
    padding: 16px 36px;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    text-decoration: none;
    transition: all 0.3s ease;
    border: none;
    box-shadow: 0 4px 20px rgba(79, 70, 229, 0.35);
}

.btn-main:hover {
    background: #6366f1;
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(99, 102, 241, 0.45);
    color: #ffffff;
    text-decoration: none;
}

.btn-main i {
    font-size: 12px;
    transition: transform 0.3s;
}

.btn-main:hover i {
    transform: translateX(4px);
}

.btn-ghost {
    display: inline-flex;
    align-items: center;
    padding: 16px 36px;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 700;
    color: #cbd5e1;
    text-decoration: none;
    border: 2px solid rgba(148, 163, 184, 0.25);
    transition: all 0.3s ease;
    background: transparent;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.btn-ghost:hover {
    border-color: #6366f1;
    color: #818cf8;
    background: rgba(99, 102, 241, 0.08);
    text-decoration: none;
}

/* Social */
.social-row {
    display: flex;
    align-items: center;
    gap: 16px;
}

.social-text {
    font-size: 12px;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 2px;
}

.social-sep {
    width: 30px;
    height: 1px;
    background: #475569;
}

.social-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: rgba(30, 41, 59, 0.6);
    border: 1px solid rgba(148, 163, 184, 0.15);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #94a3b8;
    font-size: 15px;
    text-decoration: none;
    transition: all 0.3s ease;
}

.social-icon:hover {
    background: #4f46e5;
    border-color: #4f46e5;
    color: #ffffff;
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(79, 70, 229, 0.3);
    text-decoration: none;
}

.hero-image-wrap {
    position: relative;
    z-index: 2;
    display: flex;
    justify-content: center;
    align-items: flex-end;
    height: 100%;
    margin-top: 80px;
}

.image-container {
    position: relative;
    width: 100%;
    max-width: 560px;
    display: flex;
    justify-content: center;
    align-items: flex-end;
}

.image-glow {
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 90%;
    height: 70%;
    background: radial-gradient(ellipse at center bottom, rgba(99, 102, 241, 0.12) 0%, transparent 70%);
    filter: blur(50px);
    pointer-events: none;
}

.hero-img {
    position: relative;
    width: 100%;
    max-width: 100%;
    height: auto;
    max-height: 720px;
    object-fit: contain;
    object-position: bottom center;
    display: block;
    z-index: 2;
    filter: drop-shadow(0 30px 60px rgba(0, 0, 0, 0.4));
    margin-bottom: -2px;
}

/* Responsive */
@media (max-width: 991px) {
    .hero-section {
        padding: 60px 0 40px;
        min-height: auto;
    }
    
    .hero-content {
        text-align: center;
        padding: 40px 0;
    }
    
    .hero-badge {
        margin-top: 0;
    }
    
    .hero-title {
        font-size: 3rem;
    }
    
    .title-underline {
        margin: 20px auto 25px;
    }
    
    .hero-desc {
        margin-left: auto;
        margin-right: auto;
    }
    
    .hero-buttons {
        justify-content: center;
    }
    
    .social-row {
        justify-content: center;
    }
    
    .hero-image-wrap {
        min-height: auto;
        margin-top: 30px;
    }
    
    .image-container {
        max-width: 400px;
    }
    
    .hero-img {
        max-height: 500px;
    }
}

@media (max-width: 576px) {
    .hero-title {
        font-size: 2.4rem;
    }
    
    .hero-buttons {
        flex-direction: column;
        width: 100%;
    }
    
    .btn-main,
    .btn-ghost {
        width: 100%;
        justify-content: center;
    }
    
    .image-container {
        max-width: 100%;
    }
    
    .hero-img {
        max-height: 450px;
    }
}
</style>