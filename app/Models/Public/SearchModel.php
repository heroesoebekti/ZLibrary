<?php
namespace App\Models\Public;

use PDO;

class SearchModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function searchGlobal($keyword) {
        $searchTerm = "%" . $keyword . "%";

        $sql = "(SELECT judul, isi, slug, kategori as category, 'post' as tipe FROM posts 
                 WHERE status = 'publish' AND (judul LIKE ? OR isi LIKE ?)) 
                UNION 
                (SELECT judul, isi, slug, 'page' as category, 'halaman' as tipe FROM pages 
                 WHERE (judul LIKE ? OR isi LIKE ?)) 
                LIMIT 20";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$searchTerm, $searchTerm, $searchTerm, $searchTerm]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}