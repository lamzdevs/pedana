<?= $this->extend('layouts/dashboard_layout') ?>
<?= $this->section('content') ?>

<div id="roleSection" class="content-section active">
    <h1>Peran</h1>
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
            <h2>Daftar Peran</h2>
            <button onclick="bukaModalTambahUser()" style="background: #28a745; color: white; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer; font-family: 'Kodchasan', sans-serif; font-weight: 600; display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-user-plus"></i> Tambah Akun Baru
            </button>
        </div>

        <table class="data-table" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background-color: #f8f9fa; text-align: left;">
                    <th style="padding: 12px; border-bottom: 2px solid #dee2e6;">Nama Pengguna</th>
                    <th style="padding: 12px; border-bottom: 2px solid #dee2e6;">Email Pengguna</th>
                    <th style="text-align: center; padding: 12px; border-bottom: 2px solid #dee2e6;">Peran</th>
                    <th style="text-align: center; padding: 12px; border-bottom: 2px solid #dee2e6;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr style="border-bottom: 1px solid #EEEEEE;" id="user-row-<?= $user['id'] ?>">
                        <td style="padding: 12px;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <img src="<?= base_url(!empty($user['profile_pic']) && $user['profile_pic'] !== 'profil.png' ? 'uploads/profiles/' . $user['profile_pic'] : 'img/profil.png') ?>" 
                                        alt="Foto" 
                                        style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 1px solid #ddd; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                                <span style="font-weight: 600; color: #333;"><?= esc($user['fullname']) ?></span>
                            </div>
                        </td>
                        <td style="padding: 12px; color: #555;"><?= esc($user['email']) ?></td>
                        
                        <td style="text-align: center; padding: 12px;">
                            <span style="background: <?= ($user['role']=='admin') ? '#007bff' : (($user['role']=='supervisor') ? '#48CAE4' : (($user['role']=='staff') ? '#6f42c1' : '#6c757d')) ?>; color: white; padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;"><?= esc(ucfirst($user['role'])) ?></span>
                        </td>
                                
                        <td style="text-align: center; padding: 12px;">
                            <div style="display: flex; justify-content: center; gap: 8px;">
                                <?php if ($user['id'] == session()->get('id')): ?>
                                    <span style="font-size: 12px; color: #023E8A; font-weight: bold; padding: 5px; border: 1px solid #023E8A; border-radius: 5px;">
                                        <i class="fas fa-check-circle"></i> Akun Anda
                                    </span>
                                <?php else: ?>
                                    <span onclick="bukaModalEditUser(<?= $user['id'] ?>, '<?= addslashes($user['fullname']) ?>', '<?= addslashes($user['email']) ?>', '<?= $user['role'] ?>')" style="border: none; background: orange; color: #333; width: 32px; height: 32px; border-radius: 6px; cursor: pointer; display: flex; align-items: center; justify-content: center;" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </span>
                                    <span onclick="hapusUser(<?= $user['id'] ?>)" style="border: none; background: #dc3545; color: white; width: 32px; height: 32px; border-radius: 6px; cursor: pointer; display: flex; align-items: center; justify-content: center;" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<!-- Modal Tambah User -->
<div id="modalTambahUser" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); justify-content: center; align-items: center;">
    <div style="background-color: #fff; padding: 20px; border-radius: 8px; width: 400px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); font-family: 'Kodchasan', sans-serif;">
        <h3 style="margin-top: 0;">Tambah Pengguna Baru</h3>
        <form id="formTambahUser">
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Nama Lengkap</label>
                <input type="text" id="addFullname" style="width: 100%; padding: 10px 12px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; font-family: 'Kodchasan', sans-serif;" required>
            </div>
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Username</label>
                <input type="text" id="addUsername" style="width: 100%; padding: 10px 12px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; font-family: 'Kodchasan', sans-serif;" required>
            </div>
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Email</label>
                <input type="email" id="addEmail" style="width: 100%; padding: 10px 12px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; font-family: 'Kodchasan', sans-serif;" required>
            </div>
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Kata Sandi</label>
                <input type="password" id="addPassword" style="width: 100%; padding: 10px 12px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; font-family: 'Kodchasan', sans-serif;" required>
            </div>
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Peran (Role)</label>
                <select id="addRole" style="width: 100%; padding: 10px 15px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; font-family: 'Kodchasan', sans-serif; appearance: none; -webkit-appearance: none; -moz-appearance: none; background-color: #fff; background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23333%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 15px top 50%; background-size: 10px auto;" required>
                    <option value="admin">Admin</option>
                    <option value="supervisor">Supervisor</option>
                    <option value="staff">Staff</option>
                </select>
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" onclick="tutupModalTambahUser()" style="background: #6c757d; color: white; border: none; padding: 8px 15px; border-radius: 4px; cursor: pointer;">Batal</button>
                <button type="submit" style="background: #28a745; color: white; border: none; padding: 8px 15px; border-radius: 4px; cursor: pointer;">Simpan Baru</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit User -->
<div id="modalEditUser" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); justify-content: center; align-items: center;">
    <div style="background-color: #fff; padding: 20px; border-radius: 8px; width: 400px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); font-family: 'Kodchasan', sans-serif;">
        <h3 style="margin-top: 0;">Edit Pengguna</h3>
        <form id="formEditUser">
            <input type="hidden" id="editUserId">
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Nama Lengkap</label>
                <input type="text" id="editFullname" style="width: 100%; padding: 10px 12px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; font-family: 'Kodchasan', sans-serif;" required>
            </div>
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Email</label>
                <input type="email" id="editEmail" style="width: 100%; padding: 10px 12px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; font-family: 'Kodchasan', sans-serif;" required>
            </div>
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Peran (Role)</label>
                <select id="editRole" style="width: 100%; padding: 10px 15px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; font-family: 'Kodchasan', sans-serif; appearance: none; -webkit-appearance: none; -moz-appearance: none; background-color: #fff; background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23333%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 15px top 50%; background-size: 10px auto;" required>
                    <option value="admin">Admin</option>
                    <option value="supervisor">Supervisor</option>
                    <option value="staff">Staff</option>
                </select>
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" onclick="tutupModalEditUser()" style="background: #6c757d; color: white; border: none; padding: 8px 15px; border-radius: 4px; cursor: pointer;">Batal</button>
                <button type="submit" style="background: #007bff; color: white; border: none; padding: 8px 15px; border-radius: 4px; cursor: pointer;">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
function bukaModalTambahUser() {
    document.getElementById('formTambahUser').reset();
    document.getElementById('modalTambahUser').style.display = 'flex';
}

function tutupModalTambahUser() {
    document.getElementById('modalTambahUser').style.display = 'none';
}

document.getElementById('formTambahUser').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const data = {
        fullname: document.getElementById('addFullname').value,
        username: document.getElementById('addUsername').value,
        email: document.getElementById('addEmail').value,
        password: document.getElementById('addPassword').value,
        role: document.getElementById('addRole').value
    };
    
    fetch('<?= base_url('manajemen/addUser') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(res => {
        if (res.status === 'success') {
            tutupModalTambahUser();
            Swal.fire('Berhasil!', 'Akun baru berhasil dibuat.', 'success').then(() => {
                location.reload();
            });
        } else {
            Swal.fire('Gagal!', res.message || 'Gagal menambahkan pengguna.', 'error');
        }
    });
});

function bukaModalEditUser(id, fullname, email, role) {
    document.getElementById('editUserId').value = id;
    document.getElementById('editFullname').value = fullname;
    document.getElementById('editEmail').value = email;
    document.getElementById('editRole').value = role;
    
    document.getElementById('modalEditUser').style.display = 'flex';
}

function tutupModalEditUser() {
    document.getElementById('modalEditUser').style.display = 'none';
}

document.getElementById('formEditUser').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const id = document.getElementById('editUserId').value;
    const data = {
        fullname: document.getElementById('editFullname').value,
        email: document.getElementById('editEmail').value,
        role: document.getElementById('editRole').value
    };
    
    fetch('<?= base_url('manajemen/updateUser/') ?>' + id, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(res => {
        if (res.status === 'success') {
            tutupModalEditUser();
            location.reload(); // Reload halaman untuk melihat perubahan
        } else {
            alert('Gagal memperbarui data pengguna.');
        }
    });
});

function hapusUser(userId) {
    Swal.fire({
        title: 'Hapus Pengguna?',
        text: 'Semua data terkait mungkin akan hilang.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#023E8A',
        cancelButtonColor: '#dc3545',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('<?= base_url('manajemen/deleteUser/') ?>' + userId, {
                method: 'POST'
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    const row = document.getElementById('user-row-' + userId);
                    row.remove();
                    Swal.fire('Terhapus!', 'Pengguna berhasil dihapus.', 'success');
                } else {
                    Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus pengguna.', 'error');
                }
            });
        }
    });
}
</script>
<?= $this->endSection() ?>
