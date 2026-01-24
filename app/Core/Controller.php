<?php
namespace App\Core;

use App\Core\Database;
use App\Helpers\Settings;
use App\Helpers\Security;
use App\Helpers\View;
use App\Models\Public\NavbarModel;
use App\Models\Public\WidgetModel;

class Controller {
    protected $menus = [];
    protected $site_settings = [];
    protected $grouped_settings = [];
    protected $db;
    protected $current_lang;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $this->db = Database::getInstance();
        $this->loadGlobalSettings();
        $this->initLanguage();
        Security::secureSession();
        Security::validateCsrf();
        $this->sanitizeRequest();
        
        
        $this->loadNavbar();
    }

    protected function loadGlobalSettings() {
        $config = Settings::load($this->db);
        $this->site_settings = $config['all'];
        $this->grouped_settings = $config['grouped'];
        $this->site_settings['is_admin'] = isset($_SESSION['admin_logged_in']);
    }

    private function sanitizeRequest() {
        $_POST = Security::sanitize($_POST);
        $_GET = Security::sanitize($_GET);
        $_REQUEST = Security::sanitize($_REQUEST);
    }

    protected function input($name = null, $default = null) {
        return Security::input($name, $default);
    }

    private function initLanguage() {
        $isAdminPath = (strpos($_SERVER['REQUEST_URI'], '/admin') !== false);
        $fallback = defined('APP_LANG') ? APP_LANG : 'en_US';

        if ($isAdminPath) {
            $lang = $_SESSION['app_lang'] ?? $fallback;
        } else {
            $lang = isset($_COOKIE['app_lang']) ? $_COOKIE['app_lang'] : $fallback;
        }

        $this->current_lang = in_array($lang, ['id_ID', 'en_US']) ? $lang : $fallback;

        \App\Helpers\Gettext::init($this->current_lang, 'messages');
    }

    protected function loadNavbar() {
        if (strpos($_SERVER['REQUEST_URI'], '/admin') === false) {
            $navbarModel = new NavbarModel($this->db);
            $this->menus = $navbarModel->getPublicMenu();
        }
    }

    public function view($view, $data = [], $layoutName = 'public') {
        Security::setHeaders($layoutName === 'admin');
        
        $globalPublicData = [];
        if ($layoutName === 'public' || $layoutName === 'blank') {
            $widgetModel = new WidgetModel($this->db);
            $rawLayout = $widgetModel->getSavedLayout();
            $rawFooter = $widgetModel->getSavedFooterLayout();
            $cleanLayout = html_entity_decode($rawLayout, ENT_QUOTES, 'UTF-8');
            $cleanFooter = html_entity_decode($rawFooter, ENT_QUOTES, 'UTF-8');

            $globalPublicData = [
                'savedLayout' => json_decode($cleanLayout, true) ?: [],
                'savedFooterLayout' => json_decode($cleanFooter, true) ?: [],
                'widgetModel' => $widgetModel
            ];
        }

        $finalData = array_merge([
            'sets' => $this->site_settings,
            'grouped_sets' => $this->grouped_settings,
            'current_lang' => $this->current_lang,
            'menus' => $this->menus,
            'asset' => new \App\Helpers\Asset(),
            'csrf_token' => Security::generateToken()
        ], $globalPublicData, $data);

        View::render($view, $finalData, $layoutName);
    }
}