<?php
namespace App\Helpers {
    class Gettext {
        private static $dictionary = [];

        public static function init($lang = 'id_ID', $domain = 'messages') {
            self::$dictionary = [];
            $poFile = LANGUAGES_PATH . "/$lang/LC_MESSAGES/$domain.po";

            if (file_exists($poFile)) {
                $content = file_get_contents($poFile);
                preg_match_all('/msgid\s+"((?:[^"\\\\]|\\\\.)*)"\s+msgstr\s+"((?:[^"\\\\]|\\\\.)*)"/', $content, $matches, PREG_SET_ORDER);

                foreach ($matches as $match) {
                    if (!empty($match[1])) {
                        $key = stripcslashes($match[1]);
                        $value = stripcslashes($match[2]);
                        self::$dictionary[$key] = $value;
                    }
                }
            }
        }

        public static function translate($text) {
            return (isset(self::$dictionary[$text]) && self::$dictionary[$text] !== "") 
                   ? self::$dictionary[$text] 
                   : $text;
        }
    }
}

namespace {
    if (!function_exists('__')) {
        function __($msgid) {
            return \App\Helpers\Gettext::translate($msgid);
        }
    }
}