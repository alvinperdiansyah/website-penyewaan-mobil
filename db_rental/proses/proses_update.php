<?php
session_start();
include '../config/koneksi.php';

if(!isset($_SESSION['login'])) { header('Location: ../admin/login.php'); exit; }

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id = $_POST['id_booking'];
    $status = $_POST['status'];

    mysqli_query($koneksi, "UPDATE booking SET status='$status' WHERE id_booking='$id'");
    header("Location: ../admin/dashboard.php");
}
?>