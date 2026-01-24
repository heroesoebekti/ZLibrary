<?php
namespace App\Controllers\Public;

use App\Core\Controller;
use App\Models\Public\PageModel;
use Exception;

class PageController extends Controller {
    private $pageModel;

    public function __construct() {
        parent::__construct();
        $this->pageModel = new PageModel($this->db);
    }

    public function index($slug = null) {
        $slug = filter_var(trim($slug), FILTER_SANITIZE_SPECIAL_CHARS);

        if (!$slug) {
            header('Location: ' . BASE_URL);
            exit;
        }

        try {
            $page = $this->pageModel->getBySlug($slug);

            if (!$page) {
                return $this->handleNotFound();
            }

            $data = [
                'title' => htmlspecialchars($page['judul'], ENT_QUOTES, 'UTF-8') . " - " . SITE_SUBTITLE,
                'post'  => [
                    'judul'    => htmlspecialchars($page['judul'], ENT_QUOTES, 'UTF-8'),
                    'kategori' => __('Profile'),
                    'isi'      => $page['isi']
                ],
                'mini_gallery' => $this->pageModel->getMiniGallery(4)
            ];

            $this->view('static_page', $data);

        } catch (Exception $e) {
            error_log("Page Error: " . $e->getMessage());
            $this->handleError();
        }
    }

    private function handleNotFound() {
        http_response_code(404);
        $data = [
            'title' => __("Page Not Found"),
            'post'  => [
                'judul'    => __("Page Not Found"),
                'kategori' => __("Error"),
                'isi'      => __("Sorry, the page you are looking for is not available.")
            ]
        ];
        $this->view('static_page', $data);
    }

    private function handleError() {
        http_response_code(500);
        $this->view('errors/500');
    }
}