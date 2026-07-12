<?= $this->extend('layouts/dashboard_layout') ?>
<?= $this->section('content') ?>

<div id="dokumenUpload" class="content-section active">
    <h1>Unggah Dokumen Baru</h1>
    
    <?php if (session()->getFlashdata('error')): ?>
        <div style="background-color: #f8d7da; color: #721c24; padding: 15px; margin-bottom: 20px; border-radius: 5px;">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <div class="card" style="position: relative;">
        <form class="form-dokumen" action="<?= base_url('dokumen/store') ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group nasabah-group">
                <label for="nasabahID">Pilih Nasabah (Ketentuan Nama Daftar Nasabah):</label>
                <select name="nasabah_id" id="nasabahID" required>
                    <option value="">-- Pilih Nasabah --</option>
                    <?php foreach($nasabah as $n): ?>
                        <option value="<?= $n['id'] ?>"><?= esc($n['nama_lengkap']) ?> (<?= esc($n['no_arsip']) ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
        
            <div class="form-group">
                <label for="fileKTP">Kartu Tanda Penduduk (KTP):</label>
                <input type="file" name="fileKTP" id="fileKTP" accept=".pdf,.jpg,.jpeg,.png"> 
            </div>
            <div class="form-group">
                <label for="fileKK">Kartu Keluarga (KK):</label>
                <input type="file" name="fileKK" id="fileKK" accept=".pdf,.jpg,.jpeg,.png">
            </div>
            <div class="form-group">
                <label for="fileNPWP">Nomor Pokok Wajib Pajak (NPWP):</label>
                <input type="file" name="fileNPWP" id="fileNPWP" accept=".pdf,.jpg,.jpeg,.png">
            </div>
            <div class="form-group">
                <label for="fileBukuTabungan">Fotokopi Buku Tabungan:</label>
                <input type="file" name="fileBukuTabungan" id="fileBukuTabungan" accept=".pdf,.jpg,.jpeg,.png">
            </div>
            <div class="form-group">
                <label for="fileSlipGaji">Surat Keterangan Penghasilan:</label>
                <input type="file" name="fileSlipGaji" id="fileSlipGaji" accept=".pdf,.jpg,.jpeg,.png">
            </div>
            <div class="form-group">
                <label for="fileSKKerja">Surat Keterangan Kerja:</label>
                <input type="file" name="fileSKKerja" id="fileSKKerja" accept=".pdf,.jpg,.jpeg,.png">
            </div>
            <div class="form-group">
                <label for="fileFormulir">Formulir Pengajuan:</label>
                <input type="file" name="fileFormulir" id="fileFormulir" accept=".jpg,.jpeg,.png,.pdf">
            </div>
            <div class="form-group">
                <label for="fileSuratKuasa">Surat Kuasa-Kuasa:</label>
                <input type="file" name="fileSuratKuasa" id="fileSuratKuasa" accept=".jpg,.jpeg,.png,.pdf">
            </div>
            <div class="form-group">
                <label for="fileLainnya">Surat Pendukung Lainnya</label>
                <input type="file" name="fileLainnya" id="fileLainnya" accept=".jpg,.jpeg,.png,.pdf">
            </div>
            
            <button type="submit" class="submit-btn">Unggah Dokumen</button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
