<?php
/**
 * Widget Name: Daftar Tombol Sejajar
 * Widget Category: Navigasi
 * Widget Description: Digunakan untuk menampilkan tombol tautan dengan posisi sejajar mendatar.
 * Widget Config: 
{
    "item_1_desc": { "label": "Layanan 1", "type": "text", "default": "Turnitin" },
    "item_1_url": { "label": "URL 1", "type": "text", "default": "#" },
    "item_2_desc": { "label": "Layanan 2", "type": "text", "default": "Member Free" },
    "item_2_url": { "label": "URL 2", "type": "text", "default": "#" },
    "item_3_desc": { "label": "Layanan 3", "type": "text", "default": "Lecturer Report" },
    "item_3_url": { "label": "URL 3", "type": "text", "default": "#" },
    "item_4_desc": { "label": "Layanan 4", "type": "text", "default": "Book Request" },
    "item_4_url": { "label": "URL 4", "type": "text", "default": "#" },
    "item_5_desc": { "label": "Layanan 5", "type": "text", "default": "Renew A Book" },
    "item_5_url": { "label": "URL 5", "type": "text", "default": "#" }
}
 */

$info = (isset($data) && is_array($data)) ? $data : [];
$display_title = $info['title'] ?? 'Our Services'; // Gunakan $info agar konsisten
$raw_content = json_decode($info['content'] ?? '{}', true) ?: [];

$services = [];
if (is_array($raw_content)) {
    foreach ($raw_content as $key => $meta) {
        $val = (is_array($meta) && isset($meta['default'])) ? $meta['default'] : $meta;
        if (preg_match('/item_?(\d+)_([a-z]+)/', $key, $matches)) {
            $index = $matches[1];
            $field = $matches[2]; 
            $services[$index][$field] = $val;
        }
    }
}
ksort($services);
?>
<div class="border-t border-slate-100 py-6">
    <?php if (($info['show_title'] ?? '1') == '1'): ?>
        <div class="bg-blue-600 rounded-full p-1 px-4 w-fit mb-8 shadow-sm">
            <h2 class="text-sm font-bold text-white uppercase tracking-widest">
                <?= htmlspecialchars($display_title, ENT_QUOTES, 'UTF-8') ?>
            </h2>
        </div>
    <?php endif; ?>
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
        <?php if (!empty($services)): ?>
            <?php foreach ($services as $svc): 
                $name = $svc['desc'] ?? '';
                $url = $svc['url'] ?? '#';
                if (empty($name)) continue; 
            ?>
                <a href="<?= htmlspecialchars($url) ?>" 
                   target="_blank"
                   class="py-4 px-2 border-2 border-slate-200 rounded-xl text-center text-slate-700 font-bold text-sm hover:border-blue-600 hover:text-blue-600 transition-all flex items-center justify-center min-h-[64px] bg-white hover:shadow-md">
                    <?= htmlspecialchars($name) ?>
                </a>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-span-full text-center py-10 border-2 border-dashed border-slate-200 rounded-xl">
                <p class="text-slate-400 text-xs italic">Belum ada layanan yang ditambahkan.</p>
            </div>
        <?php endif; ?>
    </div>
</div>