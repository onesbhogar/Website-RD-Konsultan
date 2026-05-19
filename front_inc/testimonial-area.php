<?php 
    $sel = "SELECT * FROM review";
    $query = mysqli_query($db, $sel);
?>       
<section class="review-section">
    <div class="review-bg">
        <div class="bg-shape shape-1"></div>
        <div class="bg-shape shape-2"></div>
        <div class="bg-shape shape-3"></div>
    </div>
    
    <div class="container position-relative">
        <!-- Header -->
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="review-header">
                    <span class="badge-label">
                        <i class="fas fa-comments"></i>
                        Testimoni Pelanggan
                    </span>
                    <h2 class="main-heading">Cerita Kepuasan <span class="highlight">Mereka</span></h2>
                    <p class="sub-text">Setiap ulasan adalah motivasi bagi kami untuk terus memberikan yang terbaik</p>
                </div>
            </div>
        </div>

        <!-- Review Grid -->
        <div class="row g-4">
            <?php 
                $delay = 0;
                foreach ($query as $key => $value) {
                    if($value['status'] == 2){
                        $star = (int)$value['rating'];
                        $delay += 100;
                        $colors = ['#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', '#FFEAA7', '#DDA0DD'];
                        $accent = $colors[$key % count($colors)];
            ?>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?= $delay ?>">
                <div class="review-card" style="--accent-color: <?= $accent ?>">
                    <div class="card-accent"></div>
                    
                    <div class="card-top">
                        <div class="user-block">
                            <div class="user-img" style="background: <?= $accent ?>">
                                <?php if(!empty($value['img']) && file_exists("img/user/".$value['img'])): ?>
                                    <img src="img/user/<?= htmlspecialchars($value['img']) ?>" alt="<?= htmlspecialchars($value['name']) ?>">
                                <?php else: ?>
                                    <span><?= strtoupper(substr($value['name'], 0, 2)) ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="user-meta">
                                <h6><?= htmlspecialchars($value['name']) ?></h6>
                                <span class="role-tag"><?= htmlspecialchars($value['user_status']) ?></span>
                            </div>
                        </div>
                        <div class="quote-mark">
                            <i class="fas fa-quote-right"></i>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="star-row">
                            <?php for($i = 1; $i <= 5; $i++): ?>
                                <i class="fas fa-star <?= $i <= $star ? 'on' : '' ?>"></i>
                            <?php endfor; ?>
                            <span class="score"><?= $star ?>.0</span>
                        </div>
                        <p class="review-words">"<?= htmlspecialchars($value['review']) ?>"</p>
                    </div>

                    <div class="card-foot">
                        <span class="time-stamp">
                            <i class="far fa-clock"></i> 
                            <?= date('d M Y', strtotime($value['created_at'] ?? 'now')) ?>
                        </span>
                        <span class="verify-tag">
                            <i class="fas fa-check-double"></i> Verified
                        </span>
                    </div>
                </div>
            </div>
            <?php
                    }
                }
            ?>
        </div>

        <!-- CTA -->
        <div class="row justify-content-center mt-5 pt-4">
            <div class="col-lg-6 text-center">
                <div class="cta-card">
                    <div class="cta-inner">
                        <h4>Ingin Berbagi Pengalaman?</h4>
                        <p>Ulasan Anda sangat berarti bagi perkembangan layanan kami</p>
                        <a href="frontend/page-register.php" class="btn-main">
                            <span class="btn-text">Tulis Ulasan Sekarang</span>
                            <span class="btn-icon"><i class="fas fa-arrow-right"></i></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* ============ REVIEW SECTION - PREMIUM DARK ============ */
.review-section {
    padding: 120px 0;
    background: #131f33;
    position: relative;
    overflow: hidden;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
}

/* Animated Background Shapes */
.review-bg {
    position: absolute;
    inset: 0;
    overflow: hidden;
    pointer-events: none;
}

.bg-shape {
    position: absolute;
    border-radius: 50%;
    filter: blur(100px);
    opacity: 0.15;
    animation: floatShape 20s ease-in-out infinite;
}

.shape-1 {
    width: 600px;
    height: 600px;
    background: #6366f1;
    top: -200px;
    left: -100px;
    animation-delay: 0s;
}

.shape-2 {
    width: 400px;
    height: 400px;
    background: #ec4899;
    bottom: -100px;
    right: -50px;
    animation-delay: -7s;
}

.shape-3 {
    width: 300px;
    height: 300px;
    background: #8b5cf6;
    top: 50%;
    left: 50%;
    animation-delay: -14s;
}

@keyframes floatShape {
    0%, 100% { transform: translate(0, 0) scale(1); }
    33% { transform: translate(30px, -50px) scale(1.1); }
    66% { transform: translate(-20px, 20px) scale(0.9); }
}

/* Header */
.review-header {
    margin-bottom: 70px;
    position: relative;
    z-index: 1;
}

.badge-label {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: rgba(99, 102, 241, 0.15);
    border: 1px solid rgba(99, 102, 241, 0.3);
    color: #818cf8;
    padding: 10px 24px;
    border-radius: 50px;
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 25px;
}

.badge-label i {
    font-size: 16px;
}

.main-heading {
    font-size: 3.2rem;
    font-weight: 800;
    color: #f0f6fc;
    margin-bottom: 18px;
    line-height: 1.2;
}

.main-heading .highlight {
    background: linear-gradient(135deg, #6366f1, #ec4899);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.sub-text {
    font-size: 1.15rem;
    color: #8b949e;
    max-width: 500px;
    margin: 0 auto;
    line-height: 1.7;
}

/* Review Cards */
.review-card {
    background: #161b22;
    border: 1px solid #30363d;
    border-radius: 24px;
    padding: 32px;
    height: 100%;
    position: relative;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    z-index: 1;
}

.review-card:hover {
    transform: translateY(-8px);
    border-color: var(--accent-color);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4), 
                0 0 0 1px var(--accent-color),
                0 0 60px -10px var(--accent-color);
}

.card-accent {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 4px;
    background: var(--accent-color);
    opacity: 0.7;
    transition: opacity 0.3s;
}

.review-card:hover .card-accent {
    opacity: 1;
}

/* Card Top */
.card-top {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 24px;
}

.user-block {
    display: flex;
    align-items: center;
    gap: 14px;
}

.user-img {
    width: 52px;
    height: 52px;
    border-radius: 16px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 8px 20px rgba(0,0,0,0.3);
}

.user-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.user-img span {
    color: #fff;
    font-size: 18px;
    font-weight: 700;
}

.user-meta h6 {
    color: #f0f6fc;
    font-size: 1rem;
    font-weight: 700;
    margin: 0 0 4px 0;
}

.role-tag {
    font-size: 12px;
    color: #8b949e;
    background: rgba(139, 148, 158, 0.15);
    padding: 4px 12px;
    border-radius: 20px;
    font-weight: 500;
}

.quote-mark {
    width: 40px;
    height: 40px;
    background: rgba(99, 102, 241, 0.1);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6366f1;
    font-size: 16px;
    transition: all 0.3s;
}

.review-card:hover .quote-mark {
    background: var(--accent-color);
    color: #fff;
    transform: rotate(-10deg);
}

/* Card Body */
.star-row {
    display: flex;
    align-items: center;
    gap: 4px;
    margin-bottom: 16px;
}

.star-row .fa-star {
    font-size: 14px;
    color: #30363d;
    transition: all 0.3s;
}

.star-row .fa-star.on {
    color: #fbbf24;
    text-shadow: 0 0 8px rgba(251, 191, 36, 0.4);
}

.score {
    margin-left: 8px;
    font-size: 13px;
    color: #8b949e;
    font-weight: 700;
}

.review-words {
    font-size: 15px;
    line-height: 1.8;
    color: #c9d1d9;
    margin: 0;
    font-style: italic;
}

/* Card Foot */
.card-foot {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 24px;
    padding-top: 20px;
    border-top: 1px solid #21262d;
}

.time-stamp {
    font-size: 12px;
    color: #484f58;
    display: flex;
    align-items: center;
    gap: 6px;
}

.verify-tag {
    font-size: 12px;
    color: #3fb950;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 6px;
}

.verify-tag i {
    font-size: 14px;
}

/* CTA Card */
.cta-card {
    background: linear-gradient(135deg, #161b22 0%, #1c2128 100%);
    border: 1px solid #30363d;
    border-radius: 24px;
    padding: 50px 40px;
    position: relative;
    overflow: hidden;
}

.cta-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 3px;
    background: linear-gradient(90deg, #6366f1, #ec4899, #8b5cf6);
    background-size: 200% 100%;
    animation: gradientMove 3s ease infinite;
}

@keyframes gradientMove {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
}

.cta-inner {
    position: relative;
    z-index: 1;
}

.cta-inner h4 {
    color: #f0f6fc;
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 10px;
}

.cta-inner p {
    color: #8b949e;
    margin-bottom: 30px;
    font-size: 1rem;
}

.btn-main {
    display: inline-flex;
    align-items: center;
    gap: 0;
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
    color: #fff;
    padding: 0;
    border-radius: 50px;
    font-weight: 700;
    font-size: 15px;
    text-decoration: none;
    overflow: hidden;
    transition: all 0.4s;
    box-shadow: 0 10px 30px rgba(99, 102, 241, 0.3);
    border: none;
}

.btn-main:hover {
    transform: translateY(-3px);
    box-shadow: 0 20px 40px rgba(99, 102, 241, 0.5);
    color: #fff;
    text-decoration: none;
}

.btn-text {
    padding: 16px 28px;
}

.btn-icon {
    background: rgba(255,255,255,0.15);
    padding: 16px 20px;
    border-left: 1px solid rgba(255,255,255,0.1);
    transition: all 0.3s;
}

.btn-main:hover .btn-icon {
    background: rgba(255,255,255,0.25);
}

.btn-icon i {
    transition: transform 0.3s;
}

.btn-main:hover .btn-icon i {
    transform: translateX(4px);
}

/* Responsive */
@media (max-width: 991px) {
    .main-heading {
        font-size: 2.4rem;
    }
    
    .review-card {
        padding: 28px;
    }
}

@media (max-width: 576px) {
    .review-section {
        padding: 80px 0;
    }
    
    .main-heading {
        font-size: 1.8rem;
    }
    
    .review-card {
        padding: 24px;
    }
    
    .cta-card {
        padding: 35px 25px;
    }
}
</style>