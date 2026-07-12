<?php 
// Helper untuk nge-check checkbox
function checkPerm($permissions, $feature, $role) {
    return (isset($permissions[$feature][$role]) && $permissions[$feature][$role]) ? 'checked' : '';
}
$roles = ['admin', 'supervisor', 'staff'];
?>
<?= $this->extend('layouts/dashboard_layout') ?>
<?= $this->section('content') ?>

<div id="permissionSection" class="content-section active">
                    <h1>Hak Izin</h1>
                    <div class="card">
                        <h2>Pengaturan Akses Fitur</h2>
                        <div class="table-scroll-wrapper">
                            <table class="permission-table" id="table-permissions">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">Fitur/Aksi (Permission)</th>
                                        <th style="text-align: center;">Admin</th>
                                        <th style="text-align: center;">Supervisor</th>
                                        <th style="text-align: center;">Staf</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="group-header"><td colspan="4"><h4><i class="fas fa-chart-line"></i> Dashboard</h4></td></tr>
                                    <tr data-feature="dashboard_akses">
                                        <td>Akses Dashboard Utama</td>
                                        <?php foreach($roles as $r): ?>
                                            <td><div class="toggle-container"><label class="switch"><input type="checkbox" data-role="<?= $r ?>" <?= checkPerm($permissions, 'dashboard_akses', $r) ?>><span class="slider round"></span></label></div></td>
                                        <?php endforeach; ?>
                                    </tr>
                                    
                                    <tr class="group-header"><td colspan="4"><h4><i class="fas fa-users"></i> Menu Nasabah</h4></td></tr>
                                    <tr data-feature="nasabah_lihat">
                                        <td>Daftar Nasabah (Lihat)</td>
                                        <?php foreach($roles as $r): ?>
                                            <td><div class="toggle-container"><label class="switch"><input type="checkbox" data-role="<?= $r ?>" <?= checkPerm($permissions, 'nasabah_lihat', $r) ?>><span class="slider round"></span></label></div></td>
                                        <?php endforeach; ?>
                                    </tr>
                                    <tr data-feature="nasabah_tambah">
                                        <td>Tambah Nasabah Baru</td>
                                        <?php foreach($roles as $r): ?>
                                            <td><div class="toggle-container"><label class="switch"><input type="checkbox" data-role="<?= $r ?>" <?= checkPerm($permissions, 'nasabah_tambah', $r) ?>><span class="slider round"></span></label></div></td>
                                        <?php endforeach; ?>
                                    </tr>
                                    
                                    <tr class="group-header"><td colspan="4"><h4><i class="fas fa-folder"></i> Menu Dokumen</h4></td></tr>
                                    <tr data-feature="dokumen_unggah">
                                        <td>Unggah Dokumen</td>
                                        <?php foreach($roles as $r): ?>
                                            <td><div class="toggle-container"><label class="switch"><input type="checkbox" data-role="<?= $r ?>" <?= checkPerm($permissions, 'dokumen_unggah', $r) ?>><span class="slider round"></span></label></div></td>
                                        <?php endforeach; ?>
                                    </tr>
                                    <tr data-feature="dokumen_masuk">
                                        <td>Dokumen Masuk</td>
                                        <?php foreach($roles as $r): ?>
                                            <td><div class="toggle-container"><label class="switch"><input type="checkbox" data-role="<?= $r ?>" <?= checkPerm($permissions, 'dokumen_masuk', $r) ?>><span class="slider round"></span></label></div></td>
                                        <?php endforeach; ?>
                                    </tr>
                                    <tr data-feature="dokumen_arsip">
                                        <td>Arsip Dokumen</td>
                                        <?php foreach($roles as $r): ?>
                                            <td><div class="toggle-container"><label class="switch"><input type="checkbox" data-role="<?= $r ?>" <?= checkPerm($permissions, 'dokumen_arsip', $r) ?>><span class="slider round"></span></label></div></td>
                                        <?php endforeach; ?>
                                    </tr>
                                    
                                    <tr class="group-header"><td colspan="4"><h4><i class="fas fa-chart-column"></i> Menu Laporan</h4></td></tr>
                                    <tr data-feature="laporan_analisis">
                                        <td>Laporan & Analisis</td>
                                        <?php foreach($roles as $r): ?>
                                            <td><div class="toggle-container"><label class="switch"><input type="checkbox" data-role="<?= $r ?>" <?= checkPerm($permissions, 'laporan_analisis', $r) ?>><span class="slider round"></span></label></div></td>
                                        <?php endforeach; ?>
                                    </tr>
                                    
                                    <tr class="group-header"><td colspan="4"><h4><i class="fas fa-bars-progress"></i> Manajemen Pengguna</h4></td></tr>
                                    <tr data-feature="manajemen_pengguna">
                                        <td>Mengelola Role, Permission, Status & Log</td>
                                        <?php foreach($roles as $r): ?>
                                            <td><div class="toggle-container"><label class="switch"><input type="checkbox" data-role="<?= $r ?>" <?= checkPerm($permissions, 'manajemen_pengguna', $r) ?>><span class="slider round"></span></label></div></td>
                                        <?php endforeach; ?>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                            <div style="margin-top:20px; text-align:right;">
                                <button class="save-button" onclick="simpanIzin()" id="btnSaveIzin">
                                    <i class="fas fa-save"></i> Simpan Perubahan
                                </button>
                            </div>
                        </div>
                </div>

<script>
function simpanIzin() {
    const btn = document.getElementById('btnSaveIzin');
    const originalText = btn.innerHTML;
    btn.innerHTML = 'Menyimpan...';
    btn.disabled = true;

    // Kumpulkan semua data dari tabel
    const data = {
        'admin': {},
        'supervisor': {},
        'staff': {}
    };

    const rows = document.querySelectorAll('#table-permissions tbody tr[data-feature]');
    rows.forEach(row => {
        const feature = row.getAttribute('data-feature');
        const checkboxes = row.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(cb => {
            const role = cb.getAttribute('data-role');
            data[role][feature] = cb.checked;
        });
    });

    fetch('<?= base_url('manajemen/savePermissions') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(res => {
        if (res.status === 'success') {
            alert('Hak akses berhasil diperbarui!');
            location.reload();
        } else {
            alert('Terjadi kesalahan saat menyimpan hak akses.');
        }
    })
    .finally(() => {
        btn.innerHTML = originalText;
        btn.disabled = false;
    });
}
</script>
<?= $this->endSection() ?>
