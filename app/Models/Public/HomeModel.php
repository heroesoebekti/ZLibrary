<?php
namespace App\Models\Public;

use PDO;

class HomeModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getPostsByCategory(string $category, int $limit) {
        $sql = "SELECT * FROM posts WHERE kategori = :cat AND status = 'publish' 
                ORDER BY tanggal_dibuat DESC LIMIT :lim";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':cat', $category, PDO::PARAM_STR);
            $stmt->bindValue(':lim', $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function getGalleries(int $limit) {
        $sql = "SELECT * FROM gallery WHERE is_active = 1 
                ORDER BY tanggal_upload DESC LIMIT :lim";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':lim', $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function getWidgets() {
        $sql = "SELECT * FROM widgets WHERE layout_position != 'library' AND is_active = 1 ORDER BY order_position ASC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}