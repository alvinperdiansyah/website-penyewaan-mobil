<?php 
include '../config/koneksi.php';
include '../templates/header.php'; 
?>
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="text-center mb-4">
            <h4 class="fw-bold text-dark"><i class="bi bi-calendar-range text-primary"></i> Informasi Jadwal Terbooking</h4>
            <p class="text-muted">Gunakan jadwal ini sebagai referensi sebelum melakukan booking.</p>
        </div>

        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-4">
                <div class="alert alert-info border-0 shadow-sm d-flex align-items-center mb-4" role="alert">
                    <i class="bi bi-info-circle-fill fs-4 me-3"></i>
                    <div>
                        Daftar di bawah ini menampilkan mobil yang <strong>sedang dibooking atau disewa</strong>. Mobil yang ada di daftar ini tidak tersedia pada rentang tanggal yang tertera.
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="text-secondary">Periode Sewa (Mulai - Selesai)</th>
                                <th class="text-secondary">Mobil & Plat</th>
                                <th class="text-secondary">Paket Waktu</th>
                                <th class="text-secondary">Status Booking</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Ambil data yang Menunggu atau Disetujui, dan tanggal selesainya belum lewat dari hari ini
                            $q = mysqli_query($koneksi, "SELECT b.*, m.nama_mobil, m.plat_nomor 
                                                         FROM booking b 
                                                         JOIN mobil m ON b.id_mobil = m.id_mobil 
                                                         WHERE b.status IN ('Menunggu', 'Disetujui') 
                                                         AND b.tanggal_selesai >= CURDATE()
                                                         ORDER BY b.tanggal ASC");
                            
                            if(mysqli_num_rows($q) > 0):
                                while($d = mysqli_fetch_array($q)):
                                    // Cek apakah hari ini berada di dalam rentang waktu sewa
                                    $is_active = ($d['tanggal'] <= date('Y-m-d') && $d['tanggal_selesai'] >= date('Y-m-d'));
                            ?>
                            <tr class="<?= $is_active ? 'table-warning' : '' ?>">
                                <td class="fw-medium">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-calendar-event text-muted me-2"></i>
                                        <div>
                                            <?= date('d M Y', strtotime($d['tanggal'])) ?> 
                                            <i class="bi bi-arrow-right mx-1 text-primary"></i> 
                                            <?= date('d M Y', strtotime($d['tanggal_selesai'])) ?>
                                            <div class="text-muted small"><i class="bi bi-clock"></i> Jam <?= $d['jam_mulai'] ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-bold"><?= $d['nama_mobil'] ?></span><br>
                                    <span class="badge bg-light text-dark border mt-1"><i class="bi bi-123"></i> <?= $d['plat_nomor'] ?></span>
                                </td>
                                <td>
                                    <span class="badge bg-info text-dark border">
                                        <?= $d['lama_sewa'] ?> <?= str_replace("an", "", $d['tipe_sewa']) ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if($d['status'] == 'Disetujui'): ?>
                                        <span class="badge bg-success rounded-pill px-3"><i class="bi bi-check-circle"></i> Disetujui</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark rounded-pill px-3"><i class="bi bi-hourglass-split"></i> Menunggu</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php 
                                endwhile; 
                            else:
                            ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted py-5">
                                    <i class="bi bi-calendar2-check fs-1 d-block mb-3 text-success"></i>
                                    <h5 class="text-dark">Semua Jadwal Kosong!</h5>
                                    <p class="mb-0">Saat ini tidak ada mobil yang sedang disewa. Semua mobil tersedia untuk dibooking.</p>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="text-center mt-4">
                    <a href="home.php" class="btn btn-primary btn-modern px-4"><i class="bi bi-car-front"></i> Lihat Daftar Mobil</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include '../templates/footer.php'; ?>