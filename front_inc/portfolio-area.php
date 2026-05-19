<?php
// Portfolio Area - Front End Display
// File: front_inc/portfolio-area.php

// Get all categories for filter
$cat_query = "SELECT DISTINCT catagory FROM portfolio ORDER BY catagory ASC";
$cat_result = mysqli_query($db, $cat_query);

// Get portfolio items
if (isset($_GET['category']) && !empty($_GET['category'])) {
    $category = mysqli_real_escape_string($db, $_GET['category']);
    $port_query = "SELECT * FROM portfolio WHERE catagory = '$category' ORDER BY id DESC";
} else {
    $port_query = "SELECT * FROM portfolio ORDER BY id DESC";
}
$port_result = mysqli_query($db, $port_query);
?>

<section id="portfolio" class="portfolio-area primary-bg pt-120 pb-90">
    <div class="container">
        <!-- Section Title -->
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-8">
                <div class="section-title text-center mb-70">
                    <span>PORTOFOLIO PROYEK</span>
                    <h2>Proyek Yang Telah Dikerjakan</h2>
                    <p class="mt-20">Berikut adalah beberapa proyek yang pernah dikerjakan dalam berbagai kategori bangunan.</p>
                </div>
            </div>
        </div>

        <!-- Filter Buttons -->
        <div class="row">
            <div class="col-12">
                <div class="portfolio-filter text-center mb-50">
                    <a href="index.php#portfolio" class="filter-btn <?= !isset($_GET['category']) ? 'active' : '' ?>">Semua</a>
                    <?php 
                    $categories = ['Rumah', 'Kantor', 'Restoran', 'Kampus', 'Hotel', 'Sekolah'];
                    foreach ($categories as $cat): 
                        $active = (isset($_GET['category']) && $_GET['category'] == $cat) ? 'active' : '';
                    ?>
                        <a href="index.php?category=<?= urlencode($cat) ?>#portfolio" class="filter-btn <?= $active ?>"><?= $cat ?></a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Portfolio Grid (3 kolom) -->
        <div class="row portfolio-grid">
            <?php 
            if (mysqli_num_rows($port_result) > 0):
                foreach ($port_result as $item): 
            ?>
            <div class="col-lg-4 col-md-6 portfolio-item mb-30" data-category="<?= strtolower($item['catagory']) ?>">
                <div class="portfolio-box">
                    <div class="portfolio-image">
                        <img src="img/portfolio/<?= $item['img'] ?>" alt="<?= htmlspecialchars($item['heading']) ?>" class="img-fluid">
                        <div class="portfolio-overlay">
                            <div class="portfolio-content">
                                <span class="category"><?= $item['catagory'] ?></span>
                                <h4><?= htmlspecialchars($item['heading']) ?></h4>
                                <a href="frontend/portfolio-detail.php?slug=<?= $item['slug'] ?>" class="btn btn-sm btn-success">Lihat Selengkapnya →</a>
                            </div>
                        </div>
                    </div>
                    <div class="portfolio-info">
                        <p class="description"><?= htmlspecialchars(substr($item['description'], 0, 120)) ?>...</p>
                        <div class="project-meta">
                            <span><i class="fas fa-map-marker-alt"></i> <?= $item['location'] ?? 'Maumere' ?></span>
                            <span><i class="fas fa-calendar"></i> <?= $item['year'] ?? '2023' ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
                endforeach;
            else:
            ?>
            <div class="col-12 text-center">
                <p>Belum ada proyek dalam kategori ini.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<style>
.portfolio-filter {
    margin-bottom: 40px;
}
.portfolio-filter .filter-btn {
    display: inline-block;
    padding: 8px 20px;
    margin: 0 5px 10px;
    background: transparent;
    border: 2px solid #28a745;
    color: #fff;
    text-decoration: none;
    border-radius: 25px;
    transition: all 0.3s ease;
    font-size: 14px;
    text-transform: uppercase;
}
.portfolio-filter .filter-btn:hover,
.portfolio-filter .filter-btn.active {
    background: #28a745;
    color: #fff;
}
.portfolio-box {
    position: relative;
    overflow: hidden;
    border-radius: 10px;
    background: #1a1a2e;
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
}
.portfolio-image {
    position: relative;
    overflow: hidden;
    height: 250px;
}
.portfolio-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}
.portfolio-box:hover .portfolio-image img {
    transform: scale(1.1);
}
.portfolio-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.8);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}
.portfolio-box:hover .portfolio-overlay {
    opacity: 1;
}
.portfolio-content {
    text-align: center;
    padding: 20px;
}
.portfolio-content .category {
    color: #28a745;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 2px;
}
.portfolio-content h4 {
    color: #fff;
    margin: 10px 0 20px;
    font-size: 20px;
}
.portfolio-info {
    padding: 20px;
}
.portfolio-info .description {
    color: #aaa;
    font-size: 14px;
    margin-bottom: 15px;
}
.project-meta {
    display: flex;
    justify-content: space-between;
    color: #28a745;
    font-size: 12px;
}
.project-meta i {
    margin-right: 5px;
}
</style>