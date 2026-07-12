<?php

namespace App\Controllers;

use App\Models\NasabahModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $nasabahModel = new NasabahModel();
        $dokumenModel = new \App\Models\DokumenModel();
        
        $role = session()->get('role');
        $data = [
            'role' => $role,
            'total_nasabah' => $nasabahModel->where('status', 'Aktif')->countAllResults()
        ];
        
        if ($role === 'staff' || !$role) {
            $data['new_entries'] = $nasabahModel->where('MONTH(tanggal_arsip)', date('n'))
                                                ->where('YEAR(tanggal_arsip)', date('Y'))
                                                ->countAllResults();
            $data['doc_pending'] = $dokumenModel->where('status', 'Pending')->countAllResults();
            $data['doc_error']   = $dokumenModel->where('status', 'Revisi')->countAllResults();
        } 
        elseif ($role === 'supervisor') {
            $data['nasabah_inactive'] = $nasabahModel->where('status', 'Tidak Aktif')->countAllResults();
            $data['doc_pending'] = $dokumenModel->where('status', 'Pending')->countAllResults();
            $data['doc_approved_month'] = $dokumenModel->where('status', 'Approved')
                                                       ->where('MONTH(updated_at)', date('n'))
                                                       ->where('YEAR(updated_at)', date('Y'))
                                                       ->countAllResults();
        } 
        elseif ($role === 'admin') {
            $userModel = new \App\Models\UserModel();
            $data['nasabah_inactive'] = $nasabahModel->where('status', 'Tidak Aktif')->countAllResults();
            $data['total_pengguna'] = $userModel->countAllResults();
            $data['active_users'] = $userModel->where('status', 'Aktif')->countAllResults();
        }

        // Fetch monthly chart data
        $year = date('Y');
        $monthly_data = array_fill(1, 12, 0);
        
        $db = \Config\Database::connect();
        $query = $db->query("SELECT MONTH(tanggal_arsip) as month, COUNT(*) as total FROM nasabah WHERE YEAR(tanggal_arsip) = ? GROUP BY MONTH(tanggal_arsip)", [$year]);
        
        foreach ($query->getResultArray() as $row) {
            $monthly_data[(int)$row['month']] = (int)$row['total'];
        }
        
        $data['chart_data'] = array_values($monthly_data);

        // Fetch Recent Activities for this role
        $activityModel = new \App\Models\ActivityLogModel();
        // Since ActivityLogModel stores user_id, we need to join with users to filter by role
        $builder = $db->table('activity_logs');
        $builder->select('activity_logs.*, users.fullname, users.role');
        $builder->join('users', 'users.id = activity_logs.user_id');
        $builder->where('users.role', $role);
        $builder->orderBy('activity_logs.created_at', 'DESC');
        $builder->limit(3);
        $data['recent_activities'] = $builder->get()->getResultArray();

        return view('dashboard/index', $data);
    }

    public function updateProfilePic()
    {
        $file = $this->request->getFile('profile_pic');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Validasi tipe file
            $type = $file->getClientMimeType();
            if (!in_array($type, ['image/jpeg', 'image/png', 'image/jpg'])) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Hanya file JPG/PNG yang diperbolehkan.']);
            }

            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/profiles', $newName);

            $userModel = new \App\Models\UserModel();
            $userId = session()->get('id');
            
            $oldUser = $userModel->find($userId);
            if ($oldUser && !empty($oldUser['profile_pic']) && $oldUser['profile_pic'] !== 'profil.png' && file_exists(FCPATH . 'uploads/profiles/' . $oldUser['profile_pic'])) {
                unlink(FCPATH . 'uploads/profiles/' . $oldUser['profile_pic']);
            }

            $userModel->update($userId, ['profile_pic' => $newName]);
            session()->set('profile_pic', $newName);
            
            return $this->response->setJSON(['status' => 'success', 'new_pic' => base_url('uploads/profiles/' . $newName)]);
        }
        
        return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal mengunggah gambar.']);
    }
}
