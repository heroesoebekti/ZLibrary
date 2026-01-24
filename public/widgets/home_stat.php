<?php
/**
 * Widget Name: Statistik Perpustakaan
 */

$display_title = $widget_data['widget_name'] ?? 'Library Stats';
?>

<div class="bg-slate-900 p-8 rounded-[1rem] text-white shadow-2xl shadow-slate-900/20">
    <h3 class="text-xs font-bold uppercase tracking-widest text-slate-500 mb-6">
        <?= htmlspecialchars($display_title ?? '', ENT_QUOTES, 'UTF-8') ?>
    </h3>

    <div class="grid grid-cols-2 gap-4">
        <div class="text-center p-4 bg-slate-800/50 border border-slate-700 rounded-xl hover:bg-slate-800 transition-colors">
            <span class="block text-2xl font-black text-blue-400 mb-1">12K+</span>
            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">Koleksi</span>
        </div>

        <div class="text-center p-4 bg-slate-800/50 border border-slate-700 rounded-xl hover:bg-slate-800 transition-colors">
            <span class="block text-2xl font-black text-indigo-400 mb-1">5K+</span>
            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">E-Journal</span>
        </div>
    </div>
</div>