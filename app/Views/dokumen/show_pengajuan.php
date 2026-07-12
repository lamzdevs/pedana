<?= $this->extend('layouts/dashboard_layout') ?>
<?= $this->section('content') ?>

<div id="pengajuanShow" class="content-section active">
    <h1>Detail Pengajuan Penonaktifan</h1>
    <div class="card" style="max-width: 800px; margin: 0 auto; padding: 30px;">
        <div style="text-align: center; margin-bottom: 30px;">
            <div style="width: 80px; height: 80px; background-color: rgba(220, 53, 69, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #dc3545; margin: 0 auto 15px;">
                <i class="fa-solid fa-user-xmark" style="font-size: 35px;"></i>
            </div>
            <h2 style="margin: 0; color: #333; font-size: 24px;">Pengajuan Arsip Nasabah</h2>
            <p style="color: #666; margin-top: 5px;">Mohon tinjau alasan penonaktifan berikut sebelum menyetujui.</p>
        </div>

        <table style="width: 100%; border-collapse: collapse; margin-bottom: 30px;">
            <tr>
                <td style="padding: 15px; border-bottom: 1px solid #eee; width: 30%; font-weight: bold; color: #555;">Nama Nasabah</td>
                <td style="padding: 15px; border-bottom: 1px solid #eee; color: #333;"><?= esc($nasabah['nama_lengkap']) ?></td>
            </tr>
            <tr>
                <td style="padding: 15px; border-bottom: 1px solid #eee; font-weight: bold; color: #555;">Nomor Rekening</td>
                <td style="padding: 15px; border-bottom: 1px solid #eee; color: #333; font-family: monospace;"><?= esc($nasabah['no_rekening']) ?></td>
            </tr>
            <tr>
                <td style="padding: 15px; border-bottom: 1px solid #eee; font-weight: bold; color: #555;">Kebutuhan</td>
                <td style="padding: 15px; border-bottom: 1px solid #eee; color: #dc3545; font-weight: 600;"><?= esc($dokumen['kebutuhan']) ?></td>
            </tr>
            <tr>
                <td style="padding: 15px; border-bottom: 1px solid #eee; font-weight: bold; color: #555; vertical-align: top;">Keterangan Tambahan</td>
                <td style="padding: 15px; border-bottom: 1px solid #eee; color: #333; line-height: 1.5;"><?= nl2br(esc($dokumen['keterangan'])) ?></td>
            </tr>
            <tr>
                <td style="padding: 15px; font-weight: bold; color: #555;">Tanggal Pengajuan</td>
                <td style="padding: 15px; color: #333;"><?= date('d F Y H:i', strtotime($dokumen['tanggal_upload'])) ?></td>
            </tr>
        </table>

        <div style="display: flex; justify-content: center; gap: 15px;">
            <a href="<?= base_url('dokumen/approve/' . $dokumen['id']) ?>" style="background-color: #28a745; color: white; padding: 12px 25px; text-decoration: none; border-radius: 6px; font-weight: bold; transition: background-color 0.2s;" onmouseover="this.style.backgroundColor='#218838'" onmouseout="this.style.backgroundColor='#28a745'"><i class="fa-solid fa-check"></i> Setujui Penonaktifan</a>
            <a href="<?= base_url('dokumen') ?>" style="background-color: #6c757d; color: white; padding: 12px 25px; text-decoration: none; border-radius: 6px; font-weight: bold; transition: background-color 0.2s;" onmouseover="this.style.backgroundColor='#5a6268'" onmouseout="this.style.backgroundColor='#6c757d'">Kembali</a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
