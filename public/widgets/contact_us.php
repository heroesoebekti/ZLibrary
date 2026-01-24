<?php
/**
 * Widget Name: Contact Us
 * Widget Category: Footer
 * Widget Description: Menampilkan info kontak dan daftar media sosial.
 * Widget Config: {
"accent_color": { "label": "Warna Aksen", "type": "color", "default": "#facc15" },
"address": { "label": "Alamat", "type": "textarea", "default": "Jl. Raya Nasional 3" },
"email": { "label": "Email", "type": "text", "default": "library@localhost" },
"social_1_name": { "label": "Nama Sosmed 1", "type": "text", "default": "Instagram" },
"social_1_url": { "label": "URL Sosmed 1", "type": "text", "default": "#" },
"social_2_name": { "label": "Nama Sosmed 2", "type": "text", "default": "YouTube" },
"social_2_url": { "label": "URL Sosmed 2", "type": "text", "default": "#" }
}
 */

$info = (isset($data) && is_array($data)) ? $data : [];
$raw_content = json_decode($info['content'] ?? '{}', true) ?: [];
$accent = '#facc15';
$address = 'Alamat belum diset';
$email = 'email@contoh.com';
$socials = [];

if (is_array($raw_content)) {
    foreach ($raw_content as $key => $meta) {
        $val = (is_array($meta) && isset($meta['default'])) ? $meta['default'] : $meta;
        if ($key === 'accent_color') { $accent = $val; continue; }
        if ($key === 'address' && !empty($val)) { $address = $val; continue; }
        if ($key === 'email' && !empty($val)) { $email = $val; continue; }
        if (preg_match('/social_(\d+)_([a-z]+)/', $key, $matches)) {
            $index = $matches[1];
            $field = $matches[2];
            $socials[$index][$field] = $val;
        }
    }
}
ksort($socials);
?>

<div class="w-full">
    <h3 class="text-lg font-bold mb-8 tracking-tight border-l-4 pl-4 text-slate-100" 
        style="border-color: <?= $accent ?>;">
        <?= htmlspecialchars($info['title'] ?? __('Contact Us')) ?>
    </h3>

    <div class="space-y-5 text-sm text-slate-400">
        <div class="flex gap-4 items-start">
            <svg class="w-5 h-5 shrink-0" style="color: <?= $accent ?>;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            <p class="leading-relaxed"><?= nl2br(htmlspecialchars($address)) ?></p>
        </div>

        <div class="flex gap-4 items-center">
            <svg class="w-5 h-5 shrink-0" style="color: <?= $accent ?>;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
            </svg>
            <a href="mailto:<?= $email ?>" class="hover:text-white transition-colors"><?= htmlspecialchars($email) ?></a>
        </div>

        <?php if (!empty($socials)): ?>
            <div class="flex flex-wrap gap-x-4 gap-y-2 pt-4 border-t border-slate-800">
                <?php 
                $i = 0;
                foreach ($socials as $soc): 
                    if (empty($soc['name'])) continue;
                    if ($i > 0) echo '<span class="text-slate-800">|</span>';
                ?>
                    <a href="<?= htmlspecialchars($soc['url'] ?? '#') ?>" 
                       target="_blank"
                       class="text-slate-500 hover:text-white transition-colors font-medium">
                        <?= htmlspecialchars($soc['name']) ?>
                    </a>
                <?php 
                $i++;
                endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>