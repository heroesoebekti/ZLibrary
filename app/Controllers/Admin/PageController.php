<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Helpers\ToaStr;
use App\Helpers\ImageConvert;
use App\Models\Admin\PageModel;
use PDO;

class PageController extends Controller {
    private $model;
    private $target_dir = "assets/img/pages/";
    private $target_path = "public/assets/img/pages/";

    public function __construct() {
        parent::__construct();
        if (!isset($_SESSION['admin_logged_in'])) {
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                header('Content-Type: application/json');
                echo json_encode(['uploaded' => false, 'error' => ['message' => 'Unauthorized']]);
                exit;
            }
            header("Location: " . BASE_URL . "/auth");
            exit;
        }
        $this->model = new PageModel($this->db);
    }

    public function index() {
        $pages = $this->model->getAll()->fetchAll(PDO::FETCH_ASSOC);
        $parents = $this->model->getNavbarParents()->fetchAll(PDO::FETCH_ASSOC);

        $data = [
            'title'   => __('Manage Pages'),
            'pages'   => $pages,
            'parents' => $parents
        ];
        $this->view('pages', $data, 'admin');
    }

    public function uploadImage() {
        header('Content-Type: application/json');
        try {
            $token = $_POST['csrf_token'] ?? '';
            if ($token !== $_SESSION['csrf_token']) throw new \Exception(__('Security token mismatch.'));

            if (isset($_FILES['upload']) && $_FILES['upload']['error'] === UPLOAD_ERR_OK) {
                $upload = ImageConvert::process($_FILES['upload'], $this->target_dir, 75, 'page_');
                if ($upload) {
                    echo json_encode(['uploaded' => true, 'url' => BASE_URL . '/' . $this->target_dir . $upload]);
                } else {
                    throw new \Exception(__('Failed to process the image.'));
                }
            }
        } catch (\Exception $e) {
            echo json_encode(['uploaded' => false, 'error' => ['message' => $e->getMessage()]]);
        }
        exit;
    }

    public function save() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_target     = (int)$this->input('id_target', 0);
            $title         = $this->input('judul');
            $content       = $_POST['isi'] ?? ''; 
            $parentId      = $this->input('parent_id');
            $is_standalone = isset($_POST['is_standalone']) ? 1 : 0;

            if (empty($title)) {
                ToaStr::set('error', __('Title cannot be empty'));
                header("Location: " . BASE_URL . "/admin/page");
                exit;
            }

            $slug = strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $title));
            $is_update = ($id_target > 0);
            $old_url = "";

            if ($is_update) {
                $old_data = $this->model->find($id_target);
                if ($old_data) {
                    $old_url = "page.php?slug=" . ($old_data['slug'] ?? '');
                    $this->cleanupImages($old_data['isi'], $content);
                }
            }

            $saveData = [
                'id_target'     => $id_target, 
                'judul'         => $title, 
                'isi'           => $content, 
                'slug'          => $slug,
                'is_standalone' => $is_standalone
            ];

            $navData = [
                'is_standalone' => $is_standalone,
                'parent_id'     => ($parentId === 'NULL' || empty($parentId) || $is_standalone) ? null : (int)$parentId,
                'nama_menu'     => $title,
                'url'           => "page.php?slug=" . $slug,
                'old_url'       => $old_url
            ];

            if ($this->model->save($saveData, $navData)) {
                ToaStr::set($is_update ? 'info' : 'success', $is_update ? __('Page updated successfully') : __('New page published successfully'));
            }
            header("Location: " . BASE_URL . "/admin/page");
            exit;
        }
    }

    private function cleanupImages($oldContent, $newContent) {
        if (empty($oldContent)) return;

        preg_match_all('/src="([^"]+)"/', $oldContent, $oldImages);
        preg_match_all('/src="([^"]+)"/', $newContent, $newImages);

        $oldPaths = $oldImages[1] ?? [];
        $newPaths = $newImages[1] ?? [];
        $deletedImages = array_diff($oldPaths, $newPaths);

        foreach ($deletedImages as $imgUrl) {
            if (strpos($imgUrl, $this->target_dir) !== false) {
                $filename = basename($imgUrl);
                $filePath = (defined('FCPATH') ? FCPATH : $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR) . $this->target_path . $filename; 
                $filePath = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $filePath);

                if (file_exists($filePath)) {
                    @unlink($filePath);
                }
            }
        }
    }

    public function delete($id) {
        $page = $this->model->find((int)$id);
        if ($page) {
            $this->cleanupImages($page['isi'], '');
            if ($this->model->delete((int)$id, $page['slug'])) {
                ToaStr::set('error', __('Page deleted successfully'));
            }
        }
        header("Location: " . BASE_URL . "/admin/page");
        exit;
    }
}