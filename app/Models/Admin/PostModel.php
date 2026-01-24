<?php
namespace App\Models\Admin;

use PDO;

class PostModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAll($cond = "", $limit = 10, $offset = 0) {
        $sql = "SELECT * FROM posts $cond ORDER BY id DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countAll($cond = "") {
        $sql = "SELECT COUNT(id) as total FROM posts $cond";
        $res = $this->db->query($sql);
        $row = $res->fetch(PDO::FETCH_ASSOC);
        return $row['total'] ?? 0;
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM posts WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function save($data) {
        if ($data['id_target'] > 0) {
            $sql = "UPDATE posts SET judul=?, slug=?, kategori=?, isi=?, gambar=?, status=?, tags=?, author=? WHERE id=?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                $data['judul'], 
                $data['slug'], 
                $data['kategori'], 
                $data['isi'], 
                $data['gambar'], 
                $data['status'],
                $data['tags'],
                $data['author'],
                $data['id_target']
            ]);
        } else {
            $sql = "INSERT INTO posts (judul, slug, kategori, isi, gambar, status, tags, author, tanggal_dibuat) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                $data['judul'], 
                $data['slug'], 
                $data['kategori'], 
                $data['isi'], 
                $data['gambar'], 
                $data['status'],
                $data['tags'],
                $data['author']
            ]);
        }
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM posts WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function bulkDelete($ids) {
        if (empty($ids)) return false;
        $safe_ids = array_map('intval', $ids);
        $placeholders = str_repeat('?,', count($safe_ids) - 1) . '?';
        $sql = "DELETE FROM posts WHERE id IN ($placeholders)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($safe_ids);
    }
}