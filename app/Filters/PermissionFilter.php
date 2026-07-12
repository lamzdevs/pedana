<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class PermissionFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }

        if (empty($arguments)) {
            return; // no specific permission required
        }

        $feature = $arguments[0]; // e.g. 'nasabah_lihat'
        
        helper('permission');
        if (!has_permission($feature)) {
            // Jika request ajax / fetch API
            if ($request->isAJAX() || strpos($request->getHeaderLine('Accept'), 'application/json') !== false) {
                return \Config\Services::response()->setJSON(['status' => 'error', 'message' => 'Anda tidak memiliki hak akses untuk fitur ini.']);
            }
            // Jika request biasa
            return redirect()->to('/dashboard')->with('error', 'Anda tidak memiliki hak akses untuk fitur tersebut.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
