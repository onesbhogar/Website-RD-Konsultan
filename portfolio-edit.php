<?php
// ============================================
// PORTFOLIO EDIT - Admin Panel
// File: portfolio-edit.php
// ============================================

// --- 1. ERROR REPORTING (Aktifkan saat development, matikan saat production) ---
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// --- 2. SESSION & DATABASE ---
session_start();

// Cek login
if (!isset($_SESSION['role']) || $_SESSION['role'] != 2) {
    header('Location: page-login.html');
    exit;
}

// Koneksi database
$db_path = 'backend/db.php';
if (!file_exists($db_path)) {
    die("Error: File database tidak ditemukan di: " . realpath('.') . "/" . $db_path);
}
require $db_path;

if (!isset($db) || !$db) {
    die("Error: Koneksi database gagal.");
}

// --- 3. KONFIGURASI ---
define('UPLOAD_DIR', 'img/portfolio/');
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_TYPES', ['image/jpeg', 'image/png', 'image/gif', 'image/webp']);

$categories = ['Rumah', 'Kantor', 'Restoran', 'Kampus', 'Hotel', 'Sekolah'];
$project_statuses = ['Selesai', 'Dalam Pengerjaan', 'Perencanaan', 'Penawaran'];

// --- 4. PESAN & ERROR ---
$message = '';
$error = '';

// --- 5. PROSES FORM (TAMBAH / EDIT / HAPUS) ---
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // ===== TAMBAH / EDIT PORTFOLIO =====
    if (isset($_POST['save_portfolio'])) {
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $category = mysqli_real_escape_string($db, $_POST['category']);
        $heading = mysqli_real_escape_string($db, $_POST['heading']);
        $description = mysqli_real_escape_string($db, $_POST['description']);
        $service_type = mysqli_real_escape_string($db, $_POST['service_type']);
        $location = mysqli_real_escape_string($db, $_POST['location']);
        $year = intval($_POST['year']);
        $project_status = mysqli_real_escape_string($db, $_POST['project_status']);
        $slug = isset($_POST['slug']) && !empty($_POST['slug']) 
            ? mysqli_real_escape_string($db, $_POST['slug']) 
            : strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $heading));
        
        $img = '';
        
        // Proses upload gambar
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $file = $_FILES['image'];
            
            // Validasi ukuran
            if ($file['size'] > MAX_FILE_SIZE) {
                $error = "Ukuran file terlalu besar. Maksimal 5MB.";
            }
            // Validasi tipe
            elseif (!in_array($file['type'], ALLOWED_TYPES)) {
                $error = "Tipe file tidak didukung. Gunakan JPG, PNG, GIF, atau WEBP.";
            }
            else {
                // Buat nama file unik
                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $img = $slug . '-' . time() . '.' . $ext;
                $upload_path = UPLOAD_DIR . $img;
                
                // Buat folder jika belum ada
                if (!is_dir(UPLOAD_DIR)) {
                    mkdir(UPLOAD_DIR, 0755, true);
                }
                
                if (!move_uploaded_file($file['tmp_name'], $upload_path)) {
                    $error = "Gagal mengupload gambar.";
                    $img = '';
                }
            }
        }
        
        if (empty($error)) {
            if ($id > 0) {
                // ===== EDIT =====
                if (!empty($img)) {
                    // Hapus gambar lama
                    $old = mysqli_query($db, "SELECT img FROM portfolio WHERE id=$id");
                    if ($old_row = mysqli_fetch_assoc($old)) {
                        $old_path = UPLOAD_DIR . $old_row['img'];
                        if (file_exists($old_path)) unlink($old_path);
                    }
                    $sql = "UPDATE portfolio SET 
                        catagory='$category', heading='$heading', description='$description',
                        img='$img', service_type='$service_type', location='$location',
                        year=$year, project_status='$project_status', slug='$slug'
                        WHERE id=$id";
                } else {
                    $sql = "UPDATE portfolio SET 
                        catagory='$category', heading='$heading', description='$description',
                        service_type='$service_type', location='$location',
                        year=$year, project_status='$project_status', slug='$slug'
                        WHERE id=$id";
                }
                $message = "Portfolio berhasil diperbarui!";
            } else {
                // ===== TAMBAH BARU =====
                if (empty($img)) {
                    $img = 'default.jpg';
                }
                $sql = "INSERT INTO portfolio 
                    (catagory, heading, description, img, service_type, location, year, project_status, slug)
                    VALUES ('$category', '$heading', '$description', '$img', '$service_type', '$location', $year, '$project_status', '$slug')";
                $message = "Portfolio berhasil ditambahkan!";
            }
            
            if (!mysqli_query($db, $sql)) {
                $error = "Error database: " . mysqli_error($db);
                $message = '';
            }
        }
    }
    
    // ===== HAPUS PORTFOLIO =====
    elseif (isset($_POST['delete_portfolio'])) {
        $id = intval($_POST['id']);
        
        // Hapus gambar
        $old = mysqli_query($db, "SELECT img FROM portfolio WHERE id=$id");
        if ($old_row = mysqli_fetch_assoc($old)) {
            $old_path = UPLOAD_DIR . $old_row['img'];
            if (file_exists($old_path) && $old_row['img'] != 'default.jpg') {
                unlink($old_path);
            }
        }
        
        $sql = "DELETE FROM portfolio WHERE id=$id";
        if (mysqli_query($db, $sql)) {
            $message = "Portfolio berhasil dihapus!";
        } else {
            $error = "Gagal menghapus: " . mysqli_error($db);
        }
    }
}

// --- 6. AMBIL DATA UNTUK EDIT ---
$edit_data = null;
if (isset($_GET['edit'])) {
    $edit_id = intval($_GET['edit']);
    $edit_query = mysqli_query($db, "SELECT * FROM portfolio WHERE id=$edit_id");
    $edit_data = mysqli_fetch_assoc($edit_query);
}

// --- 7. AMBIL SEMUA PORTFOLIO (dengan filter) ---
$where = "1=1";
if (isset($_GET['filter_category']) && !empty($_GET['filter_category'])) {
    $fc = mysqli_real_escape_string($db, $_GET['filter_category']);
    $where .= " AND catagory='$fc'";
}
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $s = mysqli_real_escape_string($db, $_GET['search']);
    $where .= " AND (heading LIKE '%$s%' OR description LIKE '%$s%' OR location LIKE '%$s%')";
}

$portfolio_list = mysqli_query($db, "SELECT * FROM portfolio WHERE $where ORDER BY id DESC");

// Hitung total
$total_result = mysqli_query($db, "SELECT COUNT(*) as total FROM portfolio WHERE $where");
$total_row = mysqli_fetch_assoc($total_result);
$total_items = $total_row['total'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Portfolio - RD DESIGN Admin</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #28a745;
            --primary-dark: #1e7e34;
            --secondary: #6c757d;
            --dark: #1a1a2e;
            --light: #f8f9fa;
        }
        
        * { font-family: 'Poppins', sans-serif; }
        
        body {
            background: #f0f2f5;
            min-height: 100vh;
        }
        
        .admin-header {
            background: linear-gradient(135deg, var(--dark) 0%, #16213e 100%);
            color: white;
            padding: 25px 0;
            margin-bottom: 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        }
        
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0,0,0,0.12);
        }
        
        .card-header {
            background: white;
            border-bottom: 2px solid #e9ecef;
            border-radius: 15px 15px 0 0 !important;
            padding: 20px 25px;
        }
        
        .form-control, .form-select {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.15);
        }
        
        .btn {
            border-radius: 10px;
            padding: 10px 25px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background: var(--primary);
            border-color: var(--primary);
        }
        
        .btn-primary:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
            transform: translateY(-2px);
        }
        
        .portfolio-item-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .portfolio-item-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        }
        
        .portfolio-img {
            height: 200px;
            object-fit: cover;
            width: 100%;
        }
        
        .portfolio-img-placeholder {
            height: 200px;
            background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #adb5bd;
            font-size: 3rem;
        }
        
        .badge-category {
            background: var(--primary);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .status-badge {
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .status-selesai { background: #d4edda; color: #155724; }
        .status-dalam-pengerjaan { background: #fff3cd; color: #856404; }
        .status-perencanaan { background: #d1ecf1; color: #0c5460; }
        .status-penawaran { background: #f8d7da; color: #721c24; }
        
        .action-btn {
            width: 35px;
            height: 35px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            transition: all 0.3s ease;
        }
        
        .action-btn:hover { transform: scale(1.1); }
        
        .preview-img {
            max-height: 250px;
            border-radius: 10px;
            object-fit: cover;
            width: 100%;
        }
        
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }
        
        .search-box {
            position: relative;
        }
        
        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #adb5bd;
        }
        
        .search-box input {
            padding-left: 45px;
        }
        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }
        
        .empty-state i {
            font-size: 4rem;
            color: #dee2e6;
            margin-bottom: 20px;
        }
        
        .stats-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        }
        
        .stats-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary);
        }
        
        .modal-content {
            border-radius: 15px;
            border: none;
        }
        
        .modal-header {
            border-radius: 15px 15px 0 0;
            background: var(--dark);
            color: white;
        }
        
        .modal-footer {
            border-top: 2px solid #e9ecef;
        }
        
        @media (max-width: 768px) {
            .portfolio-img { height: 180px; }
            .stats-number { font-size: 2rem; }
        }
    </style>
</head>
<body>

    <!-- Toast Notifications -->
    <div class="toast-container">
        <?php if (!empty($message)): ?>
        <div class="toast align-items-center text-white bg-success border-0 show" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-check-circle me-2"></i><?= htmlspecialchars($message) ?>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
        <?php endif; ?>
        
        <?php if (!empty($error)): ?>
        <div class="toast align-items-center text-white bg-danger border-0 show" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-exclamation-circle me-2"></i><?= htmlspecialchars($error) ?>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Header -->
    <header class="admin-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-1"><i class="fas fa-briefcase me-3"></i>Kelola Portfolio</h2>
                    <p class="mb-0 opacity-75">Tambah, edit, dan hapus proyek portfolio RD DESIGN</p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <a href="dashboard.php" class="btn btn-outline-light btn-sm me-2">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                    <span class="badge bg-success px-3 py-2">
                        <i class="fas fa-user-shield me-1"></i>Admin
                    </span>
                </div>
            </div>
        </div>
    </header>

    <div class="container mb-5">
        
        <!-- Stats Row -->
        <div class="row g-4 mb-4">
            <div class="col-md-3 col-6">
                <div class="stats-card">
                    <div class="stats-number"><?= $total_items ?></div>
                    <div class="text-muted small">Total Proyek</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stats-card">
                    <div class="stats-number text-warning">
                        <?= mysqli_num_rows(mysqli_query($db, "SELECT * FROM portfolio WHERE project_status='Dalam Pengerjaan'")) ?>
                    </div>
                    <div class="text-muted small">Dalam Pengerjaan</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stats-card">
                    <div class="stats-number text-success">
                        <?= mysqli_num_rows(mysqli_query($db, "SELECT * FROM portfolio WHERE project_status='Selesai'")) ?>
                    </div>
                    <div class="text-muted small">Selesai</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stats-card">
                    <div class="stats-number text-info">
                        <?= count($categories) ?>
                    </div>
                    <div class="text-muted small">Kategori</div>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-<?= $edit_data ? 'edit' : 'plus-circle' ?> me-2 text-primary"></i>
                    <?= $edit_data ? 'Edit Portfolio' : 'Tambah Portfolio Baru' ?>
                </h5>
                <?php if ($edit_data): ?>
                <a href="portfolio-edit.php" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-times me-1"></i>Batal Edit
                </a>
                <?php endif; ?>
            </div>
            <div class="card-body p-4">
                <form method="POST" enctype="multipart/form-data" id="portfolioForm">
                    <?php if ($edit_data): ?>
                    <input type="hidden" name="id" value="<?= $edit_data['id'] ?>">
                    <?php endif; ?>
                    
                    <div class="row g-4">
                        <!-- Kolom Kiri: Form -->
                        <div class="col-lg-8">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Judul Proyek <span class="text-danger">*</span></label>
                                    <input type="text" name="heading" class="form-control" 
                                           value="<?= $edit_data ? htmlspecialchars($edit_data['heading']) : '' ?>" 
                                           placeholder="Contoh: Rumah Tinggal Modern" required>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Kategori <span class="text-danger">*</span></label>
                                    <select name="category" class="form-select" required>
                                        <option value="">Pilih Kategori</option>
                                        <?php foreach ($categories as $cat): ?>
                                        <option value="<?= $cat ?>" <?= ($edit_data && $edit_data['catagory'] == $cat) ? 'selected' : '' ?>>
                                            <?= $cat ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Lokasi</label>
                                    <input type="text" name="location" class="form-control" 
                                           value="<?= $edit_data ? htmlspecialchars($edit_data['location']) : 'Maumere' ?>" 
                                           placeholder="Contoh: Maumere, Flores">
                                </div>
                                
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Tahun</label>
                                    <input type="number" name="year" class="form-control" 
                                           value="<?= $edit_data ? $edit_data['year'] : date('Y') ?>" 
                                           min="2000" max="2030">
                                </div>
                                
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Status</label>
                                    <select name="project_status" class="form-select">
                                        <?php foreach ($project_statuses as $ps): ?>
                                        <option value="<?= $ps ?>" <?= ($edit_data && $edit_data['project_status'] == $ps) ? 'selected' : '' ?>>
                                            <?= $ps ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Jenis Layanan</label>
                                    <input type="text" name="service_type" class="form-control" 
                                           value="<?= $edit_data ? htmlspecialchars($edit_data['service_type']) : 'Perencanaan dan Konstruksi' ?>">
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Slug URL</label>
                                    <input type="text" name="slug" class="form-control" 
                                           value="<?= $edit_data ? htmlspecialchars($edit_data['slug']) : '' ?>" 
                                           placeholder="Auto-generate jika kosong">
                                    <div class="form-text">Contoh: rumah-tinggal-modern</div>
                                </div>
                                
                                <div class="col-12">
                                    <label class="form-label fw-bold">Deskripsi <span class="text-danger">*</span></label>
                                    <textarea name="description" class="form-control" rows="4" 
                                              placeholder="Deskripsikan proyek ini..." required><?= $edit_data ? htmlspecialchars($edit_data['description']) : '' ?></textarea>
                                </div>
                                
                                <div class="col-12">
                                    <label class="form-label fw-bold">Gambar Proyek <?= $edit_data ? '' : '<span class="text-danger">*</span>' ?></label>
                                    <input type="file" name="image" class="form-control" accept="image/*" 
                                           <?= $edit_data ? '' : 'required' ?> onchange="previewImage(this)">
                                    <div class="form-text">
                                        Format: JPG, PNG, GIF, WEBP. Maksimal 5MB.
                                        <?= $edit_data ? 'Kosongkan jika tidak ingin mengganti gambar.' : '' ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Kolom Kanan: Preview -->
                        <div class="col-lg-4">
                            <div class="card bg-light border-0">
                                <div class="card-body text-center">
                                    <h6 class="text-muted mb-3">Preview Gambar</h6>
                                    <div id="imagePreview">
                                        <?php if ($edit_data && !empty($edit_data['img'])): ?>
                                        <img src="<?= UPLOAD_DIR . $edit_data['img'] ?>" class="preview-img" id="previewImg">
                                        <p class="mt-2 small text-muted"><?= $edit_data['img'] ?></p>
                                        <?php else: ?>
                                        <div class="portfolio-img-placeholder" id="previewPlaceholder">
                                            <i class="fas fa-image"></i>
                                        </div>
                                        <img src="" class="preview-img d-none" id="previewImg">
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4 pt-3 border-top">
                        <button type="submit" name="save_portfolio" class="btn btn-primary btn-lg">
                            <i class="fas fa-<?= $edit_data ? 'save' : 'plus' ?> me-2"></i>
                            <?= $edit_data ? 'Simpan Perubahan' : 'Tambah Portfolio' ?>
                        </button>
                        <button type="reset" class="btn btn-outline-secondary btn-lg ms-2" onclick="resetPreview()">
                            <i class="fas fa-undo me-2"></i>Reset
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Filter & Search -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label fw-bold"><i class="fas fa-filter me-2"></i>Filter Kategori</label>
                        <select name="filter_category" class="form-select" onchange="this.form.submit()">
                            <option value="">Semua Kategori</option>
                            <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat ?>" <?= (isset($_GET['filter_category']) && $_GET['filter_category'] == $cat) ? 'selected' : '' ?>>
                                <?= $cat ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label fw-bold"><i class="fas fa-search me-2"></i>Cari Proyek</label>
                        <div class="search-box">
                            <i class="fas fa-search"></i>
                            <input type="text" name="search" class="form-control" 
                                   value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>" 
                                   placeholder="Cari berdasarkan judul, deskripsi, atau lokasi...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-filter me-2"></i>Terapkan Filter
                        </button>
                        <?php if (isset($_GET['filter_category']) || isset($_GET['search'])): ?>
                        <a href="portfolio-edit.php" class="btn btn-outline-secondary w-100 mt-2">
                            <i class="fas fa-times me-2"></i>Reset Filter
                        </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

        <!-- Portfolio List -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-list me-2 text-primary"></i>Daftar Portfolio</h5>
                <span class="badge bg-primary"><?= $total_items ?> Item</span>
            </div>
            <div class="card-body p-4">
                <?php if (mysqli_num_rows($portfolio_list) > 0): ?>
                <div class="row g-4">
                    <?php while ($item = mysqli_fetch_assoc($portfolio_list)): 
                        $status_class = 'status-' . strtolower(str_replace(' ', '-', $item['project_status']));
                        $img_path = UPLOAD_DIR . $item['img'];
                        $img_exists = file_exists($img_path) && !empty($item['img']);
                    ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="portfolio-item-card">
                            <?php if ($img_exists): ?>
                            <img src="<?= $img_path ?>" class="portfolio-img" alt="<?= htmlspecialchars($item['heading']) ?>">
                            <?php else: ?>
                            <div class="portfolio-img-placeholder">
                                <i class="fas fa-image"></i>
                            </div>
                            <?php endif; ?>
                            
                            <div class="p-3">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <span class="badge-category"><?= $item['catagory'] ?></span>
                                    <span class="status-badge <?= $status_class ?>"><?= $item['project_status'] ?></span>
                                </div>
                                
                                <h5 class="mb-2"><?= htmlspecialchars($item['heading']) ?></h5>
                                <p class="text-muted small mb-2">
                                    <i class="fas fa-map-marker-alt me-1 text-primary"></i><?= $item['location'] ?>
                                    <span class="mx-2">|</span>
                                    <i class="fas fa-calendar me-1 text-primary"></i><?= $item['year'] ?>
                                </p>
                                <p class="text-muted small mb-3" style="height: 40px; overflow: hidden;">
                                    <?= htmlspecialchars(substr($item['description'], 0, 80)) ?>...
                                </p>
                                
                                <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                                    <small class="text-muted">ID: #<?= $item['id'] ?></small>
                                    <div>
                                        <a href="portfolio-edit.php?edit=<?= $item['id'] ?>" 
                                           class="action-btn btn-warning text-white me-1" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="action-btn btn-danger text-white" 
                                                data-bs-toggle="modal" data-bs-target="#deleteModal<?= $item['id'] ?>" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Delete Modal -->
                    <div class="modal fade" id="deleteModal<?= $item['id'] ?>" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body text-center py-4">
                                    <i class="fas fa-trash-alt text-danger mb-3" style="font-size: 3rem;"></i>
                                    <h5>Apakah Anda yakin?</h5>
                                    <p class="text-muted">Portfolio "<strong><?= htmlspecialchars($item['heading']) ?></strong>" akan dihapus permanen beserta gambarnya.</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                    <form method="POST" class="d-inline">
                                        <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                        <button type="submit" name="delete_portfolio" class="btn btn-danger">
                                            <i class="fas fa-trash me-2"></i>Ya, Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
                <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-folder-open"></i>
                    <h5>Belum Ada Portfolio</h5>
                    <p class="text-muted">Tambahkan portfolio pertama Anda menggunakan form di atas.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center py-4 text-muted">
        <small>RD DESIGN Admin Panel &copy; <?= date('Y') ?> | Kelola Portfolio</small>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Preview gambar saat upload
        function previewImage(input) {
            const previewImg = document.getElementById('previewImg');
            const placeholder = document.getElementById('previewPlaceholder');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewImg.classList.remove('d-none');
                    if (placeholder) placeholder.classList.add('d-none');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        
        // Reset preview
        function resetPreview() {
            const previewImg = document.getElementById('previewImg');
            const placeholder = document.getElementById('previewPlaceholder');
            
            previewImg.src = '';
            previewImg.classList.add('d-none');
            if (placeholder) placeholder.classList.remove('d-none');
        }
        
        // Auto-hide toast setelah 5 detik
        setTimeout(() => {
            document.querySelectorAll('.toast').forEach(toast => {
                const bsToast = new bootstrap.Toast(toast);
                bsToast.hide();
            });
        }, 5000);
        
        // Auto-generate slug dari heading
        document.querySelector('input[name="heading"]')?.addEventListener('blur', function() {
            const slugInput = document.querySelector('input[name="slug"]');
            if (slugInput && !slugInput.value) {
                const slug = this.value.toLowerCase()
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/^-+|-+$/g, '');
                slugInput.value = slug;
            }
        });
    </script>
</body>
</html>