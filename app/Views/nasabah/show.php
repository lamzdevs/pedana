<?= $this->extend('layouts/dashboard_layout') ?>
<?= $this->section('content') ?>

<style>
    .biodata-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        table-layout: fixed;
    }
    .biodata-table th {
        width: 35%;
        padding: 12px 10px;
        border-bottom: 1px solid #ddd;
        word-wrap: break-word;
        color: #555;
    }
    .biodata-table td {
        padding: 12px 10px;
        border-bottom: 1px solid #ddd;
        word-wrap: break-word;
        color: #333;
    }
    .status-active {
        color: white;
        background-color: #28a745;
        padding: 4px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 13px;
        display: inline-block;
    }
    .status-inactive {
        color: white;
        background-color: #dc3545;
        padding: 4px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 13px;
        display: inline-block;
    }

</style>

<div id="nasabahShow" class="content-section active">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div>
            <h1 style="margin: 0;">Detail Nasabah</h1>
        </div>
        <a href="<?= base_url('nasabah') ?>" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Nasabah
        </a>
    </div>
    <div class="card">
        <div class="form-nasabah form-nasabah-grid" style="display: grid; grid-template-columns: 400px 1fr; gap: 30px;">
            <!-- Kiri: Biodata -->
            <div style="min-width: 0;">
                <div style="margin-bottom: 25px; padding: 25px; border: 1px solid #eaeaea; border-radius: 12px; display: flex; flex-direction: column; align-items: center; justify-content: center; background-color: #ffffff; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);">
                    <div style="width: 65px; height: 65px; background-color: rgba(2, 62, 138, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #023E8A; margin-bottom: 15px;">
                        <i class="fa-solid fa-user" style="font-size: 30px;"></i>
                    </div>
                    <h3 style="margin: 0; color: #333; font-size: 20px; font-weight: 700;">Informasi Biodata</h3>
                </div>
                
                <table class="biodata-table">
                    <tr><th>No Arsip</th><td><?= esc($nasabah['no_arsip']) ?></td></tr>
                    <tr><th>Nama Lengkap</th><td style="font-weight: bold;"><?= esc($nasabah['nama_lengkap']) ?></td></tr>
                    <tr><th>Jenis Akun</th><td><?= esc($nasabah['jenis_akun']) ?></td></tr>
                    <tr><th>Nomor Rekening</th><td style="font-family: monospace; font-size: 15px;"><?= esc($nasabah['no_rekening']) ?></td></tr>
                    <tr><th>Tanggal Arsip</th><td><?= date('d/m/Y', strtotime($nasabah['tanggal_arsip'])) ?></td></tr>
                    <tr><th>Status Data</th><td><span class="<?= $nasabah['status'] == 'Aktif' ? 'status-active' : 'status-inactive' ?>"><?= esc($nasabah['status']) ?></span></td></tr>
                </table>
                

            </div>
            
            <!-- Kanan: Kotak Dokumen -->
            <div style="min-width: 0; padding: 20px; display: flex; flex-direction: column; background-color: #fafafa; border: 1px solid #eaeaea; border-radius: 12px; box-sizing: border-box;">
                <?php if(!empty($dokumen_revisi)): ?>
                    <h3 style="margin-top: 0; color: #dc3545; font-size: 16px; margin-bottom: 10px;">Perlu Direvisi:</h3>
                    <div style="display: flex; flex-direction: column; gap: 10px; margin-bottom: 20px;">
                        <?php foreach($dokumen_revisi as $doc): ?>
                            <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px 15px; background-color: #fff3cd; border: 1px solid #ffeeba; border-radius: 8px;">
                                <div style="display: flex; align-items: center; gap: 15px;">
                                    <i class="fa-solid fa-exclamation-triangle" style="color: #856404; font-size: 24px;"></i>
                                    <div>
                                        <div style="font-weight: bold; color: #856404; font-size: 14px;"><?= esc($doc['jenis_dokumen']) ?></div>
                                        <div style="font-size: 12px; color: #856404; font-style: italic;">"<?= esc($doc['keterangan']) ?>"</div>
                                    </div>
                                </div>
                                <a href="<?= base_url('dokumen/edit/' . $doc['id']) ?>" style="display: flex; align-items: center; gap: 6px; white-space: nowrap; flex-shrink: 0; background-color: #28a745; color: white; padding: 8px 14px; border-radius: 6px; text-decoration: none; font-size: 13px; font-weight: bold; transition: background-color 0.2s;" onmouseover="this.style.backgroundColor='#218838'" onmouseout="this.style.backgroundColor='#28a745'">
                                    <i class="fa-solid fa-file-arrow-up"></i> Update
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <hr style="border: none; border-top: 1px solid #ddd; margin-bottom: 20px;">
                <?php endif; ?>

                <?php if(empty($dokumen_approved)): ?>
                    <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%; min-height: 200px; color: #888; text-align: center;">
                        <i class="fa-solid fa-file-circle-xmark" style="font-size: 40px; margin-bottom: 15px; color: #ccc;"></i>
                        <p style="margin: 0;">Belum ada dokumen yang disetujui<br>untuk nasabah ini.</p>
                    </div>
                <?php else: ?>
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        <?php foreach($dokumen_approved as $doc): ?>
                            <?php 
                                $filePath = $doc['file_path'] ?? '';
                                $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                                $icon = 'fa-file-lines'; 
                                $iconColor = '#6c757d';
                                if($ext == 'pdf') {
                                    $icon = 'fa-file-pdf';
                                    $iconColor = '#dc3545';
                                } elseif(in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
                                    $icon = 'fa-file-image';
                                    $iconColor = '#28a745';
                                } elseif(in_array($ext, ['doc', 'docx'])) {
                                    $icon = 'fa-file-word';
                                    $iconColor = '#007bff';
                                }
                            ?>
                            <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px 15px; background-color: white; border: 1px solid #eee; border-radius: 8px; transition: transform 0.2s, box-shadow 0.2s;">
                                <div style="display: flex; align-items: center; gap: 15px;">
                                    <i class="fa-solid <?= $icon ?>" style="color: <?= $iconColor ?>; font-size: 24px;"></i>
                                    <div>
                                        <div style="font-weight: bold; color: #333; font-size: 14px;"><?= esc($doc['jenis_dokumen']) ?></div>
                                        <div style="font-size: 12px; color: #888;">Diunggah: <?= date('d/m/Y', strtotime($doc['tanggal_upload'])) ?></div>
                                    </div>
                                </div>
                                <a href="<?= base_url('dokumen/show/' . $doc['id']) ?>" target="_blank" style="background-color: #f0f8ff; color: #023E8A; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; border-radius: 50%; text-decoration: none; transition: background-color 0.2s;" onmouseover="this.style.backgroundColor='#e0f0ff'" onmouseout="this.style.backgroundColor='#f0f8ff'" title="Lihat Dokumen">
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
