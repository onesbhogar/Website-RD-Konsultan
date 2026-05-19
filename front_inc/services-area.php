<?php 
    // Selecting data from service_section table
    $select = "SELECT * FROM service_section";
    $query = mysqli_query($db, $select);
    $service = mysqli_fetch_assoc($query);

    // Selecting data from services table
    $sel = "SELECT * FROM services";
    $q = mysqli_query($db, $sel);
?>

<section id="service" class="services-section">
    <div class="services-bg">
        <div class="bg-shape shape-1"></div>
        <div class="bg-shape shape-2"></div>
    </div>

    <div class="container position-relative">
        <!-- Section Header -->
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="section-header">
                    <span class="section-badge">
                        <i class="fas fa-cogs"></i>
                        <?= htmlspecialchars($service['short_title'] ?? 'Layanan') ?>
                    </span>
                    <h2 class="section-title"><?= htmlspecialchars($service['head_title'] ?? 'Layanan Kami') ?></h2>
                    <div class="title-line"></div>
                </div>
            </div>
        </div>

        <!-- Services Grid -->
        <div class="row g-4">
            <?php 
                foreach ($q as $key => $value) {
                    $icon_colors = ['#6366f1', '#ec4899', '#8b5cf6', '#10b981', '#f59e0b', '#3b82f6'];
                    $icon_color = $icon_colors[$key % count($icon_colors)];
            ?>
            <div class="col-lg-4 col-md-6">
                <a href="service-detail.php?slug=<?= urlencode($value['slug']) ?>" class="service-card">
                    <div class="service-inner" style="--accent-color: <?= $icon_color ?>">
                        <div class="service-icon">
                            <div class="icon-bg" style="background: <?= $icon_color ?>15"></div>
                            <i class="<?= htmlspecialchars($value['img']) ?>" style="color: <?= $icon_color ?>"></i>
                        </div>
                        <div class="service-content">
                            <h3><?= htmlspecialchars($value['heading']) ?></h3>
                            <p><?= htmlspecialchars($value['description']) ?></p>
                            <span class="service-arrow">
                                Selengkapnya <i class="fas fa-arrow-right"></i>
                            </span>
                        </div>
                    </div>
                </a>
            </div>
            <?php } ?>
        </div>
    </div>
</section>

<style>
/* ===== SERVICES SECTION - ELEGANT ===== */
.services-section {
    position: relative;
    padding: 120px 0;
    background: #131f33;
    overflow: hidden;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
}

.services-bg {
    position: absolute;
    inset: 0;
    pointer-events: none;
    overflow: hidden;
}

.bg-shape {
    position: absolute;
    border-radius: 50%;
    filter: blur(120px);
    opacity: 0.08;
}

.shape-1 {
    width: 500px;
    height: 500px;
    background: #6366f1;
    top: -200px;
    left: -100px;
}

.shape-2 {
    width: 400px;
    height: 400px;
    background: #ec4899;
    bottom: -150px;
    right: -100px;
}

/* Section Header */
.section-header {
    margin-bottom: 70px;
    position: relative;
    z-index: 1;
}

.section-badge {
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
    text-transform: uppercase;
    margin-bottom: 24px;
}

.section-badge i {
    font-size: 14px;
}

.section-title {
    font-size: 2.8rem;
    font-weight: 800;
    color: #f8fafc;
    margin-bottom: 20px;
    line-height: 1.2;
    letter-spacing: -0.02em;
}

.title-line {
    width: 60px;
    height: 4px;
    background: linear-gradient(90deg, #6366f1, #ec4899);
    border-radius: 2px;
    margin: 0 auto;
}

/* Service Card */
.service-card {
    text-decoration: none;
    color: inherit;
    display: block;
    position: relative;
    z-index: 1;
}

.service-inner {
    background: rgba(30, 41, 59, 0.6);
    border: 1px solid rgba(148, 163, 184, 0.1);
    border-radius: 24px;
    padding: 40px 35px;
    position: relative;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    height: 100%;
}

.service-inner::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 3px;
    background: var(--accent-color);
    opacity: 0.7;
    transition: opacity 0.3s;
}

.service-card:hover .service-inner {
    transform: translateY(-8px);
    border-color: rgba(99, 102, 241, 0.2);
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
}

.service-card:hover .service-inner::before {
    opacity: 1;
}

/* Service Icon */
.service-icon {
    position: relative;
    width: 70px;
    height: 70px;
    margin-bottom: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.icon-bg {
    position: absolute;
    inset: 0;
    border-radius: 20px;
    transition: all 0.4s ease;
}

.service-card:hover .icon-bg {
    transform: scale(1.1) rotate(-5deg);
    opacity: 0.3;
}

.service-icon i {
    position: relative;
    font-size: 28px;
    z-index: 2;
    transition: transform 0.3s;
}

.service-card:hover .service-icon i {
    transform: scale(1.15);
}

/* Service Content */
.service-content h3 {
    font-size: 1.25rem;
    font-weight: 700;
    color: #f8fafc;
    margin-bottom: 16px;
    line-height: 1.4;
}

.service-content p {
    font-size: 14px;
    color: #94a3b8;
    line-height: 1.8;
    margin-bottom: 24px;
}

.service-arrow {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    font-size: 13px;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: all 0.3s ease;
}

.service-arrow i {
    font-size: 11px;
    transition: transform 0.3s;
}

.service-card:hover .service-arrow {
    color: var(--accent-color);
}

.service-card:hover .service-arrow i {
    transform: translateX(6px);
}

/* Responsive */
@media (max-width: 991px) {
    .services-section {
        padding: 80px 0;
    }
    
    .section-title {
        font-size: 2.2rem;
    }
}

@media (max-width: 768px) {
    .service-inner {
        padding: 30px 25px;
    }
    
    .section-title {
        font-size: 1.8rem;
    }
}
</style>