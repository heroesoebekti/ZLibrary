<?php
namespace App\Controllers\Public;

use App\Core\Controller;
use App\Core\Database;
use PDO;

class AuthController extends Controller {

    public function index() {
        if (isset($_SESSION['admin_logged_in'])) {
            header("Location: " . BASE_URL . "/admin");
            exit;
        }
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        $data = ['title' => 'Login - Dashboard'];
        require_once dirname(__DIR__, 2) . '/Views/admin/login.php';
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
            $db = Database::getInstance();
            $postToken = $_POST['csrf_token'] ?? '';
            $sessionToken = $_SESSION['csrf_token'] ?? '';

            if (empty($postToken) || !hash_equals($sessionToken, $postToken)) {
                $_SESSION['error'] = 'Security validation failed.';
                header("Location: " . BASE_URL . "/auth"); exit;
            }

            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $stmt = $db->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
            $stmt->execute([$username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                session_regenerate_id(true);
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id'] = $user['id'];
                $_SESSION['admin_name'] = $user['nama_lengkap'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['app_lang'] = $this->site_settings['default_language'] ?? 'id_ID';

                $db->prepare("UPDATE users SET last_login = NOW() WHERE id = ?")->execute([$user['id']]);
                unset($_SESSION['csrf_token']);
                header("Location: " . BASE_URL . "/admin"); exit;
            } else {
                $_SESSION['error'] = 'Invalid username or password.';
            }
        }
        header("Location: " . BASE_URL . "/auth"); exit;
    }

    public function logout() {
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
        }
        session_destroy();
        header("Location: " . BASE_URL . "/auth"); exit;
    }
}