<?php
namespace App\Controllers\Public;

use App\Core\Controller;
use App\Models\Public\HomeModel;
use Exception;

class HomeController extends Controller {
    private $homeModel;

    public function __construct() {
        parent::__construct();
        $this->homeModel = new HomeModel($this->db);
    }
    
    public function index() {
        try {
            $siteSubtitle = defined('SITE_SUBTITLE') ? SITE_SUBTITLE : '';
            $data = [
                'title'      => __("Home") . " - " . htmlspecialchars($siteSubtitle, ENT_QUOTES, 'UTF-8'),
                'berita'     => $this->homeModel->getPostsByCategory('berita', 3),
                'artikel'    => $this->homeModel->getPostsByCategory('artikel', 4),
                'pengumuman' => $this->homeModel->getPostsByCategory('informasi', 4),
                'galleries'  => $this->homeModel->getGalleries(6),
                'widgets'    => $this->homeModel->getWidgets()
            ];
            $this->view('home', $data);
            
        } catch (Exception $e) {
            error_log("HomeController Error: " . $e->getMessage());
            
            $this->view('errors/500', [
                'message' => __('A system error occurred.')
            ], 'blank');
        }
    }
}