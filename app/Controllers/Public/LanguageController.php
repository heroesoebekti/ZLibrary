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
                setcookie('app_lang', $lang, time() + (86400 * 30), "/", "", false, true);
                $_COOKIE['app_lang'] = $lang;
            }
        }

        $redirect = (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST']) !== false) 
                    ? $_SERVER['HTTP_REFERER'] 
                    : BASE_URL;

        header("Location: " . $redirect);
        exit;
    }
}