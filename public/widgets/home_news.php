<?php
/**
 * Widget Name: Berita Utama
 * Widget Category: Blog
 * Widget Description: Menampilkan daftar berita terbaru dengan desain artikel yang bersih.
 * Widget Config: {
"limit": { "label": "Jumlah Berita", "type": "number", "default": "3" },
"accent_color": { "label": "Warna Aksen", "type": "color", "default": "#2563eb" },
"category": { "label": "Filter Kategori (ID)", "type": "text", "default": "" }
}
 */
$display_title = $widget_data['widget_name'] ?? 'Berita Terbaru';
?>
<section class="mb-12 py-8">
    <div class="flex items-center justify-between mb-10">
        <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">
            <?= htmlspecialchars($display_title ?? '', ENT_QUOTES, 'UTF-8') ?>
        </h2>
        <div class="h-1 flex-1 mx-6 bg-slate-100 rounded-full"></div>
    </div>

    <div class="space-y-12">
        <?php if(!empty($berita)): ?>
            <?php foreach($berita as $b): ?>
            <article class="group">
                <div class="relative overflow-hidden rounded-[1rem] mb-6 aspect-[16/10] shadow-sm">
                    <?= $asset::render_image($b['gambar'], "w-full h-full object-cover group-hover:scale-110 transition duration-500") ?>
                </div>
                <div class="flex items-center gap-3 mb-3">
                    <span class="text-[10px] font-black uppercase tracking-widest text-blue-600 bg-blue-50 px-3 py-1 rounded-lg">Update</span>
                    <span class="text-xs text-slate-400 font-medium">
                        <?= date('d M, Y', strtotime($b['tanggal_dibuat'] ?? 'now')) ?>
                    </span>
                </div>
                <h3 class="text-xl font-bold text-slate-900 leading-tight group-hover:text-blue-600 transition-colors mb-3">
                    <a href="<?= BASE_URL ?>/post/<?= $b['slug'] ?>"><?= strip_tags($b['judul'] ?? '') ?></a>
                </h3>
                <p class="text-slate-500 leading-relaxed line-clamp-2">
                    <?= strip_tags($b['isi'] ?? '') ?>
                </p>
            </article>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-slate-400 italic text-sm">Belum ada berita untuk ditampilkan.</p>
        <?php endif; ?>
    </div>
</section>