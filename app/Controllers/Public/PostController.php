<?php
namespace App\Controllers\Public;

use App\Core\Controller;
use App\Models\Public\PostModel;
use Exception;

class PostController extends Controller {
    private $postModel;

    public function __construct() {
        parent::__construct();
        $this->postModel = new PostModel($this->db);
    }

    public function category($category = null) {
        try {
            $posts = $this->postModel->getPublishedPosts($category);
            $title_page = $category ? __("Archive") . " " . ucfirst($category) : __("All News & Information");

            $data = [
                'title'    => strip_tags($title_page) . " - " . SITE_SUBTITLE,
                'header'   => strip_tags($title_page),
                'posts'    => $posts,
                'kategori' => $category
            ];
            $this->view('archive', $data);
        } catch (Exception $e) {
            error_log($e->getMessage());
            $this->view('errors/500');
        }
    }

    public function index($slug = null) {
        if (!$slug) {
            header('Location: ' . BASE_URL);
            exit;
        }

        try {
            $post = $this->postModel->getBySlug($slug);
            if (!$post) {
                http_response_code(404);
                return $this->view('errors/404');
            }

            $recent_posts = $this->postModel->getRecentPosts(4);

            $data = [
                'post'         => $post,
                'related_posts' => $recent_posts,
                'title'        => strip_tags($post['judul']) . " - " . SITE_SUBTITLE
            ];
            $this->view('single_post', $data);
        } catch (Exception $e) {
            error_log($e->getMessage());
            $this->view('errors/500');
        }
    }
}