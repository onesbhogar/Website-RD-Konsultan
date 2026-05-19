<?php
session_start();
require 'db.php';

// Check admin login
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 2) {
    header('Location: ../index.php');
    exit;
}

$action = $_GET['action'] ?? 'list';

switch ($action) {
    case 'list':
        // Get all portfolio items
        $query = "SELECT * FROM portfolio ORDER BY id DESC";
        $result = mysqli_query($db, $query);
        break;

    case 'add':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $catagory = mysqli_real_escape_string($db, $_POST['catagory']);
            $heading = mysqli_real_escape_string($db, $_POST['heading']);
            $description = mysqli_real_escape_string($db, $_POST['description']);
            $service_type = mysqli_real_escape_string($db, $_POST['service_type']);
            $location = mysqli_real_escape_string($db, $_POST['location']);
            $year = intval($_POST['year']);
            $project_status = mysqli_real_escape_string($db, $_POST['project_status']);
            $slug = mysqli_real_escape_string($db, $_POST['slug']);
            
            if (empty($slug)) {
                $slug = strtolower(str_replace(' ', '-', $heading)) . '-' . time();
            }
            
            // Image upload
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $allowed = ['jpg', 'jpeg', 'png', 'gif'];
                $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                
                if (in_array($ext, $allowed) && $_FILES['image']['size'] <= 2000000) {
                    $newname = time() . '_' . $_FILES['image']['name'];
                    $upload_path = '../img/portfolio/' . $newname;
                    
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                        $insert = "INSERT INTO portfolio (catagory, heading, description, img, service_type, location, year, project_status, slug) 
                                   VALUES ('$catagory', '$heading', '$description', '$newname', '$service_type', '$location', $year, '$project_status', '$slug')";
                        
                        if (mysqli_query($db, $insert)) {
                            $_SESSION['success'] = "Portfolio berhasil ditambahkan!";
                            header('Location: ../admin/dashboard.php?page=portfolio');
                            exit;
                        }
                    }
                }
            }
            $_SESSION['error'] = "Gagal menambahkan portfolio!";
            header('Location: ../admin/dashboard.php?page=portfolio-add');
            exit;
        }
        break;

    case 'edit':
        $id = intval($_GET['id'] ?? 0);
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $catagory = mysqli_real_escape_string($db, $_POST['catagory']);
            $heading = mysqli_real_escape_string($db, $_POST['heading']);
            $description = mysqli_real_escape_string($db, $_POST['description']);
            $service_type = mysqli_real_escape_string($db, $_POST['service_type']);
            $location = mysqli_real_escape_string($db, $_POST['location']);
            $year = intval($_POST['year']);
            $project_status = mysqli_real_escape_string($db, $_POST['project_status']);
            $slug = mysqli_real_escape_string($db, $_POST['slug']);
            
            $img_update = '';
            
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $allowed = ['jpg', 'jpeg', 'png', 'gif'];
                $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                
                if (in_array($ext, $allowed) && $_FILES['image']['size'] <= 2000000) {
                    $newname = time() . '_' . $_FILES['image']['name'];
                    $upload_path = '../img/portfolio/' . $newname;
                    
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                        // Delete old image
                        $old = mysqli_query($db, "SELECT img FROM portfolio WHERE id = $id");
                        $old_data = mysqli_fetch_assoc($old);
                        if ($old_data && file_exists("../img/portfolio/" . $old_data['img'])) {
                            unlink("../img/portfolio/" . $old_data['img']);
                        }
                        $img_update = ", img = '$newname'";
                    }
                }
            }
            
            $update = "UPDATE portfolio SET 
                       catagory = '$catagory',
                       heading = '$heading',
                       description = '$description',
                       service_type = '$service_type',
                       location = '$location',
                       year = $year,
                       project_status = '$project_status',
                       slug = '$slug'
                       $img_update
                       WHERE id = $id";
            
            if (mysqli_query($db, $update)) {
                $_SESSION['success'] = "Portfolio berhasil diupdate!";
            } else {
                $_SESSION['error'] = "Gagal mengupdate: " . mysqli_error($db);
            }
            header('Location: ../admin/dashboard.php?page=portfolio');
            exit;
        }
        
        // Get data for edit form
        $sel = "SELECT * FROM portfolio WHERE id = $id";
        $res = mysqli_query($db, $sel);
        $edit_data = mysqli_fetch_assoc($res);
        break;

    case 'delete':
        $id = intval($_GET['id'] ?? 0);
        
        // Get image to delete
        $sel = "SELECT img FROM portfolio WHERE id = $id";
        $res = mysqli_query($db, $sel);
        $data = mysqli_fetch_assoc($res);
        
        if ($data && file_exists("../img/portfolio/" . $data['img'])) {
            unlink("../img/portfolio/" . $data['img']);
        }
        
        // Delete gallery images
        $img_sel = "SELECT image FROM portfolio_images WHERE portfolio_id = $id";
        $img_res = mysqli_query($db, $img_sel);
        while ($img = mysqli_fetch_assoc($img_res)) {
            if (file_exists("../img/portfolio/gallery/" . $img['image'])) {
                unlink("../img/portfolio/gallery/" . $img['image']);
            }
        }
        
        mysqli_query($db, "DELETE FROM portfolio_images WHERE portfolio_id = $id");
        mysqli_query($db, "DELETE FROM portfolio WHERE id = $id");
        
        $_SESSION['success'] = "Portfolio berhasil dihapus!";
        header('Location: ../admin/dashboard.php?page=portfolio');
        exit;

    case 'gallery':
        $portfolio_id = intval($_GET['id'] ?? 0);
        
        // Get portfolio info
        $port_query = "SELECT heading FROM portfolio WHERE id = $portfolio_id";
        $port_res = mysqli_query($db, $port_query);
        $portfolio = mysqli_fetch_assoc($port_res);
        
        // Add gallery image
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['gallery_image'])) {
            $caption = mysqli_real_escape_string($db, $_POST['caption']);
            $sort_order = intval($_POST['sort_order']);
            
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
            $ext = strtolower(pathinfo($_FILES['gallery_image']['name'], PATHINFO_EXTENSION));
            
            if (in_array($ext, $allowed) && $_FILES['gallery_image']['size'] <= 2000000) {
                $newname = time() . '_' . $_FILES['gallery_image']['name'];
                $upload_path = '../img/portfolio/gallery/' . $newname;
                
                if (move_uploaded_file($_FILES['gallery_image']['tmp_name'], $upload_path)) {
                    $insert = "INSERT INTO portfolio_images (portfolio_id, image, caption, sort_order) 
                               VALUES ($portfolio_id, '$newname', '$caption', $sort_order)";
                    mysqli_query($db, $insert);
                    $_SESSION['success'] = "Gambar berhasil ditambahkan!";
                }
            }
            header("Location: ../admin/dashboard.php?page=portfolio-gallery&id=$portfolio_id");
            exit;
        }
        
        // Delete gallery image
        if (isset($_GET['delete_img'])) {
            $img_id = intval($_GET['delete_img']);
            $sel = "SELECT image FROM portfolio_images WHERE id = $img_id";
            $res = mysqli_query($db, $sel);
            $img_data = mysqli_fetch_assoc($res);
            
            if ($img_data && file_exists("../img/portfolio/gallery/" . $img_data['image'])) {
                unlink("../img/portfolio/gallery/" . $img_data['image']);
            }
            mysqli_query($db, "DELETE FROM portfolio_images WHERE id = $img_id");
            $_SESSION['success'] = "Gambar berhasil dihapus!";
            header("Location: ../admin/dashboard.php?page=portfolio-gallery&id=$portfolio_id");
            exit;
        }
        
        // Get gallery images
        $img_query = "SELECT * FROM portfolio_images WHERE portfolio_id = $portfolio_id ORDER BY sort_order ASC";
        $img_result = mysqli_query($db, $img_query);
        break;
}

// Return data for admin pages
return [
    'result' => $result ?? null,
    'edit_data' => $edit_data ?? null,
    'portfolio' => $portfolio ?? null,
    'images' => $img_result ?? null,
    'portfolio_id' => $portfolio_id ?? null
];
?>