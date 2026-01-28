<?php defined('INDEX_AUTH') or exit('Direct access denied.'); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : SITE_TITLE ; ?></title>
    <script src="<?= BASE_URL ?>/assets/js/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/fonts.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
    <link rel="icon" type="image/png" sizes="16x16"  href="<?= BASE_URL ?>/assets/img/default/<?= SITE_ICON ?>">
    <meta name="author" content="<?= htmlspecialchars_decode($post['author'] ?? SITE_TITLE.' '.SITE_SUBTITLE ) ?>">
</head>
<body class="bg-slate-50 text-slate-900">