<?php 
defined('INDEX_AUTH') or exit('Direct access denied.');
$current_page = $current_page ?? 'dashboard'; ?>
<aside class="w-72 flex-shrink-0 border-r border-slate-200">
    <div class="h-full flex flex-col p-6 bg-white">
        <div class="mb-10 px-2 flex items-center gap-3">
            <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-100 text-white">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
            <h2 class="text-slate-900 font-extrabold text-lg tracking-tight uppercase">ZLibrary CMS</h2>
            <p class="text-[10px] text-blue-500 font-bold uppercase tracking-tighter">v1.0 Stable</p>
        </div>

        <nav class="flex-1 space-y-2 overflow-y-auto">
            <p class="px-4 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-4"><?= __('Main Menu') ?></p>
            
            <a href="<?=BASE_URL?>/admin/dashboard" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all <?= ($current_page == 'dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-500 hover:bg-slate-50' ?>">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <?= __('Dashboard') ?>
            </a>

            <div class="pt-6 pb-2 px-4 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest"><?= __('Content') ?></div>
            
            <a href="<?=BASE_URL?>/admin/post" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all <?= (strpos($current_page, 'post') !== false) ? 'bg-indigo-50 text-indigo-700' : 'text-slate-500 hover:bg-slate-50' ?>">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v12a2 2 0 01-2 2z"/></svg>
                <?= __('News & Articles') ?>
            </a>
            
            <a href="<?=BASE_URL?>/admin/gallery" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all <?= ($current_page == 'gallery') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-500 hover:bg-slate-50' ?>">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <?= __('Photo Gallery') ?>
            </a>

            <?php if ($_SESSION['role'] == 'admin'): ?>
            <div class="pt-6 pb-2 px-4 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest"><?= __('Admin System') ?></div>
            
            <a href="<?=BASE_URL?>/admin/page" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all <?= ($current_page == 'page' || $current_page == 'Manage Pages') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-500 hover:bg-slate-50' ?>">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <?= __('Static Pages') ?>
            </a>
            
            <a href="<?=BASE_URL?>/admin/navbar" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all <?= ($current_page == 'navbar' || $current_page == 'Manage Navbar') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-500 hover:bg-slate-50' ?>">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
                <?= __('Navigation Menu') ?>
            </a>
            
            <a href="<?=BASE_URL?>/admin/user" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all <?= ($current_page == 'user' || $current_page == 'Manage Users') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-500 hover:bg-slate-50' ?>">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                <?= __('User Management') ?>
            </a>

            <a href="<?=BASE_URL?>/admin/widget" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all <?= ($current_page == 'widget' || $current_page == 'Manage Layout Widgets') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-500 hover:bg-slate-50' ?>">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h4a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM14 5a1 1 0 011-1h4a1 1 0 011 1v10a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM14 17a1 1 0 011-1h4a1 1 0 011 1v2a1 1 0 01-1 1h-4a1 1 0 01-1-1v-2z" />
                </svg>
                <?= __('Home Widgets') ?>
            </a>
            <a href="<?=BASE_URL?>/admin/setting" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all <?= ($current_page == 'setting' || $current_page == 'Site Settings') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-500 hover:bg-slate-50' ?>">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <?= __('Site Settings') ?>
            </a>
            <?php endif; ?>
        </nav>

        <div class="mt-auto pt-6 border-t border-slate-100">
            <a href="<?=BASE_URL?>/admin/logout" class="flex items-center justify-center gap-2 px-4 py-4 bg-red-50 text-red-600 rounded-2xl font-bold text-xs uppercase hover:bg-red-600 hover:text-white transition-all">
                <?= __('Log Out') ?>
            </a>
        </div>
    </div>
</aside>

<div class="flex-1 flex flex-col min-w-0">
    <header class="h-20 bg-white border-b border-slate-200 px-10 flex items-center justify-between sticky top-0 z-40">
        <div>
            <h1 class="text-[11px] font-bold uppercase tracking-[0.15em] text-slate-400"><?= __('Page') ?></h1>
            <p class="text-base font-bold text-slate-800 capitalize"><?= __(str_replace('_', ' ', $current_page)) ?></p>
        </div>
        <div class="flex items-center gap-4">
            <div class="text-right">
                <p class="text-sm font-semibold text-slate-900 leading-tight"><?= $_SESSION['admin_name'] ?></p>
                <span class="text-[10px] font-bold text-indigo-600 uppercase bg-indigo-50 px-2 py-0.5 rounded"><?= __($_SESSION['role']) ?></span>
            </div>
            <div class="w-11 h-11 bg-slate-100 rounded-lg flex items-center justify-center border border-slate-200 overflow-hidden">
                <?php if(!empty($_SESSION['admin_foto'])): ?>
                    <img src="<?= BASE_URL ?>/assets/img/users/<?= $_SESSION['admin_foto'] ?>" class="w-full h-full object-cover">
                <?php else: ?>
                    <svg class="w-6 h-6 text-slate-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <?php
    $checks = [
        'assets/img' => 'Gallery Storage',
        'assets/cache/widgets' => 'Widget Cache'
    ];
    $activeErrors = [];
    foreach ($checks as $path => $label) {
        if (!is_dir($path)) {
            $activeErrors[] = "<strong>$label:</strong> Folder tidak ditemukan ($path)";
        } elseif (!is_writable($path)) {
            $activeErrors[] = "<strong>$label:</strong> Folder tidak bisa ditulisi/read-only ($path)";
        }
    }
    ?>

    <?php if (!empty($activeErrors)): ?>
    <div class="bg-rose-50 border-b border-rose-100 px-10 py-4 flex items-center gap-4 animate-in fade-in slide-in-from-top duration-300">
        <div class="w-10 h-10 bg-rose-500 rounded-xl flex items-center justify-center shadow-lg shadow-rose-100 text-white flex-shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>
        <div class="flex-1">
            <h4 class="text-[10px] font-black text-rose-800 uppercase tracking-widest mb-1"><?= __('Directory Permission Alert') ?></h4>
            <div class="flex gap-x-6 gap-y-1 flex-wrap">
                <?php foreach ($activeErrors as $error): ?>
                <p class="text-[11px] text-rose-600 font-medium flex items-center gap-2">
                    <span class="w-1 h-1 bg-rose-400 rounded-full"></span> <?= $error ?>
                </p>
                <?php endforeach; ?>
            </div>
        </div>
        <button onclick="this.parentElement.remove()" class="p-2 text-rose-300 hover:text-rose-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>
    <?php endif; ?>

    <main class="flex-1 overflow-y-auto p-10">
        <div class="max-w-6xl mx-auto">