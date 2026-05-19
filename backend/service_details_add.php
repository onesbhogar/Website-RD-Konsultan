<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $service_id = intval($_POST['service_id']);
    $layout_type = mysqli_real_escape_string($db, $_POST['layout_type']);
    $description = mysqli_real_escape_string($db, $_POST['description']);
    $list_items = isset($_POST['list_items']) ? $_POST['list_items'] : [];
    $list_ids = isset($_POST['list_ids']) ? $_POST['list_ids'] : [];
    
    // Validasi
    $hasError = false;
    
    if (empty($service_id)) {
        $_SESSION['service_err'] = "Layanan wajib dipilih!";
        $hasError = true;
    }
    if (empty($description)) {
        $_SESSION['desc_err'] = "Deskripsi wajib diisi!";
        $hasError = true;
    }
    
    if ($hasError) {
        header("Location: ../service_details.php" . ($id > 0 ? "?edit=$id" : ""));
        exit;
    }

    $main_image = '';
    
    // Proses upload gambar
    if (isset($_FILES['main_image']) && $_FILES['main_image']['error'] == 0) {
        $uploadDir = '../uploads/services/';
        
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $fileName = time() . '_' . basename($_FILES['main_image']['name']);
        $targetFile = $uploadDir . $fileName;
        
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $fileType = $_FILES['main_image']['type'];
        
        if (in_array($fileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES['main_image']['tmp_name'], $targetFile)) {
                $main_image = 'uploads/services/' . $fileName;
            } else {
                $_SESSION['image_err'] = "Gagal mengupload gambar!";
                header("Location: ../service_details.php" . ($id > 0 ? "?edit=$id" : ""));
                exit;
            }
        } else {
            $_SESSION['image_err'] = "Tipe file tidak valid! Gunakan JPG, PNG, GIF, atau WEBP.";
            header("Location: ../service_details.php" . ($id > 0 ? "?edit=$id" : ""));
            exit;
        }
    }
    
    if ($id > 0) {
        // Update data
        $existing_image = isset($_POST['existing_image']) ? $_POST['existing_image'] : '';
        $delete_image = isset($_POST['delete_image']) ? true : false;
        
        if ($main_image && $existing_image && file_exists('../' . $existing_image)) {
            unlink('../' . $existing_image);
        }
        
        if ($delete_image && $existing_image && file_exists('../' . $existing_image)) {
            unlink('../' . $existing_image);
            $existing_image = '';
        }
        
        $final_image = $main_image ? $main_image : ($delete_image ? '' : $existing_image);
        
        $sql = "UPDATE service_details SET 
                service_id = $service_id,
                layout_type = '$layout_type',
                main_image = " . ($final_image ? "'$final_image'" : "NULL") . ",
                description = '$description'
                WHERE id = $id";
        $message = "Detail layanan berhasil diupdate!";
    } else {
        $sql = "INSERT INTO service_details (service_id, layout_type, main_image, description) 
                VALUES ($service_id, '$layout_type', " . ($main_image ? "'$main_image'" : "NULL") . ", '$description')";
        $message = "Detail layanan berhasil ditambahkan!";
    }

    if (mysqli_query($db, $sql)) {
        $detail_id = $id > 0 ? $id : mysqli_insert_id($db);
        
        // Proses list items
        if ($id > 0) {
            // Hapus list lama yang tidak ada di form
            $existingListIds = array_filter($list_ids, function($v) { return $v > 0; });
            if (!empty($existingListIds)) {
                $idList = implode(',', $existingListIds);
                mysqli_query($db, "DELETE FROM service_lists WHERE service_detail_id = $detail_id AND id NOT IN ($idList)");
            } else {
                mysqli_query($db, "DELETE FROM service_lists WHERE service_detail_id = $detail_id");
            }
        }
        
        // Insert/update list items
        foreach ($list_items as $index => $item) {
            if (!empty(trim($item))) {
                $item = mysqli_real_escape_string($db, $item);
                $sort = $index + 1;
                $listId = isset($list_ids[$index]) ? intval($list_ids[$index]) : 0;
                
                if ($listId > 0) {
                    mysqli_query($db, "UPDATE service_lists SET list_item = '$item', sort_order = $sort WHERE id = $listId");
                } else {
                    mysqli_query($db, "INSERT INTO service_lists (service_detail_id, list_item, sort_order) VALUES ($detail_id, '$item', $sort)");
                }
            }
        }
        
        $_SESSION['success'] = $message;
    } else {
        $_SESSION['error'] = "Error: " . mysqli_error($db);
    }
    
    header("Location: ../service_details.php");
    exit;
}
?>