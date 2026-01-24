<?php
namespace App\Controllers\Public;

use App\Core\Controller;
use App\Models\Public\SearchModel;
use Exception;

class SearchController extends Controller {
    private $searchModel;

    public function __construct() {
        parent::__construct();
        $this->searchModel = new SearchModel($this->db);
    }

    public function index() {
        try {
            $keyword = isset($_GET['q']) ? trim($_GET['q']) : '';
            $keyword = strip_tags($keyword);
            $keyword = htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8');

            $results = null;
            $error = null;

            if (isset($_GET['q'])) {
                if (mb_strlen($keyword) >= 3) {
                    $results = $this->searchModel->searchGlobal($keyword);
                } else {
                    $error = __("Keyword is too short (min. 3 characters).");
                }
            }

            $this->view('search', [
                'title'   => ($keyword !== '') ? __("Search results for") . ": " . $keyword : __("Search"),
                'keyword' => $keyword,
                'results' => $results,
                'error'   => $error
            ]);

        } catch (Exception $e) {
            error_log("Search Error: " . $e->getMessage());
            $this->view('errors/500');
        }
    }
}