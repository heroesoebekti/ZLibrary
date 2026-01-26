<?php defined('INDEX_AUTH') or exit('Direct access denied.'); ?>
<nav class="bg-blue-800 text-white shadow-lg sticky top-0 z-50">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center h-20">
            <a href="<?= BASE_URL ?>" class="flex items-center gap-3 flex-shrink-0 z-50 max-w-[70%] sm:max-w-none">
                <div class="w-10 h-10 bg-white rounded-lg p-1 flex-shrink-0 flex items-center justify-center text-blue-800 font-bold text-xl shadow-inner">
                    <?= substr(SITE_TITLE, 0, 1) ?>
                </div>
                <div class="flex flex-col min-w-0">
                    <span class="font-bold text-blue-200 leading-none uppercase tracking-wider truncate"
                          style="font-size: clamp(8px, 2vw, 10px);">
                        <?= SITE_TITLE ?>
                    </span>                
                    <?php $subtitle = explode(" ", SITE_SUBTITLE); ?>
                    <h2 class="font-black text-white leading-[0.9] uppercase"
                        style="font-size: clamp(14px, 4vw, 20px);">
                        <?= array_shift($subtitle) ?> 
                        <span class="text-yellow-400"><?= implode(" ", $subtitle); ?></span>
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
                           class="px-4 py-2 hover:bg-blue-700 rounded-xl transition font-bold text-sm flex items-center gap-1">
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
                                   class="block px-4 py-2 hover:bg-blue-50 hover:text-blue-700 font-semibold text-sm transition-colors">
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
                    <button class="flex items-center gap-2 px-3 py-1.5 bg-blue-900/50 hover:bg-blue-700 border border-blue-700 rounded-lg transition-all text-xs font-bold uppercase">
                        <svg class="w-4 h-4 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                        </svg>
                        <span><?= ($current_lang == 'id_ID') ? 'ID' : 'EN' ?></span>
                        <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <ul class="absolute right-0 mt-2 w-48 bg-white text-slate-800 shadow-2xl rounded-xl py-2 invisible opacity-0 group-hover:visible group-hover:opacity-100 transition-all duration-300 z-[60] border border-gray-100">
                        <li>
                            <a href="<?= BASE_URL ?>/language/switch/id_ID" class="flex items-center justify-between px-4 py-2 hover:bg-blue-50 transition-colors text-xs font-bold">
                                <span><?= __('Indonesian') ?></span>
                                <?php if($current_lang == 'id_ID'): ?>
                                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <?php endif; ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?= BASE_URL ?>/language/switch/en_US" class="flex items-center justify-between px-4 py-2 hover:bg-blue-50 transition-colors text-xs font-bold">
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
                               class="bg-blue-900/50 border border-blue-700 text-white text-sm rounded-full px-4 py-2 w-40 focus:w-60 focus:bg-white focus:text-gray-900 transition-all outline-none">
                        <button type="submit" class="absolute right-3 top-2.5 text-blue-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </button>
                    </form>
                </div>

                <button id="btn-hamburger" class="lg:hidden p-2 rounded-lg bg-blue-700 hover:bg-blue-600 transition outline-none">
                    <svg id="icon-bars" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                    <svg id="icon-x" class="hidden w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>
    </div>

    <div id="sidebar-mobile" class="hidden lg:hidden bg-blue-900 border-t border-blue-700 shadow-inner overflow-y-auto max-h-[calc(100vh-80px)]">
        <div class="p-4 space-y-4">
            <form action="<?= BASE_URL ?>/search" method="GET" class="relative">
                <input type="text" name="q" placeholder="<?= __('Search...') ?>" class="w-full bg-blue-800 border border-blue-600 text-white rounded-xl px-4 py-3 outline-none">
                <button type="submit" class="absolute right-4 top-3.5 text-blue-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </button>
            </form>

            <div class="flex gap-2 pb-2 border-b border-blue-800">
                <a href="<?= BASE_URL ?>/language/switch/id_ID" class="flex-1 flex items-center justify-center gap-2 p-2 rounded-lg bg-blue-800 text-xs font-bold border <?= ($current_lang == 'id_ID') ? 'border-yellow-400 text-yellow-400' : 'border-blue-700 text-blue-300' ?>">
                    ID
                </a>
                <a href="<?= BASE_URL ?>/language/switch/en_US" class="flex-1 flex items-center justify-center gap-2 p-2 rounded-lg bg-blue-800 text-xs font-bold border <?= ($current_lang == 'en_US') ? 'border-yellow-400 text-yellow-400' : 'border-blue-700 text-blue-300' ?>">
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
                           class="mobile-dropdown-btn flex justify-between items-center p-3 rounded-lg hover:bg-blue-800 font-bold transition">
                            <?= $m['nama_menu'] ?>
                            <?php if($has_child): ?>
                                <svg class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            <?php endif; ?>
                        </a>
                        
                        <?php if($has_child): ?>
                        <ul class="mobile-submenu hidden bg-blue-950/40 rounded-lg mt-1 ml-2 border-l-2 border-yellow-500 overflow-hidden">
                            <?php foreach($m['children'] as $child): 
                                $child_url_final = $pretty_url($child['url']);
                            ?>
                            <li>
                                <a href="<?= BASE_URL . '/' . ltrim($child_url_final, '/') ?>" class="block p-3 text-sm text-blue-200 hover:text-white hover:bg-blue-800 transition">
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

<script>
$(document).ready(function() {
    const $btnHamburger = $('#btn-hamburger');
    const $sidebarMobile = $('#sidebar-mobile');
    const $iconBars = $('#icon-bars');
    const $iconX = $('#icon-x');

    $btnHamburger.on('click', function() {
        $sidebarMobile.slideToggle(300).toggleClass('hidden flex flex-col');
        $iconBars.toggleClass('hidden');
        $iconX.toggleClass('hidden');
        $('body').toggleClass('overflow-hidden');
    });

    $('.mobile-dropdown-btn').on('click', function(e) {
        const $submenu = $(this).next('.mobile-submenu');
        const $arrow = $(this).find('svg');

        if ($submenu.length) {
            e.preventDefault();
            $('.mobile-submenu').not($submenu).slideUp().addClass('hidden');
            $('.mobile-dropdown-btn svg').not($arrow).removeClass('rotate-180');
            $submenu.slideToggle(300).toggleClass('hidden');
            $arrow.toggleClass('rotate-180');
        }
    });

    $(window).on('resize', function() {
        if ($(window).width() >= 1024) {
            $sidebarMobile.addClass('hidden').hide();
            $iconBars.removeClass('hidden');
            $iconX.addClass('hidden');
            $('body').removeClass('overflow-hidden');
        }
    });
});
</script>