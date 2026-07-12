<?php

namespace App\Controllers;

use App\Models\PesanModel;

class Pesan extends BaseController
{
    public function index()
    {
        $pesanModel = new \App\Models\PesanModel();
        $role = session()->get('role');
        
        $data['semua_pesan'] = $pesanModel->where('penerima_role', $role)
                                          ->orderBy('created_at', 'DESC')
                                          ->paginate(5, 'pesan');
        
        $data['pager'] = $pesanModel->pager;
                                          
        return view('pesan/index', $data);
    }

    public function read($id)
    {
        $model = new PesanModel();
        $pesan = $model->find($id);

        if ($pesan) {
            $was_read = $pesan['is_read'];
            
            // Tandai sudah dibaca jika belum
            if (!$was_read) {
                $model->update($id, ['is_read' => 1]);
                
                // Jika pesan baru, arahkan ke target_url (Detail Nasabah)
                if (!empty($pesan['target_url'])) {
                    return redirect()->to(base_url($pesan['target_url']));
                }
            } else {
                // Jika pesan sudah dibaca sebelumnya, arahkan ke halaman detail pesan
                return redirect()->to(base_url('pesan/detail/' . $id));
            }
        }
        
        // Redirect default
        return redirect()->to(base_url('pesan'));
    }

    public function detail($id)
    {
        $model = new PesanModel();
        $pesan = $model->find($id);
        
        if (!$pesan) {
            return redirect()->to(base_url('pesan'))->with('error', 'Pesan tidak ditemukan');
        }
        
        $data['pesan'] = $pesan;
        
        // Coba ekstrak ID Nasabah dari target_url (misal: nasabah/show/5)
        $data['nasabah_nama'] = null;
        if (!empty($pesan['target_url'])) {
            $parts = explode('/', $pesan['target_url']);
            $nasabah_id = end($parts);
            if (is_numeric($nasabah_id)) {
                $nasabahModel = new \App\Models\NasabahModel();
                $nasabah = $nasabahModel->find($nasabah_id);
                if ($nasabah) {
                    $data['nasabah_nama'] = $nasabah['nama_lengkap'];
                }
            }
        }
        
        // Ekstrak ID Dokumen jika pesan merupakan revisi
        $data['dokumen_id'] = null;
        if (preg_match('/\(DOC-\d+\)/', $pesan['isi_pesan'], $matches)) {
            $id_doc = trim($matches[0], '()');
            $dokumenModel = new \App\Models\DokumenModel();
            $dokumen = $dokumenModel->where('id_doc', $id_doc)->first();
            if ($dokumen) {
                $data['dokumen_id'] = $dokumen['id'];
            }
        }
        
        return view('pesan/detail', $data);
    }
}
