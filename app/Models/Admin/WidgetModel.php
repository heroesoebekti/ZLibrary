<?php
namespace App\Models\Admin;

use PDO;

class WidgetModel {
    private $db;
    private $cache_path;
    private $cache_enabled = true;
    private $error_message = null;

    public function __construct($db) {
        $this->db = $db;
        $this->cache_path = "assets/cache/widgets/";
        
        if ($this->cache_enabled) {
            if (!is_dir($this->cache_path)) {
                if (!@mkdir($this->cache_path, 0777, true)) {
                    $this->error_message = __("Cache directory could not be created. Please check permissions in assets/cache/");
                }
            } 

            if (is_dir($this->cache_path) && !is_writable($this->cache_path)) {
                $this->error_message = __("Cache directory is not writable. Please CHMOD 775/777: ") . $this->cache_path;
            }
        }
    }

    public function getErrorMessage() {
        return $this->error_message;
    }

    public function getWidgetContent($id, $isInstance = false) {
        $id = intval($id);
        $isIns = ($isInstance === true || $isInstance === 'true' || $isInstance === 1 || $isInstance === '1');
        
        $cache_filename = "widget_" . ($isIns ? "ins" : "mst") . "_" . $id . ".json";
        $cache_file = $this->cache_path . $cache_filename;

        if ($this->cache_enabled && file_exists($cache_file)) {
            if ((time() - filemtime($cache_file)) < 86400) {
                return json_decode(file_get_contents($cache_file), true);
            }
        }

        if ($isIns) {
            $sql = "SELECT instance_title as title, instance_content as content, show_title 
                    FROM widget_instances WHERE id = ? LIMIT 1";
        } else {
            $sql = "SELECT title, content, 1 as show_title 
                    FROM widgets WHERE id = ? AND is_active = 1 LIMIT 1";
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data && $this->cache_enabled) {
            file_put_contents($cache_file, json_encode($data));
        }

        return $data;
    }

    public function deleteWidgetCache($id, $isInstance = false) {
        $id = intval($id);
        $isIns = ($isInstance === true || $isInstance === 'true' || $isInstance === 1 || $isInstance === '1');
        $cache_filename = "widget_" . ($isIns ? "ins" : "mst") . "_" . $id . ".json";
        $cache_file = $this->cache_path . $cache_filename;

        if (file_exists($cache_file)) {
            unlink($cache_file);
        }
    }

    public function clearAllWidgetCache() {
        if (is_dir($this->cache_path)) {
            $files = glob($this->cache_path . '*');
            foreach ($files as $file) {
                if (is_file($file)) unlink($file);
            }
            return true;
        }
        return false;
    }

    public function getSavedLayout($name = 'homepage_layout') {
        $stmt = $this->db->prepare("SELECT setting_value FROM settings WHERE setting_name = ? LIMIT 1");
        $stmt->execute([$name]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? html_entity_decode($result['setting_value']) : '[]';
    }

    public function getSavedFooterLayout() {
        return $this->getSavedLayout('footer_layout');
    }

    public function getAll() {
        return $this->db->query("SELECT * FROM widgets WHERE is_active = 1 ORDER BY title ASC");
    }

    public function saveCompleteLayout($layout, $name = 'homepage_layout') {
        $setting_group = 'system';
        $setting_type = 'textarea';

        $sql = "INSERT INTO settings (setting_group, setting_name, setting_value, setting_type) 
                VALUES (?, ?, ?, ?) 
                ON DUPLICATE KEY UPDATE setting_value = ?, updated_at = CURRENT_TIMESTAMP";
        
        $stmt = $this->db->prepare($sql);
        $success = $stmt->execute([$setting_group, $name, $layout, $setting_type, $layout]);
        
        if($success) {
            $this->clearAllWidgetCache();
        }
        
        return $success;
    }

    public function register($type, $name, $category = 'General', $description = '', $default_content = '{}') {
        $sql = "INSERT INTO widgets (widget_type, title, category, description, content, is_active) 
                VALUES (?, ?, ?, ?, ?, 1) 
                ON DUPLICATE KEY UPDATE 
                title = VALUES(title), 
                category = VALUES(category), 
                description = VALUES(description),
                content = CASE 
                    WHEN content IS NULL OR content = '' OR content = '{}' THEN VALUES(content) 
                    ELSE content 
                END";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$type, $name, $category, $description, $default_content]);
    }

    public function deleteInstance($id) {
        $id = intval($id);
        $this->deleteWidgetCache($id, true);
        $stmt = $this->db->prepare("DELETE FROM widget_instances WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function updateWidgetContent($id, $content) {
        $sql = "UPDATE widgets SET content = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$content, $id]);
    }

    public function saveInstance($id, $isInstance, $data) {
        if ($isInstance === 'true' || $isInstance === true) {
            $sql = "UPDATE widget_instances SET instance_title = ?, instance_content = ?, show_title = ? WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$data['title'], $data['content'], $data['show_title'], $id]);
            
            $this->deleteWidgetCache($id, true);
            return $id;
        } else {
            $sql = "INSERT INTO widget_instances (widget_type, instance_title, instance_content, show_title) VALUES (?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$data['widget_type'], $data['title'], $data['content'], $data['show_title']]);
            
            $new_id = $this->db->lastInsertId();
            $this->deleteWidgetCache($new_id, true);
            return $new_id;
        }
    }

    public function createInstance($master_id, $title, $content, $show_title = 1) {
        $sql = "INSERT INTO widget_instances (widget_id, instance_title, instance_content, show_title) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        if ($stmt->execute([$master_id, $title, $content, $show_title])) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    public function updateInstance($id, $title, $content, $show_title = 1) {
        $this->deleteWidgetCache($id, true);
        
        $sql = "UPDATE widget_instances SET instance_title = ?, instance_content = ?, show_title = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$title, $content, $show_title, $id]);
    }

    public function getMasterContentByType($type) {
        $stmt = $this->db->prepare("SELECT content FROM widgets WHERE widget_type = ? LIMIT 1");
        $stmt->execute([$type]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}