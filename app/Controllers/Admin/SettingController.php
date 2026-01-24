<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Helpers\ToaStr;
use App\Models\Admin\SettingModel;
use PDO;

class SettingController extends Controller {
    private $model;

    public function __construct() {
        parent::__construct();
        if (!isset($_SESSION['admin_logged_in'])) {
            header("Location: " . BASE_URL . "/auth");
            exit;
        }
        $this->model = new SettingModel($this->db);
    }

    public function index() {
        $rawSettings = $this->db->query("SELECT * FROM settings WHERE setting_name NOT LIKE '%layout%' ORDER BY setting_group ASC")->fetchAll(PDO::FETCH_ASSOC);
        
        $grouped = [];
        foreach ($rawSettings as $s) {
            $grouped[$s['setting_group']][] = $s;
        }

        $this->view('settings', [
            'title' => __('Settings'),
            'grouped_settings' => $grouped
        ], 'admin');
    }

    public function save() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (($_POST['csrf_token'] ?? '') !== ($_SESSION['csrf_token'] ?? '')) {
                ToaStr::set('error', __('Invalid security token'));
                header("Location: " . BASE_URL . "/admin/setting");
                exit;
            }

            $sets = $_POST['sets'] ?? [];
            $files = $_FILES['files'] ?? [];

            if ($this->model->updateSettings($sets, $files)) {
                ToaStr::set('success', __('Settings updated successfully'));
            } else {
                ToaStr::set('error', __('Failed to update settings'));
            }
            
            header("Location: " . BASE_URL . "/admin/setting");
            exit;
        }
    }
}