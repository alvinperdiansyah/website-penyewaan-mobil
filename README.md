# 📱 Sistem Booking Sewa Mobil (RentalMobil)

#dibuat oleh:
# 1.Alvin perdiansyah dwi putra (2488010019)
# 2.abdullah assegaf (2488010076)

## 📌 Deskripsi Umum

**RentalMobil** merupakan sistem informasi berbasis web yang dirancang untuk mempermudah proses penyewaan mobil secara online. Sistem ini menghubungkan calon penyewa *(user)* dengan pengelola rental *(admin)* secara terintegrasi sehingga proses booking menjadi lebih cepat, praktis, dan efisien.

---

# ⚙️ Teknologi yang Digunakan

| Bagian           | Teknologi                              |
| ---------------- | -------------------------------------- |
| **Backend**      | PHP Native *(terstruktur & modular)*   |
| **Database**     | MySQL / MySQLi                         |
| **Frontend**     | HTML5, CSS3, JavaScript *(Vanilla JS)* |
| **UI Framework** | Bootstrap 5 *(CDN)* & Bootstrap Icons  |

---

# 👤 Fitur Utama Pengguna (Penyewa)

### 🔎 Katalog & Pencarian Mobil

Menampilkan daftar mobil yang tersedia lengkap dengan fitur pencarian berdasarkan nama maupun merk mobil sehingga memudahkan pengguna menemukan kendaraan yang diinginkan.

### 📅 Booking Fleksibel

Pengguna dapat memilih berbagai paket penyewaan seperti:

* Harian
* Mingguan
* Bulanan
* Tahunan

Sistem secara otomatis menghitung:

* Total harga sewa
* Tanggal selesai penyewaan

### 🕒 Cek Jadwal Ketersediaan

Pengguna dapat melihat jadwal mobil yang sedang disewa sehingga menghindari kesalahan pemilihan tanggal booking.

### 🧾 Tracking & Invoice Digital

Setiap pemesanan memiliki:

* ID Booking unik
* Pelacakan status booking
* Fitur cetak invoice / bukti pemesanan dalam format PDF

### 💬 Integrasi WhatsApp

Tersedia tombol konfirmasi yang langsung terhubung ke WhatsApp admin dengan pesan otomatis *(Auto-Text)* sehingga komunikasi menjadi lebih praktis.

---

# 🔐 Fitur Utama Admin (Pengelola)

### 🔑 Sistem Login

Fitur login dilengkapi dengan:

* Show / Hide Password
* Auto-focus input
* Tampilan modern dan mudah digunakan

### 📊 Dashboard Interaktif

Dashboard admin menampilkan ringkasan data penting seperti:

* Total mobil
* Total booking
* Booking hari ini
* Total pendapatan

### 🚗 Manajemen Data Mobil (CRUD)

Admin dapat:

* Menambah data mobil
* Mengedit data mobil
* Menghapus data mobil
* Upload foto mobil

Fitur upload juga dilengkapi:

* Live Preview gambar
* Validasi ekstensi file gambar

### 📋 Manajemen Booking

Admin dapat memproses pesanan dengan mengubah status menjadi:

* Menunggu
* Disetujui
* Ditolak
* Selesai

Selain itu tersedia fitur filter booking berdasarkan tanggal.

### 📆 Pemantauan Jadwal Sewa

Sistem menyediakan tabel khusus untuk memantau mobil yang sedang aktif disewa secara akurat dan real-time.

---

# 🚀 Keunggulan & Keamanan Sistem

### ✅ Anti Double Booking

Sistem memiliki validasi cerdas pada database untuk mencegah bentroknya jadwal penyewaan pada mobil yang sama.

### 📁 Auto Create Folder

Folder `uploads` akan dibuat otomatis apabila belum tersedia sehingga mencegah error saat proses upload foto mobil.

### 🎨 UI/UX Modern & Responsif

Tampilan dirancang modern dan nyaman digunakan dengan fitur:

* Card design modern
* Efek hover animation
* Sticky footer
* Responsive layout *(mobile & desktop friendly)*

### 🧩 Struktur Kode Modular

Struktur project dipisahkan ke dalam beberapa folder seperti:

* `config`
* `pages`
* `admin`
* `proses`
* `templates`

Sehingga kode lebih:

* Rapi
* Mudah dipelajari
* Mudah dikembangkan kembali

---

# 🎯 Tujuan Sistem

Sistem ini dibuat untuk meningkatkan efisiensi pengelolaan rental mobil sekaligus memberikan pengalaman pemesanan kendaraan yang lebih mudah, cepat, aman, dan modern bagi pengguna maupun admin.
