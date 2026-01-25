<?php
namespace App\Controllers\Public;

use App\Core\Controller;

class LanguageController extends Controller {
    
    public function switch($lang) {
        $allowed = ['id_ID', 'en_US'];       
        if (in_array($lang, $allowed)) {
            $referer = $_SERVER['HTTP_REFERER'] ?? '';
            if (strpos($referer, '/admin') !== false) {
                $_SESSION['app_lang'] = $lang;
            } else {
                setcookie('app_lang', $lang, [
                    'expires' => time() + (86400 * 30),
                    'path' => '/',
                    'domain' => '',
                    'secure' => isset($_SERVER['HTTPS']),
                    'httponly' => true,
                    'samesite' => 'Lax'
                ]);
            }
        }
        $redirect = BASE_URL;
        
        if (isset($_SERVER['HTTP_REFERER'])) {
            $refererHost = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
            $serverHost = $_SERVER['HTTP_HOST'];
            if ($refererHost === $serverHost) {
                $redirect = str_replace(["\r", "\n"], '', $_SERVER['HTTP_REFERER']);
            }
        }

        header("Location: " . $redirect);
        exit;
    }
}