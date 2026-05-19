<?php
session_start();
require 'db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Ambil data untuk hapus gambar
    $result = mysqli_query($db, "SELECT main_image FROM service_details WHERE id = $id");
    $data = mysqli_fetch_assoc($result);
    
    if ($data && $data['main_image'] && file_exists('../' . $data['main_image'])) {
        unlink('../' . $data['main_image']);
    }
    
    // Hapus list items terlebih dahulu
    mysqli_query($db, "DELETE FROM service_lists WHERE service_detail_id = $id");
    
    // Hapus detail layanan
    $sql = "DELETE FROM service_details WHERE id = $id";
    
    if (mysqli_query($db, $sql)) {
        $_SESSION['success'] = "Detail layanan berhasil dihapus!";
    } else {
        $_SESSION['error'] = "Error: " . mysqli_error($db);
    }
}

header("Location: ../service_details.php");
exit;
?>