<?php
namespace App\Models\Admin;

use PDO;

class PageModel {
    private $db;

    public function __construct($db) { $this->db = $db; }

    public function getAll() {
        $sql = "SELECT p.*, n.nama_menu as current_menu_name, n.parent_id, parent_nav.nama_menu as parent_name 
                FROM pages p
                LEFT JOIN navbar n ON n.url = CONCAT('page.php?slug=', p.slug)
                LEFT JOIN navbar parent_nav ON n.parent_id = parent_nav.id
                ORDER BY p.id DESC";
        return $this->db->query($sql);
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM pages WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function save($data, $navData) {
        if ($data['id_target'] > 0) {
            // Update Page
            $stmt = $this->db->prepare("UPDATE pages SET judul=?, isi=?, slug=?, is_standalone=? WHERE id=?");
            $stmt->execute([$data['judul'], $data['isi'], $data['slug'], $data['is_standalone'], $data['id_target']]);

            if ($data['is_standalone']) {
                $stmtDel = $this->db->prepare("DELETE FROM navbar WHERE url = ?");
                return $stmtDel->execute([$navData['old_url']]);
            } else {
                $check = $this->db->prepare("SELECT id FROM navbar WHERE url = ?");
                $check->execute([$navData['old_url']]);
                
                if ($check->fetch()) {
                    $stmtNav = $this->db->prepare("UPDATE navbar SET nama_menu=?, url=?, parent_id=? WHERE url=?");
                    return $stmtNav->execute([$navData['nama_menu'], $navData['url'], $navData['parent_id'], $navData['old_url']]);
                } else {
                    return $this->insertNavbar($navData);
                }
            }
        } else {
            $stmt = $this->db->prepare("INSERT INTO pages (judul, isi, slug, is_standalone) VALUES (?, ?, ?, ?)");
            $stmt->execute([$data['judul'], $data['isi'], $data['slug'], $data['is_standalone']]);

            if (!$data['is_standalone']) {
                return $this->insertNavbar($navData);
            }
            return true;
        }
    }

    private function insertNavbar($navData) {
        $pId = $navData['parent_id'];
        if ($pId === null) {
            $resOrder = $this->db->query("SELECT MAX(urutan) as max_u FROM navbar WHERE parent_id IS NULL");
        } else {
            $stmtOrder = $this->db->prepare("SELECT MAX(urutan) as max_u FROM navbar WHERE parent_id = ?");
            $stmtOrder->execute([$pId]);
            $resOrder = $stmtOrder;
        }
        
        $row = $resOrder->fetch(PDO::FETCH_ASSOC);
        $nextOrder = ($row['max_u'] ?? 0) + 1;

        $stmtNav = $this->db->prepare("INSERT INTO navbar (parent_id, nama_menu, url, urutan) VALUES (?, ?, ?, ?)");
        return $stmtNav->execute([$navData['parent_id'], $navData['nama_menu'], $navData['url'], $nextOrder]);
    }

    public function delete($id, $slug) {
        $url = "page.php?slug=" . $slug;
        $stmt1 = $this->db->prepare("DELETE FROM pages WHERE id = ?");
        $stmt1->execute([$id]);
        
        $stmt2 = $this->db->prepare("DELETE FROM navbar WHERE url = ?");
        return $stmt2->execute([$url]);
    }

    public function getNavbarParents() {
        return $this->db->query("SELECT id, nama_menu FROM navbar WHERE parent_id IS NULL ORDER BY urutan ASC");
    }
}