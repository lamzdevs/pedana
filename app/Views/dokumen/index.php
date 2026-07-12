<?= $this->extend('layouts/dashboard_layout') ?>
<?= $this->section('content') ?>

<div id="dokumenMasuk" class="content-section active">
                    <h1>Dokumen Masuk</h1>
                    <div class="card">
                        <h2>Daftar Dokumen yang Baru Saja Diterima</h2>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">No</th>
                                    <th style="text-align: center;">Nama Nasabah</th>
                                    <th style="text-align: center;">No Arsip</th>
                                    <th style="text-align: center;">Jumlah Dokumen Pending</th>
                                    <th style="text-align: center;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(empty($grouped_dokumen)): ?>
                                    <tr>
                                        <td colspan="5" style="text-align: center; padding: 20px;">Belum ada dokumen masuk.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php $no=1; foreach($grouped_dokumen as $row): ?>
                                    <tr>
                                        <td style="text-align: center;"><?= $no++ ?></td>
                                        <td><?= esc($row['nama_lengkap']) ?></td>
                                        <td style="text-align: center;"><?= esc($row['no_arsip']) ?></td>
                                        <td style="text-align: center;">
                                            <span class="status-pending" style="font-size: 14px; padding: 4px 8px; border-radius: 4px;"><?= $row['jumlah_dokumen'] ?> Dokumen</span>
                                        </td>
                                        <td style='text-align: center;'>
                                            <div style='display: flex; justify-content: center; gap: 5px;'>
                                                <a href="<?= base_url('dokumen/review/' . $row['nasabah_id']) ?>" style='background-color:#007bff; color: white; padding: 6px 15px; border-radius: 4px; text-decoration: none; font-size: 14px;' title="Lihat Daftar Dokumen">
                                                    <i class='fas fa-list'></i> Lihat Daftar Dokumen
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
<?= $this->endSection() ?>
