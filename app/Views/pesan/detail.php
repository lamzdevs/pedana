<?= $this->extend('layouts/dashboard_layout') ?>
<?= $this->section('content') ?>

<div class="content-section active">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div>
            <h1 style="margin: 0;">Detail Pesan Masuk</h1>
        </div>
        <a href="<?= base_url('pesan') ?>" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Kotak Masuk Notifikasi
        </a>
    </div>

    <div class="card">
        <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 25px; padding-bottom: 20px; border-bottom: 1px solid #eee;">
            <div style="width: 50px; height: 50px; background-color: rgba(2, 62, 138, 0.1); color: #023E8A; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px;">
                <i class="fa-solid fa-envelope-open-text"></i>
            </div>
            <div>
                <h2 style="margin: 0; color: #333; font-size: 22px;"><?= esc($pesan['judul']) ?></h2>
                <div style="display: flex; flex-wrap: wrap; gap: 15px; color: #777; font-size: 13px; margin-top: 8px;">
                    <div style="display: flex; align-items: center; gap: 6px;">
                        <i class="fa-regular fa-clock"></i>
                        <span>Diterima: <?= date('d F Y, H:i', strtotime($pesan['created_at'])) ?></span>
                    </div>
                    <?php if(!empty($nasabah_nama)): ?>
                        <div style="display: flex; align-items: center; gap: 6px; padding-left: 15px; border-left: 1px solid #ddd;">
                            <i class="fa-solid fa-user"></i>
                            <span>Nasabah: <strong style="color: #444;"><?= esc($nasabah_nama) ?></strong></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div style="font-size: 16px; color: #444; line-height: 1.6; min-height: 150px;">
            <?= esc($pesan['isi_pesan']) ?>
        </div>
        
        <?php if(!empty($pesan['target_url'])): ?>
        <div style="margin-top: 30px; text-align: right; border-top: 1px solid #eee; padding-top: 20px;">
            <?php if(!empty($dokumen_id)): ?>
                <a href="<?= base_url('dokumen/edit/' . $dokumen_id) ?>" style="display: inline-block; background-color: #28a745; color: white; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-weight: bold; transition: background-color 0.3s; margin-right: 10px;" onmouseover="this.style.backgroundColor='#218838'" onmouseout="this.style.backgroundColor='#28a745'">
                    <i class="fa-solid fa-file-arrow-up" style="margin-right: 8px;"></i> Update Dokumen
                </a>
            <?php endif; ?>
            <a href="<?= base_url($pesan['target_url']) ?>" style="display: inline-block; background-color: var(--marian-blue); color: white; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-weight: bold; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#012a60'" onmouseout="this.style.backgroundColor='var(--marian-blue)'">
                Cek Detail Dokumen / Nasabah Terkait <i class="fa-solid fa-arrow-right" style="margin-left: 8px;"></i>
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
