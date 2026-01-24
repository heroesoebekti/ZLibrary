<?php
namespace App\Helpers;

use PDO;

class Settings {
    private static $settings = [];
    private static $grouped = [];

    public static function load($db) {
        $sql = "SELECT * FROM settings ORDER BY setting_group ASC";
        
        if ($db instanceof PDO) {
            $rows = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $res = $db->query($sql);
            $rows = $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
        }

        foreach ($rows as $row) {
            $name  = $row['setting_name'];
            $value = $row['setting_value'];
            $group = $row['setting_group'];

            self::$settings[$name] = $value;
            self::$grouped[$group][$name] = [
                'value' => $value,
                'type'  => $row['setting_type'] ?? 'text'
            ];

            $constName = strtoupper($name);
            if (!defined($constName)) {
                define($constName, $value);
            }
        }
        
        return [
            'all'     => self::$settings,
            'grouped' => self::$grouped
        ];
    }

    public static function get($name, $default = null) {
        return self::$settings[$name] ?? $default;
    }
}