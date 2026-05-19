<?php include 'inc/header.php';
    require 'backend/db.php';
    
    $edit_id = isset($_GET['edit']) ? intval($_GET['edit']) : 0;
    $section = isset($_GET['section']) ? $_GET['section'] : 'experience';
    $data = [];
    
    if ($edit_id) {
        $sel = "SELECT * FROM detail_about WHERE id='$edit_id'";
        $query = mysqli_query($db, $sel);
        $data = mysqli_fetch_assoc($query);
        $section = $data['section_type'];
    }
?>
<?php include 'inc/sidebar.php' ?>
<?php include 'inc/topbar.php' ?>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <div class="jumbotron text-center">
                        <h2><?php echo $edit_id ? 'Edit' : 'Tambah'; ?> Konten Detail Tentang</h2>
                    </div>
                    
                    <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong><?php echo $_SESSION['success']; ?></strong>
                    </div>
                    <?php unset($_SESSION['success']); endif; ?>
                    
                    <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong><?php echo $_SESSION['error']; ?></strong>
                    </div>
                    <?php unset($_SESSION['error']); endif; ?>
                    
                    <!-- Tabs -->
                    <ul class="nav nav-tabs mb-4">
                        <li class="nav-item">
                            <a class="nav-link <?php echo $section=='experience' ? 'active' : ''; ?>" href="?section=experience">Pengalaman</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $section=='vision' ? 'active' : ''; ?>" href="?section=vision">Visi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $section=='mission' ? 'active' : ''; ?>" href="?section=mission">Misi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $section=='quality' ? 'active' : ''; ?>" href="?section=quality">Kualitas</a>
                        </li>
                    </ul>
                    
                    <form action="backend/detail-about-add.php" method="post">
                        <input type="hidden" name="section_type" value="<?php echo $section; ?>">
                        <?php if ($edit_id): ?>
                        <input type="hidden" name="id" value="<?php echo $edit_id; ?>">
                        <?php endif; ?>
                        
                        <div class="form-group">
                            <label>Judul</label>
                            <input type="text" class="form-control" name="title" 
                                   value="<?php echo $edit_id ? $data['title'] : ''; ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Deskripsi <?php echo $section=='mission' ? '(Opsional untuk Misi)' : ''; ?></label>
                            <textarea name="description" class="form-control" rows="4" 
                                      <?php echo $section=='mission' ? '' : 'required'; ?>><?php echo $edit_id ? $data['description'] : ''; ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label>Icon (Font Awesome Class)</label>
                            <input type="text" class="form-control" name="icon" 
                                   value="<?php echo $edit_id ? $data['icon'] : 'fa-check-circle'; ?>" required>
                            <small class="text-muted">Contoh: fa-drafting-compass, fa-eye, fa-check-circle</small>
                        </div>
                        
                        <div class="form-group">
                            <label>Urutan</label>
                            <input type="number" class="form-control" name="sort_order" 
                                   value="<?php echo $edit_id ? $data['sort_order'] : '0'; ?>" min="0">
                        </div>
                        
                        <div class="form-group text-center mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <?php echo $edit_id ? 'Update' : 'Simpan'; ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'inc/copyright.php' ?>
<?php include 'inc/footer.php' ?>