<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedana Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kodchasan:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,200;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?= base_url('css/') ?>login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .swal2-popup, .swal2-popup * {
            font-family: 'Kodchasan', sans-serif !important;
        }
    </style>
</head>
<body>
    <!-- Login Area -->
    <div class="login-page-container">
        <div class="login-card">
            <div class="login-illustration-side">
                <img src="<?= base_url('img/') ?>arsip-recycle.png" alt="gambar-arsip-recycle"/>
            </div>
            <div class="login-form-side">
                <div class="logo-area">
                    <img src="<?= base_url('logo/') ?>LOGO PENADA_FIX_UTAMA_GELAP.png" alt="Logo Penada"> 
                </div>
                <h1>Masuk</h1>
                <?php if(session()->getFlashdata('error')): ?>
                    <script>
                        Swal.fire({
                            title: 'Gagal!',
                            text: '<?= addslashes(session()->getFlashdata('error')) ?>',
                            icon: 'error',
                            confirmButtonColor: '#023E8A',
                            heightAuto: false
                        });
                    </script>
                <?php endif; ?>
                <?php if(session()->getFlashdata('success')): ?>
                    <script>
                        Swal.fire({
                            title: 'Berhasil!',
                            text: '<?= addslashes(session()->getFlashdata('success')) ?>',
                            icon: 'success',
                            confirmButtonColor: '#023E8A',
                            heightAuto: false
                        });
                    </script>
                <?php endif; ?>

                <?php if(session()->getFlashdata('alert_error')): ?>
                    <script>
                        Swal.fire({
                            title: 'Akses Ditolak!',
                            text: '<?= addslashes(str_replace("Akses Ditolak! ", "", session()->getFlashdata("alert_error"))) ?>',
                            icon: 'error',
                            confirmButtonColor: '#023E8A',
                            heightAuto: false
                        });
                    </script>
                <?php endif; ?>
                <form id="loginForm" action="<?= base_url('login') ?>" method="POST">
                    <div class="input-group">
                        <i class="fas fa-user"></i>
                        <input type="text" id="username" name="username" placeholder="Nama Pengguna" required/>
                    </div>
                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="password" name="password" placeholder="Sandi" required/>
                        <i class="far fa-eye toggle-password" id="togglePassword"></i>
                    </div>
                    <button type="submit" class="login-btn">Masuk</button>
                </form>
                <div class="extra-links">
                    <p>Belum memiliki akun?</p>
                    <a href="<?= base_url('register') ?>"  id="register-link">Daftar sebagai Administrator</a>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function (e) {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
            this.classList.toggle('fa-eye');
        });
    </script>
</body>
</html>

