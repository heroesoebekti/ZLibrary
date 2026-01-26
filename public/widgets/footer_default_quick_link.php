<?php
/**
 * Widget Name: Quick Links
 * Widget Category: Footer
 * Widget Description: Daftar tautan cepat dengan ikon titik dekoratif yang bisa diubah.
 * Widget Config: {
    "link_1_label": { "label": "Label Link 1", "type": "text", "default": "E-Journal" },
    "link_1_url": { "label": "URL Link 1", "type": "text", "default": "#" },
    "link_2_label": { "label": "Label Link 2", "type": "text", "default": "Clearance Procedure" },
    "link_2_url": { "label": "URL Link 2", "type": "text", "default": "#" },
    "link_3_label": { "label": "Label Link 3", "type": "text", "default": "Thesis Submission Guide" },
    "link_3_url": { "label": "URL Link 3", "type": "text", "default": "#" }
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

$accent = $config['accent_color'] ?? '#facc15';
$links = [];
for ($i = 1; $i <= 4; $i++) {
    if (!empty($config["link_{$i}_label"])) {
        $links[] = [
            'label' => $config["link_{$i}_label"],
            'url'   => $config["link_{$i}_url"] ?? '#'
        ];
    }
}
?>

<div class="w-full">
    <h3 class="text-lg font-bold mb-8 tracking-tight border-l-4 pl-4" 
        style="border-color: <?= $accent ?>;">
        <?= htmlspecialchars($info['title'] ?? __('Quick Links')) ?>
    </h3>

    <ul class="space-y-4 text-sm text-slate-400">
        <?php if (!empty($links)): ?>
            <?php foreach ($links as $link): ?>
                <li>
                    <a href="<?= htmlspecialchars($link['url']) ?>" 
                       class="hover:text-white transition-colors flex items-center gap-2 group-link-footer">
                        <span class="w-1.5 h-1.5 bg-slate-700 rounded-full transition-colors"
                              style="--tw-group-hover-bg: <?= $accent ?>;"
                              onmouseover="this.style.backgroundColor='<?= $accent ?>'"
                              onmouseout="this.style.backgroundColor=''">
                        </span> 
                        <?= htmlspecialchars(__($link['label'])) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li class="italic text-xs text-slate-500">Belum ada link yang dikonfigurasi.</li>
        <?php endif; ?>
    </ul>
</div>

<style>
    .group-link-footer:hover span {
        background-color: <?= $accent ?> !important;
    }
</style>