<?php
namespace App\Helpers;

class View {
    public static function render($view, $data = [], $layoutName = 'public') {
        $view = basename(str_replace(["\0", "../", "./"], '', $view));
        $path = BASE_PATH . '/themes';
        $active_themes = [];

        if (is_dir($path)) {
            $dir = scandir($path);
            foreach ($dir as $file) {
                if ($file !== '.' && $file !== '..' && is_dir($path . '/' . $file)) {
                    $active_themes[] = $file;
                }
            }
        }
       extract($data, EXTR_SKIP);
       if ($layoutName === 'admin') {
            $basePath = dirname(__DIR__, 2) . "/app/Views/admin/";
        } else {
            if (defined('ACTIVE_THEME') && in_array(ACTIVE_THEME, $active_themes)) {
                $selectedTheme = ACTIVE_THEME;
            } else {
                $selectedTheme = !empty($active_themes) ? $active_themes[0] : 'default';
            } 
            $theme = preg_replace('/[^a-zA-Z0-9_-]/', '', $selectedTheme);
            $basePath = BASE_PATH . "/themes/{$theme}/";
        }

        $pagePath = $basePath . "page/" . $view . ".php";

        if (!file_exists($pagePath)) {
            die("View {$view} tidak ditemukan di: {$pagePath}");
        }

        if ($layoutName === 'blank') {
            require_once $pagePath;
        } else {
            require_once $basePath . 'header.php';
            
            if ($layoutName === 'admin') {
                require_once $basePath . 'sidebar.php';
            } else {
                if (file_exists($basePath . 'navbar.php')) {
                    require_once $basePath . 'navbar.php';
                }
            }
            
            require_once $pagePath;
            require_once $basePath . 'footer.php';
        }
    }
}