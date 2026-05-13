<?php 
include '../config/koneksi.php';
include '../templates/header.php'; 

if(!isset($_SESSION['login'])) { header('Location: login.php'); exit; }

$filter_tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : '';
?>
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3 align-items-center">
            <div class="col-auto">
                <label class="col-form-label fw-bold">Filter Tanggal Booking:</label>
            </div>
            <div class="col-auto">
                <input type="date" name="tanggal" class="form-control" value="<?= $filter_tanggal ?>">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Cari Data</button>
                <a href="booking.php" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0 text-primary">Semua Riwayat Booking</h5>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Nama Penyewa</th>
                    <th>Mobil</th>
                    <th>Waktu Sewa</th>
                    <th>No. HP</th>
                    <th>Total Biaya</th>
                    <th>Status</th>
                    <th>Ubah Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Logika Filter Tanggal
                $where = "";
                if($filter_tanggal != ""){
                    $where = "WHERE b.tanggal = '$filter_tanggal'";
                }

                $q = mysqli_query($koneksi, "SELECT b.*, m.nama_mobil FROM booking b JOIN mobil m ON b.id_mobil=m.id_mobil $where ORDER BY b.id_booking DESC");
                while($d = mysqli_fetch_array($q)):
                    $badge = ($d['status'] == 'Disetujui') ? 'success' : (($d['status'] == 'Ditolak') ? 'danger' : (($d['status'] == 'Selesai') ? 'primary' : 'warning'));
                ?>
                <tr>
                    <td>#<?= $d['id_booking'] ?></td>
                    <td><?= $d['nama'] ?></td>
                    <td><?= $d['nama_mobil'] ?></td>
                    <td><?= date('d/m/Y', strtotime($d['tanggal'])) ?> <br> <small class="text-muted"><?= $d['jam_mulai'] ?> - <?= $d['jam_selesai'] ?></small></td>
                    <td><?= $d['no_hp'] ?></td>
                    <td>Rp <?= number_format($d['total_harga'],0,',','.') ?></td>
                    <td><span class="badge bg-<?= $badge ?>"><?= $d['status'] ?></span></td>
                    <td>
                        <form action="../proses/proses_update.php" method="POST">
                            <input type="hidden" name="id_booking" value="<?= $d['id_booking'] ?>">
                            <select name="status" class="form-select form-select-sm w-auto" onchange="this.form.submit()">
                                <option value="Menunggu" <?= $d['status']=='Menunggu'?'selected':'' ?>>Menunggu</option>
                                <option value="Disetujui" <?= $d['status']=='Disetujui'?'selected':'' ?>>Disetujui</option>
                                <option value="Ditolak" <?= $d['status']=='Ditolak'?'selected':'' ?>>Ditolak</option>
                                <option value="Selesai" <?= $d['status']=='Selesai'?'selected':'' ?>>Selesai</option>
                            </select>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include '../templates/footer.php'; ?>