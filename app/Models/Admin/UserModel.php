<?php
namespace App\Models\Admin;

use App\Helpers\ImageConvert;
use PDO;

class UserModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllUsers() {
        return $this->db->query("SELECT * FROM users ORDER BY id DESC");
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function save($data, $file) {
        $id = (int)($data['id_user'] ?? 0); 
        $user = $data['username'];
        $nama = $data['nama'];
        $role = $data['role'];
        $pass = $data['password'] ?? null;
        $foto_name = $data['current_foto'] ?? '';

        if (isset($file['name']) && $file['name'] != "") {
            $targetDir = "assets/img/users/";
            $newFoto = ImageConvert::process($file, $targetDir, 80, 'user_');
            if ($newFoto) {
                if (!empty($foto_name) && file_exists($targetDir . $foto_name)) {
                    ImageConvert::delete($targetDir . $foto_name);
                }
                $foto_name = $newFoto;
            }
        }

        if ($id > 0) {
            if (!empty($pass)) {
                $sql = "UPDATE users SET username=?, nama_lengkap=?, role=?, foto=?, password=? WHERE id=?";
                $stmt = $this->db->prepare($sql);
                return $stmt->execute([$user, $nama, $role, $foto_name, $pass, $id]);
            } else {
                $sql = "UPDATE users SET username=?, nama_lengkap=?, role=?, foto=? WHERE id=?";
                $stmt = $this->db->prepare($sql);
                return $stmt->execute([$user, $nama, $role, $foto_name, $id]);
            }
        } else {
            $sql = "INSERT INTO users (username, password, nama_lengkap, role, foto) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$user, $pass, $nama, $role, $foto_name]);
        }
    }

    public function delete($id) {
        $user = $this->find($id);
        if ($user && !empty($user['foto'])) {
            ImageConvert::delete("assets/img/users/" . $user['foto']);
        }
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }
}