<?php
namespace App\Models\Admin;

use App\Core\Model;

class GalleryModel extends Model {

    public function getAll() {
        return $this->fetchAll("SELECT * FROM gallery ORDER BY id DESC");
    }

    public function find($id) {
        return $this->fetch("SELECT * FROM gallery WHERE id = ?", [$id]);
    }

    public function save($data) {
        if (isset($data['id_target']) && $data['id_target'] > 0) {
            $sql = "UPDATE gallery SET judul=?, kategori=?, gambar=?, tipe_layout=? WHERE id=?";
            $params = [$data['judul'], $data['kategori'], $data['gambar'], $data['tipe_layout'], $data['id_target']];
        } else {
            $sql = "INSERT INTO gallery (judul, kategori, gambar, tipe_layout, is_active) VALUES (?, ?, ?, ?, 1)";
            $params = [$data['judul'], $data['kategori'], $data['gambar'], $data['tipe_layout']];
        }
        
        $stmt = $this->query($sql, $params);
        return ($this->is_pdo) ? $stmt : ($stmt->affected_rows >= 0);
    }

    public function updateStatus($id, $status) {
        $stmt = $this->query("UPDATE gallery SET is_active = ? WHERE id = ?", [$status, $id]);
        return ($this->is_pdo) ? $stmt : ($stmt->affected_rows >= 0);
    }

    public function delete($id) {
        $stmt = $this->query("DELETE FROM gallery WHERE id = ?", [$id]);
        return ($this->is_pdo) ? $stmt : ($stmt->affected_rows >= 0);
    }
}