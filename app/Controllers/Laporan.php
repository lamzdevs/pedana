<?php

namespace App\Controllers;

use App\Models\NasabahModel;

class Laporan extends BaseController
{
    public function analisis()
    {
        $nasabahModel = new NasabahModel();
        
        $data['total_nasabah'] = $nasabahModel->countAllResults();
        $data['nasabah_aktif'] = $nasabahModel->where('status', 'Aktif')->countAllResults();
        $data['nasabah_arsip'] = $nasabahModel->where('status', 'Tidak Aktif')->countAllResults();

        $db = \Config\Database::connect();
        $jenisAkunQuery = $db->query("SELECT jenis_akun, COUNT(id) as total FROM nasabah GROUP BY jenis_akun");
        $data['chart_jenis_akun'] = $jenisAkunQuery->getResultArray();

        $statusQuery = $db->query("SELECT status, COUNT(id) as total FROM nasabah GROUP BY status");
        $data['chart_status'] = $statusQuery->getResultArray();

        return view('laporan/analisis', $data);
    }

}
