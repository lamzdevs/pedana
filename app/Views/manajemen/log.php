<?= $this->extend('layouts/dashboard_layout') ?>
<?= $this->section('content') ?>

<style>
.pagination {
    display: flex;
    padding-left: 0;
    list-style: none;
    justify-content: center;
    gap: 5px;
    margin-top: 20px;
}
.pagination li a, .pagination li span {
    padding: 8px 12px;
    border: 1px solid #ddd;
    background-color: #fff;
    color: #023E8A;
    text-decoration: none;
    border-radius: 5px;
    font-family: 'Kodchasan', sans-serif;
}
.pagination li.active span {
    background-color: #023E8A;
    color: #fff;
    border-color: #023E8A;
}
.pagination li a:hover {
    background-color: #e9ecef;
}
</style>

<div id="logAktivitasSection" class="content-section active">
    <h1>Log Aktivitas</h1>
    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 15px;">
            <h2>Riwayat Aktivitas Pengguna</h2>
            <div style="display: flex; align-items: center; gap: 15px;">
                <form action="<?= base_url('manajemen/log') ?>" method="GET" style="display: flex; gap: 10px; align-items: center; margin: 0;">
                    <select name="role" onchange="this.form.submit()" style="padding: 6px 12px; border: 1px solid #ccc; border-radius: 4px; font-family: 'Kodchasan', sans-serif; appearance: none; background-color: #fff; background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23333%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 10px top 50%; background-size: 10px auto; padding-right: 30px;">
                        <option value="all" <?= (empty($selected_role) || $selected_role == 'all') ? 'selected' : '' ?>>Semua Role</option>
                        <option value="admin" <?= ($selected_role == 'admin') ? 'selected' : '' ?>>Admin</option>
                        <option value="supervisor" <?= ($selected_role == 'supervisor') ? 'selected' : '' ?>>Supervisor</option>
                        <option value="staff" <?= ($selected_role == 'staff') ? 'selected' : '' ?>>Staff</option>
                    </select>
                </form>

                <button onclick="location.reload()" style="background:none; border:none; cursor:pointer; color:#023E8A;" title="Segarkan Log">
                    <i class="fas fa-sync-alt"></i>
                </button>

                <button onclick="hapusSeluruhLog()" 
                        style="background-color: #dc3545; color: white; border: none; padding: 5px 12px; border-radius: 5px; cursor: pointer; font-size: 12px; display: flex; align-items: center; gap: 5px; font-family: 'Kodchasan', sans-serif;">
                    <i class="fas fa-trash-alt"></i> Bersihkan Log
                </button>
                
            </div>
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th style="text-align: center; width: 150px;">Waktu</th>
                    <th style="text-align: center; width: 190px;">Pengguna</th>
                    <th style="text-align: center; width: 120px;">Role</th>
                    <th style="text-align: center;">Aktivitas</th>
                    <th style="text-align: center;">Target Data</th>
                </tr>
            </thead>
            <tbody>   
                <?php if (empty($logs)): ?>
                    <tr><td colspan="5" style="text-align: center; padding: 20px;">Belum ada aktivitas.</td></tr>
                <?php else: ?>
                    <?php foreach ($logs as $log): ?>
                    <tr>
                        <td style="padding: 12px; color: #555; text-align: center;"><?= esc($log['created_at']) ?></td>
                        <td style="padding: 12px; color: #555;"><?= esc($log['fullname']) ?></td>
                        <td style="text-align: center; padding: 12px;">
                            <span style="background: <?= ($log['role']=='admin') ? '#007bff' : (($log['role']=='supervisor') ? '#48CAE4' : (($log['role']=='staff') ? '#6f42c1' : '#6c757d')) ?>; color: white; padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;"><?= esc(ucfirst($log['role'])) ?></span>
                        </td>
                        <td style="padding: 12px; color: #555;"><?= esc($log['action']) ?></td>
                        <td style="padding: 12px; color: #555; text-align: left;"><?= esc($log['target_data']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Render Pagination Links -->
        <div style="display: flex; justify-content: center; margin-top: 15px;">
            <?= $pager->links('logs', 'custom_pagination') ?>
        </div>
    </div>
</div>

<script>
function hapusSeluruhLog() {
    Swal.fire({
        title: 'Bersihkan Log?',
        text: 'Apakah Anda yakin ingin menghapus seluruh log aktivitas? Aksi ini tidak dapat dibatalkan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#023E8A',
        cancelButtonColor: '#dc3545',
        confirmButtonText: 'Ya, Bersihkan!',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('<?= base_url('manajemen/clearLogs') ?>', {
                method: 'POST'
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Seluruh log aktivitas telah dibersihkan.',
                        icon: 'success'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Gagal!', 'Gagal membersihkan log.', 'error');
                }
            });
        }
    });
}
</script>
<?= $this->endSection() ?>
