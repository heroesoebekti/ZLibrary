<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Helpers\ToaStr;
use App\Helpers\ImageConvert;
use App\Models\Admin\GalleryModel;

class GalleryController extends Controller {
    private $model;
    private $target_dir = "assets/img/gallery/";

    public function __construct() {
        parent::__construct();
        
        if (!isset($_SESSION['admin_logged_in'])) {
            header("Location: " . BASE_URL . "/auth");
            exit;
        }

        $this->model = new GalleryModel($this->db);
    }

    public function index() {
        $editId = (int)$this->input('edit_id', 0);
        $edit_data = ($editId > 0) ? $this->model->find($editId) : null;

        $data = [
            'title'        => __('Manage Gallery'),
            'current_page' => 'Gallery',
            'gallery'      => $this->model->getAll(),
            'edit_data'    => $edit_data
        ];

        $this->view('gallery', $data, 'admin');
    }

    public function save() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_target  = (int)$this->input('id_target', 0);
            $judul      = $this->input('judul');
            $kategori   = $this->input('kategori');
            $layout     = $this->input('tipe_layout');
            $old_gambar = $this->input('old_gambar');
            
            $new_name = $old_gambar;

            if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
                $allowed_types = ['image/jpeg', 'image/png', 'image/webp'];
                $file_info = finfo_open(FILEINFO_MIME_TYPE);
                $mime_type = finfo_file($file_info, $_FILES['gambar']['tmp_name']);
                finfo_close($file_info);

                if (!in_array($mime_type, $allowed_types)) {
                    ToaStr::set('error', __('Invalid file format. Please use JPG, PNG, or WEBP.'));
                    header("Location: " . BASE_URL . "/admin/gallery");
                    exit;
                }

                $upload = ImageConvert::process($_FILES['gambar'], $this->target_dir, 75, 'gal_');

                if ($upload) {
                    if ($id_target > 0 && !empty($old_gambar)) {
                        ImageConvert::delete($this->target_dir . $old_gambar);
                    }
                    $new_name = $upload;
                } else {
                    ToaStr::set('error', __('Failed to process the image.'));
                    header("Location: " . BASE_URL . "/admin/gallery");
                    exit;
                }
            }

            $saveData = [
                'id_target'   => $id_target,
                'judul'       => $judul,
                'kategori'    => $kategori,
                'tipe_layout' => $layout,
                'gambar'      => $new_name
            ];

            if ($this->model->save($saveData)) {
                $status = ($id_target > 0) ? 'info' : 'success';
                $message = ($id_target > 0) ? __('Asset updated successfully') : __('Asset published successfully');
                ToaStr::set($status, $message);
            } else {
                ToaStr::set('error', __('Database operation failed.'));
            }
            
            header("Location: " . BASE_URL . "/admin/gallery");
            exit;
        }
    }

    public function toggle($id, $current_status) {
        $id = (int)$id;
        
        $exists = $this->model->find($id);
        if (!$exists) {
            ToaStr::set('error', __('Asset not found.'));
            header("Location: " . BASE_URL . "/admin/gallery");
            exit;
        }

        $new_status = ($current_status == 1) ? 0 : 1;
        if ($this->model->updateStatus($id, $new_status)) {
            ToaStr::set('warning', __('Asset visibility has been changed'));
        }
        header("Location: " . BASE_URL . "/admin/gallery");
        exit;
    }

    public function delete($id) {
        $id = (int)$id;
        $data = $this->model->find($id);
        
        if ($data) {
            if (!empty($data['gambar'])) {
                ImageConvert::delete($this->target_dir . $data['gambar']);
            }
            if ($this->model->delete($id)) {
                ToaStr::set('error', __('Asset permanently deleted'));
            } else {
                ToaStr::set('warning', __('Could not delete asset from database'));
            }
        } else {
            ToaStr::set('error', __('Target asset not found'));
        }
        
        header("Location: " . BASE_URL . "/admin/gallery");
        exit;
    }
}