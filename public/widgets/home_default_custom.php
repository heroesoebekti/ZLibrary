<?php
/**
 * Widget Name: Custom Content
 * Widget Category: General
 * Widget Description: Digunakan untuk membuat widget secara mandiri dengan menyisipkan kode HTML/JS.
 */
?>
<section class="widget-custom-container">
    <?php if ($data['show_title']): ?>
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">
                <?= strip_tags($data['title']) ?>
            </h2>
            <div class="h-1 flex-1 mx-6 bg-slate-100 rounded-full"></div>
        </div>
    <?php endif; ?>

    <div class="custom-html-content">
        <?= $data['content'] ?>
    </div>
</section>