<?= $this->extend('layouts/dashboard_layout') ?>
<?= $this->section('content') ?>

<div class="content-section active">
    <div style="margin-bottom: 20px;">
        <h1 style="margin: 0;">Kotak Masuk Notifikasi</h1>
        <p style="color: #666; margin-top: 5px;">Daftar pesan dan pemberitahuan sistem.</p>
    </div>

    <div class="card">
        <ul class="activity-list" style="border: none; border-radius: 0;">
            <?php if(empty($semua_pesan)): ?>
                <li style="text-align: center; color: #888; padding: 30px;">
                    <i class="fa-regular fa-envelope-open" style="font-size: 40px; margin-bottom: 15px; color: #ccc;"></i>
                    <p>Tidak ada pesan di kotak masuk Anda.</p>
                </li>
            <?php else: ?>
                <?php foreach($semua_pesan as $msg): ?>
                    <li style="display: flex; justify-content: space-between; align-items: flex-start; padding: 12px 18px; border: 1px solid #eee; border-radius: 6px; margin-bottom: 8px; background-color: <?= $msg['is_read'] ? '#ffffff' : '#f0f8ff' ?>; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s;" onclick="window.location.href='<?= base_url('pesan/read/'.$msg['id']) ?>'">
                        <div style="display: flex; gap: 15px; align-items: flex-start;">
                            <div style="width: 38px; height: 38px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0; background-color: <?= $msg['is_read'] ? '#f8f9fa' : 'rgba(2, 62, 138, 0.1)' ?>; color: <?= $msg['is_read'] ? '#888' : '#023E8A' ?>;">
                                <i class="fa-solid <?= $msg['is_read'] ? 'fa-envelope-open' : 'fa-envelope' ?>"></i>
                            </div>
                            <div style="min-width: 0; flex: 1;">
                                <h3 style="margin: 0 0 3px 0; color: <?= $msg['is_read'] ? '#555' : 'var(--dark)' ?>; font-size: 15px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    <?= esc($msg['judul']) ?>
                                    <?php if(!$msg['is_read']): ?>
                                        <span class="badge badge-red" style="font-size: 10px; margin-left: 5px; padding: 2px 6px;">Baru</span>
                                    <?php endif; ?>
                                </h3>
                                <?php
                                    $pesanText = esc($msg['isi_pesan']);
                                    if (strpos($pesanText, 'Catatan: ') !== false) {
                                        $parts = explode('Catatan: ', $pesanText, 2);
                                        $mainText = $parts[0];
                                        $catatanText = 'Catatan: ' . $parts[1];
                                    } else {
                                        $mainText = $pesanText;
                                        $catatanText = '';
                                    }
                                ?>
                                <p style="margin: 0; color: #666; font-size: 13px; line-height: 1.4; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    <?= $mainText ?>
                                </p>
                                <?php if (!empty($catatanText)): ?>
                                <p style="margin: 4px 0 0 0; color: #888; font-size: 12px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    <?= $catatanText ?>
                                </p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div style="text-align: right; color: #999; font-size: 11px; white-space: nowrap; margin-top: 5px;">
                            <?= date('d M Y, H:i', strtotime($msg['created_at'])) ?>
                        </div>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>

        <?php if (!empty($semua_pesan)): ?>
            <div style="margin-top: 20px; display: flex; justify-content: center;">
                <?= $pager->links('pesan', 'custom_pagination') ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
