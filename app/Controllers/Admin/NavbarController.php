<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Admin\NavbarModel;
use App\Helpers\ToaStr;
use PDO;

class NavbarController extends Controller {
    private $model;

    public function __construct() {
        parent::__construct();
        
        if (!isset($_SESSION['admin_logged_in'])) {
            header("Location: " . BASE_URL . "/auth");
            exit;
        }

        $this->model = new NavbarModel($this->db);
    }

    public function index() {
        $editId = (int)$this->input('edit', 0);
        $edit_data = ($editId > 0) ? $this->model->find($editId) : null;
        $parents = $this->model->getAllParents()->fetchAll(PDO::FETCH_ASSOC);

        $data = [
            'title'     => __('Manage Navigation'),
            'parents'   => $parents,
            'edit_data' => $edit_data,
            'is_edit'   => !!$edit_data,
            'model'     => $this->model
        ];
        
        $this->view('navbar', $data, 'admin');
    }

    public function save() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $this->input('id');
            $parentId = $this->input('parent_id');

            $data = [
                'id'        => !empty($id) ? (int)$id : null,
                'nama_menu' => $this->input('nama_menu'),
                'url_menu'  => $this->input('url_menu'),
                'parent_id' => ($parentId === 'NULL' || empty($parentId)) ? null : (int)$parentId
            ];

            if (empty($data['nama_menu']) || empty($data['url_menu'])) {
                ToaStr::set('error', __('Menu name and URL are required'));
                header("Location: " . BASE_URL . "/admin/navbar");
                exit;
            }

            if ($this->model->save($data)) {
                $status = $data['id'] ? 'info' : 'success';
                $message = $data['id'] ? __('Navigation updated successfully') : __('Navigation added successfully');
                ToaStr::set($status, $message);
            } else {
                ToaStr::set('error', __('Failed to save to database'));
            }
            
            header("Location: " . BASE_URL . "/admin/navbar");
            exit;
        }
    }

    public function saveOrder() {
        if (ob_get_length()) ob_clean();
        header('Content-Type: application/json');

        try {
            $token = $this->input('csrf_token');
            if (!hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
                throw new \Exception(__('Invalid security token'));
            }

            $order = json_decode($_POST['order'] ?? '[]');
            $newParentId = $this->input('new_parent_id');
            $menuId = (int)$this->input('menu_id');

            if ($menuId > 0) {
                $finalParentId = ($newParentId === "NULL" || empty($newParentId)) ? null : (int)$newParentId;
                $this->model->updateParent($menuId, $finalParentId);
            }

            if (is_array($order)) {
                foreach ($order as $index => $id) {
                    $this->model->updateSortOrder((int)$id, (int)$index);
                }
            }

            echo json_encode(['success' => true]);
        } catch (\Exception $e) {
            http_response_code(403);
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit;
    }

    public function delete($id) {
        $id = (int)$id;

        if ($id > 0 && $this->model->delete($id)) {
            ToaStr::set('success', __('Navigation deleted successfully'));
        } else {
            ToaStr::set('warning', __('Failed to delete or invalid ID'));
        }
        
        header("Location: " . BASE_URL . "/admin/navbar");
        exit;
    }
}