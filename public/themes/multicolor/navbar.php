
<nav class="dynamic-bg dynamic-text shadow-lg sticky top-0 z-50">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center h-20">
            <a href="<?= BASE_URL ?>" class="flex items-center gap-3 flex-shrink-0 z-50 max-w-[70%] sm:max-w-none">
                <div class="w-10 h-10 bg-white rounded-lg p-1 flex-shrink-0 flex items-center justify-center font-bold text-xl shadow-inner" style="color: var(--nav-bg)">
                    <?= substr(SITE_TITLE, 0, 1) ?>
                </div>
                <div class="flex flex-col min-w-0">
                    <span class="font-bold dynamic-text-muted opacity-80 leading-none uppercase tracking-wider truncate"
                          style="font-size: clamp(8px, 2vw, 10px);">
                        <?= SITE_TITLE ?>
                    </span>                
                    <?php $subtitle = explode(" ", SITE_SUBTITLE); ?>
                    <h2 class="font-black dynamic-text leading-[0.9] uppercase"
                        style="font-size: clamp(14px, 4vw, 20px);">
                        <?= array_shift($subtitle) ?> 
                        <span class="dynamic-text-accent"><?= implode(" ", $subtitle); ?></span>
                    </h2>
                </div>
            </a>

            <div class="flex items-center space-x-4 justify-end flex-1">
                <ul class="hidden lg:flex items-center space-x-1">
                    <?php 
                    $pretty_url = function($url) {
                        if (strpos($url, 'page.php?slug=') !== false) return str_replace('page.php?slug=', 'halaman/', $url);
                        if (strpos($url, 'archive.php?kategori=') !== false) return str_replace('archive.php?kategori=', 'arsip/', $url);
                        return $url;
                    };

                    foreach($menus as $m): 
                        $has_child = !empty($m['children']);
                        $url_final = $pretty_url($m['url']);
                    ?>
                    <li class="relative group">
                        <a href="<?= $has_child ? 'javascript:void(0)' : BASE_URL . '/' . ltrim($url_final, '/') ?>" 
                           class="px-4 py-2 dynamic-hover rounded-xl transition font-bold text-sm flex items-center gap-1">
                            <?= $m['nama_menu'] ?>
                            <?php if($has_child): ?>
                                <svg class="w-4 h-4 opacity-50 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            <?php endif; ?>
                        </a>

                        <?php if($has_child): ?>
                        <ul class="absolute left-0 invisible opacity-0 group-hover:visible group-hover:opacity-100 bg-white text-slate-800 shadow-2xl rounded-xl w-52 py-2 transition-all duration-300 translate-y-4 group-hover:translate-y-2 border border-gray-100 z-50">
                            <?php foreach($m['children'] as $child): 
                                $child_url_final = $pretty_url($child['url']);
                            ?>
                            <li>
                                <a href="<?= BASE_URL . '/' . ltrim($child_url_final, '/') ?>" 
                                   class="block px-4 py-2 hover:bg-slate-50 hover:dynamic-text-accent font-semibold text-sm transition-colors">
                                    <?= $child['nama_menu'] ?>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                        <?php endif; ?>
                    </li>
                    <?php endforeach; ?>
                </ul>

                <div class="relative group hidden lg:block">
                    <button class="flex items-center gap-2 px-3 py-1.5 dynamic-dark-bg dynamic-hover border border-white/10 rounded-lg transition-all text-xs font-bold uppercase">
                        <svg class="w-4 h-4 dynamic-text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                        </svg>
                        <span><?= ($current_lang == 'id_ID') ? 'ID' : 'EN' ?></span>
                        <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <ul class="absolute right-0 mt-2 w-48 bg-white text-slate-800 shadow-2xl rounded-xl py-2 invisible opacity-0 group-hover:visible group-hover:opacity-100 transition-all duration-300 z-[60] border border-gray-100">
                        <li>
                            <a href="<?= BASE_URL ?>/language/switch/id_ID" class="flex items-center justify-between px-4 py-2 hover:bg-slate-50 transition-colors text-xs font-bold">
                                <span><?= __('Indonesian') ?></span>
                                <?php if($current_lang == 'id_ID'): ?>
                                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <?php endif; ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?= BASE_URL ?>/language/switch/en_US" class="flex items-center justify-between px-4 py-2 hover:bg-slate-50 transition-colors text-xs font-bold">
                                <span><?= __('English (US)') ?></span>
                                <?php if($current_lang == 'en_US'): ?>
                                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <?php endif; ?>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="lg:block hidden">
                    <form action="<?= BASE_URL ?>/search" method="GET" class="relative">
                        <input type="text" name="q" placeholder="<?= __('Search...') ?>" 
                               class="search-input text-sm rounded-full px-4 py-2 w-40 focus:w-60 transition-all outline-none">
                        <button type="submit" class="absolute right-3 top-2.5 dynamic-text-muted hover:dynamic-text-accent">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </button>
                    </form>
                </div>

                <button id="btn-hamburger" class="lg:hidden p-2 rounded-lg dynamic-hover transition outline-none">
                    <svg id="icon-bars" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                    <svg id="icon-x" class="hidden w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>
    </div>

    <div id="sidebar-mobile" class="hidden lg:hidden dynamic-dark-bg border-t border-white/5 shadow-inner overflow-y-auto max-h-[calc(100vh-80px)]">
        <div class="p-4 space-y-4">

            <form action="<?= BASE_URL ?>/search" method="GET" class="relative">
                <input type="text" name="q" placeholder="<?= __('Search...') ?>" class="w-full search-input rounded-xl px-4 py-3 outline-none">
                <button type="submit" class="absolute right-4 top-3.5 dynamic-text-muted">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </button>
            </form>

            <div class="flex gap-2 pb-2 border-b border-white/10">
                <a href="<?= BASE_URL ?>/language/switch/id_ID" class="flex-1 flex items-center justify-center gap-2 p-2 rounded-lg dynamic-bg text-xs font-bold border <?= ($current_lang == 'id_ID') ? 'dynamic-border-accent dynamic-text-accent' : 'border-white/10 opacity-60' ?>">
                    ID
                </a>
                <a href="<?= BASE_URL ?>/language/switch/en_US" class="flex-1 flex items-center justify-center gap-2 p-2 rounded-lg dynamic-bg text-xs font-bold border <?= ($current_lang == 'en_US') ? 'dynamic-border-accent dynamic-text-accent' : 'border-white/10 opacity-60' ?>">
                    EN
                </a>
            </div>

            <ul class="space-y-1">
                <?php foreach($menus as $m): 
                    $has_child = !empty($m['children']);
                    $url_final = $pretty_url($m['url']);
                ?>
                <li>
                    <div class="flex flex-col">
                        <a href="<?= $has_child ? 'javascript:void(0)' : BASE_URL . '/' . ltrim($url_final, '/') ?>" 
                           class="mobile-dropdown-btn flex justify-between items-center p-3 rounded-lg dynamic-hover font-bold transition">
                            <?= $m['nama_menu'] ?>
                            <?php if($has_child): ?>
                                <svg class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            <?php endif; ?>
                        </a>
                        
                        <?php if($has_child): ?>
                        <ul class="mobile-submenu hidden bg-black/20 rounded-lg mt-1 ml-2 mobile-submenu-border overflow-hidden">
                            <?php foreach($m['children'] as $child): 
                                $child_url_final = $pretty_url($child['url']);
                            ?>
                            <li>
                                <a href="<?= BASE_URL . '/' . ltrim($child_url_final, '/') ?>" class="block p-3 text-sm dynamic-text-muted hover:dynamic-text transition">
                                    <?= $child['nama_menu'] ?>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                        <?php endif; ?>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</nav>
<div class="theme-switcher-container">
    <div id="main-palette-btn" class="palette-btn dynamic-bg">
        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
        </svg>
    </div>

    <div id="palette-menu" class="palette-dropdown">
        <h4 class="text-[10px] font-bold uppercase text-slate-400 mb-3 tracking-widest border-b pb-2 text-center">
            Pilih Warna Tema
        </h4>
        <div class="grid grid-cols-5 gap-2">
            <?php foreach($palettes as $name => $colors): ?>
                <div onclick="setThemeCookie('<?= $name ?>')" 
                     class="color-option shadow-sm" 
                     title="<?= ucwords(str_replace('_', ' ', $name)) ?>"
                     style="background: <?= $colors['bg'] ?>; border-top: 5px solid <?= $colors['accent'] ?>;">
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
