<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedana Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kodchasan:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,200;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?= base_url('css/') ?>dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <?php
$uri = uri_string();
$role = session()->get('role');
?>
<div class="nav-container">
        <aside class="sidebar">
            <div class="logo">
                <a href="<?= base_url('dashboard') ?>" ><img src="<?= base_url('logo/') ?>LOGO PENADA_FIX_UTAMA_GELAP.png" alt="Logo Pedana"></a>
            </div>
            
            <!-- Menu Sidebar -->
            <nav class="sidebar-nav">
                <ul>
                    <?php if(has_permission('dashboard_akses')): ?>
                    <li>
                        <a href="<?= base_url('dashboard') ?>" class="menu-link <?= $uri == 'dashboard' || $uri == '' ? 'active' : '' ?>">
                            <i class="fa-solid fa-chart-line"></i> Dashboard
                        </a>
                    </li>
                    <?php endif; ?>

                    <?php if(has_permission('nasabah_lihat') || has_permission('nasabah_tambah')): ?>
                    <li>
                        <div class="menu-group">
                        <input type="checkbox" id="menu-nasabah" class="toggle-menu" <?= strpos($uri, 'nasabah') === 0 ? 'checked' : '' ?>>
                        <label for="menu-nasabah" class="menu-label">
                            <i class="fa-solid fa-users"></i><span class="arrow"></span> Nasabah</label>
                            <ul class="submenu">
                                <?php if(has_permission('nasabah_lihat')): ?>
                                <li><a href="<?= base_url('nasabah') ?>" class="menu-link <?= $uri == 'nasabah' ? 'active' : '' ?>"><i class="fa-solid fa-list"></i> Daftar Nasabah</a></li>
                                <?php endif; ?>
                                <?php if(has_permission('nasabah_tambah')): ?>
								<li><a href="<?= base_url('nasabah/create') ?>" class="menu-link <?= $uri == 'nasabah/create' ? 'active' : '' ?>"><i class="fa-solid fa-square-plus"></i> Tambah Nasabah Baru</a></li>
								<?php endif; ?>
                            </ul>
                        </div>
                    </li>
                    <?php endif; ?>

                    <?php if(has_permission('dokumen_unggah') || has_permission('dokumen_masuk') || has_permission('dokumen_arsip')): ?>
					<li>
						<div class="menu-group">
						<input type="checkbox" id="menu-dokumen" <?= strpos($uri, 'dokumen') === 0 ? 'checked' : '' ?> class="toggle-menu">
                        <label for="menu-dokumen" class="menu-label">
                            <i class="fa-solid fa-folder"></i><span class="arrow"></span> Dokumen</label>
                            <ul class="submenu">
                                <?php if(has_permission('dokumen_unggah')): ?>
								<li><a href="<?= base_url('dokumen/create') ?>" class="menu-link <?= $uri == 'dokumen/create' ? 'active' : '' ?>"><i class="fa-solid fa-upload"></i> Unggah Dokumen Baru</a></li>
								<?php endif; ?>
                                <?php if(has_permission('dokumen_masuk')): ?>
								<li><a href="<?= base_url('dokumen') ?>" class="menu-link <?= $uri == 'dokumen' ? 'active' : '' ?>"><i class="fa-solid fa-inbox"></i> Dokumen Masuk</a></li>
								<?php endif; ?>
                                <?php if(has_permission('dokumen_arsip')): ?>
								<li><a href="<?= base_url('dokumen/arsip') ?>" class="menu-link <?= $uri == 'dokumen/arsip' ? 'active' : '' ?>"><i class="fa-solid fa-box-archive"></i> Arsip Dokumen</a></li>
								<?php endif; ?>
                            </ul>
                        </div>
                    </li>
                    <?php endif; ?>

                    <?php if(has_permission('laporan_analisis')): ?>
					<li>
						<div class="menu-group">
						<input type="checkbox" id="menu-laporan" <?= strpos($uri, 'laporan') === 0 ? 'checked' : '' ?> class="toggle-menu">
                        <label for="menu-laporan" class="menu-label">
                            <i class="fa-solid fa-chart-column"></i><span class="arrow"></span> Laporan</label>
                            <ul class="submenu">
                                <?php if(has_permission('laporan_analisis')): ?>
								<li><a href="<?= base_url('laporan/analisis') ?>" class="menu-link <?= $uri == 'laporan/analisis' ? 'active' : '' ?>"><i class="fa-solid fa-pie-chart"></i> Laporan & Analisis</a></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </li>
					<?php endif; ?>

                    <?php if(has_permission('manajemen_pengguna')): ?>
					<li>
						<div class="menu-group">
						<input type="checkbox" id="menu-manajemen" <?= strpos($uri, 'manajemen') === 0 ? 'checked' : '' ?> class="toggle-menu">
                        <label for="menu-manajemen" class="menu-label">
                            <i class="fa-solid fa-bars-progress"></i><span class="arrow"></span> Manajemen Pengguna</label>
                            <ul class="submenu">
								<li><a href="<?= base_url('manajemen/peran') ?>" class="menu-link <?= $uri == 'manajemen/peran' ? 'active' : '' ?>"><i class="fa-solid fa-user-shield"></i> Peran</a></li>
								<li><a href="<?= base_url('manajemen/izin') ?>" class="menu-link <?= $uri == 'manajemen/izin' ? 'active' : '' ?>"><i class="fa-solid fa-lock"></i> Hak Izin</a></li>
								<li><a href="<?= base_url('manajemen/status') ?>" class="menu-link <?= $uri == 'manajemen/status' ? 'active' : '' ?>"><i class="fa-solid fa-user-check"></i> Status Akun</a></li>
								<li><a href="<?= base_url('manajemen/persetujuan') ?>" class="menu-link <?= $uri == 'manajemen/persetujuan' ? 'active' : '' ?>"><i class="fa-solid fa-user-plus"></i> Persetujuan Akun</a></li>
								<li><a href="<?= base_url('manajemen/log') ?>" class="menu-link <?= $uri == 'manajemen/log' ? 'active' : '' ?>"><i class="fa-solid fa-clock-rotate-left"></i> Log Aktivitas</a></li>
                            </ul>
                        </div>
                    </li>
					<?php endif; ?>
                </ul>
            </nav>
            
            <div class="log-out" style="display: flex; flex-direction: column; padding: 0; background: transparent;">
                    <div style="padding: 10px 20px; text-align: left; border-bottom: 1px solid rgba(0,0,0,0.1);">
                        <div style="font-size: 15px; font-weight: 700; color: #333; margin-bottom: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            <?= $role == 'admin' ? 'Administrator' : ucfirst($role) ?>
                        </div>
                    </div>
                    <div class="log-out" style="margin-top: 10px;">
                        <a href="<?= base_url('logout') ?>" onclick="confirmAction(event, 'Konfirmasi Keluar', 'Apakah Anda yakin ingin keluar dari aplikasi?', 'question', 'Ya, Keluar')">
                            <i class="fas fa-sign-out-alt"></i> Keluar
                        </a>
                    </div>
                </div>
        </aside>

        <main class="main-content">
            <!-- Header Navbar -->
            <header class="header">
                <div class="header-greeting">
                    <h2>Halo, <?= session()->get('fullname') ?></h2>
                    <p>Apa yang ingin Anda lakukan hari ini?</p>
                </div>

                <form action="<?= base_url('nasabah') ?>" method="GET" class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="search" name="search" placeholder="Cari Sesuatu..." value="<?= isset($_GET['search']) ? esc($_GET['search']) : '' ?>">
                </form>

                <div class="header-actions">
                    <div class="date-badge">
                        <i class="fa-solid fa-calendar-days"></i>
                        <?php 
                        $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                        $currentMonth = $months[date('n') - 1];
                        echo date('d') . ' ' . $currentMonth . ' ' . date('Y');
                        ?>
                        &nbsp;|&nbsp; <i class="fa-solid fa-clock"></i> <span id="live-clock-time"><?= date('H:i:s') ?></span>
                    </div>

                    <div class="action-icons">
                        <a href="<?= base_url('pesan') ?>" class="icon-btn">
                            <i class="fa-solid fa-bell"></i>
                            <?php if (isset($pesan_unread) && $pesan_unread > 0): ?>
                                <span class="badge badge-red"><?= $pesan_unread ?></span>
                            <?php endif; ?>
                        </a>
                    </div>

                    <div class="profile-avatar" onclick="changeProfilePic()" style="cursor: pointer;" title="Klik untuk ubah foto profil">
                        <?php
                        $profilePic = session()->get('profile_pic') ?? 'profil.png';
                        $profilePicUrl = ($profilePic !== 'profil.png') ? base_url('uploads/profiles/' . $profilePic) : base_url('img/' . $profilePic);
                        ?>
                        <img id="profile-img-display" src="<?= $profilePicUrl ?>" alt="profile" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <section id="content-area">
                <?= $this->renderSection('content') ?>
            </section>

        </main>
    </div>
    <script src="<?= base_url('js/menu.js') ?>"></script>

    <style>
        .swal2-popup, .swal2-popup * {
            font-family: 'Kodchasan', sans-serif !important;
        }
        .swal2-select {
            appearance: none !important;
            -webkit-appearance: none !important;
            -moz-appearance: none !important;
            padding-right: 45px !important;
            background: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e") no-repeat !important;
            background-size: 16px 12px !important;
            background-position: calc(100% - 20px) center !important;
        }
        .profile-avatar:hover {
            opacity: 0.8;
        }
        .swal2-profile-preview {
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #023E8A;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .profile-pic-container {
            position: relative;
            display: inline-block;
            margin: 20px auto;
        }
        .edit-pic-btn {
            position: absolute;
            bottom: 5px;
            right: 5px;
            background: #023E8A;
            color: white;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            border: 2px solid white;
            transition: all 0.3s;
        }
        .edit-pic-btn:hover {
            background: #005b96;
            transform: scale(1.1);
        }
    </style>
    <script>
        function changeProfilePic() {
            const currentImgUrl = document.getElementById('profile-img-display').src;
            
            Swal.fire({
                title: 'Ubah Foto Profil',
                html: `
                    <p style="font-family: 'Kodchasan', sans-serif; font-size: 14px; margin-bottom: 20px;">Pilih foto baru dari komputer Anda (JPG/PNG).</p>
                    <div class="profile-pic-container">
                        <img src="${currentImgUrl}" alt="Foto Profil" class="swal2-profile-preview" width="120" height="120" id="preview-new-img">
                        <label for="hidden-file-input" class="edit-pic-btn" title="Pilih Foto Baru">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" viewBox="0 0 16 16">
                                <path d="M10.5 8.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                <path d="M2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2zm.5 2a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm9 2.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0z"/>
                            </svg>
                        </label>
                        <input type="file" id="hidden-file-input" style="display: none;" accept="image/jpeg, image/png, image/jpg" onchange="previewImage(event)">
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Unggah',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#023E8A',
                cancelButtonColor: '#dc3545',
                reverseButtons: true,
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    const fileInput = document.getElementById('hidden-file-input');
                    const file = fileInput.files[0];
                    
                    if (!file) {
                        Swal.showValidationMessage('Anda belum memilih foto baru!');
                        return;
                    }
                    
                    const formData = new FormData();
                    formData.append('profile_pic', file);

                    return fetch('<?= base_url('profile/updatePic') ?>', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .catch(error => {
                        Swal.showValidationMessage(`Gagal: ${error}`)
                    })
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed && result.value.status === 'success') {
                    document.getElementById('profile-img-display').src = result.value.new_pic;
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Foto profil Anda telah diperbarui.',
                        icon: 'success',
                        confirmButtonColor: '#023E8A'
                    });
                } else if (result.isConfirmed && result.value.status === 'error') {
                    Swal.fire({
                        title: 'Gagal!',
                        text: result.value.message,
                        icon: 'error',
                        confirmButtonColor: '#023E8A'
                    });
                }
            });
        }

        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function(){
                const output = document.getElementById('preview-new-img');
                output.src = reader.result;
            };
            if(event.target.files[0]) {
                reader.readAsDataURL(event.target.files[0]);
            }
        }

        function confirmAction(event, title, text, icon = 'warning', confirmText = 'Ya') {
            event.preventDefault();
            const url = event.currentTarget.getAttribute('href');
            Swal.fire({
                title: title,
                text: text,
                icon: icon,
                showCancelButton: true,
                confirmButtonColor: '#023E8A',
                cancelButtonColor: '#dc3545',
                confirmButtonText: confirmText,
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        }

        function updateClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            const timeString = `${hours}:${minutes}:${seconds}`;
            
            const clockEl = document.getElementById('live-clock-time');
            if(clockEl) {
                clockEl.textContent = timeString;
            }
        }
        setInterval(updateClock, 1000);
        updateClock();
    </script>
</body>
</html>