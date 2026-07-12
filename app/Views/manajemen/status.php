<?= $this->extend('layouts/dashboard_layout') ?>
<?= $this->section('content') ?>

<div id="statusAkunSection" class="content-section active">
    <h1>Status Akun</h1>
    <div class="card">
        <h2>Informasi Status Aktif/Nonaktif Akun Pengguna</h2>
        <table class="data-table">
            <thead>
                <tr>
                    <th style="text-align: center;">Email Pengguna</th>
                    <th style="text-align: center;">Nama Pengguna</th>
                    <th style="text-align: center;">Peran</th>
                    <th style="text-align: center;">Status</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= esc($user['email']) ?></td>
                        <td><?= esc($user['fullname']) ?></td>
                        <td style="text-align: center;"><?= esc(ucfirst($user['role'])) ?></td>
                        <td style="text-align: center;">
                            <span id="status-text-<?= $user['id'] ?>" style="font-weight: bold; font-size: 12px; color: <?= ($user['status'] == 'Aktif') ? '#28a745' : '#dc3545' ?>; font-family: 'Kodchasan', sans-serif;">
                                <?= esc($user['status']) ?>
                            </span>
                        </td>
                        <td style="text-align: center;">
                            <?php if ($user['role'] == 'admin'): ?>
                                <button disabled style="background:#ccc; cursor:not-allowed; border:none; padding:5px 10px; border-radius:10px; color:#666; font-family: 'Kodchasan', sans-serif;">
                                    <i class="fas fa-lock"></i> Terkunci
                                </button>
                            <?php else: ?>
                                <button 
                                    id="btn-status-<?= $user['id'] ?>"
                                    onclick="toggleStatus(<?= $user['id'] ?>)"
                                    style="background:<?= ($user['status'] == 'Aktif') ? '#dc3545' : '#28a745' ?>; color:white; border:none; padding:5px 10px; border-radius:10px; cursor:pointer; font-family: 'Kodchasan', sans-serif;">
                                        <?= ($user['status'] == 'Aktif') ? 'Nonaktifkan' : 'Aktifkan' ?>
                                </button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function toggleStatus(userId) {
    Swal.fire({
        title: 'Ubah Status?',
        text: 'Apakah Anda yakin ingin mengubah status pengguna ini?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#023E8A',
        cancelButtonColor: '#dc3545',
        confirmButtonText: 'Ya, Ubah!',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('<?= base_url('manajemen/toggleStatus/') ?>' + userId, {
                method: 'POST'
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    const btn = document.getElementById('btn-status-' + userId);
                    const text = document.getElementById('status-text-' + userId);
                    
                    text.innerText = data.new_status;
                    if (data.new_status === 'Aktif') {
                        text.style.color = '#28a745';
                        btn.style.background = '#dc3545';
                        btn.innerText = 'Nonaktifkan';
                    } else {
                        text.style.color = '#dc3545';
                        btn.style.background = '#28a745';
                        btn.innerText = 'Aktifkan';
                    }
                    Swal.fire('Berhasil!', 'Status pengguna telah diubah.', 'success');
                } else {
                    Swal.fire('Gagal!', 'Gagal mengubah status pengguna.', 'error');
                }
            });
        }
    });
}
</script>
<?= $this->endSection() ?>
