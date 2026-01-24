<?php
namespace App\Models\Public;

use PDO;

class PageModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getBySlug($slug) {
        $stmt = $this->db->prepare("SELECT judul, isi FROM pages WHERE slug = :slug LIMIT 1");
        $stmt->execute(['slug' => $slug]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function getMiniGallery($limit = 4) {
        $sql = "SELECT gambar FROM posts WHERE gambar IS NOT NULL AND gambar != '' AND status = 'publish' ORDER BY id DESC LIMIT :limit";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}