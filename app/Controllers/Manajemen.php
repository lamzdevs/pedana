<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\ActivityLogModel;
use App\Models\PermissionModel;

class Manajemen extends BaseController
{
    public function peran()
    {
        $userModel = new UserModel();
        $data['users'] = $userModel->findAll();
        return view('manajemen/peran', $data);
    }

    public function izin()
    {
        $permissionModel = new PermissionModel();
        $data['permissions'] = $permissionModel->getPermissionsMatrix();
        return view('manajemen/izin', $data);
    }

    public function status()
    {
        $userModel = new UserModel();
        $data['users'] = $userModel->findAll();
        return view('manajemen/status', $data);
    }

    public function log()
    {
        $roleFilter = $this->request->getGet('role');
        $logModel = new ActivityLogModel();
        
        $data['selected_role'] = $roleFilter;
        $data['logs'] = $logModel->getLogsWithUsersPaginated(7, $roleFilter);
        $data['pager'] = $logModel->pager;
        
        return view('manajemen/log', $data);
    }

    // --- API Endpoints ---

    public function toggleStatus($id)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);
        if ($user) {
            $newStatus = ($user['status'] == 'Aktif') ? 'Nonaktif' : 'Aktif';
            $userModel->update($id, ['status' => $newStatus]);
            
            // Log it
            log_activity('Mengubah Status Akun', 'Akun ' . $user['fullname'] . ' menjadi ' . $newStatus);
            
            return $this->response->setJSON(['status' => 'success', 'new_status' => $newStatus]);
        }
        return $this->response->setJSON(['status' => 'error', 'message' => 'User not found']);
    }

    public function deleteUser($id)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);
        if ($user) {
            $userModel->delete($id);
            log_activity('Menghapus Pengguna', 'Menghapus ' . $user['fullname']);
            return $this->response->setJSON(['status' => 'success']);
        }
        return $this->response->setJSON(['status' => 'error']);
    }

    public function addUser()
    {
        $json = $this->request->getJSON();
        if (!$json) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak valid']);
        }

        $userModel = new UserModel();

        // Validasi unik
        if ($userModel->where('username', $json->username)->first()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Username sudah digunakan.']);
        }
        if ($userModel->where('email', $json->email)->first()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Email sudah terdaftar.']);
        }

        $data = [
            'fullname' => $json->fullname,
            'username' => $json->username,
            'email'    => $json->email,
            'password' => password_hash($json->password, PASSWORD_DEFAULT),
            'role'     => $json->role,
            'status'   => 'Aktif'
        ];

        if ($userModel->insert($data)) {
            log_activity('Manajemen Pengguna', 'Menambahkan pengguna baru: ' . $json->username);
            return $this->response->setJSON(['status' => 'success']);
        }

        return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal menyimpan data ke database.']);
    }

    public function updateUser($id)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);
        if ($user) {
            $data = $this->request->getJSON(true);
            $updateData = [];
            if (isset($data['fullname'])) $updateData['fullname'] = $data['fullname'];
            if (isset($data['email'])) $updateData['email'] = $data['email'];
            if (isset($data['role'])) $updateData['role'] = $data['role'];

            if (!empty($updateData)) {
                $userModel->update($id, $updateData);
                log_activity('Mengubah Data Pengguna', 'Memperbarui data ' . $user['fullname']);
                return $this->response->setJSON(['status' => 'success']);
            }
        }
        return $this->response->setJSON(['status' => 'error']);
    }

    public function clearLogs()
    {
        $db = \Config\Database::connect();
        $db->query('TRUNCATE TABLE activity_logs');
        log_activity('Membersihkan Log', 'Seluruh log aktivitas dihapus');
        return $this->response->setJSON(['status' => 'success']);
    }

    public function savePermissions()
    {
        $data = $this->request->getJSON(true); // associative array
        
        if ($data) {
            $db = \Config\Database::connect();
            $db->transStart();
            foreach ($data as $role => $features) {
                foreach ($features as $feature => $is_allowed) {
                    $val = $is_allowed ? 1 : 0;
                    $exists = $db->query("SELECT id FROM permissions WHERE role = ? AND feature = ?", [$role, $feature])->getRow();
                    
                    if ($exists) {
                        $db->query("UPDATE permissions SET is_allowed = ? WHERE id = ?", [$val, $exists->id]);
                    } else {
                        $db->query("INSERT INTO permissions (role, feature, is_allowed) VALUES (?, ?, ?)", [$role, $feature, $val]);
                    }
                }
            }
            $db->transComplete();
            
            log_activity('Mengubah Hak Akses', 'Memperbarui tabel permissions');
            return $this->response->setJSON(['status' => 'success']);
        }
        return $this->response->setJSON(['status' => 'error']);
    }

    public function persetujuan()
    {
        $userModel = new UserModel();
        $data['guests'] = $userModel->where('status', 'Pending')->where('role', 'guest')->findAll();
        return view('manajemen/persetujuan', $data);
    }

    public function approveGuest($id)
    {
        $userModel = new UserModel();
        $role = $this->request->getPost('role');
        
        if (!in_array($role, ['admin', 'supervisor', 'staff'])) {
            session()->setFlashdata('error', 'Role tidak valid!');
            return redirect()->to(base_url('manajemen/persetujuan'));
        }

        $user = $userModel->find($id);
        if ($user) {
            $userModel->update($id, [
                'role' => $role,
                'status' => 'Aktif'
            ]);
            log_activity('Persetujuan Akun', "Menyetujui akun {$user['username']} sebagai {$role}");
            session()->setFlashdata('success', 'Akun berhasil disetujui dan diaktifkan!');
        }
        return redirect()->to(base_url('manajemen/persetujuan'));
    }

    public function rejectGuest($id)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);
        if ($user) {
            $userModel->delete($id);
            log_activity('Penolakan Akun', "Menolak dan menghapus akun {$user['username']}");
            session()->setFlashdata('success', 'Akun berhasil ditolak dan dihapus!');
        }
        return redirect()->to(base_url('manajemen/persetujuan'));
    }
}
