<?php include 'inc/header.php';

    require 'backend/db.php';
    
    // Ambil data untuk edit
    $editData = null;
    $editLists = [];
    if (isset($_GET['edit'])) {
        $id = intval($_GET['edit']);
        $result = mysqli_query($db, "SELECT * FROM service_details WHERE id = $id");
        $editData = mysqli_fetch_assoc($result);
        
        // Ambil list items untuk edit
        $listResult = mysqli_query($db, "SELECT * FROM service_lists WHERE service_detail_id = $id ORDER BY sort_order ASC");
        while ($list = mysqli_fetch_assoc($listResult)) {
            $editLists[] = $list;
        }
    }
    
    // Ambil semua data detail layanan dengan JOIN ke services
    $query = "SELECT sd.*, s.heading as service_name 
              FROM service_details sd 
              LEFT JOIN services s ON sd.service_id = s.id 
              ORDER BY sd.created_at DESC";
    $services = mysqli_query($db, $query);
    
    // Ambil daftar layanan untuk dropdown
    $serviceList = mysqli_query($db, "SELECT id, heading FROM services ORDER BY heading ASC");
    
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
                                    <h2>Detail Layanan - <?php echo $sectionData ? htmlspecialchars($sectionData['head_title']) : 'Overview'; ?></h2>
                                </div>
                                
                                <?php 
                                    if (isset($_SESSION['success'])) {
                                        ?>
                                        <div class="alert alert-success alert-dismissible" style="margin-top:10px;">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true" style="font-size:20px">×</span>
                                            </button>
                                            <strong><?php echo $_SESSION['success']; ?></strong>
                                        </div>
                                        <?php
                                        unset($_SESSION['success']);
                                    }
                                    
                                    if (isset($_SESSION['error'])) {
                                        ?>
                                        <div class="alert alert-danger alert-dismissible" style="margin-top:10px;">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true" style="font-size:20px">×</span>
                                            </button>
                                            <strong><?php echo $_SESSION['error']; ?></strong>
                                        </div>
                                        <?php
                                        unset($_SESSION['error']);
                                    }
                                ?>

                                <!-- Form Tambah/Edit -->
                                <h4 class="header-title mb-3 mt-4">
                                    <?php echo $editData ? '✏️ Edit Detail Layanan' : '➕ Tambah Detail Layanan'; ?>
                                </h4>
                                
                                <form action="backend/service_details_add.php" method="post" enctype="multipart/form-data">
                                    <?php if ($editData): ?>
                                        <input type="hidden" name="id" value="<?php echo $editData['id']; ?>">
                                        <input type="hidden" name="existing_image" value="<?php echo $editData['main_image']; ?>">
                                    <?php endif; ?>
                                    
                                    <div class="form-group">
                                        <label for="service_id">Pilih Layanan</label>
                                        <select name="service_id" id="service_id" class="form-control <?php echo isset($_SESSION['service_err'])? 'err':'' ?>" required>
                                            <option value="">-- Pilih Layanan --</option>
                                            <?php 
                                            mysqli_data_seek($serviceList, 0);
                                            while ($svc = mysqli_fetch_assoc($serviceList)): 
                                            ?>
                                            <option value="<?php echo $svc['id']; ?>" 
                                                <?php echo ($editData && $editData['service_id'] == $svc['id']) ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($svc['heading']); ?>
                                            </option>
                                            <?php endwhile; ?>
                                        </select>
                                        <?php 
                                            if (isset($_SESSION['service_err'])) {
                                                ?>
                                                <span style='color:red;font-size:15px;margin-left:10px'>
                                                    <?php echo $_SESSION['service_err']; ?>
                                                </span>
                                                <style>.err{border:1px solid red;}</style>
                                                <?php
                                                unset($_SESSION['service_err']);
                                            }
                                        ?>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="layout_type">Layout Tampilan</label>
                                        <select name="layout_type" id="layout_type" class="form-control">
                                            <option value="text_left" <?php echo ($editData && $editData['layout_type'] == 'text_left') ? 'selected' : ''; ?>>Text Kiri - Gambar Kanan</option>
                                            <option value="text_right" <?php echo ($editData && $editData['layout_type'] == 'text_right') ? 'selected' : ''; ?>>Gambar Kiri - Text Kanan</option>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="main_image">Gambar Utama</label>
                                        <input type="file" name="main_image" id="main_image" class="form-control-file <?php echo isset($_SESSION['image_err'])? 'err':'' ?>" accept="image/*">
                                        <?php 
                                            if (isset($_SESSION['image_err'])) {
                                                ?>
                                                <span style='color:red;font-size:15px;margin-left:10px'>
                                                    <?php echo $_SESSION['image_err']; ?>
                                                </span>
                                                <style>.err{border:1px solid red;}</style>
                                                <?php
                                                unset($_SESSION['image_err']);
                                            }
                                        ?>
                                        <?php if ($editData && $editData['main_image']): ?>
                                            <small class="text-muted d-block mt-1">Gambar saat ini: <?php echo basename($editData['main_image']); ?></small>
                                            <img src="<?php echo $editData['main_image']; ?>" style="max-height: 80px; margin-top: 5px;" class="img-thumbnail">
                                        <?php endif; ?>
                                    </div>
                                    
                                    <?php if ($editData && $editData['main_image']): ?>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="delete_image" class="custom-control-input" id="deleteImage">
                                            <label class="custom-control-label" for="deleteImage">Hapus gambar saat ini</label>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <div class="form-group">
                                        <label for="description">Deskripsi Layanan</label>
                                        <textarea name="description" id="description" class="form-control <?php echo isset($_SESSION['desc_err'])? 'err':'' ?>" rows="4" placeholder="Jelaskan detail layanan..." required><?php echo $editData ? htmlspecialchars($editData['description']) : ''; ?></textarea>
                                        <?php 
                                            if (isset($_SESSION['desc_err'])) {
                                                ?>
                                                <span style='color:red;font-size:15px;margin-left:10px'>
                                                    <?php echo $_SESSION['desc_err']; ?>
                                                </span>
                                                <style>.err{border:1px solid red;}</style>
                                                <?php
                                                unset($_SESSION['desc_err']);
                                            }
                                        ?>
                                    </div>
                                    
                                    <!-- List Items / Bullet Points -->
                                    <h5 class="mt-4 mb-3">📋 List Item (Bullet Points)</h5>
                                    <div id="listContainer">
                                        <?php if (!empty($editLists)): ?>
                                            <?php foreach ($editLists as $index => $list): ?>
                                            <div class="row list-item mb-2">
                                                <div class="col-md-1">
                                                    <span class="badge badge-secondary"><?php echo $index + 1; ?></span>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="text" name="list_items[]" class="form-control" 
                                                           value="<?php echo htmlspecialchars($list['list_item']); ?>" 
                                                           placeholder="Masukkan item list">
                                                    <input type="hidden" name="list_ids[]" value="<?php echo $list['id']; ?>">
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="button" class="btn btn-danger btn-sm remove-list">✕</button>
                                                </div>
                                            </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <div class="row list-item mb-2">
                                                <div class="col-md-1">
                                                    <span class="badge badge-secondary">1</span>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="text" name="list_items[]" class="form-control" placeholder="Masukkan item list">
                                                    <input type="hidden" name="list_ids[]" value="0">
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="button" class="btn btn-danger btn-sm remove-list">✕</button>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <button type="button" class="btn btn-success btn-sm mb-4" id="addListItem">
                                        + Tambah List Item
                                    </button>
                                    
                                    <div class="form-group text-center mt-3">
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            <?php echo $editData ? 'Update' : 'Save'; ?>
                                        </button>
                                        <?php if ($editData): ?>
                                            <a href="service_details.php" class="btn btn-secondary btn-lg">Cancel</a>
                                        <?php endif; ?>
                                    </div>
                                </form>

                                <hr class="my-5">

                                <!-- Tabel Data Detail Layanan -->
                                <h4 class="header-title mb-3">📋 Daftar Detail Layanan</h4>
                                <table class="table table-striped table-hover mb-5">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Nama Layanan</th>
                                            <th>Layout</th>
                                            <th>Gambar</th>
                                            <th>Deskripsi</th>
                                            <th>List Items</th>
                                            <th>Terakhir Update</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $sl = 1;
                                        while ($row = mysqli_fetch_assoc($services)): 
                                            // Hitung jumlah list items
                                            $listCount = mysqli_query($db, "SELECT COUNT(*) as total FROM service_lists WHERE service_detail_id = {$row['id']}");
                                            $countData = mysqli_fetch_assoc($listCount);
                                        ?>
                                        <tr>
                                            <td><?php echo $sl++; ?></td>
                                            <td><strong><?php echo htmlspecialchars($row['service_name'] ?: 'Layanan #' . $row['service_id']); ?></strong></td>
                                            <td>
                                                <?php if ($row['layout_type'] == 'text_left'): ?>
                                                    <span class="badge badge-info">Text Kiri</span>
                                                <?php else: ?>
                                                    <span class="badge badge-warning">Text Kanan</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($row['main_image']): ?>
                                                    <img src="<?php echo $row['main_image']; ?>" style="height: 50px; width: 80px; object-fit: cover;" class="img-thumbnail">
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo substr($row['description'], 0, 60) . '...'; ?></td>
                                            <td><span class="badge badge-secondary"><?php echo $countData['total']; ?> items</span></td>
                                            <td><?php echo date('d M Y', strtotime($row['updated_at'])); ?></td>
                                            <td>
                                                <a href="service_details_view.php?id=<?php echo $row['id']; ?>" title="Lihat Detail">
                                                    <img src="img/eye.png" style="height:25px; margin:5px">
                                                </a>
                                                <a href="service_details.php?edit=<?php echo $row['id']; ?>" title="Edit">
                                                    <img src="img/writing.png" style="height:25px; margin:5px">
                                                </a>
                                                <a href="backend/service_details_delete.php?id=<?php echo $row['id']; ?>" 
                                                   onclick="return confirm('Yakin hapus detail layanan ini?')" title="Hapus">
                                                    <img src="img/delete.png" style="height:25px; margin:5px">
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endwhile; ?>
                                        
                                        <?php if (mysqli_num_rows($services) == 0): ?>
                                        <tr>
                                            <td colspan="8" class="text-center text-muted py-4">
                                                Belum ada data detail layanan. Silakan tambah detail baru.
                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> <!-- container -->
            </div> <!-- content -->

<script>
// Tambah list item dinamis
document.getElementById('addListItem').addEventListener('click', function() {
    const container = document.getElementById('listContainer');
    const count = container.querySelectorAll('.list-item').length + 1;
    
    const div = document.createElement('div');
    div.className = 'row list-item mb-2';
    div.innerHTML = `
        <div class="col-md-1">
            <span class="badge badge-secondary">${count}</span>
        </div>
        <div class="col-md-9">
            <input type="text" name="list_items[]" class="form-control" placeholder="Masukkan item list">
            <input type="hidden" name="list_ids[]" value="0">
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-danger btn-sm remove-list">✕</button>
        </div>
    `;
    container.appendChild(div);
    updateNumbers();
});

// Hapus list item
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-list')) {
        const items = document.querySelectorAll('.list-item');
        if (items.length > 1) {
            e.target.closest('.list-item').remove();
            updateNumbers();
        } else {
            alert('Minimal harus ada 1 list item!');
        }
    }
});

function updateNumbers() {
    document.querySelectorAll('.list-item').forEach((item, index) => {
        item.querySelector('.badge').textContent = index + 1;
    });
}
</script>

<?php include 'inc/copyright.php' ?>
<?php include 'inc/footer.php' ?>