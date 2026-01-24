<?php
namespace App\Models\Public;

use PDO;

class PostModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getPublishedPosts($category = null) {
        $sql = "SELECT * FROM posts WHERE status = 'publish'";
        $params = [];

        if ($category) {
            $sql .= " AND kategori = ?";
            $params[] = $category;
        }

        $sql .= " ORDER BY tanggal_dibuat DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBySlug($slug) {
        $stmt = $this->db->prepare("SELECT * FROM posts WHERE slug = ? AND status = 'publish' LIMIT 1");
        $stmt->execute([$slug]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function getRecentPosts($limit = 5) {
        $stmt = $this->db->prepare("SELECT * FROM posts WHERE status = 'publish' ORDER BY tanggal_dibuat DESC LIMIT :limit");
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}