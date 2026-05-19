<?php
// ============================================
// QUALITY MENU CRUD - Admin Panel
// File: backend/quality-menu.php
// ============================================

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 2) {
    header('Location: ../page-login.html');
    exit;
}

require 'db.php';

if (!isset($db) || !$db) {
    die("Error: Koneksi database gagal.");
}

define('UPLOAD_DIR', '../img/quality/');
define('MAX_FILE_SIZE', 5 * 1024 * 1024);
define('ALLOWED_TYPES', ['image/jpeg', 'image/png', 'image/gif', 'image/webp']);

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if (isset($_POST['save_item'])) {
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $main_category = mysqli_real_escape_string($db, $_POST['main_category']);
        $sub_category = mysqli_real_escape_string($db, $_POST['sub_category']);
        $title = mysqli_real_escape_string($db, $_POST['title']);
        $description = mysqli_real_escape_string($db, $_POST['description']);
        $description_full = mysqli_real_escape_string($db, $_POST['description_full']);
        $sort_order = intval($_POST['sort_order']);
        $status = isset($_POST['status']) ? 1 : 0;
        $image = '';
        
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $file = $_FILES['image'];
            
            if ($file['size'] > MAX_FILE_SIZE) {
                $error = "Ukuran file terlalu besar. Maksimal 5MB.";
            } elseif (!in_array($file['type'], ALLOWED_TYPES)) {
                $error = "Tipe file tidak didukung.";
            } else {
                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $image = 'quality_' . time() . '_' . rand(1000,9999) . '.' . $ext;
                
                if (!is_dir(UPLOAD_DIR)) {
                    mkdir(UPLOAD_DIR, 0755, true);
                }
                
                if (!move_uploaded_file($file['tmp_name'], UPLOAD_DIR . $image)) {
                    $error = "Gagal mengupload gambar.";
                    $image = '';
                }
            }
        }
        
        if (empty($error)) {
            if ($id > 0) {
                if (!empty($image)) {
                    $old = mysqli_query($db, "SELECT image FROM quality_menu WHERE id=$id");
                    if ($old_row = mysqli_fetch_assoc($old)) {
                        $old_path = UPLOAD_DIR . $old_row['image'];
                        if (file_exists($old_path) && $old_row['image'] != 'default.jpg') {
                            unlink($old_path);
                        }
                    }
                    $sql = "UPDATE quality_menu SET 
                        main_category='$main_category', sub_category='$sub_category', 
                        title='$title', description='$description', description_full='$description_full',
                        image='$image', sort_order=$sort_order, status=$status
                        WHERE id=$id";
                } else {
                    $sql = "UPDATE quality_menu SET 
                        main_category='$main_category', sub_category='$sub_category', 
                        title='$title', description='$description', description_full='$description_full',
                        sort_order=$sort_order, status=$status
                        WHERE id=$id";
                }
                $message = "Item berhasil diperbarui!";
            } else {
                if (empty($image)) $image = 'default.jpg';
                $sql = "INSERT INTO quality_menu 
                    (main_category, sub_category, title, description, description_full, image, sort_order, status)
                    VALUES ('$main_category', '$sub_category', '$title', '$description', '$description_full', '$image', $sort_order, $status)";
                $message = "Item berhasil ditambahkan!";
            }
            
            if (!mysqli_query($db, $sql)) {
                $error = "Error: " . mysqli_error($db);
                $message = '';
            }
        }
    }
    
    elseif (isset($_POST['delete_item'])) {
        $id = intval($_POST['id']);
        
        $old = mysqli_query($db, "SELECT image FROM quality_menu WHERE id=$id");
        if ($old_row = mysqli_fetch_assoc($old)) {
            $old_path = UPLOAD_DIR . $old_row['image'];
            if (file_exists($old_path) && $old_row['image'] != 'default.jpg') {
                unlink($old_path);
            }
        }
        
        if (mysqli_query($db, "DELETE FROM quality_menu WHERE id=$id")) {
            $message = "Item berhasil dihapus!";
        } else {
            $error = "Gagal menghapus: " . mysqli_error($db);
        }
    }
}

$edit_data = null;
if (isset($_GET['edit'])) {
    $edit_id = intval($_GET['edit']);
    $edit_result = mysqli_query($db, "SELECT * FROM quality_menu WHERE id=$edit_id");
    $edit_data = mysqli_fetch_assoc($edit_result);
}

$where = "1=1";
if (isset($_GET['filter_cat']) && !empty($_GET['filter_cat'])) {
    $fc = mysqli_real_escape_string($db, $_GET['filter_cat']);
    $where .= " AND main_category='$fc'";
}
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $s = mysqli_real_escape_string($db, $_GET['search']);
    $where .= " AND (title LIKE '%$s%' OR description LIKE '%$s%' OR main_category LIKE '%$s%')";
}

$items = mysqli_query($db, "SELECT * FROM quality_menu WHERE $where ORDER BY main_category ASC, sub_category ASC, sort_order ASC, id ASC");

$stats = [
    'total' => mysqli_num_rows(mysqli_query($db, "SELECT * FROM quality_menu")),
    'active' => mysqli_num_rows(mysqli_query($db, "SELECT * FROM quality_menu WHERE status=1")),
    'main_cats' => mysqli_num_rows(mysqli_query($db, "SELECT DISTINCT main_category FROM quality_menu")),
];

$existing_cats = [];
$cat_result = mysqli_query($db, "SELECT DISTINCT main_category FROM quality_menu ORDER BY main_category ASC");
while ($c = mysqli_fetch_assoc($cat_result)) {
    $existing_cats[] = $c['main_category'];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Dokumentasi Proyek - RD DESIGN Admin</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #28a745;
            --primary-dark: #1e7e34;
            --dark: #1a1a2e;
        }
        
        * { font-family: 'Poppins', sans-serif; }
        body { background: #f0f2f5; }
        
        .admin-header {
            background: linear-gradient(135deg, var(--dark) 0%, #16213e 100%);
            color: white;
            padding: 30px 0;
            margin-bottom: 30px;
        }
        
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
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
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.15);
        }
        
        .btn { border-radius: 10px; padding: 10px 25px; font-weight: 500; }
        .btn-primary { background: var(--primary); border-color: var(--primary); }
        
        .stats-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        }
        
        .stats-number { font-size: 2.5rem; font-weight: 700; color: var(--primary); }
        
        .table { vertical-align: middle; }
        .table img { border-radius: 8px; object-fit: cover; }
        
        .badge-main { background: var(--primary); color: white; padding: 5px 12px; border-radius: 15px; font-size: 0.75rem; }
        .badge-sub { background: #6c757d; color: white; padding: 5px 12px; border-radius: 15px; font-size: 0.75rem; }
        
        .action-btn {
            width: 35px; height: 35px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            transition: all 0.3s;
        }
        .action-btn:hover { transform: scale(1.1); }
        
        .preview-img { max-height: 200px; border-radius: 10px; object-fit: cover; }
        
        .toast-container { position: fixed; top: 20px; right: 20px; z-index: 9999; }
    </style>
</head>
<body>

    <div class="toast-container">
        <?php if (!empty($message)): ?>
        <div class="toast align-items-center text-white bg-success border-0 show" role="alert">
            <div class="d-flex">
                <div class="toast-body"><i class="fas fa-check-circle me-2"></i><?= htmlspecialchars($message) ?></div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
        <?php endif; ?>
        <?php if (!empty($error)): ?>
        <div class="toast align-items-center text-white bg-danger border-0 show" role="alert">
            <div class="d-flex">
                <div class="toast-body"><i class="fas fa-exclamation-circle me-2"></i><?= htmlspecialchars($error) ?></div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <header class="admin-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-1"><i class="fas fa-images me-3"></i>Kelola Dokumentasi Proyek</h2>
                    <p class="mb-0 opacity-75">Tambah, edit, hapus dokumentasi proyek</p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <a href="../dashboard.php" class="btn btn-outline-light btn-sm me-2"><i class="fas fa-arrow-left me-2"></i>Dashboard</a>
                    <a href="../index.php#quality" target="_blank" class="btn btn-outline-light btn-sm"><i class="fas fa-eye me-2"></i>Lihat Web</a>
                </div>
            </div>
        </div>
    </header>

    <div class="container mb-5">
        
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="stats-card">
                    <div class="stats-number"><?= $stats['total'] ?></div>
                    <div class="text-muted small">Total Item</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card">
                    <div class="stats-number text-success"><?= $stats['active'] ?></div>
                    <div class="text-muted small">Aktif</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card">
                    <div class="stats-number text-info"><?= $stats['main_cats'] ?></div>
                    <div class="text-muted small">Kategori</div>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-<?= $edit_data ? 'edit' : 'plus-circle' ?> me-2 text-primary"></i>
                    <?= $edit_data ? 'Edit Item' : 'Tambah Item Baru' ?>
                </h5>
                <?php if ($edit_data): ?>
                <a href="quality-menu.php" class="btn btn-sm btn-outline-secondary">Batal Edit</a>
                <?php endif; ?>
            </div>
            <div class="card-body p-4">
                <form method="POST" enctype="multipart/form-data">
                    <?php if ($edit_data): ?>
                    <input type="hidden" name="id" value="<?= $edit_data['id'] ?>">
                    <?php endif; ?>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Kategori Utama <span class="text-danger">*</span></label>
                            <input type="text" name="main_category" class="form-control" list="mainCats"
                                   value="<?= $edit_data ? htmlspecialchars($edit_data['main_category']) : '' ?>" 
                                   placeholder="Contoh: 1. Proses Persiapan Lapangan" required>
                            <datalist id="mainCats">
                                <?php foreach ($existing_cats as $c): ?>
                                <option value="<?= htmlspecialchars($c) ?>">
                                <?php endforeach; ?>
                            </datalist>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Sub Kategori</label>
                            <input type="text" name="sub_category" class="form-control"
                                   value="<?= $edit_data ? htmlspecialchars($edit_data['sub_category']) : '' ?>" 
                                   placeholder="Kosongkan jika tidak ada">
                        </div>
                        
                        <div class="col-md-8">
                            <label class="form-label fw-bold">Judul <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control"
                                   value="<?= $edit_data ? htmlspecialchars($edit_data['title']) : '' ?>" 
                                   placeholder="Contoh: Pengukuran Lahan" required>
                        </div>
                        
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Urutan</label>
                            <input type="number" name="sort_order" class="form-control"
                                   value="<?= $edit_data ? $edit_data['sort_order'] : '0' ?>" min="0">
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label fw-bold">Deskripsi Singkat</label>
                            <input type="text" name="description" class="form-control"
                                   value="<?= $edit_data ? htmlspecialchars($edit_data['description']) : '' ?>" 
                                   placeholder="Deskripsi untuk tampilan menu">
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label fw-bold">Deskripsi Lengkap (Halaman Detail)</label>
                            <textarea name="description_full" class="form-control" rows="5"
                                      placeholder="Deskripsi lengkap yang tampil saat item diklik..."><?= $edit_data ? htmlspecialchars($edit_data['description_full'] ?? '') : '' ?></textarea>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Gambar <?= $edit_data ? '' : '<span class="text-danger">*</span>' ?></label>
                            <input type="file" name="image" class="form-control" accept="image/*" <?= $edit_data ? '' : 'required' ?>>
                            <div class="form-text">JPG, PNG, GIF, WEBP. Max 5MB. <?= $edit_data ? 'Kosongkan jika tidak ganti.' : '' ?></div>
                        </div>
                        
                        <div class="col-md-3">
                            <?php if ($edit_data && !empty($edit_data['image'])): ?>
                            <label class="form-label fw-bold">Gambar Saat Ini</label>
                            <div><img src="<?= UPLOAD_DIR . $edit_data['image'] ?>" class="preview-img" alt="Current"></div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="col-md-3 d-flex align-items-end">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="status" id="statusSwitch" 
                                       <?= ($edit_data && $edit_data['status'] == 1) || !$edit_data ? 'checked' : '' ?>>
                                <label class="form-check-label fw-bold" for="statusSwitch">Aktif</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4 pt-3 border-top">
                        <button type="submit" name="save_item" class="btn btn-primary btn-lg">
                            <i class="fas fa-<?= $edit_data ? 'save' : 'plus' ?> me-2"></i>
                            <?= $edit_data ? 'Simpan Perubahan' : 'Tambah Item' ?>
                        </button>
                        <button type="reset" class="btn btn-outline-secondary btn-lg ms-2">
                            <i class="fas fa-undo me-2"></i>Reset
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Filter -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" class="row g-3 align-items-end">
                    <div class="col-md-5">
                        <label class="form-label fw-bold">Filter Kategori</label>
                        <select name="filter_cat" class="form-select" onchange="this.form.submit()">
                            <option value="">Semua Kategori</option>
                            <?php foreach ($existing_cats as $c): ?>
                            <option value="<?= htmlspecialchars($c) ?>" <?= (isset($_GET['filter_cat']) && $_GET['filter_cat'] == $c) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($c) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label fw-bold">Cari</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" name="search" class="form-control" 
                                   value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>" 
                                   placeholder="Judul, deskripsi, kategori...">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter me-2"></i>Filter</button>
                        <?php if (isset($_GET['filter_cat']) || isset($_GET['search'])): ?>
                        <a href="quality-menu.php" class="btn btn-outline-secondary w-100 mt-2"><i class="fas fa-times me-2"></i>Reset</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-list me-2 text-primary"></i>Daftar Item</h5>
                <span class="badge bg-primary"><?= mysqli_num_rows($items) ?> Item</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="50">ID</th>
                                <th width="80">Gambar</th>
                                <th>Kategori</th>
                                <th>Judul</th>
                                <th>Deskripsi</th>
                                <th width="60">Urut</th>
                                <th width="80">Status</th>
                                <th width="120">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($item = mysqli_fetch_assoc($items)): ?>
                            <tr>
                                <td class="text-muted">#<?= $item['id'] ?></td>
                                <td>
                                    <?php 
                                    $img_path = UPLOAD_DIR . $item['image'];
                                    if (file_exists($img_path) && !empty($item['image'])): 
                                    ?>
                                    <img src="<?= $img_path ?>" width="60" height="60" alt="">
                                    <?php else: ?>
                                    <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="width:60px;height:60px;border-radius:8px;">
                                        <i class="fas fa-image"></i>
                                    </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge-main d-block mb-1"><?= htmlspecialchars($item['main_category']) ?></span>
                                    <?php if (!empty($item['sub_category'])): ?>
                                    <span class="badge-sub"><?= htmlspecialchars($item['sub_category']) ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="fw-bold"><?= htmlspecialchars($item['title']) ?></td>
                                <td>
                                    <small class="text-muted"><?= htmlspecialchars(substr($item['description'], 0, 50)) ?>...</small>
                                    <?php if (!empty($item['description_full'])): ?>
                                    <span class="badge bg-success ms-1" style="font-size:0.6rem;">FULL</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= $item['sort_order'] ?></td>
                                <td>
                                    <?php if ($item['status'] == 1): ?>
                                    <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                    <span class="badge bg-secondary">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="quality-menu.php?edit=<?= $item['id'] ?>" class="action-btn btn-warning text-white me-1" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="action-btn btn-danger text-white" data-bs-toggle="modal" data-bs-target="#del<?= $item['id'] ?>" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            
                            <div class="modal fade" id="del<?= $item['id'] ?>" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title"><i class="fas fa-trash me-2"></i>Hapus Item</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body text-center py-4">
                                            <i class="fas fa-exclamation-triangle text-warning mb-3" style="font-size:3rem;"></i>
                                            <h5>Hapus "<?= htmlspecialchars($item['title']) ?>"?</h5>
                                            <p class="text-muted">Item dan gambarnya akan dihapus permanen.</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                            <form method="POST" class="d-inline">
                                                <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                                <button type="submit" name="delete_item" class="btn btn-danger">
                                                    <i class="fas fa-trash me-2"></i>Ya, Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-center py-4 text-muted">
        <small>RD DESIGN Admin &copy; <?= date('Y') ?></small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        setTimeout(() => {
            document.querySelectorAll('.toast').forEach(t => {
                const bs = new bootstrap.Toast(t);
                bs.hide();
            });
        }, 5000);
    </script>
</body>
</html>