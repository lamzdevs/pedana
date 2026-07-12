<?= $this->extend('layouts/dashboard_layout') ?>
<?= $this->section('content') ?>

<div class="content-section active">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div>
            <h1 style="margin: 0;">Review Dokumen Pending</h1>
            <p style="color: #666;">Nasabah: <strong><?= esc($nama_nasabah) ?></strong> (No Arsip: <?= esc($no_arsip) ?>)</p>
        </div>
        <a href="<?= base_url('dokumen') ?>" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali ke Dokumen Masuk
        </a>
    </div>

    <div class="card">
        <h2>Daftar Dokumen yang Membutuhkan Persetujuan</h2>
        <table class="data-table">
            <thead>
                <tr>
                    <th style="text-align: center;">ID Doc</th>
                    <th style="text-align: center;">Jenis Dokumen</th>
                    <th style="text-align: center;">Tanggal Upload</th>
                    <th style="text-align: center;">Status</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($dokumen as $row): ?>
                <tr>
                    <td style="text-align: center;"><?= esc($row['id_doc']) ?></td>
                    <td style="text-align: center;">
                        <?= esc($row['jenis_dokumen']) ?>
                        <?php if ($row['jenis_dokumen'] === 'Pengajuan Penonaktifan'): ?>
                            <br><small style="color: #888;">(<?= esc($row['kebutuhan']) ?>)</small>
                        <?php endif; ?>
                    </td>
                    <td style="text-align: center;"><?= date('d/m/Y', strtotime($row['tanggal_upload'])) ?></td>
                    <td style="text-align: center;">
                        <span class="status-pending" style="font-size: 13px;">Pending</span>
                    </td>
                    <td style='text-align: center;'>
                        <div style='display: flex; justify-content: center; gap: 5px;'>
                            <a href="<?= base_url('dokumen/show/' . $row['id']) ?>" target="_blank" style='background-color:#007bff; color: white; padding: 6px 10px; border-radius: 4px; text-decoration: none;' title="Lihat Dokumen Asli">
                                <i class='fas fa-eye'></i>
                            </a>
                            
                            <?php if(in_array(session()->get('role'), ['admin', 'supervisor'])): ?>
                            <a href="<?= base_url('dokumen/approve/' . $row['id']) ?>" onclick="confirmAction(event, 'Setujui Dokumen', 'Apakah Anda yakin ingin menyetujui dokumen ini?', 'question', 'Ya, Setujui')" style='background-color:#28a745; color: white; padding: 6px 10px; border-radius: 4px; text-decoration: none;' title="Approve">
                                <i class="fas fa-check"></i>
                            </a>

                            <a href="javascript:void(0);" onclick="revisiDokumen(<?= $row['id'] ?>);" style='background-color:#dc3545; color: white; padding: 6px 10px; border-radius: 4px; text-decoration: none;' title="Tolak / Revisi">
                                <i class='fas fa-times'></i>
                            </a>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
</div>

<script>
function revisiDokumen(id) {
    Swal.fire({
        title: 'Revisi Dokumen',
        text: 'Masukkan catatan revisi (contoh: KTP kurang jelas, dll):',
        input: 'textarea',
        inputPlaceholder: 'Tulis catatan di sini...',
        showCancelButton: true,
        confirmButtonColor: '#023E8A',
        cancelButtonColor: '#dc3545',
        confirmButtonText: 'Kirim Revisi',
        cancelButtonText: 'Batal',
        reverseButtons: true,
        inputValidator: (value) => {
            if (!value || value.trim() === '') {
                return 'Catatan revisi wajib diisi!';
            }
        }
    }).then((result) => {
        if (result.isConfirmed && result.value) {
            window.location.href = "<?= base_url('dokumen/revisi') ?>/" + id + "?catatan=" + encodeURIComponent(result.value);
        }
    });
}
</script>

<?= $this->endSection() ?>
