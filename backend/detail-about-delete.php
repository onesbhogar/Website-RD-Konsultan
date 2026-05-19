<?php
session_start();
require 'db.php';

$id = intval($_GET['id']);
$sql = "DELETE FROM detail_about WHERE id=$id";

if (mysqli_query($db, $sql)) {
    $_SESSION['delete'] = "Data berhasil dihapus!";
} else {
    $_SESSION['error'] = "Gagal menghapus!";
}

header('Location: ../view-detail-about.php');
exit;
?>