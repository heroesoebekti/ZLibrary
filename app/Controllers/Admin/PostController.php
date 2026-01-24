<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Helpers\ToaStr;
use App\Helpers\ImageConvert;
use App\Models\Admin\PostModel;

class PostController extends Controller {
    private $model;
    private $target_dir = "assets/img/posts/";

    public function __construct() {
        parent::__construct();
        if (!isset($_SESSION['admin_logged_in'])) {
            header("Location: " . BASE_URL . "/auth");
            exit;
        }
        $this->model = new PostModel($this->db);
    }

    public function index() {
        $limit = 10;
        $halaman = (int)$this->input('halaman', 1);
        $offset = ($halaman - 1) * $limit;
        
        $search = $this->input('search');
        $filter_cat = $this->input('filter_cat');
        
        $cond = " WHERE 1=1 ";

        if ($search) {
            $escaped_search = $this->db->quote('%' . $search . '%');
            $cond .= " AND judul LIKE " . $escaped_search;
        }
        if ($filter_cat) {
            $escaped_cat = $this->db->quote($filter_cat);
            $cond .= " AND kategori = " . $escaped_cat;
        }

        $total_data = $this->model->countAll($cond);
        
        $data = [
            'title'      => __("Manage Posts"),
            'posts'      => $this->model->getAll($cond, $limit, $offset),
            'total_hal'  => ceil($total_data / $limit),
            'halaman'    => $halaman,
            'search'     => $search,
            'filter_cat' => $filter_cat,
            'total_data' => $total_data
        ];

        $this->view('post', $data, 'admin');
    }

    public function save() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)$this->input('post_id', 0);
            $judul = $this->input('judul');
            $old_gambar = $this->input('old_gambar');
            $new_name = $old_gambar;
            $new_content = $_POST['isi'] ?? '';

            if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
                $fileType = mime_content_type($_FILES['gambar']['tmp_name']);
                if (strpos($fileType, 'image/') === 0) {
                    $upload = ImageConvert::process($_FILES['gambar'], $this->target_dir, 80, 'thumbnail_');
                    if ($upload && $upload !== 'ERR_PERMISSION') {
                        if ($id > 0 && !empty($old_gambar)) {
                            ImageConvert::delete($this->target_dir . $old_gambar);
                        }
                        $new_name = $upload;
                    }
                }
            }

            if ($id > 0) {
                $old_post = $this->model->find($id);
                if ($old_post) {
                    $this->cleanupEditorImages($old_post['isi'], $new_content);
                }
            }

            $saveData = [
                'id_target' => $id,
                'judul'     => $judul,
                'slug'      => preg_replace('/[^A-Za-z0-9\-]/', '', strtolower(str_replace(' ', '-', $judul))),
                'kategori'  => $this->input('kategori'),
                'status'    => $this->input('status_post'),
                'isi'       => $new_content,
                'gambar'    => $new_name,
                'author'    => $_SESSION['admin_name'] ?? __("Administrator"),
                'tags'      => $this->input('tags')
            ];

            if ($this->model->save($saveData)) {
                ToaStr::set('success', __("Post saved successfully"));
            } else {
                ToaStr::set('error', __("Failed to save post"));
            }
            header("Location: " . BASE_URL . "/admin/post");
            exit;
        }
    }

    private function cleanupEditorImages($oldContent, $newContent) {
        preg_match_all('/src="([^"]+)"/', $oldContent, $oldMatches);
        preg_match_all('/src="([^"]+)"/', $newContent, $newMatches);
        $deletedImages = array_diff($oldMatches[1] ?? [], $newMatches[1] ?? []);
        foreach ($deletedImages as $imgUrl) {
            if (strpos($imgUrl, $this->target_dir) !== false) {
                ImageConvert::delete($this->target_dir . basename($imgUrl));
            }
        }
    }

    public function delete($id) {
        $post = $this->model->find((int)$id);
        if ($post) {
            if (!empty($post['gambar'])) {
                ImageConvert::delete($this->target_dir . $post['gambar']);
            }
            preg_match_all('/src="([^"]+)"/', $post['isi'], $matches);
            foreach ($matches[1] as $imgUrl) {
                if (strpos($imgUrl, $this->target_dir) !== false) {
                    ImageConvert::delete($this->target_dir . basename($imgUrl));
                }
            }
            $this->model->delete($id);
            ToaStr::set('error', __("Post deleted permanently"));
        }
        header("Location: " . BASE_URL . "/admin/post");
        exit;
    }
}