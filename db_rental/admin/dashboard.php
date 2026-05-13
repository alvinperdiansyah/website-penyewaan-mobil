<?php 
include '../config/koneksi.php';
include '../templates/header.php'; 

if(!isset($_SESSION['login'])) { header('Location: login.php'); exit; }

$tot_mobil = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(*) as tot FROM mobil"))['tot'];
$tot_booking = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(*) as tot FROM booking"))['tot'];
$book_hari_ini = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(*) as tot FROM booking WHERE tanggal=CURDATE()"))['tot'];
$pendapatan = mysqli_fetch_array(mysqli_query($koneksi, "SELECT SUM(total_harga) as tot FROM booking WHERE status='Selesai'"))['tot'];
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-dark">Dashboard Admin</h3>
    <p class="text-muted mb-0"><i class="bi bi-calendar3"></i> <?= date('d F Y') ?></p>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-0 bg-primary text-white shadow-sm rounded-4 card-hover">
            <div class="card-body p-4 d-flex align-items-center">
                <div class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; font-size: 24px;">
                    <i class="bi bi-car-front-fill"></i>
                </div>
                <div>
                    <h6 class="mb-0 text-white-50">Total Mobil</h6>
                    <h3 class="mb-0 fw-bold"><?= $tot_mobil ?></h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 bg-success text-white shadow-sm rounded-4 card-hover">
            <div class="card-body p-4 d-flex align-items-center">
                <div class="bg-white text-success rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; font-size: 24px;">
                    <i class="bi bi-journal-check"></i>
                </div>
                <div>
                    <h6 class="mb-0 text-white-50">Total Booking</h6>
                    <h3 class="mb-0 fw-bold"><?= $tot_booking ?></h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 bg-warning text-dark shadow-sm rounded-4 card-hover">
            <div class="card-body p-4 d-flex align-items-center">
                <div class="bg-white text-warning rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; font-size: 24px;">
                    <i class="bi bi-bell-fill"></i>
                </div>
                <div>
                    <h6 class="mb-0 text-muted">Booking Hari Ini</h6>
                    <h3 class="mb-0 fw-bold"><?= $book_hari_ini ?></h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 bg-info text-white shadow-sm rounded-4 card-hover">
            <div class="card-body p-4 d-flex align-items-center">
                <div class="bg-white text-info rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; font-size: 24px;">
                    <i class="bi bi-wallet2"></i>
                </div>
                <div>
                    <h6 class="mb-0 text-white-50">Total Pendapatan</h6>
                    <h5 class="mb-0 fw-bold">Rp <?= number_format((float)$pendapatan,0,',','.') ?></h5>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0 rounded-4">
    <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
        <h5 class="fw-bold mb-0 text-dark">Antrean Booking Terbaru</h5>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th class="text-secondary">ID</th>
                    <th class="text-secondary">Penyewa & Mobil</th>
                    <th class="text-secondary">Waktu Sewa</th>
                    <th class="text-secondary">Status</th>
                    <th class="text-secondary">Aksi Update</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $q = mysqli_query($koneksi, "SELECT b.*, m.nama_mobil FROM booking b JOIN mobil m ON b.id_mobil=m.id_mobil ORDER BY b.id_booking DESC LIMIT 5");
                while($d = mysqli_fetch_array($q)):
                    $badge = ($d['status'] == 'Disetujui') ? 'success' : (($d['status'] == 'Ditolak') ? 'danger' : (($d['status'] == 'Selesai') ? 'primary' : 'warning'));
                ?>
                <tr>
                    <td class="fw-bold text-primary">#<?= $d['id_booking'] ?></td>
                    <td>
                        <span class="fw-medium"><?= $d['nama'] ?></span><br>
                        <small class="text-muted"><i class="bi bi-car-front"></i> <?= $d['nama_mobil'] ?></small>
                    </td>
                    <td>
                        <i class="bi bi-calendar2-date text-muted"></i> <?= date('d M Y', strtotime($d['tanggal'])) ?><br>
                        <small class="text-muted"><i class="bi bi-clock"></i> <?= $d['jam_mulai'] ?> - <?= $d['jam_selesai'] ?></small>
                    </td>
                    <td><span class="badge bg-<?= $badge ?> rounded-pill px-3 py-2"><?= $d['status'] ?></span></td>
                    <td>
                        <form action="../proses/proses_update.php" method="POST" class="d-inline">
                            <input type="hidden" name="id_booking" value="<?= $d['id_booking'] ?>">
                            <select name="status" class="form-select form-select-sm d-inline w-auto border-<?= $badge ?>" onchange="this.form.submit()">
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
        <div class="text-center mt-3">
            <a href="booking.php" class="btn btn-outline-primary btn-sm btn-modern px-4">Lihat Semua Booking <i class="bi bi-arrow-right"></i></a>
        </div>
    </div>
</div>
<?php include '../templates/footer.php'; ?>