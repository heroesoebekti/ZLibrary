<?php
namespace App\Models\Public;

use PDO;

class NavbarModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getPublicMenu() {
        try {
            $stmt = $this->db->query("SELECT * FROM navbar WHERE parent_id IS NULL ORDER BY urutan ASC");
            $parents = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($parents as &$parent) {
                $childStmt = $this->db->prepare("SELECT * FROM navbar WHERE parent_id = :pid ORDER BY urutan ASC");
                $childStmt->execute(['pid' => $parent['id']]);
                $parent['children'] = $childStmt->fetchAll(PDO::FETCH_ASSOC);
            }
            return $parents;
        } catch (\PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }
}