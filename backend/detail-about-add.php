<?php
session_start();
require 'db.php';

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$section_type = mysqli_real_escape_string($db, $_POST['section_type']);
$title = mysqli_real_escape_string($db, $_POST['title']);
$description = mysqli_real_escape_string($db, $_POST['description']);
$icon = mysqli_real_escape_string($db, $_POST['icon']);
$sort_order = intval($_POST['sort_order']);

if ($id) {
    // Update
    $sql = "UPDATE detail_about SET 
            section_type='$section_type', title='$title', description='$description', 
            icon='$icon', sort_order=$sort_order 
            WHERE id=$id";
} else {
    // Insert
    $sql = "INSERT INTO detail_about (section_type, title, description, icon, sort_order) 
            VALUES ('$section_type', '$title', '$description', '$icon', $sort_order)";
}

if (mysqli_query($db, $sql)) {
    $_SESSION['success'] = "Data berhasil disimpan!";
} else {
    $_SESSION['error'] = "Gagal: " . mysqli_error($db);
}

header('Location: ../detail-about.php?section=' . $section_type);
exit;
?>