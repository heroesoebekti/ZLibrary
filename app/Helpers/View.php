<?php
namespace App\Helpers;

class View {
    public static function render($view, $data = [], $layoutName = 'public') {
        $view = basename(str_replace(["\0", "../", "./"], '', $view));
        extract($data, EXTR_SKIP);

        if ($layoutName === 'admin') {
            $basePath = dirname(__DIR__, 2) . "/app/Views/admin/";
        } else {
            $theme = preg_replace('/[^a-zA-Z0-9_-]/', '', $data['sets']['active_theme'] ?? 'default');
            $basePath = dirname(__DIR__, 2) . "/public/themes/{$theme}/";
        }

        $pagePath = $basePath . "page/" . $view . ".php";

        if (!file_exists($pagePath)) {
            die("View {$view} tidak ditemukan.");
        }

        if ($layoutName === 'blank') {
            require_once $pagePath;
        } else {
            require_once $basePath . 'header.php';
            if ($layoutName === 'admin') {
                require_once $basePath . 'sidebar.php';
            } else {
                require_once $basePath . 'navbar.php';
            }
            require_once $pagePath;
            require_once $basePath . 'footer.php';
        }
    }
}