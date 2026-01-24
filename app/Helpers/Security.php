<?php
namespace App\Helpers;

class Security {
    public static function secureSession() {
        if (session_status() === PHP_SESSION_NONE) {
            if (!headers_sent()) header_remove("X-Powered-By");
            session_set_cookie_params([
                'lifetime' => 0,
                'path'     => '/',
                'domain'   => '',
                'secure'   => (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'),
                'httponly' => true,
                'samesite' => 'Lax'
            ]);
            session_start();
        }
        if (!isset($_SESSION['initialized'])) {
            session_regenerate_id(true);
            $_SESSION['initialized'] = true;
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
            if (in_array($key, ['isi', 'content', 'layout'])) return $data;
            $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        }
        return $data;
    }

    public static function validateCsrf() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['csrf_token'] ?? '';
            if (empty($token) || !isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
                http_response_code(403);
                die("Security Error: CSRF Token Invalid.");
            }
        }
    }

    public static function generateToken() {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function setHeaders($isAdmin = false) {
        $allowedScripts = defined('CSP_ALLOWED_SCRIPTS') && !empty(CSP_ALLOWED_SCRIPTS) ? explode(',', CSP_ALLOWED_SCRIPTS) : [];
        $allowedStyles  = defined('CSP_ALLOWED_STYLES') && !empty(CSP_ALLOWED_STYLES) ? explode(',', CSP_ALLOWED_STYLES) : [];
        $allowedImages  = defined('CSP_ALLOWED_IMAGES') && !empty(CSP_ALLOWED_IMAGES) ? explode(',', CSP_ALLOWED_IMAGES) : [];
        $allowedFonts   = defined('CSP_ALLOWED_FONTS') && !empty(CSP_ALLOWED_FONTS) ? explode(',', CSP_ALLOWED_FONTS) : [];

        $scripts = array_merge(["'self'", "'unsafe-inline'", "'unsafe-eval'"], $allowedScripts);
        $styles  = array_merge(["'self'", "'unsafe-inline'"], $allowedStyles);
        $images  = array_merge(["'self'", "data:"], $allowedImages);
        $fonts   = array_merge(["'self'", "data:"], $allowedFonts);

        $csp = "default-src 'self'; ";
        $csp .= "script-src " . implode(' ', array_unique($scripts)) . "; ";
        $csp .= "style-src " . implode(' ', array_unique($styles)) . "; ";
        $csp .= "font-src " . implode(' ', array_unique($fonts)) . "; ";
        $csp .= "img-src " . implode(' ', array_unique($images)) . "; ";
        $csp .= "frame-src 'self'; ";

        header("Content-Security-Policy: " . $csp);
        header("X-Content-Type-Options: nosniff");
        header("X-Frame-Options: SAMEORIGIN");
        header("X-XSS-Protection: 1; mode=block");
        header("Referrer-Policy: strict-origin-when-cross-origin");
    }
}