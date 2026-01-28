<?php
/**
 * Widget Name: Footer Social Media
 * Widget Category: Footer
 * Widget Description: Daftar ikon media sosial untuk bagian footer.
 * Widget Config: {
"facebook_url": { "label": "Facebook URL", "type": "text", "default": "#" },
"instagram_url": { "label": "Instagram URL", "type": "text", "default": "#" },
"youtube_url": { "label": "YouTube URL", "type": "text", "default": "#" },
"twitter_url": { "label": "X / Twitter URL", "type": "text", "default": "#" },
"tiktok_url": { "label": "TikTok URL", "type": "text", "default": "" },
"linkedin_url": { "label": "LinkedIn URL", "type": "text", "default": "" },
"whatsapp_url": { "label": "WhatsApp URL", "type": "text", "default": "" },
"telegram_url": { "label": "Telegram URL", "type": "text", "default": "" },
"threads_url": { "label": "Threads URL", "type": "text", "default": "" },
"pinterest_url": { "label": "Pinterest URL", "type": "text", "default": "" }
}
 */

$info = (isset($data) && is_array($data)) ? $data : [];
$raw_content = json_decode($info['content'] ?? '{}', true) ?: [];

$config = [];
foreach ($raw_content as $key => $meta) {
    $config[$key] = (is_array($meta) && isset($meta['default'])) ? $meta['default'] : $meta;
}

$socials = [
    ['name' => 'Facebook', 'color' => '#1877F2', 'url' => $config['facebook_url'] ?? '', 'icon' => 'M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z'],
    ['name' => 'Instagram', 'color' => '#E4405F', 'url' => $config['instagram_url'] ?? '', 'icon' => 'M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z M17.5 6.5h.01 M2 2h20v20H2z'],
    ['name' => 'YouTube', 'color' => '#FF0000', 'url' => $config['youtube_url'] ?? '', 'icon' => 'M22.54 6.42a2.78 2.78 0 00-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.42a2.78 2.78 0 00-1.94 2A29 29 0 001 11.75a29 29 0 00.46 5.33 2.78 2.78 0 001.94 2C5.12 20 12 20 12 20s6.88 0 8.6-.42a2.78 2.78 0 001.94-2 29 29 0 00.46-5.33 2.78 2.78 0 00-.46-5.33z'],
    ['name' => 'X / Twitter', 'color' => '#000000', 'url' => $config['twitter_url'] ?? '', 'icon' => 'M4 4l11.733 16h4.267l-11.733 -16z M4 20l6.768 -6.768m2.46 -2.46l6.772 -6.772'],
    ['name' => 'TikTok', 'color' => '#000000', 'url' => $config['tiktok_url'] ?? '', 'icon' => 'M9 12a4 4 0 1 0 4 4V4a5 5 0 0 0 5 5'],
    ['name' => 'LinkedIn', 'color' => '#0A66C2', 'url' => $config['linkedin_url'] ?? '', 'icon' => 'M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6z M2 9h4v12H2z M4 2a2 2 0 11-2 2 2 2 0 012-2z'],
    ['name' => 'WhatsApp', 'color' => '#25D366', 'url' => $config['whatsapp_url'] ?? '', 'icon' => 'M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 11-7.6-10.4 8.38 8.38 0 013.8.9L21 3.5z'],
    ['name' => 'Telegram', 'color' => '#26A5E4', 'url' => $config['telegram_url'] ?? '', 'icon' => 'M15 10l-4 4l6 6l4-16l-18 7l4 2l2 6l3-4'],
    ['name' => 'Threads', 'color' => '#000000', 'url' => $config['threads_url'] ?? '', 'icon' => 'M12 12c-3 0-3-3-3-3s3-3 3-3s3 3 3 3v1c0 2-2 2-2 2s-4 0-4-4s3-5 6-5s6 4 6 8s-3 8-7 8'],
    ['name' => 'Pinterest', 'color' => '#BD081C', 'url' => $config['pinterest_url'] ?? '', 'icon' => 'M8 12c0 3 2 5 4 5s4-2 4-5s-2-5-4-5s-4 2-4 5z M12 22c5.5 0 10-4.5 10-10S17.5 2 12 2S2 6.5 2 12c0 4.3 2.7 8 6.6 9.4l-.6-2.9l1.2-4.5']
];
?>

<div class="footer-social-wrapper">
    <?php if ($data['show_title'] ?? true): ?>
    <h3 class="text-white font-bold mb-5 uppercase tracking-wider text-sm">
        <?= htmlspecialchars($info['title'] ?? __('Follow Us')) ?>
    </h3>
    <?php endif; ?>
    
    <div class="flex flex-wrap gap-3">
        <?php foreach ($socials as $soc): ?>
            <?php if (!empty($soc['url']) && $soc['url'] !== '#'): ?>
                <a href="<?= htmlspecialchars($soc['url']) ?>" 
                   target="_blank" 
                   title="<?= $soc['name'] ?>"
                   class="social-icon-btn w-10 h-10 rounded-full flex items-center justify-center bg-slate-800 text-slate-300 transition-all duration-300"
                   style="--brand-color: <?= $soc['color'] ?>;">
                    
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="<?= $soc['icon'] ?>" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </a>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>

<style>
    .social-icon-btn {
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(255,255,255,0.05);
    }
    
    .social-icon-btn:hover {
        background-color: var(--brand-color) !important;
        color: white !important;
        transform: translateY(-4px);
        box-shadow: 0 6px 15px rgba(0,0,0,0.4);
        border-color: transparent;
    }

    .social-icon-btn svg {
        transition: transform 0.3s ease;
    }

    .social-icon-btn:hover svg {
        transform: scale(1.1);
    }
</style>