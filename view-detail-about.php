<?php 
    require 'backend/db.php';
    
    $sections = ['experience', 'vision', 'mission', 'quality'];
    $section_labels = [
        'experience' => 'Pengalaman & Keahlian',
        'vision' => 'Visi',
        'mission' => 'Misi',
        'quality' => 'Komitmen Kualitas'
    ];
?>
<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php' ?>
<?php include 'inc/topbar.php' ?>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <div class="jumbotron text-center">
                        <h2>Detail Tentang - Overview</h2>
                    </div>
                    
                    <?php if (isset($_SESSION['delete'])): ?>
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong><?php echo $_SESSION['delete']; ?></strong>
                    </div>
                    <?php unset($_SESSION['delete']); endif; ?>
                    
                    <?php foreach ($sections as $sec): ?>
                    <h4 class="header-title mb-3 mt-4"><?php echo $section_labels[$sec]; ?></h4>
                    <table class="table table-striped table-hover mb-5">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Judul</th>
                                <th>Deskripsi</th>
                                <th>Icon</th>
                                <th>Urutan</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $query = mysqli_query($db, "SELECT * FROM detail_about WHERE section_type='$sec' ORDER BY sort_order ASC");
                            $sl = 1;
                            while ($row = mysqli_fetch_assoc($query)): 
                            ?>
                            <tr>
                                <td><?php echo $sl++; ?></td>
                                <td><?php echo $row['title']; ?></td>
                                <td><?php echo substr($row['description'], 0, 50) . '...'; ?></td>
                                <td><i class="fas <?php echo $row['icon']; ?>"></i></td>
                                <td><?php echo $row['sort_order']; ?></td>
                                <td>
                                    <span class="badge badge-<?php echo $row['status'] ? 'success' : 'secondary'; ?>">
                                        <?php echo $row['status'] ? 'Aktif' : 'Nonaktif'; ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="detail-about.php?edit=<?php echo $row['id']; ?>">
                                        <img src="img/writing.png" style="height:25px; margin:5px">
                                    </a>
                                    <a href="backend/detail-about-delete.php?id=<?php echo $row['id']; ?>" 
                                       onclick="return confirm('Yakin hapus?')">
                                        <img src="img/delete.png" style="height:25px; margin:5px">
                                    </a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'inc/copyright.php' ?>
<?php include 'inc/footer.php' ?>