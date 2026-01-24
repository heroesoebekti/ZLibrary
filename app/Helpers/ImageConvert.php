<?php
namespace App\Helpers;

class ImageConvert {
    public static function process($file, $targetDir, $quality = 80, $prefix = 'page_') {
        if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) return false;

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $fileTmp    = $file['tmp_name'];
        $extension  = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $newName    = $prefix . bin2hex(random_bytes(8)) . ".webp";
        $destination = rtrim($targetDir, '/') . '/' . $newName;

        switch ($extension) {
            case 'jpeg':
            case 'jpg':  $image = @imagecreatefromjpeg($fileTmp); break;
            case 'png':   $image = @imagecreatefrompng($fileTmp);  break;
            case 'webp':  $image = @imagecreatefromwebp($fileTmp); break;
            default:      return false;
        }

        if (!$image) return false;

        imagepalettetotruecolor($image);
        imagealphablending($image, true);
        imagesavealpha($image, true);

        $success = imagewebp($image, $destination, $quality);
        imagedestroy($image);

        return $success ? $newName : false;
    }

    public static function delete($filePath) {
        if (file_exists($filePath) && is_file($filePath)) {
            return @unlink($filePath);
        }
        return false;
    }
}