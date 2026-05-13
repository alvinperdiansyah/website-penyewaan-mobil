<?php 
include '../config/koneksi.php';
include '../templates/header.php'; 

$mobil_terpilih = isset($_GET['id']) ? $_GET['id'] : '';
?>
<div class="card shadow-sm max-w-lg mx-auto border-0 rounded-4 mb-5">
    <div class="card-header bg-white border-bottom-0 pt-4 pb-0 text-center">
        <h4 class="mb-0 text-primary fw-bold"><i class="bi bi-calendar2-plus"></i> Form Booking Mobil</h4>
        <p class="text-muted small">Lengkapi data di bawah ini untuk melakukan pemesanan</p>
    </div>
    <div class="card-body p-4">
        <?php if(isset($_SESSION['pesan'])): ?>
            <div class="alert alert-<?= $_SESSION['jenis_pesan'] ?> shadow-sm rounded-3">
                <?= $_SESSION['pesan'] ?>
            </div>
            <?php unset($_SESSION['pesan'], $_SESSION['jenis_pesan']); ?>
        <?php endif; ?>

        <form action="../proses/proses_booking.php" method="POST">
            <div class="mb-3">
                <label class="form-label fw-medium">Nama Penyewa</label>
                <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-medium">Pilih Mobil</label>
                <select name="id_mobil" id="id_mobil" class="form-select" onchange="hitung()" required>
                    <option value="">-- Pilih Mobil --</option>
                    <?php
                    $q = mysqli_query($koneksi, "SELECT * FROM mobil WHERE status='Tersedia'");
                    while($m = mysqli_fetch_array($q)):
                    ?>
                    <option value="<?= $m['id_mobil'] ?>" data-harga="<?= $m['harga'] ?>" <?= ($m['id_mobil'] == $mobil_terpilih) ? 'selected' : '' ?>>
                        <?= $m['nama_mobil'] ?> - Rp <?= number_format($m['harga'],0,',','.') ?> / Hari
                    </option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <div class="row bg-light p-3 rounded-3 mb-3 border">
                <h6 class="text-primary fw-bold mb-3">Rincian Waktu Sewa</h6>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-medium">Tanggal Mulai</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control" onchange="hitung()" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-medium">Jam Ambil</label>
                    <input type="time" name="jam_mulai" id="jam_mulai" class="form-control" onchange="hitung()" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-medium">Paket Sewa</label>
                    <select name="tipe_sewa" id="tipe_sewa" class="form-select" onchange="hitung()" required>
                        <option value="Harian">Harian</option>
                        <option value="Mingguan">Mingguan (7 Hari)</option>
                        <option value="Bulanan">Bulanan (30 Hari)</option>
                        <option value="Tahunan">Tahunan (365 Hari)</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-medium">Berapa Lama?</label>
                    <div class="input-group">
                        <input type="number" name="lama_sewa" id="lama_sewa" class="form-control" min="1" value="1" oninput="hitung()" required>
                        <span class="input-group-text bg-white" id="label_lama">Hari</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-medium text-muted">Tanggal Selesai <small>(Otomatis)</small></label>
                    <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control bg-light" readonly>
                    <!-- Menyimpan jam selesai sama dengan jam mulai -->
                    <input type="hidden" name="jam_selesai" id="jam_selesai"> 
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold text-success">Total Biaya <small>(Rp)</small></label>
                    <input type="number" name="total_harga" id="total_harga" class="form-control bg-white fw-bold text-success fs-5" readonly>
                </div>
            </div>

            <hr class="text-muted">

            <div class="mb-3">
                <label class="form-label fw-medium">No HP / WhatsApp</label>
                <input type="text" name="no_hp" class="form-control" placeholder="Contoh: 08123456789" required>
            </div>
            <div class="mb-4">
                <label class="form-label fw-medium">Alamat Lengkap</label>
                <textarea name="alamat" class="form-control" rows="2" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-modern w-100 py-3 fs-5"><i class="bi bi-check2-circle"></i> Konfirmasi Booking</button>
        </form>
    </div>
</div>

<script>
function hitung() {
    const selectMobil = document.getElementById('id_mobil');
    const tglMulai = document.getElementById('tanggal').value;
    const jamMulai = document.getElementById('jam_mulai').value;
    const tipeSewa = document.getElementById('tipe_sewa').value;
    const lamaSewa = parseInt(document.getElementById('lama_sewa').value) || 0;

    // Update label input
    document.getElementById('label_lama').innerText = tipeSewa.replace("an", "");

    if (selectMobil.value && tglMulai && lamaSewa > 0 && jamMulai) {
        const hargaPerHari = parseInt(selectMobil.options[selectMobil.selectedIndex].getAttribute('data-harga'));
        let totalHari = 0;

        // Hitung pengali hari berdasarkan tipe
        if(tipeSewa === 'Harian') totalHari = lamaSewa;
        else if(tipeSewa === 'Mingguan') totalHari = lamaSewa * 7;
        else if(tipeSewa === 'Bulanan') totalHari = lamaSewa * 30;
        else if(tipeSewa === 'Tahunan') totalHari = lamaSewa * 365;

        // Hitung Total Harga
        let totalHarga = hargaPerHari * totalHari;
        document.getElementById('total_harga').value = totalHarga;

        // Hitung Tanggal Selesai
        let startDate = new Date(tglMulai);
        startDate.setDate(startDate.getDate() + totalHari);
        
        let dd = String(startDate.getDate()).padStart(2, '0');
        let mm = String(startDate.getMonth() + 1).padStart(2, '0'); // January is 0!
        let yyyy = startDate.getFullYear();

        document.getElementById('tanggal_selesai').value = yyyy + '-' + mm + '-' + dd;
        document.getElementById('jam_selesai').value = jamMulai; // Jam kembali = Jam ambil
    }
}
</script>
<?php include '../templates/footer.php'; ?>