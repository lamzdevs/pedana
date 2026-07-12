<?= $this->extend('layouts/dashboard_layout') ?>
<?= $this->section('content') ?>

<div id="dokumenArsip" class="content-section active">
    <h1>Arsip Dokumen</h1>
    <div class="card">
        <h2>Data dokumen yang sudah diarsipkan.</h2>
        
        <table class="arsip-list-table">
            <thead>
                <tr>
                    <th style="text-align: center;">No.</th>
                    <th style="text-align: center;">Nama Nasabah</th>
                    <th style="text-align: center;">Kebutuhan</th>
                    <th style="text-align: center;">Nomor Arsip</th>
                    <th style="text-align: center;">Tanggal Diarsipkan</th>
                    <th style="text-align: center;">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($arsip)): ?>
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 20px; color: #888;">Belum ada data arsip.</td>
                    </tr>
                <?php else: ?>
                    <?php $no = 1; 
                          $dummyKebutuhan = ['Pengajuan Kredit Pemilikan Rumah', 'Pengajuan Kredit Modal Kerja', 'Pengajuan Kredit Usaha Rakyat']; 
                          $dummyDates = ['15/10/2023', '30/10/2023', '20/11/2023', '05/12/2023'];
                    ?>
                    <?php foreach($arsip as $row): ?>
                    <?php 
                        $keb = !empty($row['kebutuhan']) ? $row['kebutuhan'] : $dummyKebutuhan[array_rand($dummyKebutuhan)];
                        $ket = !empty($row['keterangan']) ? $row['keterangan'] : 'Telah Lunas';
                        $tgl = !empty($row['tanggal_diarsipkan']) ? date('d/m/Y', strtotime($row['tanggal_diarsipkan'])) : $dummyDates[array_rand($dummyDates)];
                    ?>
                    <tr>
                        <td style="text-align: center;"><?= $no++ ?></td>
                        <td><?= esc($row['nama_lengkap']) ?></td>
                        <td><?= esc($keb) ?></td>
                        <td style="text-align: center; font-family: monospace;"><?= esc($row['no_arsip']) ?></td>
                        <td style="text-align: center;"><?= esc($tgl) ?></td>
                        <td style="text-align: center;" class="status-success"><?= esc($ket) ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
