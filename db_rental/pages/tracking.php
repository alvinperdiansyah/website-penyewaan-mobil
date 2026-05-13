<?php 
include '../config/koneksi.php';
include '../templates/header.php'; 
?>

<!-- CSS khusus untuk menyembunyikan elemen saat diprint -->
<style>
    @media print {
        body { background-color: #fff !important; }
        .navbar, .footer, .form-pencarian, .btn-aksi, .alert-sukses { display: none !important; }
        .card { box-shadow: none !important; border: 1px solid #ddd !important; }
        .container { max-width: 100% !important; }
    }
</style>

<div class="row justify-content-center">
    <div class="col-md-7">
        
        <?php if(isset($_GET['status']) && $_GET['status'] == 'sukses'): ?>
            <div class="alert alert-success shadow-sm border-0 rounded-4 alert-sukses mb-4 d-flex align-items-center">
                <i class="bi bi-check-circle-fill fs-1 me-3"></i>
                <div>
                    <h5 class="alert-heading fw-bold mb-1">Booking Berhasil Dibuat!</h5>
                    <p class="mb-0">Ini adalah bukti pemesanan Anda. Harap simpan atau <strong>ingat ID Booking Anda</strong> untuk mengecek status kedepannya.</p>
                </div>
            </div>
        <?php endif; ?>

        <div class="card shadow-sm border-0 rounded-4 form-pencarian mb-4">
            <div class="card-body text-center p-4">
                <h4 class="fw-bold text-dark mb-4"><i class="bi bi-search text-primary"></i> Lacak & Cetak Booking</h4>
                <form method="GET" action="">
                    <div class="input-group input-group-lg shadow-sm">
                        <span class="input-group-text bg-white"><i class="bi bi-hash"></i></span>
                        <input type="number" name="id" class="form-control" placeholder="Masukkan ID Booking Anda (Contoh: 12)" required>
                        <button class="btn btn-primary fw-medium px-4" type="submit">Cari Data</button>
                    </div>
                </form>
            </div>
        </div>

        <?php
        if(isset($_GET['id'])):
            $id = $_GET['id'];
            $q = mysqli_query($koneksi, "SELECT b.*, m.nama_mobil, m.plat_nomor FROM booking b JOIN mobil m ON b.id_mobil = m.id_mobil WHERE b.id_booking='$id'");
            
            if(mysqli_num_rows($q) > 0):
                $b = mysqli_fetch_array($q);
                // Logika Badge Status
                $badge = 'warning'; $icon = 'bi-hourglass-split';
                if($b['status'] == 'Disetujui') { $badge = 'success'; $icon = 'bi-check-circle-fill'; }
                elseif($b['status'] == 'Ditolak') { $badge = 'danger'; $icon = 'bi-x-circle-fill'; }
                elseif($b['status'] == 'Selesai') { $badge = 'primary'; $icon = 'bi-flag-fill'; }

                // Setup WhatsApp Link (Ganti nomor admin sesuai kebutuhan)
                $no_admin = "6281234567890"; 
                $pesan_wa = "Halo Admin RentalMobil, saya ingin konfirmasi pesanan saya.%0A%0A*ID Booking:* #" . $b['id_booking'] . "%0A*Nama:* " . $b['nama'] . "%0A*Mobil:* " . $b['nama_mobil'] . "%0A%0AMohon info selanjutnya. Terima kasih.";
                $link_wa = "https://wa.me/" . $no_admin . "?text=" . $pesan_wa;
        ?>
            <!-- Tampilan Bukti Booking (Invoice/Tiket) -->
            <div class="card shadow border-0 rounded-4" id="areaPrint">
                <div class="card-header bg-white border-bottom-0 text-center pt-4">
                    <h3 class="fw-bold text-primary mb-0"><i class="bi bi-car-front-fill"></i> RentalMobil</h3>
                    <p class="text-muted small">Bukti Pemesanan Kendaraan</p>
                    <hr>
                </div>
                <div class="card-body px-5 pb-5">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h6 class="text-muted mb-1">ID Booking Anda</h6>
                            <h2 class="fw-bold mb-0 text-dark">#<?= $b['id_booking'] ?></h2>
                        </div>
                        <div class="text-end">
                            <h6 class="text-muted mb-1">Status Pesanan</h6>
                            <span class="badge bg-<?= $badge ?> fs-6 rounded-pill"><i class="bi <?= $icon ?>"></i> <?= $b['status'] ?></span>
                        </div>
                    </div>

                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="text-muted" width="40%">Nama Penyewa</td>
                            <td class="fw-bold">: <?= $b['nama'] ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">No. HP / WhatsApp</td>
                            <td class="fw-bold">: <?= $b['no_hp'] ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Kendaraan</td>
                            <td class="fw-bold">: <?= $b['nama_mobil'] ?> (<?= $b['plat_nomor'] ?>)</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Periode Sewa</td>
                            <td class="fw-bold">: <?= date('d M Y', strtotime($b['tanggal'])) ?> s/d <?= date('d M Y', strtotime($b['tanggal_selesai'])) ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Paket Waktu</td>
                            <td class="fw-bold">: <?= $b['lama_sewa'] ?> <?= str_replace("an", "", $b['tipe_sewa']) ?> <br><small class="text-muted ms-2">(Pengambilan/Kembali Jam <?= $b['jam_mulai'] ?>)</small></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Alamat Penjemputan</td>
                            <td class="fw-bold">: <?= $b['alamat'] ?></td>
                        </tr>
                    </table>

                    <div class="bg-light p-3 rounded-3 mt-4 text-center border">
                        <h6 class="text-muted mb-1">Total yang harus dibayar:</h6>
                        <h2 class="text-primary fw-bold mb-0">Rp <?= number_format($b['total_harga'],0,',','.') ?></h2>
                    </div>

                    <!-- Tombol Aksi (Akan hilang saat diprint) -->
                    <div class="row mt-4 btn-aksi">
                        <div class="col-sm-6 mb-2">
                            <button onclick="window.print()" class="btn btn-outline-dark w-100 py-2 fw-medium"><i class="bi bi-printer"></i> Cetak PDF / Simpan</button>
                        </div>
                        <div class="col-sm-6 mb-2">
                            <a href="<?= $link_wa ?>" target="_blank" class="btn btn-success w-100 py-2 fw-medium"><i class="bi bi-whatsapp"></i> Konfirmasi ke Admin</a>
                        </div>
                    </div>
                </div>
            </div>
            
        <?php else: ?>
            <div class="alert alert-danger shadow-sm text-center border-0 rounded-3">
                <i class="bi bi-exclamation-triangle-fill fs-3 d-block mb-2"></i>
                Maaf, ID Booking <strong>#<?= $id ?></strong> tidak ditemukan di database.
            </div>
        <?php endif; endif; ?>
    </div>
</div>

<?php include '../templates/footer.php'; ?>