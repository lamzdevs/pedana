<?= $this->extend('layouts/dashboard_layout') ?>
<?= $this->section('content') ?>

<div id="persetujuanAkunSection" class="content-section active">
    <h1>Persetujuan Akun</h1>
    
    <?php if(session()->getFlashdata('success')): ?>
        <script>
            Swal.fire({
                title: 'Berhasil!',
                text: '<?= session()->getFlashdata('success') ?>',
                icon: 'success',
                confirmButtonColor: '#023E8A'
            });
        </script>
    <?php endif; ?>
    <?php if(session()->getFlashdata('error')): ?>
        <script>
            Swal.fire({
                title: 'Gagal!',
                text: '<?= session()->getFlashdata('error') ?>',
                icon: 'error',
                confirmButtonColor: '#023E8A'
            });
        </script>
    <?php endif; ?>

    <div class="card">
        <h2>Daftar Akun Baru (Menunggu Persetujuan)</h2>
        <table class="data-table">
            <thead>
                <tr>
                    <th style="text-align: center;">Nama Lengkap</th>
                    <th style="text-align: center;">Username</th>
                    <th style="text-align: center;">Email</th>
                    <th style="text-align: center;">Waktu Daftar</th>
                    <th style="text-align: center; width: 200px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($guests)): ?>
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 20px;">Tidak ada akun yang menunggu persetujuan.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($guests as $guest): ?>
                        <tr>
                            <td><?= esc($guest['fullname']) ?></td>
                            <td><?= esc($guest['username']) ?></td>
                            <td><?= esc($guest['email']) ?></td>
                            <td style="text-align: center;"><?= esc($guest['created_at']) ?></td>
                            <td style="text-align: center;">
                                <button onclick="terimaAkun(<?= $guest['id'] ?>)" style="background:#023E8A; color:white; border:none; padding:5px 10px; border-radius:5px; cursor:pointer; font-family: 'Kodchasan', sans-serif; margin-right: 5px;">
                                    <i class="fas fa-check"></i> Terima
                                </button>
                                <button onclick="tolakAkun(<?= $guest['id'] ?>)" style="background:#dc3545; color:white; border:none; padding:5px 10px; border-radius:5px; cursor:pointer; font-family: 'Kodchasan', sans-serif;">
                                    <i class="fas fa-times"></i> Tolak
                                </button>

                                <form id="form-terima-<?= $guest['id'] ?>" action="<?= base_url('manajemen/approveGuest/'.$guest['id']) ?>" method="POST" style="display: none;">
                                    <input type="hidden" name="role" id="role-terima-<?= $guest['id'] ?>" value="">
                                </form>
                                <form id="form-tolak-<?= $guest['id'] ?>" action="<?= base_url('manajemen/rejectGuest/'.$guest['id']) ?>" method="POST" style="display: none;"></form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function terimaAkun(userId) {
    Swal.fire({
        title: 'Terima Akun & Pilih Peran',
        text: 'Silakan pilih peran (role) permanen untuk pengguna ini:',
        input: 'select',
        inputOptions: {
            'staff': 'Staff',
            'supervisor': 'Supervisor',
            'admin': 'Admin'
        },
        inputPlaceholder: 'Pilih Peran',
        showCancelButton: true,
        confirmButtonColor: '#023E8A',
        cancelButtonColor: '#dc3545',
        confirmButtonText: 'Ya, Terima!',
        cancelButtonText: 'Batal',
        inputValidator: (value) => {
            if (!value) {
                return 'Anda harus memilih peran untuk melanjutkan!';
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('role-terima-' + userId).value = result.value;
            document.getElementById('form-terima-' + userId).submit();
        }
    });
}

function tolakAkun(userId) {
    Swal.fire({
        title: 'Tolak Akun?',
        text: 'Akun ini akan dihapus permanen dari sistem.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#023E8A',
        cancelButtonColor: '#dc3545',
        confirmButtonText: 'Ya, Tolak!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('form-tolak-' + userId).submit();
        }
    });
}
</script>
<?= $this->endSection() ?>
