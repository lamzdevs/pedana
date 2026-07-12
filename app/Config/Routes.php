<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::login');
$routes->post('/login', 'Auth::process_login');
$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::process_register');
$routes->get('/logout', 'Auth::logout');

$routes->group('', ['filter' => 'auth'], static function ($routes) {
    // Dashboard Utama
    $routes->get('/dashboard', 'Dashboard::index', ['filter' => 'permission:dashboard_akses']);
    $routes->post('/profile/updatePic', 'Dashboard::updateProfilePic', ['filter' => 'permission:dashboard_akses']);
    
    // Daftar Nasabah
    $routes->get('/nasabah', 'Nasabah::index', ['filter' => 'permission:nasabah_lihat']);
    
    // Tambah nasabah
    $routes->get('/nasabah/create', 'Nasabah::create', ['filter' => 'permission:nasabah_tambah']);
    $routes->post('/nasabah/store', 'Nasabah::store', ['filter' => 'permission:nasabah_tambah']);
    
    // CRUD Tambahan (Diasumsikan terikat ke nasabah_lihat dan nasabah_tambah)
    $routes->get('/nasabah/show/(:num)', 'Nasabah::show/$1', ['filter' => 'permission:nasabah_lihat']);
    $routes->get('/nasabah/edit/(:num)', 'Nasabah::edit/$1', ['filter' => 'permission:nasabah_tambah']);
    $routes->post('/nasabah/update/(:num)', 'Nasabah::update/$1', ['filter' => 'permission:nasabah_tambah']);
    $routes->get('/nasabah/delete/(:num)', 'Nasabah::delete/$1', ['filter' => 'permission:nasabah_tambah']);
    
    // Dokumen masuk & Arsip
    $routes->get('/dokumen', 'Dokumen::index', ['filter' => 'permission:dokumen_masuk']);
    $routes->get('/dokumen/arsip', 'Dokumen::arsip', ['filter' => 'permission:dokumen_arsip']);
    
    // Unggah Dokumen
    $routes->get('/dokumen/create', 'Dokumen::create', ['filter' => 'permission:dokumen_unggah']);
    $routes->post('/dokumen/store', 'Dokumen::store', ['filter' => 'permission:dokumen_unggah']);
    $routes->get('/dokumen/edit/(:num)', 'Dokumen::edit/$1', ['filter' => 'permission:dokumen_unggah']);
    $routes->post('/dokumen/update/(:num)', 'Dokumen::update/$1', ['filter' => 'permission:dokumen_unggah']);
    
    // Aksi Dokumen Masuk (Bisa approve kalau punya akses dokumen masuk)
    $routes->get('/dokumen/approve/(:num)', 'Dokumen::approve/$1', ['filter' => 'permission:dokumen_masuk']);
    $routes->get('/dokumen/revisi/(:num)', 'Dokumen::revisi/$1', ['filter' => 'permission:dokumen_masuk']);
    $routes->get('/dokumen/review/(:num)', 'Dokumen::review/$1', ['filter' => 'permission:dokumen_masuk']);
    // Akses detail dokumen biasanya dibolehkan jika bisa lihat dokumen/arsip/unggah
    $routes->get('/dokumen/show/(:num)', 'Dokumen::show/$1');
    
    // Pesan Notifikasi (Semua yang login)
    $routes->get('/pesan', 'Pesan::index');
    $routes->get('/pesan/read/(:num)', 'Pesan::read/$1');
    $routes->get('/pesan/detail/(:num)', 'Pesan::detail/$1');
    
    // Laporan
    $routes->get('/laporan/analisis', 'Laporan::analisis', ['filter' => 'permission:laporan_analisis']);
    
    // Manajemen Pengguna
    $routes->get('/manajemen/peran', 'Manajemen::peran', ['filter' => 'permission:manajemen_pengguna']);
    $routes->get('/manajemen/izin', 'Manajemen::izin', ['filter' => 'permission:manajemen_pengguna']);
    $routes->get('/manajemen/status', 'Manajemen::status', ['filter' => 'permission:manajemen_pengguna']);
    $routes->get('/manajemen/log', 'Manajemen::log', ['filter' => 'permission:manajemen_pengguna']);
    $routes->get('/manajemen/persetujuan', 'Manajemen::persetujuan', ['filter' => 'permission:manajemen_pengguna']);

    // API Endpoints Manajemen
    $routes->post('/manajemen/addUser', 'Manajemen::addUser', ['filter' => 'permission:manajemen_pengguna']);
    $routes->post('/manajemen/approveGuest/(:num)', 'Manajemen::approveGuest/$1', ['filter' => 'permission:manajemen_pengguna']);
    $routes->post('/manajemen/rejectGuest/(:num)', 'Manajemen::rejectGuest/$1', ['filter' => 'permission:manajemen_pengguna']);
    $routes->post('/manajemen/toggleStatus/(:num)', 'Manajemen::toggleStatus/$1', ['filter' => 'permission:manajemen_pengguna']);
    $routes->post('/manajemen/deleteUser/(:num)', 'Manajemen::deleteUser/$1', ['filter' => 'permission:manajemen_pengguna']);
    $routes->post('/manajemen/updateUser/(:num)', 'Manajemen::updateUser/$1', ['filter' => 'permission:manajemen_pengguna']);
    $routes->post('/manajemen/clearLogs', 'Manajemen::clearLogs', ['filter' => 'permission:manajemen_pengguna']);
    $routes->post('/manajemen/savePermissions', 'Manajemen::savePermissions', ['filter' => 'permission:manajemen_pengguna']);
});
