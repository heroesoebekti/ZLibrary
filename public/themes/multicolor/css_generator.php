<?php 
defined('INDEX_AUTH') or exit('Direct access denied.');
$palettes = [

    'slate_pro'   => ['bg' => '#0f172a', 'accent' => '#38bdf8', 'hover' => '#1e293b', 'dark' => '#020617', 'text' => '#ffffff', 'muted' => '#94a3b8'],
    'nordic'      => ['bg' => '#2e3440', 'accent' => '#88c0d0', 'hover' => '#3b4252', 'dark' => '#242933', 'text' => '#eceff4', 'muted' => '#d8dee9'],
    'indigo_dye'  => ['bg' => '#1e1b4b', 'accent' => '#818cf8', 'hover' => '#312e81', 'dark' => '#0f172a', 'text' => '#ffffff', 'muted' => '#c7d2fe'],
    'emerald'     => ['bg' => '#064e3b', 'accent' => '#10b981', 'hover' => '#065f46', 'dark' => '#022c22', 'text' => '#ffffff', 'muted' => '#a7f3d0'],
    'moss'        => ['bg' => '#365314', 'accent' => '#a3e635', 'hover' => '#3f6212', 'dark' => '#1a2e05', 'text' => '#ffffff', 'muted' => '#d9f99d'],
    'autumn'      => ['bg' => '#78350f', 'accent' => '#f59e0b', 'hover' => '#92400e', 'dark' => '#451a03', 'text' => '#ffffff', 'muted' => '#fef3c7'],
    'sand'        => ['bg' => '#454739', 'accent' => '#d4d185', 'hover' => '#5c5e4a', 'dark' => '#2a2b22', 'text' => '#ffffff', 'muted' => '#e5e4bc'],
    'gold_dark'   => ['bg' => '#1c1917', 'accent' => '#eab308', 'hover' => '#292524', 'dark' => '#0c0a09', 'text' => '#ffffff', 'muted' => '#a8a29e'],
    'deep_plum'   => ['bg' => '#4c0519', 'accent' => '#fb7185', 'hover' => '#881337', 'dark' => '#27000a', 'text' => '#ffffff', 'muted' => '#fecdd3'],
    'royal_blue'  => ['bg' => '#172554', 'accent' => '#60a5fa', 'hover' => '#1e3a8a', 'dark' => '#081431', 'text' => '#ffffff', 'muted' => '#bfdbfe'],
    'cyber'       => ['bg' => '#000000', 'accent' => '#00ff41', 'hover' => '#1a1a1a', 'dark' => '#000000', 'text' => '#ffffff', 'muted' => '#008f11'],
    'neon_pulse'  => ['bg' => '#09090b', 'accent' => '#d946ef', 'hover' => '#18181b', 'dark' => '#000000', 'text' => '#ffffff', 'muted' => '#a1a1aa'],
    'volcano'     => ['bg' => '#450a0a', 'accent' => '#ef4444', 'hover' => '#7f1d1d', 'dark' => '#290000', 'text' => '#ffffff', 'muted' => '#fca5a5'],
    'electric'    => ['bg' => '#1e1b4b', 'accent' => '#22d3ee', 'hover' => '#312e81', 'dark' => '#0f172a', 'text' => '#ffffff', 'muted' => '#a5f3fc'],
    'lavender'    => ['bg' => '#2d2159', 'accent' => '#c084fc', 'hover' => '#3b2d7d', 'dark' => '#1e1548', 'text' => '#ffffff', 'muted' => '#e9d5ff'],
    'teal_dark'   => ['bg' => '#134e4a', 'accent' => '#2dd4bf', 'hover' => '#115e59', 'dark' => '#042f2e', 'text' => '#ffffff', 'muted' => '#99f6e4'],
    'coffee'      => ['bg' => '#27272a', 'accent' => '#d97706', 'hover' => '#3f3f46', 'dark' => '#18181b', 'text' => '#ffffff', 'muted' => '#a1a1aa'],
    'space'       => ['bg' => '#020617', 'accent' => '#6366f1', 'hover' => '#0f172a', 'dark' => '#000000', 'text' => '#ffffff', 'muted' => '#94a3b8'],
    'maroon'      => ['bg' => '#500724', 'accent' => '#f472b6', 'hover' => '#700d33', 'dark' => '#310417', 'text' => '#ffffff', 'muted' => '#fbcfe8'],
    'charcoal'    => ['bg' => '#18181b', 'accent' => '#fafafa', 'hover' => '#27272a', 'dark' => '#09090b', 'text' => '#ffffff', 'muted' => '#71717a'],
    'midnight'    => ['bg' => '#020617', 'accent' => '#f8fafc', 'hover' => '#0f172a', 'dark' => '#000000', 'text' => '#f1f5f9', 'muted' => '#475569'],
    'oceanic'     => ['bg' => '#083344', 'accent' => '#22d3ee', 'hover' => '#164e63', 'dark' => '#020617', 'text' => '#ecfeff', 'muted' => '#a5f3fc'],
    'rose_gold'   => ['bg' => '#451a03', 'accent' => '#fda4af', 'hover' => '#78350f', 'dark' => '#290000', 'text' => '#fff1f2', 'muted' => '#fecdd3'],
    'forest'      => ['bg' => '#052e16', 'accent' => '#4ade80', 'hover' => '#064e3b', 'dark' => '#022c22', 'text' => '#f0fdf4', 'muted' => '#bbf7d0'],
    'amethyst'    => ['bg' => '#3b0764', 'accent' => '#d8b4fe', 'hover' => '#581c87', 'dark' => '#2e1065', 'text' => '#faf5ff', 'muted' => '#e9d5ff'],
    'crimson'     => ['bg' => '#7f1d1d', 'accent' => '#f87171', 'hover' => '#991b1b', 'dark' => '#450a0a', 'text' => '#fef2f2', 'muted' => '#fecaca'],
    'zinc_dark'   => ['bg' => '#09090b', 'accent' => '#71717a', 'hover' => '#18181b', 'dark' => '#000000', 'text' => '#fafafa', 'muted' => '#3f3f46'],
    'solar'       => ['bg' => '#422006', 'accent' => '#facc15', 'hover' => '#713f12', 'dark' => '#2d1a0b', 'text' => '#fefce8', 'muted' => '#fef08a'],
    'glacier'     => ['bg' => '#0c4a6e', 'accent' => '#7dd3fc', 'hover' => '#075985', 'dark' => '#082f49', 'text' => '#f0f9ff', 'muted' => '#bae6fd'],
    'bamboo'      => ['bg' => '#14532d', 'accent' => '#bef264', 'hover' => '#166534', 'dark' => '#064e3b', 'text' => '#f7fee7', 'muted' => '#d9f99d'],
    'obsidian'    => ['bg' => '#000000', 'accent' => '#ffffff', 'hover' => '#111111', 'dark' => '#000000', 'text' => '#ffffff', 'muted' => '#666666'],
    'grape'       => ['bg' => '#2e1065', 'accent' => '#a855f7', 'hover' => '#4c1d95', 'dark' => '#1e1b4b', 'text' => '#f5f3ff', 'muted' => '#ddd6fe'],
    'sunset'      => ['bg' => '#7c2d12', 'accent' => '#fb923c', 'hover' => '#9a3412', 'dark' => '#431407', 'text' => '#fff7ed', 'muted' => '#ffedd5'],
    'mint_dark'   => ['bg' => '#064e3b', 'accent' => '#5eead4', 'hover' => '#0f766e', 'dark' => '#042f2e', 'text' => '#f0fdfa', 'muted' => '#99f6e4'],
    'blood_moon'  => ['bg' => '#450a0a', 'accent' => '#dc2626', 'hover' => '#7f1d1d', 'dark' => '#290000', 'text' => '#ffffff', 'muted' => '#f87171'],
    'nebula'      => ['bg' => '#1e1b4b', 'accent' => '#e879f9', 'hover' => '#312e81', 'dark' => '#0f172a', 'text' => '#fdf4ff', 'muted' => '#f5d0fe'],
    'earth'       => ['bg' => '#3f2c1d', 'accent' => '#d2b48c', 'hover' => '#5d4037', 'dark' => '#261a11', 'text' => '#f4efe1', 'muted' => '#a68b6d'],
    'abyss'       => ['bg' => '#111827', 'accent' => '#10b981', 'hover' => '#1f2937', 'dark' => '#030712', 'text' => '#f9fafb', 'muted' => '#9ca3af'],
    'ruby'        => ['bg' => '#831843', 'accent' => '#f472b6', 'hover' => '#9d174d', 'dark' => '#500724', 'text' => '#fdf2f8', 'muted' => '#fbcfe8'],
    'vintage'     => ['bg' => '#1a1c1e', 'accent' => '#e2b808', 'hover' => '#2c2e30', 'dark' => '#000000', 'text' => '#e0e0e0', 'muted' => '#808080'],
    'deep_teal'   => ['bg' => '#042f2e', 'accent' => '#2dd4bf', 'hover' => '#134e4a', 'dark' => '#020617', 'text' => '#f0fdfa', 'muted' => '#5eead4'],
    'phantom'     => ['bg' => '#18181b', 'accent' => '#6366f1', 'hover' => '#27272a', 'dark' => '#09090b', 'text' => '#ffffff', 'muted' => '#a1a1aa'],
    'copper'      => ['bg' => '#431407', 'accent' => '#fbbf24', 'hover' => '#7c2d12', 'dark' => '#290000', 'text' => '#fffbeb', 'muted' => '#fde68a'],
    'ink'         => ['bg' => '#0f172a', 'accent' => '#94a3b8', 'hover' => '#1e293b', 'dark' => '#020617', 'text' => '#ffffff', 'muted' => '#334155'],
    'emerald_night' => ['bg' => '#022c22', 'accent' => '#34d399', 'hover' => '#064e3b', 'dark' => '#000000', 'text' => '#ecfdf5', 'muted' => '#10b981'],
    'carbon'      => ['bg' => '#171717', 'accent' => '#404040', 'hover' => '#262626', 'dark' => '#0a0a0a', 'text' => '#ededed', 'muted' => '#737373'],
    'royal_purple' => ['bg' => '#2e1065', 'accent' => '#f0abfc', 'hover' => '#4c1d95', 'dark' => '#1e1b4b', 'text' => '#fdf4ff', 'muted' => '#d8b4fe'],
    'desert_dark' => ['bg' => '#454739', 'accent' => '#eab308', 'hover' => '#5c5e4a', 'dark' => '#2a2b22', 'text' => '#ffffff', 'muted' => '#a1a1aa'],
    'arctic'      => ['bg' => '#0f172a', 'accent' => '#bae6fd', 'hover' => '#1e293b', 'dark' => '#020617', 'text' => '#f8fafc', 'muted' => '#7dd3fc'],
    'shadow'      => ['bg' => '#0c0a09', 'accent' => '#78716c', 'hover' => '#1c1917', 'dark' => '#000000', 'text' => '#f5f5f4', 'muted' => '#44403c'],
];

$cookie_theme = $_COOKIE['user_theme'] ?? null;
$public_theme = $settings['theme_preset'] ?? 'slate_pro';
$selected_preset = (array_key_exists($cookie_theme, $palettes)) ? $cookie_theme : $public_theme;
$p = $palettes[$selected_preset];
?>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; text-rendering: optimizeLegibility; background-color: #f8fafc; }
        .font-smooth { letter-spacing: -0.01em; line-height: 1.6; }
        .line-clamp-2 { display: -webkit-box; -webkit-box-orient: vertical; overflow: hidden; -webkit-line-clamp: 2; }
        .line-clamp-3 { display: -webkit-box; -webkit-box-orient: vertical; overflow: hidden; -webkit-line-clamp: 3; }
        .auth-card { background: #fff; border: 1px solid #f1f5f9; }
        .sharp-radius { border-radius: 4px; }
        .input-flat { border: 1px solid #e2e8f0; background: #fcfcfc; transition: 0.2s; }
        .input-flat:focus { border-color: #4f46e5; background: #fff; outline: none; box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1); }
        .text-readable-menu { font-size: .95rem; font-weight: 700; color: #1e293b; }
        .text-url { font-family: monospace; font-size: 11px; color: #94a3b8; }
        .btn-action-box { width: 40px; height: 40px; border: 1px solid #e2e8f0; border-radius: var(--radius-custom); display: flex; align-items: center; justify-content: center; color: #64748b; background-color: #fff; transition: all .2s ease; }
        .main-handle, .sub-handle { cursor: grab; color: #cbd5e1; padding: 4px; font-size: 20px; }
        .sortable-ghost { background-color: #eef2ff !important; border: 2px dashed #4f46e5 !important; opacity: 0.8; }
        .rounded-custom { border-radius: var(--radius-custom) !important; }
        .ck-editor__editable { min-height: 250px; padding: 0 20px !important; }
        [x-cloak] { display: none !important; }
        .modal-overlay { background-color: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); }
        .sortable-chosen { box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); transform: scale(1.01); }
        .submenu-list.drag-over { background-color: #f0f9ff !important; border: 1px solid #0ea5e9 !important; }
        .connected-sortable { min-height: 40px; transition: all .2s ease; }
        .btn-action-box:hover { transform: translateY(-2px); box-shadow: 0 4px 12px -2px rgba(0,0,0,0.1); }
        .btn-edit:hover { border-color: #6366f1; color: #6366f1; background-color: #f5f7ff; }
        .btn-toggle:hover { border-color: #10b981; color: #10b981; background-color: #ecfdf5; }
        .btn-delete:hover { border-color: #ef4444; color: #ef4444; background-color: #fff1f2; }

        :root {
            --radius-custom: 10px;
            --nav-bg: <?= $p['bg'] ?>;
            --nav-accent: <?= $p['accent'] ?>;
            --nav-hover: <?= $p['hover'] ?>;
            --nav-dark: <?= $p['dark'] ?>;
            --nav-text: <?= $p['text'] ?>;
            --nav-muted: <?= $p['muted'] ?>;
        }

        .dynamic-bg { background-color: var(--nav-bg) !important; }
        .dynamic-text { color: var(--nav-text) !important; }
        .dynamic-text-muted { color: var(--nav-muted) !important; }
        .dynamic-text-accent { color: var(--nav-accent) !important; }
        .dynamic-hover:hover { background-color: var(--nav-hover) !important; }
        .dynamic-dark-bg { background-color: var(--nav-dark) !important; }
        .dynamic-border-accent { border-color: var(--nav-accent) !important; }
        .mobile-submenu-border { border-left: 2px solid var(--nav-accent); }
        .search-input { background-color: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); color: white; }
        .search-input:focus { background-color: white; color: #1a1a1a; }
        .hero-gradient-text { background-image: linear-gradient(to right, var(--nav-accent), #fff); -webkit-background-clip: text; background-clip: text; color: transparent; }
        .hero-overlay { background-image: linear-gradient(to right, var(--nav-dark) 0%, rgba(15, 23, 42, 0.8) 50%, transparent 100%); }
        .dynamic-breadcrumb a:hover { color: var(--nav-accent) !important; }
        .dynamic-post-badge { background-color: var(--nav-accent); color: var(--nav-dark); }
        .dynamic-post-author-icon { background-color: var(--nav-bg); color: #fff; }
        .dynamic-related-link:hover { border-color: var(--nav-accent) !important; }
        .dynamic-related-title:hover { color: var(--nav-bg) !important; }
        .dynamic-related-more { color: var(--nav-accent) !important; }
        .dynamic-tag-link:hover { color: var(--nav-accent) !important; }
        .prose blockquote { color: var(--nav-bg) !important; border-left-color: var(--nav-accent) !important; }
        .dynamic-post-accent-bg { background-color: var(--nav-accent); opacity: 0.2; }
        .dynamic-post-icon { background-color: var(--nav-accent); color: var(--nav-dark); }
        .dynamic-post-title-link:hover { color: var(--nav-bg) !important; }
        .dynamic-tag:hover { background-color: var(--nav-bg) !important; color: #fff !important; }
        .prose a { color: var(--nav-bg); }
        .prose a:hover { color: var(--nav-accent); }
        .dynamic-search-header { background-color: var(--nav-dark); }
        .dynamic-search-accent-blur { background-color: var(--nav-accent); opacity: 0.1; }
        .dynamic-search-keyword { color: var(--nav-accent); }
        .dynamic-search-icon { color: var(--nav-accent); }
        .dynamic-search-card:hover { border-color: var(--nav-accent) !important; }
        .dynamic-search-title:hover { color: var(--nav-bg) !important; }
        .dynamic-search-link { color: var(--nav-bg); }
        .dynamic-search-link:hover { color: var(--nav-accent); }
        .dynamic-search-btn { background-color: var(--nav-bg); }
        .dynamic-search-btn:hover { background-color: var(--nav-dark); }
        .archive-badge { background-color: var(--nav-accent); color: var(--nav-dark); }
        .archive-link { color: var(--nav-bg); }
        .archive-link:hover { color: var(--nav-accent); }
        .archive-btn-back { background-color: var(--nav-bg); }
        .theme-switcher-container { position: fixed; top: 100px; right: 20px; z-index: 9999; }
        .palette-btn { width: 45px; height: 45px; border-radius: 12px; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 4px 15px rgba(0,0,0,0.15); transition: all 0.3s ease; border: 2px solid white; }
        .palette-btn:hover { transform: scale(1.1); }
        .palette-dropdown { position: absolute; top: 0; right: 55px; width: 220px; background: white; border-radius: 15px; padding: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.2); display: none; border: 1px solid #f0f0f0; }
        .palette-dropdown.active { display: block; animation: slideIn 0.3s ease-out; }
        @keyframes slideIn { from { opacity: 0; transform: translateX(10px); } to { opacity: 1; transform: translateX(0); } }
        .color-option { width: 30px; height: 30px; border-radius: 50%; cursor: pointer; transition: transform 0.2s; border: 2px solid #f0f0f0; }
        .color-option:hover { transform: scale(1.2); border-color: #ddd; }
    </style>