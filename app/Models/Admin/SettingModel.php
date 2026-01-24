<?php
namespace App\Models\Admin;

use PDO;

class SettingModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAll() {
        $result = $this->db->query("SELECT * FROM settings");
        $settings = [];
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $settings[$row['setting_name']] = [
                'value' => $row['setting_value'],
                'type'  => $row['setting_type']
            ];
        }
        return $settings;
    }

    public function updateSettings($data, $files = []) {
        $targetDir = "assets/img/default/";

        if (!empty($files['name'])) {
            foreach ($files['name'] as $name => $fileName) {
                if (isset($files['error'][$name]) && $files['error'][$name] === UPLOAD_ERR_OK) {
                    $ext = ($name === 'site_icon') ? 'ico' : 'webp';
                    $fixedName = $name . '.' . $ext;
                    
                    if (move_uploaded_file($files['tmp_name'][$name], $targetDir . $fixedName)) {
                        $data[$name] = $fixedName;
                    }
                }
            }
        }

        try {
            foreach ($data as $name => $value) {
                $stmt = $this->db->prepare("UPDATE settings SET setting_value = ? WHERE setting_name = ?");
                $val = htmlspecialchars($value);
                $stmt->execute([$val, $name]);
            }
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }
}