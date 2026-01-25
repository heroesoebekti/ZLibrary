<?php
namespace App\Controllers\Public;

use App\Core\Controller;

class LanguageController extends Controller {

    /**
     * Fallback untuk mencegah Fatal Error jika /language diakses tanpa method
     */
    public function index() {
        header("Location: " . BASE_URL);
        exit;
    }
    
    public function switch($lang = null) {
        
        $allowed = ['id_ID', 'en_US'];        
        if ($lang && in_array($lang, $allowed)) {
            $referer = $_SERVER['HTTP_REFERER'] ?? '';

            if (strpos($referer, '/admin') !== false) {
                $_SESSION['app_lang'] = $lang;
            } else {
                setcookie('app_lang', $lang, [
                    'expires' => time() + (86400 * 30),
                    'path' => '/',
                    'secure' => isset($_SERVER['HTTPS']),
                    'httponly' => true,
                    'samesite' => 'Lax'
                ]);
            }
        }

        $redirect = BASE_URL;
        if (isset($_SERVER['HTTP_REFERER'])) {
            $refererParts = parse_url($_SERVER['HTTP_REFERER']);
            $currentHost = $_SERVER['HTTP_HOST'];
            if (isset($refererParts['host']) && $refererParts['host'] === $currentHost) {
                $redirect = str_replace(["\r", "\n"], '', $_SERVER['HTTP_REFERER']);
            }
        }

        header("Location: " . $redirect);
        exit;
    }
}