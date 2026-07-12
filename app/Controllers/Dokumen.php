<?php

namespace App\Controllers;

use App\Models\DokumenModel;

class Dokumen extends BaseController
{
    public function index()
    {
        $model = new DokumenModel();
        $db      = \Config\Database::connect();
        $builder = $db->table('dokumen');
        $builder->select('dokumen.*, nasabah.nama_lengkap, nasabah.no_arsip');
        $builder->join('nasabah', 'nasabah.id = dokumen.nasabah_id');
        $builder->where('dokumen.status', 'Pending');
        $builder->orderBy('dokumen.id', 'DESC');
        $pendingDocs = $builder->get()->getResultArray();
        
        $grouped = [];
        foreach ($pendingDocs as $doc) {
            $nid = $doc['nasabah_id'];
            if (!isset($grouped[$nid])) {
                $grouped[$nid] = [
                    'nasabah_id' => $nid,
                    'nama_lengkap' => $doc['nama_lengkap'],
                    'no_arsip' => $doc['no_arsip'],
                    'jumlah_dokumen' => 0,
                    'dokumen_list' => []
                ];
            }
            $grouped[$nid]['jumlah_dokumen']++;
            $grouped[$nid]['dokumen_list'][] = $doc;
        }
        
        $data['grouped_dokumen'] = $grouped;
        
        return view('dokumen/index', $data);
    }

    public function create()
    {
        $nasabahModel = new \App\Models\NasabahModel();
        $data['nasabah'] = $nasabahModel->where('status', 'Aktif')->findAll();
        return view('dokumen/create', $data);
    }

    public function review($nasabah_id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('dokumen');
        $builder->select('dokumen.*, nasabah.nama_lengkap, nasabah.no_arsip');
        $builder->join('nasabah', 'nasabah.id = dokumen.nasabah_id');
        $builder->where('dokumen.nasabah_id', $nasabah_id);
        $builder->where('dokumen.status', 'Pending');
        $builder->orderBy('dokumen.id', 'DESC');
        $data['dokumen'] = $builder->get()->getResultArray();
        
        if (empty($data['dokumen'])) {
            return redirect()->to(base_url('dokumen'))->with('error', 'Tidak ada dokumen tertunda untuk nasabah ini.');
        }
        
        $data['nama_nasabah'] = $data['dokumen'][0]['nama_lengkap'];
        $data['no_arsip'] = $data['dokumen'][0]['no_arsip'];
        
        return view('dokumen/review', $data);
    }

    public function store()
    {
        $model = new DokumenModel();
        $nasabah_id = $this->request->getPost('nasabah_id');
        
        $nasabahModel = new \App\Models\NasabahModel();
        $nasabah = $nasabahModel->find($nasabah_id);
        
        if (!$nasabah || $nasabah['status'] !== 'Aktif') {
            return redirect()->back()->with('error', 'Nasabah tidak valid atau tidak aktif. Tidak dapat mengunggah dokumen.');
        }
        
        $dokumenTypes = [
            'fileKTP' => 'KTP',
            'fileKK' => 'Kartu Keluarga',
            'fileNPWP' => 'NPWP',
            'fileBukuTabungan' => 'Buku Tabungan',
            'fileSlipGaji' => 'Surat Keterangan Penghasilan',
            'fileSKKerja' => 'Surat Keterangan Kerja',
            'fileFormulir' => 'Formulir Pengajuan',
            'fileSuratKuasa' => 'Surat Kuasa',
            'fileLainnya' => 'Lainnya'
        ];
        
        $hasUpload = false;
        
        foreach ($dokumenTypes as $inputName => $jenis) {
            $file = $this->request->getFile($inputName);
            
            if ($file && $file->isValid() && ! $file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move(FCPATH . 'uploads/dokumen', $newName);
                
                $data = [
                    'id_doc'        => 'DOC-' . rand(10000, 99999),
                    'nasabah_id'    => $nasabah_id,
                    'jenis_dokumen' => $jenis,
                    'file_path'     => 'uploads/dokumen/' . $newName,
                    'status'        => 'Pending',
                    'tanggal_upload'=> date('Y-m-d H:i:s')
                ];
                
                $model->insert($data);
                $hasUpload = true;
            }
        }
        
        if (!$hasUpload) {
            return redirect()->back()->with('error', 'Silakan pilih setidaknya satu dokumen untuk diunggah.');
        }
        
        $pesanModel = new \App\Models\PesanModel();
        $pesanModel->insert([
            'pengirim_role' => session()->get('role') ?? 'staff',
            'penerima_role' => 'supervisor',
            'judul'         => 'Dokumen Baru',
            'isi_pesan'     => 'Ada dokumen baru yang telah diunggah dan membutuhkan persetujuan Anda.',
            'target_url'    => 'dokumen/review/' . $nasabah_id
        ]);
        
        log_activity('Mengunggah Dokumen', 'Mengunggah dokumen untuk nasabah ID: ' . $nasabah_id);
        
        return redirect()->to(base_url('dokumen'))->with('success', 'Dokumen berhasil diunggah');
    }

    public function arsip()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('nasabah');
        $builder->select('nasabah.id as nasabah_id, nasabah.nama_lengkap, nasabah.no_arsip, dokumen.kebutuhan, dokumen.keterangan, dokumen.updated_at as tanggal_diarsipkan');
        // Get the approved deactivation request
        $builder->join('dokumen', "dokumen.nasabah_id = nasabah.id AND dokumen.jenis_dokumen = 'Pengajuan Penonaktifan' AND dokumen.status = 'Approved'", 'left');
        $builder->where('nasabah.status', 'Tidak Aktif');
        $builder->orderBy('nasabah.updated_at', 'DESC');
        
        $data['arsip'] = $builder->get()->getResultArray();
        return view('dokumen/arsip', $data);
    }

    public function approve($id)
    {
        $model = new DokumenModel();
        $dokumen = $model->find($id);
        if (!$dokumen) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $model->update($id, ['status' => 'Approved']);

        // Jika ini adalah pengajuan penonaktifan, resmi ubah status nasabah
        if ($dokumen['jenis_dokumen'] === 'Pengajuan Penonaktifan') {
            $nasabahModel = new \App\Models\NasabahModel();
            $nasabahModel->update($dokumen['nasabah_id'], ['status' => 'Tidak Aktif']);
        }
        
        $pesanModel = new \App\Models\PesanModel();
        $pesanModel->insert([
            'pengirim_role' => session()->get('role') ?? 'supervisor',
            'penerima_role' => 'staff',
            'judul'         => 'Dokumen Disetujui',
            'isi_pesan'     => 'Dokumen ' . $dokumen['jenis_dokumen'] . ' (' . $dokumen['id_doc'] . ') telah disetujui.',
            'target_url'    => 'nasabah/show/' . $dokumen['nasabah_id']
        ]);

        log_activity('Menyetujui Dokumen', 'Menyetujui dokumen ' . $dokumen['jenis_dokumen'] . ' untuk nasabah ID: ' . $dokumen['nasabah_id']);

        return redirect()->back()->with('success', 'Dokumen berhasil disetujui');
    }

    public function revisi($id)
    {
        $model = new DokumenModel();
        $dokumen = $model->find($id);
        if ($dokumen) {
            $catatan = $this->request->getGet('catatan') ?? 'Tidak ada keterangan.';
            $model->update($id, [
                'status' => 'Revisi',
                'keterangan' => $catatan
            ]);
            $pesanModel = new \App\Models\PesanModel();
            $pesanModel->insert([
                'pengirim_role' => session()->get('role') ?? 'supervisor',
                'penerima_role' => 'staff',
                'judul'         => 'Dokumen Perlu Direvisi',
                'isi_pesan'     => 'Dokumen ' . $dokumen['jenis_dokumen'] . ' (' . $dokumen['id_doc'] . ') ditandai untuk revisi. Catatan: ' . $catatan,
                'target_url'    => 'nasabah/show/' . $dokumen['nasabah_id']
            ]);
            
            log_activity('Menandai Revisi', 'Menandai revisi dokumen ' . $dokumen['jenis_dokumen'] . ' untuk nasabah ID: ' . $dokumen['nasabah_id']);
        }
        return redirect()->back()->with('error', 'Dokumen ditandai untuk revisi');
    }

    public function show($id)
    {
        $model = new DokumenModel();
        $dokumen = $model->find($id);
        if (!$dokumen) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        
        if ($dokumen['jenis_dokumen'] === 'Pengajuan Penonaktifan' || empty($dokumen['file_path'])) {
            $nasabahModel = new \App\Models\NasabahModel();
            $data['dokumen'] = $dokumen;
            $data['nasabah'] = $nasabahModel->find($dokumen['nasabah_id']);
            return view('dokumen/show_pengajuan', $data);
        }

        return redirect()->to(base_url($dokumen['file_path']));
    }

    public function edit($id)
    {
        $model = new DokumenModel();
        $dokumen = $model->find($id);
        if (!$dokumen) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        
        $nasabahModel = new \App\Models\NasabahModel();
        $data['nasabah'] = $nasabahModel->find($dokumen['nasabah_id']);
        $data['dokumen'] = $dokumen;
        
        return view('dokumen/edit', $data);
    }

    public function update($id)
    {
        $model = new DokumenModel();
        $dokumen = $model->find($id);
        if (!$dokumen) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        
        $file = $this->request->getFile('file_dokumen');
        
        if ($file && $file->isValid() && ! $file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/dokumen', $newName);
            
            $model->update($id, [
                'file_path'     => 'uploads/dokumen/' . $newName,
                'status'        => 'Pending',
                'keterangan'    => null, // Reset keterangan
                'tanggal_upload'=> date('Y-m-d H:i:s')
            ]);
            
            $pesanModel = new \App\Models\PesanModel();
            $pesanModel->insert([
                'pengirim_role' => session()->get('role') ?? 'staff',
                'penerima_role' => 'supervisor',
                'judul'         => 'Dokumen Diperbarui',
                'isi_pesan'     => 'Dokumen ' . $dokumen['jenis_dokumen'] . ' (' . $dokumen['id_doc'] . ') telah diperbarui dan membutuhkan persetujuan Anda.',
                'target_url'    => 'dokumen/review/' . $dokumen['nasabah_id']
            ]);
            
            log_activity('Memperbarui Dokumen', 'Memperbarui dokumen ' . $dokumen['jenis_dokumen'] . ' untuk nasabah ID: ' . $dokumen['nasabah_id']);
            
            return redirect()->to(base_url('nasabah/show/' . $dokumen['nasabah_id']))->with('success', 'Dokumen berhasil diperbarui dan diajukan ulang.');
        }
        
        return redirect()->back()->with('error', 'Gagal mengunggah dokumen baru. Pastikan file dipilih.');
    }
}
