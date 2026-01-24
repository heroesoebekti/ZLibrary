<?php
namespace App\Helpers;

class ToaStr {
    public static function set($type, $message) {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $_SESSION['toastr_msg'] = [
            'type'    => $type,
            'message' => $message
        ];
    }

    public static function display() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        if (isset($_SESSION['toastr_msg'])) {
            $type    = $_SESSION['toastr_msg']['type'];
            $message = htmlspecialchars($_SESSION['toastr_msg']['message'], ENT_QUOTES, 'UTF-8');
            
            echo "
            <script>
                $(document).ready(function() {
                    if (typeof toastr !== 'undefined') {
                        toastr.options = {
                            'closeButton': true,
                            'progressBar': true,
                            'positionClass': 'toast-top-right',
                            'timeOut': '3000'
                        };
                        toastr.{$type}('{$message}');
                    }
                });
            </script>
            ";
            unset($_SESSION['toastr_msg']);
        }
    }
}