<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 *
 * Extend this class in any new controllers:
 * ```
 *     class Home extends BaseController
 * ```
 *
 * For security, be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */

    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Load here all helpers you want to be available in your controllers that extend BaseController.
        // Caution: Do not put the this below the parent::initController() call below.
        $this->helpers = ['form', 'url', 'activity', 'permission'];

        // Caution: Do not edit this line.
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.
        $this->session = \Config\Services::session();
        
        // Fetch unread messages globally
        if ($this->session->get('role')) {
            $pesanModel = new \App\Models\PesanModel();
            
            $role = $this->session->get('role');
            
            $pesan_list = $pesanModel->where('penerima_role', $role)
                                     ->orderBy('created_at', 'DESC')
                                     ->limit(10)
                                     ->findAll();
                                     
            $pesan_unread = $pesanModel->where('penerima_role', $role)
                                       ->where('is_read', 0)
                                       ->countAllResults();
                                       
            // Make available to all views
            \Config\Services::renderer()->setVar('pesan_list', $pesan_list);
            \Config\Services::renderer()->setVar('pesan_unread', $pesan_unread);
        }
    }
}
