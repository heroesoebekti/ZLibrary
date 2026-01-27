<?php
namespace App\Helpers;

use App\Helpers\Security;

class ToaStr {
    public static function set($type, $message) {
        Security::secureSession();
        $_SESSION['toastr_msg'] = [
            'type'    => $type,
            'message' => $message
        ];
    }

    public static function display() {
        Security::secureSession();
        
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