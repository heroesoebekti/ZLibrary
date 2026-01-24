<?php
/**
 * Widget Name: Footer Social Media
 * Widget Category: Footer
 * Widget Description: Daftar ikon media sosial untuk bagian footer.
 * Widget Config: {
    "facebook_url": { "label": "Facebook URL", "type": "text", "default": "#" },
    "instagram_url": { "label": "Instagram URL", "type": "text", "default": "#" },
    "youtube_url": { "label": "YouTube URL", "type": "text", "default": "#" },
    "twitter_url": { "label": "Twitter URL", "type": "text", "default": "#" }
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
$socials = [
    [
        'name' => 'Facebook',
        'url'  => $config['facebook_url'] ?? '',
        'color'=> '#1877F2',
        'icon' => 'M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z'
    ],
    [
        'name' => 'Instagram',
        'url'  => $config['instagram_url'] ?? '',
        'color'=> '#E4405F',
        'icon' => 'M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z M17.5 6.5h.01'
    ],
    [
        'name' => 'YouTube',
        'url'  => $config['youtube_url'] ?? '',
        'color'=> '#FF0000',
        'icon' => 'M22.54 6.42a2.78 2.78 0 00-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.42a2.78 2.78 0 00-1.94 2A29 29 0 001 11.75a29 29 0 00.46 5.33 2.78 2.78 0 001.94 2C5.12 20 12 20 12 20s6.88 0 8.6-.42a2.78 2.78 0 001.94-2 29 29 0 00.46-5.33 2.78 2.78 0 00-.46-5.33z'
    ],
    [
        'name' => 'X / Twitter',
        'url'  => $config['twitter_url'] ?? '',
        'color'=> '#1DA1F2',
        'icon' => 'M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z'
    ]
];
?>

<div class="footer-social-wrapper">
    <?php if ($data['show_title']): ?>
    <h3 class="text-white font-bold mb-4 uppercase tracking-wider text-sm">
        <?= htmlspecialchars($info['title'] ?? 'Follow Us') ?>
    </h3>
    <?php endif; ?>
    
    <div class="flex gap-3">
        <?php foreach ($socials as $soc): ?>
            <?php if (!empty($soc['url']) && $soc['url'] !== '#'): ?>
                <a href="<?= htmlspecialchars($soc['url']) ?>" 
                   target="_blank" 
                   class="w-10 h-10 rounded-full flex items-center justify-center bg-slate-800 text-slate-400 transition-all duration-300 hover:text-white"
                   style="--hover-bg: <?= $soc['color'] ?>;"
                   onmouseover="this.style.backgroundColor='<?= $soc['color'] ?>'"
                   onmouseout="this.style.backgroundColor=''">
                    
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="<?= $soc['icon'] ?>" stroke-linecap="round" stroke-linejoin="round"></path>
                        <?php if($soc['name'] === 'Instagram'): ?>
                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                        <?php endif; ?>
                    </svg>
                </a>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>

<style>
    .footer-social-wrapper a:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    }
</style>