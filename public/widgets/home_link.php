<?php
/**
 * Widget Name: Icon Box
 * Widget Category: Navigasi
 * Widget Description: Barisan tautan dengan akses cepat katalog, e-book, dll.
 * Widget Config: {
    "item1_desc": { "label": "Desc 1", "type": "text", "default": "Buku di Perpustakaan" },
    "item1_url": { "label": "URL 1", "type": "text", "default": "#" },

    "item2_desc": { "label": "Desc 2", "type": "text", "default": "E-book Collection" },
    "item2_url": { "label": "URL 2", "type": "text", "default": "#" },

    "item3_desc": { "label": "Desc 3", "type": "text", "default": "Research" },
    "item3_url": { "label": "URL 3", "type": "text", "default": "#" },

    "item4_desc": { "label": "Desc 4", "type": "text", "default": "Journal fulltext access" },
    "item4_url": { "label": "URL 4", "type": "text", "default": "#" }
 }
 */

$info = (isset($data) && is_array($data)) ? $data : [];
$raw_content = json_decode($info['content'] ?? '{}', true) ?: [];

$config = [];
if (is_array($raw_content)) {
    foreach ($raw_content as $key => $meta) {
        $config[$key] = (is_array($meta) && isset($meta['default'])) ? $meta['default'] : $meta;
    }
}

// Data Statis (Judul, Warna, Ikon)
$static_data = [
    1 => ['title' => 'Online Catalog', 'color' => '#2563eb', 'icon' => 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z'],
    2 => ['title' => 'E-book',          'color' => '#4f46e5', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
    3 => ['title' => 'Repository',      'color' => '#10b981', 'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'],
    4 => ['title' => 'Journals',        'color' => '#f59e0b', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z']
];

$items = [];
for ($i = 1; $i <= 4; $i++) {
    $desc = $config["item{$i}_desc"] ?? '';
    if (!empty(trim($desc))) {
        $items[] = [
            'title' => $static_data[$i]['title'],
            'color' => $static_data[$i]['color'],
            'icon'  => $static_data[$i]['icon'],
            'desc'  => $desc,
            'url'   => $config["item{$i}_url"] ?? '#'
        ];
    }
}
?>

<section class="container mx-auto px-6 -mt-16 relative z-20">
    <div class="bg-white rounded-[1rem] shadow-xl shadow-slate-200/60 p-8 md:p-12 border border-slate-100">
        <div class="flex flex-wrap justify-center md:grid md:grid-cols-<?= count($items) > 0 ? count($items) : 1 ?> gap-8 md:gap-12">
            
            <?php foreach ($items as $item): ?>
            <a href="<?= htmlspecialchars($item['url']) ?>" class="group flex flex-col items-center text-center min-w-[150px] flex-1" target="_blank">
                <div class="w-16 h-16 rounded-2xl flex items-center justify-center mb-4 transition-all duration-300 group-hover:rotate-6 group-hover:text-white"
                     style="background-color: <?= $item['color'] ?>15; color: <?= $item['color'] ?>;"
                     onmouseover="this.style.backgroundColor='<?= $item['color'] ?>'; this.style.color='white';"
                     onmouseout="this.style.backgroundColor='<?= $item['color'] ?>15'; this.style.color='<?= $item['color'] ?>';">
                    
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="<?= $item['icon'] ?>"></path>
                    </svg>
                </div>

                <h4 class="text-slate-800 font-bold text-sm md:text-base mb-1">
                    <?= htmlspecialchars($item['title']) ?>
                </h4>
                <p class="text-slate-400 text-xs hidden md:block font-medium">
                    <?= htmlspecialchars($item['desc']) ?>
                </p>
            </a>
            <?php endforeach; ?>

            <?php if (empty($items)): ?>
                <p class="text-slate-400 text-xs italic">Konfigurasi deskripsi kosong, tidak ada data ditampilkan.</p>
            <?php endif; ?>

        </div>
    </div>
</section>