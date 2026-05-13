<?php
session_start();
include '../config/koneksi.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nama = $_POST['nama'];
    $id_mobil = $_POST['id_mobil'];
    $tanggal = $_POST['tanggal'];
    $jam_mulai = $_POST['jam_mulai'];
    $tipe_sewa = $_POST['tipe_sewa'];
    $lama_sewa = $_POST['lama_sewa'];
    $tanggal_selesai = $_POST['tanggal_selesai'];
    $jam_selesai = $_POST['jam_selesai'];
    $total_harga = $_POST['total_harga'];
    $no_hp = $_POST['no_hp'];
    $alamat = $_POST['alamat'];

    // Validasi Bentrok Jadwal Menggunakan Rentang Tanggal
    // Rumus: (MulaiA <= SelesaiB) AND (SelesaiA >= MulaiB)
    $cek = mysqli_query($koneksi, "SELECT * FROM booking 
                                   WHERE id_mobil='$id_mobil' 
                                   AND status IN ('Menunggu', 'Disetujui') 
                                   AND (tanggal <= '$tanggal_selesai' AND tanggal_selesai >= '$tanggal')");

    if(mysqli_num_rows($cek) > 0){
        $_SESSION['pesan'] = "<strong>Maaf, jadwal bentrok!</strong> Mobil ini sudah disewa pada rentang tanggal tersebut. Silakan pilih tanggal lain atau mobil yang berbeda.";
        $_SESSION['jenis_pesan'] = "danger";
        header("Location: ../pages/booking.php?id=$id_mobil");
        exit;
    }

    $query = "INSERT INTO booking (nama, id_mobil, tanggal, jam_mulai, tipe_sewa, lama_sewa, tanggal_selesai, jam_selesai, total_harga, no_hp, alamat) 
              VALUES ('$nama', '$id_mobil', '$tanggal', '$jam_mulai', '$tipe_sewa', '$lama_sewa', '$tanggal_selesai', '$jam_selesai', '$total_harga', '$no_hp', '$alamat')";
    
    if(mysqli_query($koneksi, $query)){
        $id_b = mysqli_insert_id($koneksi);
        header("Location: ../pages/tracking.php?id=$id_b&status=sukses");
        exit;
    } else {
        $_SESSION['pesan'] = "<strong>Gagal!</strong> " . mysqli_error($koneksi);
        $_SESSION['jenis_pesan'] = "danger";
        header("Location: ../pages/booking.php?id=$id_mobil");
        exit;
    }
}
?>