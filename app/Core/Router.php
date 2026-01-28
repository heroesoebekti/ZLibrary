<?php
namespace App\Core;

use App\Helpers\Security;

class Router {
    protected $controller = 'HomeController';
    protected $method     = 'index';
    protected $params     = [];
    protected $namespace  = 'App\\Controllers\\Public\\';

    public function __construct() {
        ini_set('display_errors', 0);
        
        $this->csrfMiddleware();
        $url = $this->parseUrl();

        if (isset($url[0]) && $url[0] === 'admin') {
            $this->namespace = 'App\\Controllers\\Admin\\';
            $this->controller = 'DashboardController';
            unset($url[0]);
            
            if (isset($url[1])) {
                $cleanController = preg_replace('/[^a-zA-Z0-9]/', '', $url[1]);
                $this->controller = ucfirst($cleanController) . 'Controller';
                unset($url[1]);
            }
        } else {
            $map = [
                'halaman'  => 'PageController', 
                'arsip'    => 'PostController', 
                'search'   => 'SearchController', 
                'auth'     => 'AuthController',
                'language' => 'LanguageController',
                'sitemap'  => 'SitemapController'
            ];

            if (isset($url[0])) {
                if (array_key_exists($url[0], $map)) {
                    $this->controller = $map[$url[0]];
                    if ($url[0] == 'arsip') $this->method = 'category';
                } else {
                    $cleanController = preg_replace('/[^a-zA-Z0-9]/', '', $url[0]);
                    $this->controller = ucfirst($cleanController) . 'Controller';
                }
                unset($url[0]);
            }
        }

        $className = $this->namespace . $this->controller;
        
        if (!class_exists($className) || !str_starts_with($className, 'App\\Controllers\\')) {
            $this->error404();
        }
        
        $this->controller = new $className;
        $url = array_values($url); 
        
        if (isset($url[0])) {
            $cleanMethod = preg_replace('/[^a-zA-Z0-9]/', '', $url[0]);
            if (method_exists($this->controller, $cleanMethod) && is_callable([$this->controller, $cleanMethod])) {
                $this->method = $cleanMethod;
                unset($url[0]);
            }
        }

        $this->params = $url ? array_values($url) : [];
        
        if (!method_exists($this->controller, $this->method)) {
            $this->error404();
        }

        try {
            call_user_func_array([$this->controller, $this->method], $this->params);
        } catch (\Throwable $e) {
            error_log($e->getMessage());
            $this->error404();
        }
    }

    private function csrfMiddleware() {
        Security::secureSession();
        Security::validateCsrf();
    }

    private function parseUrl() {
        if (isset($_GET['url'])) {
            $url = filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL);
            return explode('/', $url);
        }
        return [];
    }

    private function error404() {
        if (!headers_sent()) http_response_code(404);
        $errorPage = __DIR__ . '/../../app/views/errors/404.php'; 
        if (file_exists($errorPage)) {
            require_once $errorPage;
        } else {
            echo "<h1>404 Not Found</h1>";
        }
        exit;
    }
}