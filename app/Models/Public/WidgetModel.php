<?php
namespace App\Models\Public;

use PDO;

class WidgetModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getSavedLayout() {
        try {
            $stmt = $this->db->prepare("SELECT setting_value FROM settings WHERE setting_name = 'homepage_layout' LIMIT 1");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['setting_value'] ?? '[]';
        } catch (\PDOException $e) {
            error_log("Error Layout: " . $e->getMessage());
            return '[]';
        }
    }

    public function getSavedFooterLayout() {
        try {
            $stmt = $this->db->prepare("SELECT setting_value FROM settings WHERE setting_name = 'footer_layout' LIMIT 1");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['setting_value'] ?? '[]';
        } catch (\PDOException $e) {
            error_log("Error Footer Layout: " . $e->getMessage());
            return '[]';
        }
    }

    public function getWidgetContent($id, $isInstance = false) {
        try {
            if ($isInstance) {
                $table = 'widget_instances';
                $column_id = 'id';
                $column_title = 'instance_title';
                $column_content = 'instance_content';
                $column_show_title = 'show_title';
            } else {
                $table = 'widgets';
                $column_id = 'id';
                $column_title = 'title';
                $column_content = 'content';
                $column_show_title = 'show_title';
            }

            $sql = "SELECT 
                        {$column_title} AS title, 
                        {$column_content} AS content,
                        {$column_show_title} AS show_title 
                    FROM {$table} 
                    WHERE {$column_id} = :id LIMIT 1";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['id' => (int)$id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result && !empty($result['content'])) {
                $clean = html_entity_decode($result['content'], ENT_QUOTES, 'UTF-8');
                $result['content'] = html_entity_decode($clean, ENT_QUOTES, 'UTF-8');
            }

            return $result ?: null;
        } catch (\PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }
}

