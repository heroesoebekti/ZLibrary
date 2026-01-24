<?php
/**
 * Widget Name: Artikel
 * Widget Category: Blog
 * Widget Description: Menampilkan daftar artikel terbaru.
 */

$display_title = $data['title'] ?? 'Artikel Terbaru';
?>
<section class="mb-12 py-8">
    <div class="flex items-center justify-between mb-10">
        <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">
            <?= htmlspecialchars((string)$display_title, ENT_QUOTES, 'UTF-8') ?>
        </h2>
        <div class="h-1 flex-1 mx-6 bg-slate-100 rounded-full"></div>
    </div>

    <div class="space-y-10">
        <?php if (!empty($artikel) && is_array($artikel)): ?>
            <?php foreach($artikel as $art): ?>
                <article class="group flex gap-6 items-start">
                    <div class="w-32 h-32 flex-shrink-0 overflow-hidden rounded-[1rem] shadow-inner bg-slate-100 border border-slate-50">
                        <?php if(!empty($art['gambar'])): ?>
                            <?= $asset::render_image($art['gambar'], "w-full h-full object-cover group-hover:scale-110 transition duration-500") ?>
                        <?php else: ?>
                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="flex-1">
                        <span class="text-[10px] text-indigo-500 font-bold uppercase tracking-widest mb-1 block">
                            <?= htmlspecialchars((string)($art['kategori'] ?? 'Esai & Opini')) ?>
                        </span>
                        <h3 class="text-lg font-bold text-slate-900 leading-snug group-hover:text-indigo-600 transition-colors line-clamp-2 mb-2">
                            <a href="<?= BASE_URL ?>/post/<?= $art['slug'] ?? '#' ?>">
                                <?= strip_tags((string)($art['judul'] ?? '')) ?>
                            </a>
                        </h3>
                        <p class="text-slate-500 text-xs leading-relaxed line-clamp-2">
                            <?= strip_tags((string)($art['isi'] ?? '')) ?>
                        </p>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="py-10 text-center border-2 border-dashed border-slate-100 rounded-2xl">
                <p class="text-slate-400 text-sm italic">Belum ada artikel yang tersedia.</p>
            </div>
        <?php endif; ?>
    </div>
</section>