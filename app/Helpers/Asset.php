<?php
namespace App\Helpers;

class Asset {
    public static function render_image($filename, $class = "", $folder = 'posts', $alt) {
        $relativePath = "assets/img/{$folder}/" . $filename;
        $fullPath = BASE_PATH . '/' . $relativePath;

        if (!empty($filename) && file_exists($fullPath)) {
            $url = BASE_URL . '/' . $relativePath;
            return '<img src="' . $url . '" class="' . $class . '" alt="' . $alt . '" onerror="this.style.display=\'none\';this.nextElementSibling.style.display=\'flex\';">';
        }
        return '
        <div class="flex items-center justify-center bg-slate-100 w-full h-full min-h-[inherit] ' . $class . '">
            <svg class="w-12 h-12 text-slate-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
            </svg>
        </div>';
    }
}