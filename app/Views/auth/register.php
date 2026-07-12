<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedana Register</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kodchasan:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,200;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?= base_url('css/') ?>register.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet"/>
</head>
<body>
    <!-- Register Area -->
    <div class="register-page-container">
        <div class="register-card">
            <div class="register-illustration-side">
                <img src="<?= base_url('img/') ?>arsip-recycle.png" alt="gambar-arsip-recycle"/>
            </div>
            <div class="register-form-side">
                <div class="logo-area">
                    <img src="<?= base_url('logo/') ?>LOGO PENADA_FIX_UTAMA_GELAP.png" alt="Logo Penada"> 
                </div>
                <h1>Daftar</h1>
                <form id="registerForm" action="<?= base_url('register') ?>" method="POST">
                    <div class="input-group">
                        <i class="fas fa-id-card"></i>
                        <input type="text" id="fullname" name="fullname" placeholder="Nama Lengkap" required/>
                    </div>
                    <div class="input-group">
                        <i class="fas fa-envelope"></i>
                        <input type="email" id="email" name="email" placeholder="Email Perusahaan" required>
                    </div>
                    <div class="input-group">
                        <i class="fas fa-user"></i>
                        <input type="text" id="regUsername" name="username" placeholder="Nama Pengguna" required>
                    </div>
                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="password" name="password" placeholder="Sandi" required/>
                        <i class="far fa-eye toggle-password" id="togglePassword"></i>
                    </div>
                    <button type="submit" class="register-btn">Daftar</button>
                </form>
                <div class="extra-links">
                    <p>Sudah memiliki akun?</p>
                    <a href="<?= base_url() ?>"  id="register-link">Masuk</a>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url('js/') ?>register.js"></script>
</body>
</html>