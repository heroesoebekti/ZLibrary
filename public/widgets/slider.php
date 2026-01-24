<?php
/**
 * Widget Name: Promo Slider Perpustakaan
* Widget Description: Promo Slider Perpustakaan
 * Widget Config: {
    "image_url": { "label": "URL Gambar", "type": "text", "default": "https://images.unsplash.com/photo-1507842217343-583bb7270b66?q=80&w=1000" },
    "headline": { "label": "Judul", "type": "text", "default": "Koleksi Buku Digital Terbaru" },
    "button_text": { "label": "Teks Tombol", "type": "text", "default": "Baca Sekarang" },
    "target_link": { "label": "Link Tujuan", "type": "text", "default": "#" },
    "bg_color": { "label": "Warna Tema", "type": "color", "default": "#4f46e5" }
}
 */

$info = (isset($data) && is_array($data)) ? $data : [];
$raw_content = json_decode($data['content'] ?? '{}', true) ?: [];
$config = [];
foreach ($raw_content as $key => $meta) {
    if (is_array($meta) && isset($meta['default'])) {
        $config[$key] = $meta['default'];
    } 
    else {
        $config[$key] = $meta;
    }
}

$img    = $config['image_url']   ?? 'https://images.unsplash.com/photo-1507842217343-583bb7270b66?q=80&w=1000';
$title  = $config['headline']    ?? 'Koleksi Terbaru';
$btn    = $config['button_text'] ?? 'Buka';
$url    = $config['target_link'] ?? '#';
$color  = $config['bg_color']    ?? '#4f46e5';
?>

<div class="relative rounded-2xl overflow-hidden shadow-lg bg-white group h-72 w-full">
    
    <img src="<?= htmlspecialchars($img) ?>" 
         alt="<?= htmlspecialchars($title) ?>" 
         class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
    
    <div class="absolute inset-0" 
         style="background: linear-gradient(to top, <?= $color ?>e6, transparent)"></div>

    <div class="absolute bottom-0 left-0 p-8 w-full text-white">
        <h3 class="text-2xl font-black mb-3 leading-tight drop-shadow-md">
            <?= htmlspecialchars($title) ?>
        </h3>
        
        <div class="flex items-center justify-between">
            <a href="<?= htmlspecialchars($url) ?>" 
               class="inline-block px-6 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition-all hover:brightness-110 active:scale-95 shadow-lg"
               style="background: white; color: <?= $color ?>;">
                <?= htmlspecialchars($btn) ?>
            </a>
            
            <div class="p-2 bg-white/20 backdrop-blur-md rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </div>
        </div>
    </div>
</div>