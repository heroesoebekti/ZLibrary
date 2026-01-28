<?php
/**
 * Widget Name: Pengumuman
 * Widget Description: Menampilkan daftar pengumuman terbaru.
 */

$display_title = $widget_data['widget_name'] ?? 'Pengumuman';
?>

<div class="bg-white p-6 rounded-xl border border-slate-100 shadow-sm py-8">
    <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-6 flex items-center gap-2">
        <span class="w-1.5 h-4 bg-blue-500 rounded-full"></span>
        <?= htmlspecialchars($display_title ?? '', ENT_QUOTES, 'UTF-8') ?>
    </h3>

    <div class="space-y-4">
        <?php if (!empty($pengumuman) && is_array($pengumuman)): ?>
            <?php foreach($pengumuman as $p): ?>
                <div class="mb-4 border-l-2 border-slate-100 hover:border-blue-500 pl-4 transition-colors group">
                    <a href="<?= BASE_URL ?>/post/<?= $p['slug'] ?? '#' ?>" 
                       class="text-sm font-bold block text-slate-700 group-hover:text-blue-600 leading-tight mb-1 transition-colors">
                        <?= strip_tags($p['judul'] ?? '') ?>
                    </a>
                    <small class="text-[10px] text-slate-400 font-medium">
                        <?= date('d M Y', strtotime($p['tanggal_dibuat'] ?? 'now')) ?>
                    </small>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="py-4 text-center">
                <p class="text-slate-400 text-xs italic">Tidak ada pengumuman terbaru.</p>
            </div>
        <?php endif; ?>
    </div>
</div>