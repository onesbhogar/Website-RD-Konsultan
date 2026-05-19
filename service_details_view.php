<?php include 'inc/header.php';

    require 'backend/db.php';
    
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        $_SESSION['error'] = "ID detail layanan tidak ditemukan!";
        header("Location: service_details.php");
        exit;
    }
    
    $id = intval($_GET['id']);
    $query = "SELECT sd.*, s.heading as service_name, s.img as service_icon 
              FROM service_details sd 
              LEFT JOIN services s ON sd.service_id = s.id 
              WHERE sd.id = $id";
    $result = mysqli_query($db, $query);
    
    if (mysqli_num_rows($result) == 0) {
        $_SESSION['error'] = "Data detail layanan tidak ditemukan!";
        header("Location: service_details.php");
        exit;
    }
    
    $data = mysqli_fetch_assoc($result);
    
    // Ambil list items
    $lists = mysqli_query($db, "SELECT * FROM service_lists WHERE service_detail_id = $id ORDER BY sort_order ASC");
    
    // Ambil data section
    $sectionResult = mysqli_query($db, "SELECT * FROM service_section LIMIT 1");
    $sectionData = mysqli_fetch_assoc($sectionResult);
?>
        <!-- ========== Left Sidebar Start ========== -->
      <?php include 'inc/sidebar.php' ?>
        <!-- Left Sidebar End -->
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
            <!-- Top Bar start -->
            <?php include 'inc/topbar.php' ?>
            <!-- Top Bar End -->
            <!-- Start Page content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card-box">
                                <div class="jumbotron text-center">
                                    <h2>Lihat Detail Layanan</h2>
                                </div>
                                
                                <div class="row justify-content-center">
                                    <div class="col-md-10">
                                        <div class="card shadow">
                                            <div class="card-header bg-primary text-white text-center">
                                                <h3 class="mb-0">
                                                    <?php if ($data['service_icon']): ?>
                                                        <i class="<?php echo $data['service_icon']; ?> mr-2"></i>
                                                    <?php endif; ?>
                                                    <?php echo htmlspecialchars($data['service_name'] ?: 'Layanan #' . $data['service_id']); ?>
                                                </h3>
                                                <?php if ($sectionData): ?>
                                                    <small class="text-light"><?php echo htmlspecialchars($sectionData['short_title']); ?></small>
                                                <?php endif; ?>
                                            </div>
                                            <div class="card-body">
                                                <!-- Preview Layout -->
                                                <div class="mb-4">
                                                    <h5 class="text-muted mb-3 border-bottom pb-2">🎨 Preview Layout</h5>
                                                    
                                                    <?php if ($data['layout_type'] == 'text_left'): ?>
                                                        <!-- Layout: Text Kiri - Gambar Kanan -->
                                                        <div class="row align-items-center bg-light p-4 rounded">
                                                            <div class="col-md-7">
                                                                <h4 class="text-primary mb-3">Deskripsi</h4>
                                                                <p class="lead"><?php echo nl2br(htmlspecialchars($data['description'])); ?></p>
                                                                
                                                                <?php if (mysqli_num_rows($lists) > 0): ?>
                                                                <h5 class="mt-4 mb-2">📋 Detail Pekerjaan:</h5>
                                                                <ul class="list-group list-group-flush">
                                                                    <?php while ($list = mysqli_fetch_assoc($lists)): ?>
                                                                    <li class="list-group-item bg-transparent pl-0">
                                                                        <i class="fas fa-check-circle text-success mr-2"></i>
                                                                        <?php echo htmlspecialchars($list['list_item']); ?>
                                                                    </li>
                                                                    <?php endwhile; ?>
                                                                </ul>
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="col-md-5 text-center">
                                                                <?php if ($data['main_image']): ?>
                                                                    <img src="<?php echo $data['main_image']; ?>" class="img-fluid rounded shadow" style="max-height: 300px;">
                                                                <?php else: ?>
                                                                    <div class="bg-secondary text-white p-5 rounded">
                                                                        <i class="fas fa-image fa-3x mb-2"></i><br>
                                                                        Tidak ada gambar
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                        
                                                    <?php else: ?>
                                                        <!-- Layout: Gambar Kiri - Text Kanan -->
                                                        <div class="row align-items-center bg-light p-4 rounded">
                                                            <div class="col-md-5 text-center">
                                                                <?php if ($data['main_image']): ?>
                                                                    <img src="<?php echo $data['main_image']; ?>" class="img-fluid rounded shadow" style="max-height: 300px;">
                                                                <?php else: ?>
                                                                    <div class="bg-secondary text-white p-5 rounded">
                                                                        <i class="fas fa-image fa-3x mb-2"></i><br>
                                                                        Tidak ada gambar
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="col-md-7">
                                                                <h4 class="text-primary mb-3">Deskripsi</h4>
                                                                <p class="lead"><?php echo nl2br(htmlspecialchars($data['description'])); ?></p>
                                                                
                                                                <?php if (mysqli_num_rows($lists) > 0): ?>
                                                                <h5 class="mt-4 mb-2">📋 Detail Pekerjaan:</h5>
                                                                <ul class="list-group list-group-flush">
                                                                    <?php while ($list = mysqli_fetch_assoc($lists)): ?>
                                                                    <li class="list-group-item bg-transparent pl-0">
                                                                        <i class="fas fa-check-circle text-success mr-2"></i>
                                                                        <?php echo htmlspecialchars($list['list_item']); ?>
                                                                    </li>
                                                                    <?php endwhile; ?>
                                                                </ul>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                
                                                <hr>
                                                
                                                <!-- Informasi Detail -->
                                                <div class="row mb-4">
                                                    <div class="col-md-3 text-center">
                                                        <h6 class="text-muted">📋 Jenis Layout</h6>
                                                        <span class="badge badge-<?php echo $data['layout_type'] == 'text_left' ? 'info' : 'warning'; ?>" style="font-size: 13px; padding: 6px 12px;">
                                                            <?php echo $data['layout_type'] == 'text_left' ? 'Text Kiri - Gambar Kanan' : 'Gambar Kiri - Text Kanan'; ?>
                                                        </span>
                                                    </div>
                                                    <div class="col-md-3 text-center">
                                                        <h6 class="text-muted">📅 Dibuat</h6>
                                                        <p class="font-weight-bold mb-0"><?php echo date('d M Y', strtotime($data['created_at'])); ?></p>
                                                    </div>
                                                    <div class="col-md-3 text-center">
                                                        <h6 class="text-muted">🔄 Terakhir Update</h6>
                                                        <p class="font-weight-bold mb-0"><?php echo date('d M Y H:i', strtotime($data['updated_at'])); ?></p>
                                                    </div>
                                                    <div class="col-md-3 text-center">
                                                        <h6 class="text-muted">📊 List Items</h6>
                                                        <p class="font-weight-bold mb-0"><?php echo mysqli_num_rows($lists); ?> items</p>
                                                    </div>
                                                </div>
                                                
                                                <!-- Gambar Full Size -->
                                                <?php if ($data['main_image']): ?>
                                                <hr>
                                                <div class="mb-4">
                                                    <h5 class="text-muted mb-3 border-bottom pb-2">🖼️ Gambar Utama</h5>
                                                    <div class="text-center">
                                                        <img src="<?php echo $data['main_image']; ?>" class="img-fluid rounded shadow-lg" style="max-height: 400px;">
                                                        <p class="text-muted mt-2 small"><?php echo basename($data['main_image']); ?></p>
                                                    </div>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="card-footer text-center">
                                                <a href="service_details.php" class="btn btn-secondary mr-2">
                                                    ← Kembali
                                                </a>
                                                <a href="service_details.php?edit=<?php echo $data['id']; ?>" class="btn btn-warning mr-2">
                                                    ✏️ Edit
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- container -->
            </div> <!-- content -->

<?php include 'inc/copyright.php' ?>
<?php include 'inc/footer.php' ?>