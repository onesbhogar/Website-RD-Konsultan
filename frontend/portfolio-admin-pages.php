<?php
// Admin Portfolio Pages
// Include ini di dashboard admin Anda dengan parameter ?page=portfolio

session_start();
require '../backend/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 2) {
    header('Location: ../index.php');
    exit;
}

$page = $_GET['page'] ?? 'portfolio';
$msg = '';
if (isset($_SESSION['success'])) {
    $msg = '<div class="alert alert-success alert-dismissible fade show">' . $_SESSION['success'] . '<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
    unset($_SESSION['success']);
}
if (isset($_SESSION['error'])) {
    $msg = '<div class="alert alert-danger alert-dismissible fade show">' . $_SESSION['error'] . '<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
    unset($_SESSION['error']);
}

switch ($page) {
    case 'portfolio':
        // List all portfolios
        $query = "SELECT * FROM portfolio ORDER BY id DESC";
        $result = mysqli_query($db, $query);
?>
        <div class="content-header">
            <h2>Daftar Portfolio</h2>
            <a href="?page=portfolio-add" class="btn btn-success">+ Tambah Portfolio</a>
        </div>
        <?= $msg ?>
        <div class="card">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Kategori</th>
                            <th>Judul</th>
                            <th>Lokasi</th>
                            <th>Tahun</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        foreach ($result as $row): 
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><img src="../img/portfolio/<?= $row['img'] ?>" width="80" height="60" style="object-fit: cover; border-radius: 5px;"></td>
                            <td><span class="badge badge-info"><?= $row['catagory'] ?></span></td>
                            <td><?= htmlspecialchars($row['heading']) ?></td>
                            <td><?= $row['location'] ?? 'Maumere' ?></td>
                            <td><?= $row['year'] ?? '-' ?></td>
                            <td><span class="badge badge-success"><?= $row['project_status'] ?? 'Selesai' ?></span></td>
                            <td>
                                <a href="?page=portfolio-edit&id=<?= $row['id'] ?>" class="btn btn-sm btn-primary" title="Edit"><i class="fas fa-edit"></i></a>
                                <a href="?page=portfolio-gallery&id=<?= $row['id'] ?>" class="btn btn-sm btn-info" title="Gallery"><i class="fas fa-images"></i></a>
                                <a href="../backend/portfolio-admin.php?action=delete&id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')" title="Hapus"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
<?php
        break;

    case 'portfolio-add':
?>
        <div class="content-header">
            <h2>Tambah Portfolio Baru</h2>
            <a href="?page=portfolio" class="btn btn-secondary">← Kembali</a>
        </div>
        <?= $msg ?>
        <div class="card">
            <div class="card-body">
                <form action="../backend/portfolio-admin.php?action=add" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kategori <span class="text-danger">*</span></label>
                                <select name="catagory" class="form-control" required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="Rumah">Rumah</option>
                                    <option value="Kantor">Kantor</option>
                                    <option value="Restoran">Restoran</option>
                                    <option value="Kampus">Kampus</option>
                                    <option value="Hotel">Hotel</option>
                                    <option value="Sekolah">Sekolah</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Judul Proyek <span class="text-danger">*</span></label>
                                <input type="text" name="heading" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Deskripsi <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control" rows="4" required></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Jenis Layanan</label>
                                <input type="text" name="service_type" class="form-control" value="Perencanaan dan Konstruksi">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Lokasi</label>
                                <input type="text" name="location" class="form-control" value="Maumere">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Tahun</label>
                                <input type="number" name="year" class="form-control" value="2023">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Status Proyek</label>
                                <select name="project_status" class="form-control">
                                    <option value="Selesai">Selesai</option>
                                    <option value="Dalam Pengerjaan">Dalam Pengerjaan</option>
                                    <option value="Perencanaan">Perencanaan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Slug (URL)</label>
                                <input type="text" name="slug" class="form-control" placeholder="auto-generate">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Gambar Utama <span class="text-danger">*</span></label>
                        <input type="file" name="image" class="form-control-file" accept="image/*" required>
                        <small class="text-muted">Format: JPG, PNG, GIF (Max 2MB)</small>
                    </div>

                    <div class="text-right">
                        <button type="submit" class="btn btn-success">Simpan Portfolio</button>
                    </div>
                </form>
            </div>
        </div>
<?php
        break;

    case 'portfolio-edit':
        $id = intval($_GET['id'] ?? 0);
        $sel = "SELECT * FROM portfolio WHERE id = $id";
        $res = mysqli_query($db, $sel);
        $data = mysqli_fetch_assoc($res);
        if (!$data) {
            header('Location: ?page=portfolio');
            exit;
        }
?>
        <div class="content-header">
            <h2>Edit Portfolio</h2>
            <a href="?page=portfolio" class="btn btn-secondary">← Kembali</a>
        </div>
        <?= $msg ?>
        <div class="card">
            <div class="card-body">
                <form action="../backend/portfolio-admin.php?action=edit&id=<?= $id ?>" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kategori</label>
                                <select name="catagory" class="form-control" required>
                                    <?php 
                                    $cats = ['Rumah', 'Kantor', 'Restoran', 'Kampus', 'Hotel', 'Sekolah'];
                                    foreach ($cats as $cat): 
                                        $selected = ($data['catagory'] == $cat) ? 'selected' : '';
                                    ?>
                                        <option value="<?= $cat ?>" <?= $selected ?>><?= $cat ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Judul Proyek</label>
                                <input type="text" name="heading" class="form-control" value="<?= htmlspecialchars($data['heading']) ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="description" class="form-control" rows="4" required><?= htmlspecialchars($data['description']) ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Jenis Layanan</label>
                                <input type="text" name="service_type" class="form-control" value="<?= $data['service_type'] ?? 'Perencanaan dan Konstruksi' ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Lokasi</label>
                                <input type="text" name="location" class="form-control" value="<?= $data['location'] ?? 'Maumere' ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Tahun</label>
                                <input type="number" name="year" class="form-control" value="<?= $data['year'] ?? 2023 ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Status</label>
                                <select name="project_status" class="form-control">
                                    <?php 
                                    $statuses = ['Selesai', 'Dalam Pengerjaan', 'Perencanaan'];
                                    foreach ($statuses as $st): 
                                        $selected = ($data['project_status'] == $st) ? 'selected' : '';
                                    ?>
                                        <option <?= $selected ?>><?= $st ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Slug</label>
                                <input type="text" name="slug" class="form-control" value="<?= $data['slug'] ?>">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Gambar Saat Ini</label><br>
                        <img src="../img/portfolio/<?= $data['img'] ?>" width="200" class="mb-2 rounded border">
                        <input type="file" name="image" class="form-control-file" accept="image/*">
                        <small class="text-muted">Biarkan kosong jika tidak ingin mengganti gambar</small>
                    </div>

                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Update Portfolio</button>
                    </div>
                </form>
            </div>
        </div>
<?php
        break;

    case 'portfolio-gallery':
        $portfolio_id = intval($_GET['id'] ?? 0);
        $port_query = "SELECT * FROM portfolio WHERE id = $portfolio_id";
        $port_res = mysqli_query($db, $port_query);
        $portfolio = mysqli_fetch_assoc($port_res);
        
        if (!$portfolio) {
            header('Location: ?page=portfolio');
            exit;
        }
        
        // Get gallery images
        $img_query = "SELECT * FROM portfolio_images WHERE portfolio_id = $portfolio_id ORDER BY sort_order ASC";
        $img_result = mysqli_query($db, $img_query);
?>
        <div class="content-header">
            <h2>Gallery: <?= htmlspecialchars($portfolio['heading']) ?></h2>
            <a href="?page=portfolio" class="btn btn-secondary">← Kembali</a>
        </div>
        <?= $msg ?>
        
        <!-- Add Image Form -->
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">Tambah Gambar Gallery</h5>
            </div>
            <div class="card-body">
                <form action="../backend/portfolio-admin.php?action=gallery&id=<?= $portfolio_id ?>" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Gambar <span class="text-danger">*</span></label>
                                <input type="file" name="gallery_image" class="form-control-file" accept="image/*" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Caption</label>
                                <input type="text" name="caption" class="form-control" placeholder="Tampak Depan / Samping / Interior">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Urutan</label>
                                <input type="number" name="sort_order" class="form-control" value="0">
                            </div>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-info btn-block">Tambah</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Gallery Grid -->
        <div class="card">
            <div class="card-header">
                <h5>Daftar Gambar Gallery</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php if (mysqli_num_rows($img_result) > 0): ?>
                        <?php foreach ($img_result as $img): ?>
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                            <div class="card h-100">
                                <img src="../img/portfolio/gallery/<?= $img['image'] ?>" class="card-img-top" style="height: 150px; object-fit: cover;">
                                <div class="card-body p-2 text-center">
                                    <p class="card-text small mb-2"><?= htmlspecialchars($img['caption'] ?? 'No caption') ?></p>
                                    <a href="../backend/portfolio-admin.php?action=gallery&id=<?= $portfolio_id ?>&delete_img=<?= $img['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus gambar ini?')">Hapus</a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12 text-center py-5">
                            <p class="text-muted">Belum ada gambar gallery. Tambahkan gambar di atas.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
<?php
        break;
}
?>