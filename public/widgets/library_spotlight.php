<?php
/**
 * Widget Name: Library Spotlight
 * Default Config: {"category":"Semua","limit":"3","show_search":"yes","theme_color":"#6366f1"}
 */

// --- PROTEKSI & KONFIGURASI ---
$info = (isset($widget_info) && is_array($widget_info)) ? $widget_info : [];
$config = json_decode($info['content'] ?? '{}', true) ?: [];
$category = $config['category'] ?? 'Semua';
$limit = (int)($config['limit'] ?? 3);
$showSearch = ($config['show_search'] ?? 'yes') === 'yes';
$color = $config['theme_color'] ?? '#6366f1';

/** * SIMULASI DATA (Dalam produksi, ini diambil dari tabel buku Anda)
 * SELECT * FROM books WHERE category = '$category' LIMIT $limit
 */
$books = [
    ['title' => 'Laskar Pelangi', 'author' => 'Andrea Hirata', 'status' => 'Tersedia', 'cover' => 'https://api.dicebear.com/7.x/shapes/svg?seed=1'],
    ['title' => 'Filosofi Teras', 'author' => 'Henry Manampiring', 'status' => 'Dipinjam', 'cover' => 'https://api.dicebear.com/7.x/shapes/svg?seed=2'],
    ['title' => 'Bumi', 'author' => 'Tere Liye', 'status' => 'Tersedia', 'cover' => 'https://api.dicebear.com/7.x/shapes/svg?seed=3'],
];
?>

<div class="library-widget rounded-xl border border-slate-200 bg-white overflow-hidden shadow-sm font-sans">
    <div class="p-4 bg-slate-50/50 border-b border-slate-100">
        <div class="flex items-center gap-2 mb-3">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: <?= $color ?>20">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" style="color: <?= $color ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <div>
                <h4 class="text-[11px] font-black text-slate-800 uppercase tracking-wider leading-none">Koleksi Buku</h4>
                <span class="text-[9px] text-slate-400 font-bold uppercase">Kategori: <?= htmlspecialchars($category) ?></span>
            </div>
        </div>

        <?php if ($showSearch): ?>
        <form action="<?= BASE_URL ?>/library/search" method="GET" class="relative">
            <input type="text" name="q" placeholder="Cari judul atau pengarang..." 
                class="w-full pl-8 pr-3 py-1.5 text-[10px] border border-slate-200 rounded-md focus:outline-none focus:ring-1" style="--tw-ring-color: <?= $color ?>">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 absolute left-2.5 top-2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </form>
        <?php endif; ?>
    </div>

    <div class="p-4 space-y-4">
        <?php foreach (array_slice($books, 0, $limit) as $book): ?>
        <div class="flex gap-3 items-center group">
            <div class="w-10 h-14 bg-slate-100 rounded border border-slate-100 overflow-hidden shrink-0">
                <img src="<?= $book['cover'] ?>" class="w-full h-full object-cover">
            </div>
            <div class="flex-1 min-w-0">
                <div class="text-[10px] font-bold text-slate-700 truncate group-hover:text-indigo-600 transition-colors">
                    <?= htmlspecialchars($book['title']) ?>
                </div>
                <div class="text-[9px] text-slate-400 truncate mb-1 italic">oleh <?= htmlspecialchars($book['author']) ?></div>
                <span class="px-1.5 py-0.5 rounded-sm text-[8px] font-black uppercase tracking-tighter" 
                      style="<?= $book['status'] == 'Tersedia' ? 'background:#dcfce7;color:#166534;' : 'background:#fee2e2;color:#991b1b;' ?>">
                    <?= $book['status'] ?>
                </span>
            </div>
            <button class="text-slate-300 hover:text-slate-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>
        <?php endforeach; ?>
    </div>

    <a href="<?= BASE_URL ?>/library" class="block py-2 bg-slate-50 text-center text-[9px] font-bold text-slate-500 uppercase hover:bg-slate-100 transition-all border-t border-slate-100">
        Lihat Semua Koleksi
    </a>
</div>