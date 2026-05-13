<?php
session_start();
include '../config/koneksi.php';

if(!isset($_SESSION['login'])) { header('Location: ../admin/login.php'); exit; }

$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : '';

// --- FUNGSI AUTO-CREATE FOLDER UPLOADS ---
$target_dir = "../uploads/";
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0755, true);
}

// --- PROSES TAMBAH ---
if($aksi == 'tambah'){
    $nama = $_POST['nama_mobil'];
    $merk = $_POST['merk'];
    $plat = $_POST['plat_nomor'];
    $harga = $_POST['harga'];
    
    // Upload Foto
    $foto = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];
    $size = $_FILES['foto']['size'];
    $ext_boleh = array('png','jpg','jpeg','webp');
    $x = explode('.', $foto);
    $ekstensi = strtolower(end($x));
    
    $nama_baru = date('YmdHis')."_".rand(100,999).".".$ekstensi;
    $path = $target_dir . $nama_baru;

    // Validasi Ekstensi Gambar
    if(in_array($ekstensi, $ext_boleh) === true){
        if(move_uploaded_file($tmp, $path)){
            mysqli_query($koneksi, "INSERT INTO mobil (nama_mobil, merk, plat_nomor, harga, foto, status) VALUES ('$nama', '$merk', '$plat', '$harga', '$nama_baru', 'Tersedia')");
            $_SESSION['pesan'] = "<strong>Berhasil!</strong> Data mobil berhasil ditambahkan.";
            $_SESSION['jenis_pesan'] = "success";
        } else {
            $_SESSION['pesan'] = "<strong>Gagal!</strong> Foto gagal diupload.";
            $_SESSION['jenis_pesan'] = "danger";
        }
    } else {
        $_SESSION['pesan'] = "<strong>Peringatan!</strong> Ekstensi file tidak diperbolehkan (Hanya JPG/PNG/WEBP).";
        $_SESSION['jenis_pesan'] = "warning";
    }
    header("Location: ../admin/mobil.php");
}

// --- PROSES EDIT ---
elseif($aksi == 'edit'){
    $id = $_POST['id_mobil'];
    $nama = $_POST['nama_mobil'];
    $merk = $_POST['merk'];
    $plat = $_POST['plat_nomor'];
    $harga = $_POST['harga'];
    $status = $_POST['status'];
    $foto_lama = $_POST['foto_lama'];
    
    // Jika upload foto baru
    if($_FILES['foto']['name'] != ""){
        $foto = $_FILES['foto']['name'];
        $tmp = $_FILES['foto']['tmp_name'];
        $ext_boleh = array('png','jpg','jpeg','webp');
        $x = explode('.', $foto);
        $ekstensi = strtolower(end($x));
        
        $nama_baru = date('YmdHis')."_".rand(100,999).".".$ekstensi;
        $path = $target_dir . $nama_baru;
        
        if(in_array($ekstensi, $ext_boleh) === true){
            if(move_uploaded_file($tmp, $path)){
                // Hapus foto lama jika ada dan bukan gambar default
                if($foto_lama != "" && file_exists($target_dir . $foto_lama)) { 
                    unlink($target_dir . $foto_lama); 
                }
                mysqli_query($koneksi, "UPDATE mobil SET nama_mobil='$nama', merk='$merk', plat_nomor='$plat', harga='$harga', status='$status', foto='$nama_baru' WHERE id_mobil='$id'");
                $_SESSION['pesan'] = "<strong>Berhasil!</strong> Data mobil beserta foto berhasil diupdate.";
                $_SESSION['jenis_pesan'] = "success";
            }
        } else {
            $_SESSION['pesan'] = "<strong>Peringatan!</strong> Ekstensi file tidak diperbolehkan.";
            $_SESSION['jenis_pesan'] = "warning";
        }
    } else {
        // Jika foto tidak diganti
        mysqli_query($koneksi, "UPDATE mobil SET nama_mobil='$nama', merk='$merk', plat_nomor='$plat', harga='$harga', status='$status' WHERE id_mobil='$id'");
        $_SESSION['pesan'] = "<strong>Berhasil!</strong> Data mobil berhasil diupdate.";
        $_SESSION['jenis_pesan'] = "success";
    }
    header("Location: ../admin/mobil.php");
}

// --- PROSES HAPUS ---
elseif($aksi == 'hapus'){
    $id = $_GET['id'];
    $q = mysqli_query($koneksi, "SELECT foto FROM mobil WHERE id_mobil='$id'");
    $d = mysqli_fetch_array($q);
    
    // Hapus file fisik
    if($d['foto'] != "" && file_exists($target_dir . $d['foto'])) { 
        unlink($target_dir . $d['foto']); 
    }
    
    mysqli_query($koneksi, "DELETE FROM mobil WHERE id_mobil='$id'");
    $_SESSION['pesan'] = "<strong>Berhasil!</strong> Data mobil telah dihapus dari sistem.";
    $_SESSION['jenis_pesan'] = "danger";
    header("Location: ../admin/mobil.php");
}
?>