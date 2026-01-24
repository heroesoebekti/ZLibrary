<?php
namespace App\Core;

class Model {
    protected $db;
    protected $is_pdo;

    public function __construct($db) {
        $this->db = $db;
        $this->is_pdo = ($this->db instanceof \PDO);
    }

    protected function query($sql, $params = []) {
        if ($this->is_pdo) {
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } else {
            $stmt = $this->db->prepare($sql);
            if (!empty($params)) {
                $types = str_repeat('s', count($params)); 
                $stmt->bind_param($types, ...$params);
            }
            $stmt->execute();
            return $stmt->get_result();
        }
    }

    protected function fetchAll($sql, $params = []) {
        $result = $this->query($sql, $params);
        if ($this->is_pdo) {
            return $result->fetchAll(\PDO::FETCH_ASSOC);
        } else {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }

    protected function fetch($sql, $params = []) {
        $result = $this->query($sql, $params);
        if ($this->is_pdo) {
            return $result->fetch(\PDO::FETCH_ASSOC);
        } else {
            return $result->fetch_assoc();
        }
    }
}