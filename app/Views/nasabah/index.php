<?= $this->extend('layouts/dashboard_layout') ?>
<?= $this->section('content') ?>

<div id="nasabahList" class="content-section active">
    <h1>Daftar Nasabah <?= !empty($search) ? '<span style="font-size:18px; font-weight:normal; color:#666;">(Hasil Pencarian: ' . esc($search) . ')</span>' : '' ?></h1>
    
    <?php if (session()->getFlashdata('error')): ?>
        <div style="background-color: #f8d7da; color: #721c24; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
            <i class="fas fa-exclamation-circle" style="margin-right: 8px;"></i> <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
        <div style="background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
            <i class="fas fa-check-circle" style="margin-right: 8px;"></i> <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <div class="card">
        <table class="customer-list-table">
            <thead>
                <tr>
                    <th style="text-align: center;">No</th>
                    <th style="text-align: center;">Tanggal Arsip</th>
                    <th style="text-align: center;">No Arsip</th>
                    <th style="text-align: center;">Nama Lengkap</th>
                    <th style="text-align: center;">Nomor Rekening</th>
                    <th style="text-align: center;">Jenis Akun</th>
                    <th style="text-align: center;">Status Data</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($nasabah)): ?>
                <tr>
                    <td colspan="8" style="text-align: center; padding: 20px;">Belum ada data nasabah.</td>
                </tr>
                <?php else: ?>
                    <?php $no = 1 + (10 * ($page - 1)); foreach ($nasabah as $row): ?>
                    <tr>
                        <td style="text-align: center;"><?= $no++ ?></td>
                        <td style="text-align: center;"><?= date('d/m/Y', strtotime($row['tanggal_arsip'])) ?></td>
                        <td style="text-align: center;"><?= $row['no_arsip'] ?></td>
                        <td><?= esc($row['nama_lengkap']) ?></td>
                        <td><?= esc($row['no_rekening']) ?></td>
                        <td style="text-align: center;"><?= esc($row['jenis_akun']) ?></td>
                        <td style="text-align: center;" class="<?= $row['status'] == 'Aktif' ? 'status-active' : 'status-inactive' ?>"><?= esc($row['status']) ?></td>
                        <td style='text-align: center;'>
                            <div style='display: flex; justify-content: center; gap: 5px;'>
                                <a href="<?= base_url('nasabah/show/' . $row['id']) ?>" style='background-color:#007bff; color: white; padding: 6px 10px; border-radius: 4px; text-decoration: none;'>
                                <i class='fas fa-eye'></i>
                                </a>

                                <?php if(in_array(session()->get('role'), ['admin', 'staff'])): ?>
                                <a href="<?= base_url('nasabah/edit/' . $row['id']) ?>" style='background-color:orange; color: black; padding: 6px 10px; border-radius: 4px; text-decoration: none;'>
                                <i class='fas fa-edit'></i>
                                </a>

                                <a href="<?= base_url('nasabah/delete/' . $row['id']) ?>" onclick="confirmAction(event, 'Hapus Nasabah?', 'Apakah Anda yakin ingin menghapus data nasabah ini?', 'warning', 'Ya, Hapus')" style='background-color: #dc3545; color: white; padding: 6px 10px; border-radius: 4px; text-decoration: none;'>
                                <i class='fas fa-trash'></i>
                                </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        
        <?php if (!empty($nasabah) && $pager): ?>
        <div style="display: flex; justify-content: center; margin-top: 15px;">
            <?= $pager->links('nasabah', 'custom_pagination') ?>
        </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
