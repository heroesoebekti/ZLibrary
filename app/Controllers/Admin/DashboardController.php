<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Admin\DashboardModel;

class DashboardController extends Controller {
    private $model;

    public function __construct() {
        parent::__construct();
        
        if (!isset($_SESSION['admin_logged_in'])) {
            header("Location: " . BASE_URL . "/auth");
            exit;
        }
        $this->model = new DashboardModel($this->db);
    }

    public function index() {
        $stats = $this->model->getStats();

        $data = [
            'title'        => __("Dashboard") . " - " . SITE_TITLE,
            'current_page' => __("Dashboard"),
            'count_berita'  => $stats['berita'],
            'count_artikel' => $stats['artikel'],
            'count_info'    => $stats['informasi'],
            'user_role'     => $_SESSION['role'] ?? __("operator"),
            'admin_name'    => $_SESSION['admin_name'] ?? __("Admin")
        ];

        $this->view('dashboard', $data, 'admin');
    }
}