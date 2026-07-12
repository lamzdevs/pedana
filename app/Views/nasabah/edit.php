<?= $this->extend('layouts/dashboard_layout') ?>
<?= $this->section('content') ?>

<div id="nasabahEdit" class="content-section active">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div>
            <h1 style="margin: 0;">Edit Nasabah</h1>
        </div>
        <a href="<?= base_url('nasabah') ?>" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Nasabah
        </a>
    </div>
    <div class="card">
        <form class="form-nasabah" action="<?= base_url('nasabah/update/' . $nasabah['id']) ?>" method="POST">
            <div class="form-group">
                <label for="namaLengkap">Nama Lengkap:</label>
                <input type="text" id="namaLengkap" name="nama_lengkap" required value="<?= esc($nasabah['nama_lengkap']) ?>">
            </div>
            <div class="form-group">
                <label for="jenisAkun">Jenis Akun:</label>
                <select id="jenisAkun" name="jenis_akun" required>
                    <option value="Tabungan" <?= $nasabah['jenis_akun'] == 'Tabungan' ? 'selected' : '' ?>>Tabungan</option>
                    <option value="Giro" <?= $nasabah['jenis_akun'] == 'Giro' ? 'selected' : '' ?>>Giro</option>
                    <option value="Deposito" <?= $nasabah['jenis_akun'] == 'Deposito' ? 'selected' : '' ?>>Deposito</option>
                </select>
            </div>
            <div class="form-group">
                <label for="noRekening">Nomor Rekening:</label>
                <input type="text" id="noRekening" name="no_rekening" required value="<?= esc($nasabah['no_rekening']) ?>">
            </div>
            <div class="form-group">
                <label for="tanggalArsip">Tanggal Arsip:</label>
                <input type="date" id="tanggalArsip" name="tanggal_arsip" required value="<?= esc($nasabah['tanggal_arsip']) ?>">
            </div>
            <div class="form-group">
                <label for="status">Status Data:</label>
                <select id="status" name="status" required>
                    <option value="Aktif" <?= $nasabah['status'] == 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                    <option value="Tidak Aktif" <?= $nasabah['status'] == 'Tidak Aktif' ? 'selected' : '' ?>>Tidak Aktif</option>
                </select>
            </div>
            
            <div class="form-group arsip-fields" style="display: none;">
                <label for="kebutuhan">Kebutuhan (Alasan Penonaktifan):</label>
                <input type="text" id="kebutuhan" name="kebutuhan" placeholder="Misal: Tutup Rekening, Nasabah Meninggal">
            </div>
            <div class="form-group arsip-fields" style="display: none;">
                <label for="keterangan">Keterangan Tambahan:</label>
                <input type="text" id="keterangan" name="keterangan" placeholder="Penjelasan tambahan...">
            </div>

            <button type="submit" class="submit-btn">Simpan Perubahan</button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusSelect = document.getElementById('status');
        const arsipFields = document.querySelectorAll('.arsip-fields');
        const reqInputs = document.querySelectorAll('.arsip-fields input');

        function toggleArsipFields() {
            if (statusSelect.value === 'Tidak Aktif') {
                arsipFields.forEach(el => el.style.display = 'flex');
                reqInputs.forEach(el => el.required = true);
            } else {
                arsipFields.forEach(el => el.style.display = 'none');
                reqInputs.forEach(el => el.required = false);
            }
        }

        statusSelect.addEventListener('change', toggleArsipFields);
        toggleArsipFields(); // Run on load
    });
</script>

<script src="<?= base_url('js/nama-lengkap.js') ?>"></script>
<script src="<?= base_url('js/no-rek.js') ?>"></script>

<?= $this->endSection() ?>
