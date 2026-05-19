<?php 
$db_file = 'backend/db.php';
if (!file_exists($db_file)) {
    echo "<!-- Error: File backend/db.php tidak ditemukan -->";
    return;
}

require $db_file;

if (!isset($db) || !$db) {
    echo "<!-- Error: Koneksi database gagal -->";
    return;
}

$select = "SELECT * FROM quality_commitment ORDER BY id DESC LIMIT 1";
$query = mysqli_query($db, $select);

if (!$query) {
    echo "<!-- Error: " . mysqli_error($db) . " -->";
    $quality = null;
} else {
    $quality = mysqli_fetch_assoc($query);
}
?>

<section class="quality-commitment-area pt-120 pb-120">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 order-2 order-lg-1">
                <div class="quality-img">
                    <?php 
                    $quality_img = isset($quality['image']) && !empty($quality['image']) ? 'img/about/' . $quality['image'] : 'img/about/default-quality.jpg';
                    if (file_exists($quality_img)) {
                        echo '<img src="' . $quality_img . '" alt="Quality Commitment" class="img-fluid">';
                    } else {
                        echo '<img src="img/about/default-quality.jpg" alt="Quality Commitment" class="img-fluid">';
                    }
                    ?>
                </div>
            </div>
            <div class="col-lg-6 order-1 order-lg-2">
                <div class="quality-content pl-30">
                    <div class="section-title mb-30">
                        <span>Komitmen Kualitas</span>
                        <h2><?php echo isset($quality['title']) && !empty($quality['title']) ? htmlspecialchars($quality['title']) : 'Komitmen Kualitas Kami'; ?></h2>
                    </div>
                    <p><?php echo isset($quality['description']) && !empty($quality['description']) ? nl2br(htmlspecialchars($quality['description'])) : 'Deskripsi komitmen kualitas belum tersedia.'; ?></p>
                    
                    <?php if(isset($quality['commitment_1']) && !empty($quality['commitment_1'])): ?>
                    <div class="quality-features mt-40">
                        
                        <?php if(!empty($quality['commitment_1'])): ?>
                        <div class="quality-item mb-20">
                            <div class="quality-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="quality-text">
                                <h5><?php echo htmlspecialchars($quality['commitment_1']); ?></h5>
                                <p><?php echo isset($quality['commitment_1_desc']) ? htmlspecialchars($quality['commitment_1_desc']) : ''; ?></p>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if(!empty($quality['commitment_2'])): ?>
                        <div class="quality-item mb-20">
                            <div class="quality-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="quality-text">
                                <h5><?php echo htmlspecialchars($quality['commitment_2']); ?></h5>
                                <p><?php echo isset($quality['commitment_2_desc']) ? htmlspecialchars($quality['commitment_2_desc']) : ''; ?></p>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if(!empty($quality['commitment_3'])): ?>
                        <div class="quality-item">
                            <div class="quality-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="quality-text">
                                <h5><?php echo htmlspecialchars($quality['commitment_3']); ?></h5>
                                <p><?php echo isset($quality['commitment_3_desc']) ? htmlspecialchars($quality['commitment_3_desc']) : ''; ?></p>
                            </div>
                        </div>
                        <?php endif; ?>

                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>