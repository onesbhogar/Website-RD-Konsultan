<?php
// ============================================
// QUALITY - Dokumentasi Proyek (Kualitas)
// Background: #1a1a2e
// ============================================

if (!isset($db)) {
    if (file_exists('backend/db.php')) {
        require 'backend/db.php';
    } elseif (file_exists('../backend/db.php')) {
        require '../backend/db.php';
    }
}

$select = "SELECT * FROM quality_menu WHERE status = 1 ORDER BY main_category ASC, sub_category ASC, sort_order ASC, id ASC";
$query = mysqli_query($db, $select);

$menuItems = [];
while ($value = mysqli_fetch_assoc($query)) {
    $mainCat = $value['main_category'];
    $subCat = $value['sub_category'];
    
    if (!isset($menuItems[$mainCat])) {
        $menuItems[$mainCat] = ['_direct' => [], '_subcats' => []];
    }
    
    if (empty($subCat)) {
        $menuItems[$mainCat]['_direct'][] = $value;
    } else {
        if (!isset($menuItems[$mainCat]['_subcats'][$subCat])) {
            $menuItems[$mainCat]['_subcats'][$subCat] = [];
        }
        $menuItems[$mainCat]['_subcats'][$subCat][] = $value;
    }
}
?>

<section id="quality" class="quality-section">
    <div class="container">
        
        <!-- Section Header -->
        <div class="section-header" data-aos="fade-up">
            <span class="section-badge">
                <i class="fas fa-award"></i>
                STANDAR KUALITAS
            </span>
            <h2 class="section-title">Dokumentasi Proyek</h2>
            <div class="section-line"></div>
            <p class="section-desc">
                Dokumentasi komprehensif setiap tahapan konstruksi untuk memastikan 
                transparansi dan kepuasan klien.
            </p>
        </div>

        <!-- Content Layout -->
        <div class="quality-layout" data-aos="fade-up" data-aos-delay="150">
            
            <!-- Left: Navigation -->
            <div class="quality-sidebar">
                <div class="sidebar-head">
                    <div class="head-icon">
                        <i class="fas fa-folder-tree"></i>
                    </div>
                    <div class="head-text">
                        <h5>Kategori</h5>
                        <span><?= count($menuItems) ?> kategori</span>
                    </div>
                </div>
                
                <div class="sidebar-body custom-scroll">
                    <?php 
                    $idx = 0;
                    foreach ($menuItems as $mainCategory => $data): 
                        $idx++;
                        $totalItems = count($data['_direct']) + array_sum(array_map('count', $data['_subcats']));
                        $isFirst = $idx === 1;
                        $catIcon = match(true) {
                            str_contains($mainCategory, 'Persiapan') => 'fa-map-marked-alt',
                            str_contains($mainCategory, 'Dokumentasi') => 'fa-hard-hat',
                            str_contains($mainCategory, 'Pengendalian') => 'fa-clipboard-check',
                            str_contains($mainCategory, 'Material') => 'fa-cubes',
                            str_contains($mainCategory, 'Keselamatan') => 'fa-user-shield',
                            str_contains($mainCategory, 'Progress') => 'fa-chart-line',
                            default => 'fa-folder'
                        };
                        $cleanTitle = preg_replace('/^\d+\.\s*/', '', $mainCategory);
                    ?>
                    
                    <div class="cat-group <?= $isFirst ? 'open' : '' ?>">
                        <button class="cat-btn" onclick="toggleCat(this)">
                            <span class="btn-line"></span>
                            <span class="btn-icon"><i class="fas <?= $catIcon ?>"></i></span>
                            <span class="btn-label"><?= htmlspecialchars($cleanTitle) ?></span>
                            <span class="btn-count"><?= $totalItems ?></span>
                            <i class="fas fa-chevron-down btn-arrow"></i>
                        </button>
                        
                        <div class="cat-content">
                            <?php foreach ($data['_direct'] as $item): ?>
                            <a href="frontend/quality-detail.php?id=<?= $item['id'] ?>" 
                               class="item-link"
                               data-id="<?= $item['id'] ?>"
                               data-img="<?= htmlspecialchars($item['image']) ?>"
                               data-title="<?= htmlspecialchars($item['title']) ?>"
                               data-desc="<?= htmlspecialchars($item['description']) ?>"
                               onmouseenter="showItemPreview(this)"
                               onmouseleave="hideItemPreviewDelay()">
                                <span class="link-bullet"></span>
                                <span class="link-name"><?= htmlspecialchars($item['title']) ?></span>
                                <i class="fas fa-arrow-right link-go"></i>
                            </a>
                            <?php endforeach; ?>
                            
                            <?php foreach ($data['_subcats'] as $subCategory => $subItems): ?>
                            <div class="sub-wrap">
                                <span class="sub-title"><?= htmlspecialchars($subCategory) ?></span>
                                <?php foreach ($subItems as $subItem): ?>
                                <a href="frontend/quality-detail.php?id=<?= $subItem['id'] ?>" 
                                   class="item-link sub-item"
                                   data-id="<?= $subItem['id'] ?>"
                                   data-img="<?= htmlspecialchars($subItem['image']) ?>"
                                   data-title="<?= htmlspecialchars($subItem['title']) ?>"
                                   data-desc="<?= htmlspecialchars($subItem['description']) ?>"
                                   onmouseenter="showItemPreview(this)"
                                   onmouseleave="hideItemPreviewDelay()">
                                    <span class="link-bullet"></span>
                                    <span class="link-name"><?= htmlspecialchars($subItem['title']) ?></span>
                                    <i class="fas fa-arrow-right link-go"></i>
                                </a>
                                <?php endforeach; ?>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- Right: Preview Stage -->
            <div class="quality-display">
                
                <!-- Default State -->
                <div class="display-default" id="displayDefault">
                    <div class="default-bg">
                        <img src="img/quality/IFTK_170.jpg" alt="Default" id="defaultBgImg">
                        <div class="default-overlay"></div>
                    </div>
                    <div class="default-content">
                        <div class="default-icon">
                            <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="8" y="12" width="48" height="40" rx="4" stroke="currentColor" stroke-width="2"/>
                                <circle cx="24" cy="28" r="6" stroke="currentColor" stroke-width="2"/>
                                <path d="M8 44L22 30L34 42L44 32L56 44" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <h3>Dokumentasi Proyek</h3>
                        <p>Pilih kategori untuk melihat preview</p>
                    </div>
                </div>
                
                <!-- Active Preview -->
                <div class="display-active" id="displayActive">
                    <div class="active-image-wrap">
                        <img src="" alt="Preview" id="activeImage">
                        <div class="image-loader" id="imageLoader">
                            <div class="loader-spin"></div>
                        </div>
                    </div>
                    <div class="active-info">
                        <div class="info-tag">
                            <i class="fas fa-camera"></i>
                            <span>Dokumentasi</span>
                        </div>
                        <h4 id="activeTitle"></h4>
                        <p id="activeDesc"></p>
                        <a href="" class="info-btn" id="activeBtn">
                            <span>Lihat Detail Lengkap</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                
            </div>

        </div>
    </div>
</section>

<style>
/* ============================================
   QUALITY - BACKGROUND #1d1d48
   ============================================ */

.quality-section {
    background: #131f33;
    padding: 100px 0 120px;
    position: relative;
}

.quality-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: rgba(255,255,255,0.06);
}

/* --- Header --- */
.section-header {
    text-align: center;
    max-width: 600px;
    margin: 0 auto 70px;
}

.section-badge {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 10px 22px;
    background: rgba(40,167,69,0.1);
    border: 1px solid rgba(40,167,69,0.2);
    border-radius: 50px;
    color: #28a745;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 2px;
    text-transform: uppercase;
    margin-bottom: 24px;
}

.section-title {
    color: #fff;
    font-size: 40px;
    font-weight: 700;
    margin-bottom: 16px;
    letter-spacing: -0.5px;
}

.section-line {
    width: 60px;
    height: 3px;
    background: #28a745;
    border-radius: 3px;
    margin: 0 auto 20px;
}

.section-desc {
    color: #8899a6;
    font-size: 16px;
    line-height: 1.7;
}

/* --- Layout --- */
.quality-layout {
    display: grid;
    grid-template-columns: 360px 1fr;
    gap: 30px;
    max-width: 1200px;
    margin: 0 auto;
}

/* --- Sidebar --- */
.quality-sidebar {
    background: #1a1a2e;
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 20px;
    overflow: hidden;
    height: fit-content;
    position: sticky;
    top: 100px;
}

.sidebar-head {
    padding: 24px 24px 20px;
    display: flex;
    align-items: center;
    gap: 14px;
    border-bottom: 1px solid rgba(255,255,255,0.08);
}

.head-icon {
    width: 44px;
    height: 44px;
    background: #28a745;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 18px;
    box-shadow: 0 6px 16px rgba(40,167,69,0.25);
}

.head-text h5 {
    color: #fff;
    font-size: 16px;
    font-weight: 600;
    margin: 0 0 3px;
}

.head-text span {
    color: #8899a6;
    font-size: 12px;
}

.sidebar-body {
    padding: 12px;
    max-height: 580px;
    overflow-y: auto;
}

.custom-scroll::-webkit-scrollbar {
    width: 5px;
}

.custom-scroll::-webkit-scrollbar-track {
    background: transparent;
}

.custom-scroll::-webkit-scrollbar-thumb {
    background: rgba(255,255,255,0.1);
    border-radius: 10px;
}

/* --- Category Group --- */
.cat-group {
    margin-bottom: 4px;
}

.cat-btn {
    width: 100%;
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 13px 14px;
    background: transparent;
    border: none;
    border-radius: 12px;
    color: #8899a6;
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    text-align: left;
}

.cat-btn:hover {
    background: rgba(255,255,255,0.04);
    color: #fff;
}

.cat-group.open .cat-btn {
    background: rgba(40,167,69,0.1);
    color: #fff;
}

.btn-line {
    width: 3px;
    height: 18px;
    border-radius: 2px;
    background: transparent;
    transition: background 0.3s;
    flex-shrink: 0;
}

.cat-group.open .btn-line {
    background: #28a745;
}

.btn-icon {
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255,255,255,0.05);
    border-radius: 8px;
    font-size: 12px;
    color: #8899a6;
    transition: all 0.3s;
    flex-shrink: 0;
}

.cat-group.open .btn-icon {
    background: rgba(40,167,69,0.15);
    color: #28a745;
}

.btn-label {
    flex: 1;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.btn-count {
    padding: 2px 8px;
    background: rgba(255,255,255,0.06);
    border-radius: 10px;
    font-size: 10px;
    font-weight: 600;
    color: #8899a6;
    min-width: 22px;
    text-align: center;
    flex-shrink: 0;
}

.cat-group.open .btn-count {
    background: rgba(40,167,69,0.15);
    color: #28a745;
}

.btn-arrow {
    font-size: 10px;
    color: #8899a6;
    transition: all 0.3s;
    flex-shrink: 0;
}

.cat-group.open .btn-arrow {
    transform: rotate(180deg);
    color: #28a745;
}

/* --- Category Content --- */
.cat-content {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.cat-group.open .cat-content {
    max-height: 600px;
}

/* --- Item Links --- */
.item-link {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 12px 10px 42px;
    margin: 2px 6px;
    border-radius: 10px;
    color: #8899a6;
    font-size: 12px;
    text-decoration: none;
    transition: all 0.25s ease;
}

.item-link:hover {
    background: rgba(40,167,69,0.08);
    color: #fff;
}

.item-link.active {
    background: rgba(40,167,69,0.12);
    color: #28a745;
}

.link-bullet {
    width: 5px;
    height: 5px;
    border-radius: 50%;
    background: rgba(255,255,255,0.15);
    transition: all 0.25s;
    flex-shrink: 0;
}

.item-link:hover .link-bullet,
.item-link.active .link-bullet {
    background: #28a745;
    box-shadow: 0 0 6px rgba(40,167,69,0.4);
}

.link-name {
    flex: 1;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.link-go {
    font-size: 9px;
    opacity: 0;
    transform: translateX(-4px);
    transition: all 0.25s;
    flex-shrink: 0;
}

.item-link:hover .link-go,
.item-link.active .link-go {
    opacity: 1;
    transform: translateX(0);
}

/* --- Sub Wrap --- */
.sub-wrap {
    margin: 6px 6px 8px;
    padding: 8px 0;
    border-left: 2px solid rgba(255,255,255,0.06);
}

.sub-title {
    display: block;
    padding: 0 0 6px 36px;
    color: #8899a6;
    font-size: 10px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    opacity: 0.5;
}

.sub-item {
    padding-left: 36px;
}

/* --- Display Area --- */
.quality-display {
    background: #1a1a2e;
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 20px;
    overflow: hidden;
    position: relative;
    min-height: 580px;
}

/* Default State */
.display-default {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: opacity 0.5s ease, visibility 0.5s;
}

.display-default.hidden {
    opacity: 0;
    visibility: hidden;
}

.default-bg {
    position: absolute;
    inset: 0;
}

.default-bg img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    opacity: 0.15;
}

.default-overlay {
    position: absolute;
    inset: 0;
    background: #1a1a2e;
    opacity: 0.9;
}

.default-content {
    position: relative;
    text-align: center;
    z-index: 2;
}

.default-icon {
    width: 72px;
    height: 72px;
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 24px;
    color: #8899a6;
}

.default-icon svg {
    width: 32px;
    height: 32px;
}

.default-content h3 {
    color: rgba(255,255,255,0.7);
    font-size: 22px;
    font-weight: 600;
    margin-bottom: 8px;
}

.default-content p {
    color: #8899a6;
    font-size: 14px;
}

/* Active State */
.display-active {
    position: absolute;
    inset: 0;
    display: flex;
    flex-direction: column;
    opacity: 0;
    visibility: hidden;
    transform: translateY(10px);
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}

.display-active.visible {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

/* Image Wrap */
.active-image-wrap {
    position: relative;
    height: 320px;
    background: #1a1a2e;
    overflow: hidden;
}

.active-image-wrap img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    padding: 20px;
    transition: transform 0.6s ease;
}

.display-active:hover .active-image-wrap img {
    transform: scale(1.02);
}

.image-loader {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #1a1a2e;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s;
}

.image-loader.loading {
    opacity: 1;
    visibility: visible;
}

.loader-spin {
    width: 36px;
    height: 36px;
    border: 2px solid rgba(255,255,255,0.1);
    border-top-color: #28a745;
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* Info Panel */
.active-info {
    flex: 1;
    padding: 32px 36px;
    background: #1a1a2e;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.info-tag {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    align-self: flex-start;
    padding: 6px 14px;
    background: rgba(40,167,69,0.1);
    border: 1px solid rgba(40,167,69,0.2);
    border-radius: 20px;
    color: #28a745;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 1px;
    text-transform: uppercase;
    margin-bottom: 16px;
}

.active-info h4 {
    color: #fff;
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 10px;
    line-height: 1.3;
}

.active-info p {
    color: #8899a6;
    font-size: 14px;
    line-height: 1.7;
    margin-bottom: 24px;
    max-width: 480px;
}

.info-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    align-self: flex-start;
    padding: 13px 28px;
    background: #28a745;
    color: #fff;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 6px 20px rgba(40,167,69,0.25);
}

.info-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 28px rgba(40,167,69,0.35);
    color: #fff;
}

.info-btn i {
    font-size: 11px;
    transition: transform 0.3s;
}

.info-btn:hover i {
    transform: translateX(3px);
}

/* --- Responsive --- */
@media (max-width: 1199px) {
    .quality-layout {
        grid-template-columns: 320px 1fr;
    }
    
    .active-image-wrap {
        height: 280px;
    }
}

@media (max-width: 991px) {
    .quality-section {
        padding: 70px 0 90px;
    }
    
    .section-title {
        font-size: 32px;
    }
    
    .quality-layout {
        grid-template-columns: 1fr;
        max-width: 600px;
    }
    
    .quality-sidebar {
        position: static;
        max-height: 450px;
    }
    
    .quality-display {
        min-height: 500px;
    }
    
    .active-image-wrap {
        height: 260px;
    }
    
    .active-info {
        padding: 24px;
    }
    
    .active-info h4 {
        font-size: 20px;
    }
}

@media (max-width: 576px) {
    .section-title {
        font-size: 26px;
    }
    
    .section-badge {
        font-size: 11px;
        padding: 8px 16px;
    }
    
    .active-image-wrap {
        height: 220px;
    }
    
    .active-image-wrap img {
        padding: 12px;
    }
    
    .active-info {
        padding: 20px;
    }
    
    .active-info h4 {
        font-size: 18px;
    }
    
    .info-btn {
        width: 100%;
        justify-content: center;
    }
}
</style>

<script>
// ============================================
// QUALITY INTERACTIONS
// ============================================

let activeId = null;
let hideTimer = null;

const displayDefault = document.getElementById('displayDefault');
const displayActive = document.getElementById('displayActive');
const activeImage = document.getElementById('activeImage');
const activeTitle = document.getElementById('activeTitle');
const activeDesc = document.getElementById('activeDesc');
const activeBtn = document.getElementById('activeBtn');
const imageLoader = document.getElementById('imageLoader');

// Toggle category
function toggleCat(btn) {
    const group = btn.closest('.cat-group');
    const isOpen = group.classList.contains('open');
    
    document.querySelectorAll('.cat-group').forEach(g => g.classList.remove('open'));
    
    if (!isOpen) {
        group.classList.add('open');
    }
}

// Show preview
function showItemPreview(el) {
    clearTimeout(hideTimer);
    
    const id = el.dataset.id;
    const img = el.dataset.img;
    const title = el.dataset.title;
    const desc = el.dataset.desc;
    
    // Highlight
    document.querySelectorAll('.item-link').forEach(l => l.classList.remove('active'));
    el.classList.add('active');
    
    // Show loader
    imageLoader.classList.add('loading');
    
    // Update content
    activeImage.src = 'img/quality/' + (img || 'IFTK_170.jpg');
    activeTitle.textContent = title;
    activeDesc.textContent = desc || 'Dokumentasi lengkap tersedia di halaman detail.';
    activeBtn.href = 'frontend/quality-detail.php?id=' + id;
    activeId = id;
    
    // Handle image load
    activeImage.onload = function() {
        imageLoader.classList.remove('loading');
    };
    
    // Switch display
    displayDefault.classList.add('hidden');
    displayActive.classList.add('visible');
}

// Delayed hide
function hideItemPreviewDelay() {
    clearTimeout(hideTimer);
}

// Keep active on display hover
document.getElementById('displayActive').addEventListener('mouseenter', function() {
    clearTimeout(hideTimer);
});
</script>