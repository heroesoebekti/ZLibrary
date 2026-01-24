<?php
/**
 * Widget Name: Jam Layanan
 */

$display_title = $widget_data['widget_name'] ?? 'Jam Layanan';
?>

<div class="bg-gradient-to-br from-indigo-600 to-blue-700 p-8 rounded-[1rem] text-white shadow-xl shadow-blue-500/20 relative overflow-hidden">
    <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
    <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-blue-400/20 rounded-full blur-2xl"></div>

    <h3 class="text-xs font-bold uppercase tracking-widest mb-6 opacity-80 relative z-10">
        <?= htmlspecialchars($display_title ?? '', ENT_QUOTES, 'UTF-8') ?>
    </h3>

    <div class="space-y-4 text-sm relative z-10">
        <div class="flex justify-between items-center border-b border-white/10 pb-3">
            <span class="opacity-70 italic">Senin - Kamis</span>
            <span class="font-bold">08:00 - 15:30</span>
        </div>
        <div class="flex justify-between items-center border-b border-white/10 pb-3">
            <span class="opacity-70 italic">Jumat</span>
            <span class="font-bold">08:00 - 11:30</span>
        </div>
        
        <div class="pt-2 text-center">
            <p class="text-[10px] opacity-60">Sabtu, Minggu & Hari Libur Tutup</p>
        </div>
    </div>
</div>