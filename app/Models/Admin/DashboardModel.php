<?php
namespace App\Models\Admin;

use PDO;
use Exception;

class DashboardModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getStats() {
        $categories = ['berita', 'artikel', 'informasi'];
        $results = [];

        try {
            foreach ($categories as $cat) {
                $sql = "SELECT COUNT(*) as total FROM posts WHERE kategori = :cat";
                $stmt = $this->db->prepare($sql);
                
                if (!$stmt) {
                    $error = $this->db->errorInfo();
                    throw new Exception("SQL Error: " . $error[2]);
                }

                $stmt->execute(['cat' => $cat]);
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $results[$cat] = $row['total'] ?? 0;
            }
        } catch (Exception $e) {
            die("DashboardModel Error: " . $e->getMessage());
        }

        return $results;
    }
}