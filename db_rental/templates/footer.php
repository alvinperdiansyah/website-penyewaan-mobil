</div> <!-- End Container -->

<!-- Footer Modern (Sticky Bottom) -->
<footer class="bg-dark text-light pt-5 pb-3 mt-auto border-top border-primary border-5">
    <div class="container">
        <div class="row gy-4">
            <!-- Kolom 1: Brand & Info -->
            <div class="col-lg-4 col-md-6">
                <h5 class="text-white fw-bold mb-3"><i class="bi bi-car-front-fill text-primary me-2"></i>RentalMobil</h5>
                <p class="text-white-50 small pe-lg-4">
                    Solusi terbaik untuk kebutuhan transportasi Anda. Kami menyediakan berbagai pilihan kendaraan berkualitas dengan harga terjangkau, pelayanan cepat, dan aman.
                </p>
                <div class="d-flex gap-3 mt-3">
                    <a href="#" class="text-light fs-5 text-decoration-none"><i class="bi bi-facebook hover-primary"></i></a>
                    <a href="#" class="text-light fs-5 text-decoration-none"><i class="bi bi-instagram hover-primary"></i></a>
                    <a href="#" class="text-light fs-5 text-decoration-none"><i class="bi bi-twitter hover-primary"></i></a>
                    <a href="#" class="text-light fs-5 text-decoration-none"><i class="bi bi-youtube hover-primary"></i></a>
                </div>
            </div>

            <!-- Kolom 2: Tautan Cepat -->
            <div class="col-lg-4 col-md-6">
                <h5 class="text-white fw-bold mb-3">Tautan Cepat</h5>
                <ul class="list-unstyled text-white-50 small">
                    <li class="mb-2"><a href="../pages/home.php" class="text-decoration-none text-white-50 text-hover-white"><i class="bi bi-chevron-right small me-1"></i> Koleksi Mobil</a></li>
                    <li class="mb-2"><a href="../pages/booking.php" class="text-decoration-none text-white-50 text-hover-white"><i class="bi bi-chevron-right small me-1"></i> Form Booking</a></li>
                    <li class="mb-2"><a href="../pages/jadwal.php" class="text-decoration-none text-white-50 text-hover-white"><i class="bi bi-chevron-right small me-1"></i> Ketersediaan Jadwal</a></li>
                    <li class="mb-2"><a href="../pages/tracking.php" class="text-decoration-none text-white-50 text-hover-white"><i class="bi bi-chevron-right small me-1"></i> Lacak Status Pesanan</a></li>
                </ul>
            </div>

            <!-- Kolom 3: Kontak -->
            <div class="col-lg-4 col-md-12">
                <h5 class="text-white fw-bold mb-3">Hubungi Kami</h5>
                <ul class="list-unstyled text-white-50 small">
                    <li class="mb-3 d-flex">
                        <i class="bi bi-geo-alt-fill text-primary me-3 fs-5"></i>
                        <span>Jl. perjuangan No. 4513, Jawa Barat<br>Indonesia</span>
                    </li>
                    <li class="mb-3 d-flex">
                        <i class="bi bi-telephone-fill text-primary me-3 fs-5"></i>
                        <span>+62 8591-4830-0348</span>
                    </li>
                    <li class="mb-3 d-flex">
                        <i class="bi bi-envelope-fill text-primary me-3 fs-5"></i>
                        <span>cs@rentalmobil.com</span>
                    </li>
                </ul>
            </div>
        </div>

        <hr class="border-secondary mt-4 mb-3">

        <!-- Copyright & Credit -->
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <p class="mb-0 text-white-50 small">&copy; <?= date('Y') ?> <strong>RentalMobil</strong>. Hak Cipta Dilindungi.</p>
            </div>
            <div class="col-md-6 text-center text-md-end mt-2 mt-md-0">
                <p class="mb-0 text-white-50 small">Dikembangkan dengan <i class="bi bi-heart-fill text-danger"></i> oleh Alvin & Abdul</p>
            </div>
        </div>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- CSS Tambahan Khusus Footer -->
<style>
    /* CSS WAJIB AGAR FOOTER SELALU DI BAWAH (STICKY BOTTOM) */
    html, body {
        height: 100%;
    }
    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }
    footer {
        margin-top: auto !important;
    }

    /* Efek garis biru di atas footer */
    .border-5 {
        border-width: 4px !important;
    }
    
    /* Animasi teks tautan saat disorot */
    .text-hover-white {
        transition: all 0.3s ease;
        display: inline-block;
    }
    .text-hover-white:hover {
        color: #ffffff !important;
        transform: translateX(5px); /* Geser ke kanan sedikit */
    }

    /* Animasi ikon sosmed saat disorot */
    .hover-primary {
        transition: color 0.3s ease;
    }
    .hover-primary:hover {
        color: #0d6efd !important;
    }
</style>

</body>
</html>