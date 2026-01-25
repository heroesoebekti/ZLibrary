<?php
namespace App\Helpers;

class Security {
    public static function secureSession() {
        if (session_status() === PHP_SESSION_NONE) {
            if (!headers_sent()) {
                header_remove("X-Powered-By");
            }

            session_set_cookie_params([
                'lifetime' => 0,
                'path'     => '/',
                'domain'   => '',
                'secure'   => true,
                'httponly' => true,
                'samesite' => 'Strict'
            ]);
            
            session_start();
        }

        if (!isset($_SESSION['initialized'])) {
            session_regenerate_id(true);
            $_SESSION['initialized'] = true;
            $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'] ?? '';
        }

        if (($_SESSION['user_agent'] ?? '') !== ($_SERVER['HTTP_USER_AGENT'] ?? '')) {
            session_destroy();
            die("Security Error.");
        }
    }

    public static function input($name = null, $default = null) {
        if ($name === null) return $_REQUEST;
        return $_REQUEST[$name] ?? $default;
    }

    public static function sanitize($data, $key = null) {
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                $data[$k] = self::sanitize($v, $k);
            }
        } else {
            $data = trim($data);
            if (in_array($key, ['isi', 'content', 'layout'])) {
                return $data; 
            }
            $data = htmlspecialchars($data, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        }
        return $data;
    }

    public static function validateCsrf() {
        if (in_array($_SERVER['REQUEST_METHOD'], ['POST', 'PUT', 'DELETE'])) {
            $token = $_POST['csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
            if (empty($token) || !isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
                http_response_code(403);
                die("Security Error.");
            }
        }
    }

    public static function generateToken() {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function setHeaders() {
        if (empty($_SESSION['csp_nonce'])) {
            $_SESSION['csp_nonce'] = bin2hex(random_bytes(16));
        }
        $nonce = $_SESSION['csp_nonce'];

        header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");
        
        $csp = "default-src 'self'; ";
        $csp .= "script-src 'self' 'unsafe-inline'; ";
        $csp .= "style-src 'self' 'unsafe-inline'; ";
        $csp .= "img-src 'self' data: https:; ";
        $csp .= "font-src 'self' data:; ";
        $csp .= "frame-ancestors 'none'; ";

        header("Content-Security-Policy: " . $csp);
        header("X-Content-Type-Options: nosniff");
        header("X-Frame-Options: DENY");
        header("X-XSS-Protection: 1; mode=block");
        header("Referrer-Policy: strict-origin-when-cross-origin");
        header("Permissions-Policy: camera=(), microphone=(), geolocation=()");
    }
}