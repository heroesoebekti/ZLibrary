<?php
namespace App\Models\Admin;

use PDO;

class NavbarModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllParents() {
        return $this->db->query("SELECT * FROM navbar WHERE parent_id IS NULL ORDER BY urutan ASC");
    }

    public function getSubmenus($parent_id) {
        $stmt = $this->db->prepare("SELECT * FROM navbar WHERE parent_id = ? ORDER BY urutan ASC");
        $stmt->execute([$parent_id]);
        return $stmt;
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM navbar WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function save($data) {
        if (!empty($data['id'])) {
            $stmt = $this->db->prepare("UPDATE navbar SET nama_menu=?, url=?, parent_id=? WHERE id=?");
            return $stmt->execute([$data['nama_menu'], $data['url_menu'], $data['parent_id'], $data['id']]);
        } else {
            $pId = $data['parent_id'];

            if ($pId === null) {
                $res = $this->db->query("SELECT MAX(urutan) as max_u FROM navbar WHERE parent_id IS NULL");
            } else {
                $res = $this->db->prepare("SELECT MAX(urutan) as max_u FROM navbar WHERE parent_id = ?");
                $res->execute([$pId]);
            }
            
            $row = $res->fetch(PDO::FETCH_ASSOC);
            $urutan = ($row['max_u'] ?? 0) + 1;

            $stmt = $this->db->prepare("INSERT INTO navbar (nama_menu, url, urutan, parent_id) VALUES (?, ?, ?, ?)");
            return $stmt->execute([$data['nama_menu'], $data['url_menu'], $urutan, $data['parent_id']]);
        }
    }

    public function updateSortOrder($id, $order) {
        $sql = "UPDATE navbar SET urutan = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$order, $id]);
    }

    public function updateParent($id, $parentId) {
        if ($parentId === null || $parentId === 'NULL') {
            $sql = "UPDATE navbar SET parent_id = NULL WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$id]);
        } else {
            $sql = "UPDATE navbar SET parent_id = ? WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$parentId, $id]);
        }
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM navbar WHERE id = ? OR parent_id = ?");
        return $stmt->execute([$id, $id]);
    }
}