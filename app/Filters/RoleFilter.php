<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $role = session()->get('role');
        
        // If no arguments passed, just pass
        if (empty($arguments)) {
            return;
        }

        // Check if user's role is in the allowed arguments
        if (!in_array($role, $arguments)) {
            // Not allowed, redirect to dashboard with error
            session()->setFlashdata('error', 'Anda tidak memiliki hak akses ke halaman tersebut.');
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
