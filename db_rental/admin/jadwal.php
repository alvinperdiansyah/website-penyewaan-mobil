<?php 
include '../config/koneksi.php';
include '../templates/header.php'; 

if(!isset($_SESSION['login'])) { header('Location: login.php'); exit; }
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold text-dark"><i class="bi bi-calendar-check text-primary"></i> Jadwal Sewa Berjalan</h4>
</div>

<div class="card shadow-sm border-0 rounded-4">
    <div class="card-body">
        <div class="alert alert-primary border-0 shadow-sm d-flex align-items-center" role="alert">
            <i class="bi bi-info-circle-fill fs-4 me-3"></i>
            <div>
                Menampilkan daftar mobil yang <strong>sudah disetujui</strong> penyewaannya. Anda bisa melihat masa periode sewanya.
            </div>
        </div>

        <div class="table-responsive mt-4">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="text-secondary">Periode Sewa (Mulai - Selesai)</th>
                        <th class="text-secondary">Nama Penyewa</th>
                        <th class="text-secondary">Mobil</th>
                        <th class="text-secondary">Paket Sewa</th>
                        <th class="text-secondary">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Ambil data yang disetujui, dan tanggal selesainya masih hari ini atau di masa depan
                    $q = mysqli_query($koneksi, "SELECT b.*, m.nama_mobil, m.plat_nomor 
                                                 FROM booking b 
                                                 JOIN mobil m ON b.id_mobil = m.id_mobil 
                                                 WHERE b.status = 'Disetujui' 
                                                 AND b.tanggal_selesai >= CURDATE()
                                                 ORDER BY b.tanggal ASC");
                    
                    if(mysqli_num_rows($q) > 0):
                        while($d = mysqli_fetch_array($q)):
                            $is_active = ($d['tanggal'] <= date('Y-m-d') && $d['tanggal_selesai'] >= date('Y-m-d'));
                    ?>
                    <tr class="<?= $is_active ? 'table-warning' : '' ?>">
                        <td class="fw-medium">
                            <i class="bi bi-calendar-event text-muted me-1"></i> <?= date('d M Y', strtotime($d['tanggal'])) ?> 
                            <i class="bi bi-arrow-right mx-1 text-primary"></i> 
                            <?= date('d M Y', strtotime($d['tanggal_selesai'])) ?>
                            <br><small class="text-muted">Jam: <?= $d['jam_mulai'] ?></small>
                        </td>
                        <td class="fw-bold"><?= $d['nama'] ?><br><small class="fw-normal"><a href="https://wa.me/<?= $d['no_hp'] ?>" target="_blank" class="text-success text-decoration-none"><i class="bi bi-whatsapp"></i> Hubungi</a></small></td>
                        <td>
                            <?= $d['nama_mobil'] ?> <br>
                            <span class="badge bg-secondary"><i class="bi bi-123"></i> <?= $d['plat_nomor'] ?></span>
                        </td>
                        <td><span class="badge bg-info text-dark border"><?= $d['lama_sewa'] ?> <?= str_replace("an", "", $d['tipe_sewa']) ?></span></td>
                        <td><span class="badge bg-success rounded-pill"><i class="bi bi-check-circle"></i> Sedang Berjalan</span></td>
                    </tr>
                    <?php 
                        endwhile; 
                    else:
                    ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted py-5">
                            <i class="bi bi-calendar-x fs-1 d-block mb-2"></i>
                            Belum ada jadwal penyewaan yang aktif.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../templates/footer.php'; ?>