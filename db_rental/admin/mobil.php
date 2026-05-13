<?php 
include '../config/koneksi.php';
include '../templates/header.php'; 

if(!isset($_SESSION['login'])) { header('Location: login.php'); exit; }
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold text-dark"><i class="bi bi-car-front text-primary"></i> Kelola Data Mobil</h4>
    <button type="button" class="btn btn-primary btn-modern shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
      <i class="bi bi-plus-circle"></i> Tambah Mobil
    </button>
</div>

<?php if(isset($_SESSION['pesan'])): ?>
    <div class="alert alert-<?= $_SESSION['jenis_pesan'] ?> alert-dismissible fade show shadow-sm" role="alert">
        <?= $_SESSION['pesan'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['pesan'], $_SESSION['jenis_pesan']); ?>
<?php endif; ?>

<div class="card shadow-sm border-0 rounded-4">
    <div class="card-body table-responsive">
        <table class="table table-hover align-middle text-center">
            <thead class="table-light">
                <tr>
                    <th class="text-secondary">No</th>
                    <th class="text-secondary">Foto</th>
                    <th class="text-secondary">Nama Mobil & Merk</th>
                    <th class="text-secondary">Plat Nomor</th>
                    <th class="text-secondary">Harga / Hari</th>
                    <th class="text-secondary">Status</th>
                    <th class="text-secondary">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $q = mysqli_query($koneksi, "SELECT * FROM mobil ORDER BY id_mobil DESC");
                while($d = mysqli_fetch_array($q)):
                ?>
                <tr>
                    <td class="fw-medium"><?= $no++ ?></td>
                    <td>
                        <img src="../uploads/<?= $d['foto'] ?>" width="90" class="rounded-3 shadow-sm" style="height: 60px; object-fit: cover;" onerror="this.src='https://via.placeholder.com/90x60?text=No+Foto'">
                    </td>
                    <td><span class="fw-bold"><?= $d['nama_mobil'] ?></span> <br> <small class="text-muted"><i class="bi bi-tag"></i> <?= $d['merk'] ?></small></td>
                    <td><span class="badge bg-light text-dark border"><i class="bi bi-123"></i> <?= $d['plat_nomor'] ?></span></td>
                    <td class="fw-medium text-primary">Rp <?= number_format($d['harga'],0,',','.') ?></td>
                    <td>
                        <span class="badge bg-<?= $d['status'] == 'Tersedia' ? 'success' : 'danger' ?> rounded-pill">
                            <?= $d['status'] ?>
                        </span>
                    </td>
                    <td>
                        <button class="btn btn-warning btn-sm text-dark fw-medium shadow-sm" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $d['id_mobil'] ?>"><i class="bi bi-pencil-square"></i></button>
                        <a href="../proses/proses_mobil.php?aksi=hapus&id=<?= $d['id_mobil'] ?>" class="btn btn-danger btn-sm shadow-sm" onclick="return confirm('Yakin ingin menghapus mobil ini?')"><i class="bi bi-trash"></i></a>
                    </td>
                </tr>

                <!-- Modal Edit -->
                <div class="modal fade text-start" id="modalEdit<?= $d['id_mobil'] ?>" tabindex="-1">
                  <div class="modal-dialog">
                    <div class="modal-content rounded-4 border-0 shadow">
                      <div class="modal-header bg-light border-bottom-0 rounded-top-4">
                        <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square text-warning"></i> Edit Mobil</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      </div>
                      <form action="../proses/proses_mobil.php?aksi=edit" method="POST" enctype="multipart/form-data">
                      <div class="modal-body p-4">
                          <input type="hidden" name="id_mobil" value="<?= $d['id_mobil'] ?>">
                          <input type="hidden" name="foto_lama" value="<?= $d['foto'] ?>">
                          
                          <!-- Preview Gambar Edit -->
                          <div class="text-center mb-3">
                              <img src="../uploads/<?= $d['foto'] ?>" id="previewEdit<?= $d['id_mobil'] ?>" class="img-thumbnail rounded-3 shadow-sm" style="max-height: 150px; object-fit: cover;">
                          </div>

                          <div class="mb-3">
                              <label class="form-label fw-medium">Nama Mobil</label>
                              <input type="text" name="nama_mobil" class="form-control" value="<?= $d['nama_mobil'] ?>" required>
                          </div>
                          <div class="row">
                              <div class="col-6 mb-3">
                                  <label class="form-label fw-medium">Merk</label>
                                  <input type="text" name="merk" class="form-control" value="<?= $d['merk'] ?>" required>
                              </div>
                              <div class="col-6 mb-3">
                                  <label class="form-label fw-medium">Plat Nomor</label>
                                  <input type="text" name="plat_nomor" class="form-control" value="<?= $d['plat_nomor'] ?>" required>
                              </div>
                          </div>
                          <div class="mb-3">
                              <label class="form-label fw-medium">Harga per Hari (Rp)</label>
                              <input type="number" name="harga" class="form-control" value="<?= $d['harga'] ?>" required>
                          </div>
                          <div class="mb-3">
                              <label class="form-label fw-medium">Status Mobil</label>
                              <select name="status" class="form-select">
                                  <option value="Tersedia" <?= $d['status'] == 'Tersedia' ? 'selected' : '' ?>>Tersedia</option>
                                  <option value="Tidak Tersedia" <?= $d['status'] == 'Tidak Tersedia' ? 'selected' : '' ?>>Tidak Tersedia</option>
                              </select>
                          </div>
                          <div class="mb-3">
                              <label class="form-label fw-medium">Ganti Foto <small class="text-muted">(Opsional)</small></label>
                              <input type="file" name="foto" class="form-control" accept="image/*" onchange="previewImage(this, 'previewEdit<?= $d['id_mobil'] ?>')">
                          </div>
                      </div>
                      <div class="modal-footer border-top-0 pt-0">
                        <button type="submit" class="btn btn-primary w-100 btn-modern">Simpan Perubahan</button>
                      </div>
                      </form>
                    </div>
                  </div>
                </div>
                <!-- End Modal Edit -->

                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header bg-light border-bottom-0 rounded-top-4">
        <h5 class="modal-title fw-bold"><i class="bi bi-plus-circle text-primary"></i> Tambah Mobil Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="../proses/proses_mobil.php?aksi=tambah" method="POST" enctype="multipart/form-data">
      <div class="modal-body p-4">
          
          <!-- Box Preview Gambar Tambah -->
          <div class="text-center mb-3 d-none" id="boxPreviewTambah">
              <img src="" id="previewTambah" class="img-thumbnail rounded-3 shadow-sm" style="max-height: 150px; object-fit: cover;">
          </div>

          <div class="mb-3">
              <label class="form-label fw-medium">Nama Mobil</label>
              <input type="text" name="nama_mobil" class="form-control" placeholder="Contoh: Avanza Veloz" required>
          </div>
          <div class="row">
              <div class="col-6 mb-3">
                  <label class="form-label fw-medium">Merk</label>
                  <input type="text" name="merk" class="form-control" placeholder="Contoh: Toyota" required>
              </div>
              <div class="col-6 mb-3">
                  <label class="form-label fw-medium">Plat Nomor</label>
                  <input type="text" name="plat_nomor" class="form-control" placeholder="Contoh: B 1234 XYZ" required>
              </div>
          </div>
          <div class="mb-3">
              <label class="form-label fw-medium">Harga per Hari (Rp)</label>
              <input type="number" name="harga" class="form-control" placeholder="Contoh: 300000" required>
          </div>
          <div class="mb-3">
              <label class="form-label fw-medium">Upload Foto Mobil</label>
              <input type="file" name="foto" class="form-control" accept="image/*" onchange="previewImage(this, 'previewTambah', 'boxPreviewTambah')" required>
              <small class="text-muted d-block mt-1">Format: JPG, PNG, WEBP (Maks 2MB)</small>
          </div>
      </div>
      <div class="modal-footer border-top-0 pt-0">
        <button type="submit" class="btn btn-primary w-100 btn-modern"><i class="bi bi-save"></i> Simpan Mobil</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Script Live Preview Gambar -->
<script>
function previewImage(input, previewId, boxId = null) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById(previewId).src = e.target.result;
            if(boxId) {
                document.getElementById(boxId).classList.remove('d-none');
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

<?php include '../templates/footer.php'; ?>