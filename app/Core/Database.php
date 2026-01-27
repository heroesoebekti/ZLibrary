<?php
namespace App\Core;

use \PDO;
use \PDOException;

class Database {
    private static $instance = null;
    private $conn;

    private function __construct() {
        $driver = defined('DB_DRIVER') ? DB_DRIVER : 'pdo';

        if ($driver === 'pdo') {
            $this->initPDO();
        } else {
            $this->initMySQLi();
        }
    }

    private function initPDO() {
        $port = defined('DB_PORT') ? DB_PORT : '3306';
        $dsn = "mysql:host=" . DB_HOST . ";port=" . $port . ";dbname=" . DB_NAME . ";charset=utf8mb4";
        
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->conn = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            error_log("PDO Connection Error: " . $e->getMessage());
            $this->showError();
        }
    }

    private function initMySQLi() {
        mysqli_report(MYSQLI_REPORT_OFF);
        $port = defined('DB_PORT') ? (int)DB_PORT : 3306;
        $this->conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME, $port);
        
        if (!$this->conn) {
            error_log("MySQLi Connection Error: " . mysqli_connect_error());
            $this->showError();
        }
        mysqli_set_charset($this->conn, "utf8mb4");
    }

    private function showError() {
        if (!headers_sent()) {
            http_response_code(500);
        }
        die("<h1>500 Internal Server Error</h1><p>Maaf, terjadi masalah pada koneksi server.</p>");
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance->conn;
    }

    private function __clone() { }
    
    public function __wakeup() {
        throw new \Exception("Cannot unserialize a singleton.");
    }
}