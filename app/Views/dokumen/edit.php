<?= $this->extend('layouts/dashboard_layout') ?>
<?= $this->section('content') ?>

<div id="dokumenEdit" class="content-section active">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 20px;">
        <div>
            <h1 style="margin-top: 0; margin-bottom: 5px;">Perbarui Dokumen: <?= esc($dokumen['jenis_dokumen']) ?></h1>
            <p style="color: #666; margin: 0;">Nasabah: <strong><?= esc($nasabah['nama_lengkap']) ?></strong> (<?= esc($nasabah['no_arsip']) ?>)</p>
        </div>
        <a href="<?= base_url('nasabah/show/' . $dokumen['nasabah_id']) ?>" class="btn-back" style="display: inline-flex; align-items: center; gap: 6px;">
            <i class="fa-solid fa-xmark"></i> Batal
        </a>
    </div>
    
    <?php if (session()->getFlashdata('error')): ?>
        <div style="background-color: #f8d7da; color: #721c24; padding: 15px; margin-bottom: 20px; border-radius: 5px;">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <div class="card" style="position: relative;">
        <?php if($dokumen['status'] === 'Revisi'): ?>
        <div style="background-color: #fff3cd; color: #856404; padding: 15px; margin-bottom: 25px; border-radius: 8px; border-left: 4px solid #ffeeba;">
            <h4 style="margin-top: 0; margin-bottom: 10px;"><i class="fas fa-exclamation-triangle"></i> Catatan Revisi dari Supervisor:</h4>
            <p style="margin: 0; font-style: italic;">"<?= esc($dokumen['keterangan']) ?>"</p>
        </div>
        <?php endif; ?>

        <form class="form-dokumen" action="<?= base_url('dokumen/update/' . $dokumen['id']) ?>" method="POST" enctype="multipart/form-data">
            
            <div class="form-group">
                <label for="file_dokumen">Unggah File Baru untuk <?= esc($dokumen['jenis_dokumen']) ?>:</label>
                <input type="file" name="file_dokumen" id="file_dokumen" accept=".pdf,.jpg,.jpeg,.png" required>
                <small style="color: #888; display: block; margin-top: 8px;">File saat ini: <?= basename($dokumen['file_path']) ?></small>
            </div>
            
            <button type="submit" class="submit-btn" style="margin-top: 20px;">Unggah & Ajukan Kembali</button>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
