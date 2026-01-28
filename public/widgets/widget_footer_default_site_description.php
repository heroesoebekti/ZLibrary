<?php
/**
 * Widget Name: Site Description
 * Widget Category: Footer
 * Widget Description: Menampilkan Deskripsi Website secara Statis.
 */
?>

<div class="flex items-start gap-6">
    <div class="flex-shrink-0 w-24 sm:w-32">
        <img src="<?= BASE_URL ?>/assets/img/default/<?= SITE_LOGO ?>" 
             alt="Logo <?= SITE_TITLE ?>" 
             class="w-full h-auto object-contain">
    </div>

    <div class="flex-1">
        <h3 class="text-xl font-bold mb-2 tracking-tight leading-tight">
            <?= SITE_TITLE . ' ' . SITE_SUBTITLE ?>
        </h3>
        <p class="text-sm text-slate-400 leading-relaxed">
            <?= SITE_DESCRIPTION ?>
        </p>
    </div>
</div>