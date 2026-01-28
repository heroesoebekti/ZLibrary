<?php
namespace App\Controllers\Public;

use App\Core\Controller;
use App\Models\Public\HomeModel;

class SitemapController extends Controller {
    private $homeModel;

    public function __construct() {
        parent::__construct();
        $this->homeModel = new HomeModel($this->db);
    }

    public function index() {
        $posts = $this->homeModel->getSitemapData();       
        header("Content-Type: text/xml; charset=utf-8");
        echo '<?xml version="1.0" encoding="UTF-8"?>';
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        echo '<url>';
        echo '<loc>' . BASE_URL . '/</loc>';
        echo '<priority>1.0</priority>';
        echo '</url>';
        foreach ($posts as $post) {
            $url = BASE_URL . '/' . $post['kategori'] . '/' . $post['slug'];
            $date = date('c', strtotime($post['tanggal_dibuat']));
            echo '<url>';
            echo '<loc>' . htmlspecialchars($url) . '</loc>';
            echo '<lastmod>' . $date . '</lastmod>';
            echo '<changefreq>monthly</changefreq>';
            echo '<priority>'.$post['priority'].'</priority>';
            echo '</url>';
        }

        echo '</urlset>';
        exit;
    }
}