<?php

namespace App\Controllers;

use App\Models\NasabahModel;

class Nasabah extends BaseController
{
    public function index()
    {
        $model = new NasabahModel();
        
        $page = $this->request->getVar('page_nasabah') ? $this->request->getVar('page_nasabah') : 1;
        $search = $this->request->getVar('search');

        if ($search) {
            $model->groupStart()
                  ->like('nama_lengkap', $search)
                  ->orLike('no_arsip', $search)
                  ->orLike('no_rekening', $search)
                  ->groupEnd();
        }
        
        $data['nasabah'] = $model->paginate(10, 'nasabah');
        $data['pager'] = $model->pager;
        $data['page'] = $page;
        $data['search'] = $search;
        
        return view('nasabah/index', $data);
    }

    public function create()
    {
        return view('nasabah/create');
    }

    public function store()
    {
        $model = new NasabahModel();
        
        $data = [
            'nama_lengkap'  => $this->request->getPost('nama_lengkap'),
            'jenis_akun'    => $this->request->getPost('jenis_akun'),
            'no_rekening'   => $this->request->getPost('no_rekening'),
            'tanggal_arsip' => $this->request->getPost('tanggal_arsip'),
            'no_arsip'      => 'ARS-' . rand(10000, 99999), // Simulate no_arsip generation
            'status'        => 'Aktif'
        ];
        
        $model->insert($data);
        return redirect()->to(base_url('nasabah'))->with('success', 'Data nasabah berhasil disimpan');
    }

    public function show($id)
    {
        $model = new NasabahModel();
        $data['nasabah'] = $model->find($id);
        if (!$data['nasabah']) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        
        $dokumenModel = new \App\Models\DokumenModel();
        $data['dokumen_approved'] = $dokumenModel->where('nasabah_id', $id)
                                                 ->where('status', 'Approved')
                                                 ->where('jenis_dokumen !=', 'Pengajuan Penonaktifan')
                                                 ->findAll();

        $data['dokumen_revisi'] = $dokumenModel->where('nasabah_id', $id)
                                               ->where('status', 'Revisi')
                                               ->findAll();

        return view('nasabah/show', $data);
    }

    public function edit($id)
    {
        $model = new NasabahModel();
        $data['nasabah'] = $model->find($id);
        if (!$data['nasabah']) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        return view('nasabah/edit', $data);
    }

    public function update($id)
    {
        $model = new NasabahModel();
        
        $data = [
            'nama_lengkap'  => $this->request->getPost('nama_lengkap'),
            'jenis_akun'    => $this->request->getPost('jenis_akun'),
            'no_rekening'   => $this->request->getPost('no_rekening'),
            'tanggal_arsip' => $this->request->getPost('tanggal_arsip')
        ];

        $status = $this->request->getPost('status');

        if ($status === 'Tidak Aktif') {
            // Keep nasabah status as Aktif for now, it needs approval
            $data['status'] = 'Aktif';
            $model->update($id, $data);

            // Create Dokumen entry for Approval
            $dokumenModel = new \App\Models\DokumenModel();
            $dokumenData = [
                'id_doc'        => 'REQ-' . rand(10000, 99999),
                'nasabah_id'    => $id,
                'jenis_dokumen' => 'Pengajuan Penonaktifan',
                'file_path'     => null,
                'status'        => 'Pending',
                'tanggal_upload'=> date('Y-m-d H:i:s'),
                'kebutuhan'     => $this->request->getPost('kebutuhan'),
                'keterangan'    => $this->request->getPost('keterangan')
            ];
            $dokumenModel->insert($dokumenData);

            return redirect()->to(base_url('nasabah'))->with('success', 'Perubahan biodata disimpan. Pengajuan penonaktifan berhasil dikirim ke antrean Dokumen Masuk untuk disetujui.');
        } else {
            // Normal update
            $data['status'] = 'Aktif';
            $model->update($id, $data);
            return redirect()->to(base_url('nasabah'))->with('success', 'Nasabah berhasil diperbarui');
        }
    }

    public function delete($id)
    {
        $role = strtolower(session()->get('role'));
        $dokumenModel = new \App\Models\DokumenModel();
        
        $hasDocuments = $dokumenModel->where('nasabah_id', $id)->first();
        
        if ($role === 'staff' && $hasDocuments) {
            return redirect()->to(base_url('nasabah'))->with('error', 'Akses ditolak: Staff tidak dapat menghapus nasabah yang sudah memiliki dokumen.');
        }

        $model = new NasabahModel();
        $model->delete($id);
        return redirect()->to(base_url('nasabah'))->with('success', 'Data nasabah berhasil dihapus');
    }
}
