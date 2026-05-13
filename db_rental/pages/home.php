<?php 
include '../config/koneksi.php';
include '../templates/header.php'; 

// Menangkap kata kunci pencarian
$keyword = isset($_GET['cari']) ? $_GET['cari'] : '';
?>

<!-- Hero Section -->
<div class="row mb-5">
    <div class="col-12">
        <div class="hero-banner text-center shadow">
            <h1 class="fw-bold mb-3">Sewa Mobil Mudah, Cepat, dan Aman!</h1>
            <p class="lead mb-4">Temukan berbagai pilihan mobil terbaik untuk perjalanan Anda dengan harga terjangkau.</p>
            
            <!-- Form Pencarian User -->
            <form action="" method="GET" class="d-flex justify-content-center">
                <div class="input-group shadow-sm" style="max-width: 600px;">
                    <span class="input-group-text bg-white border-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="cari" class="form-control border-0 py-3" placeholder="Cari nama mobil atau merk (Cth: Avanza, Toyota)..." value="<?= $keyword ?>">
                    <button type="submit" class="btn btn-dark px-4 fw-medium border-0">Cari Mobil</button>
                </div>
            </form>

        </div>
    </div>
</div>

<div class="row mb-3" id="koleksi-mobil">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h4 class="fw-bold text-dark border-bottom border-primary border-3 pb-2 d-inline-block">
            <?= $keyword != '' ? 'Hasil Pencarian: "' . $keyword . '"' : 'Armada Kami' ?>
        </h4>
        <?php if($keyword != ''): ?>
            <a href="home.php" class="btn btn-outline-danger btn-sm"><i class="bi bi-x-circle"></i> Reset Filter</a>
        <?php endif; ?>
    </div>
</div>

<div class="row">
    <?php
    // Logika Pencarian
    if($keyword != ''){
        $query = mysqli_query($koneksi, "SELECT * FROM mobil WHERE status='Tersedia' AND (nama_mobil LIKE '%$keyword%' OR merk LIKE '%$keyword%')");
    } else {
        $query = mysqli_query($koneksi, "SELECT * FROM mobil WHERE status='Tersedia'");
    }

    if(mysqli_num_rows($query) > 0):
        while($data = mysqli_fetch_array($query)):
    ?>
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm border-0 rounded-4 card-hover h-100 overflow-hidden">
            <div class="position-relative">
                <img src="../uploads/<?= $data['foto'] ?>" class="card-img-top" alt="<?= $data['nama_mobil'] ?>" style="height: 220px; object-fit: cover;" onerror="this.src='https://via.placeholder.com/400x220?text=Mobil+Image'">
                <span class="position-absolute top-0 end-0 bg-success text-white px-3 py-1 m-2 rounded-pill small fw-medium"><i class="bi bi-check-circle"></i> Tersedia</span>
            </div>
            <div class="card-body">
                <h5 class="card-title fw-bold mb-1"><?= $data['nama_mobil'] ?></h5>
                <p class="text-muted small mb-3"><i class="bi bi-tag-fill me-1"></i> <?= $data['merk'] ?> &nbsp;|&nbsp; <i class="bi bi-card-text me-1"></i> <?= $data['plat_nomor'] ?></p>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <h5 class="fw-bold text-primary mb-0">Rp <?= number_format($data['harga'], 0, ',', '.') ?><span class="text-muted fs-6 fw-normal">/hari</span></h5>
                </div>
            </div>
            <div class="card-footer bg-white border-0 pb-3 pt-0">
                <a href="booking.php?id=<?= $data['id_mobil'] ?>" class="btn btn-primary w-100 btn-modern py-2"><i class="bi bi-calendar-plus"></i> Booking Sekarang</a>
            </div>
        </div>
    </div>
    <?php 
        endwhile; 
    else: 
    ?>
    <div class="col-12 text-center py-5">
        <i class="bi bi-search fs-1 text-muted d-block mb-3"></i>
        <h5 class="text-muted">Maaf, mobil yang Anda cari tidak ditemukan.</h5>
    </div>
    <?php endif; ?>
</div>

<?php include '../templates/footer.php'; ?>