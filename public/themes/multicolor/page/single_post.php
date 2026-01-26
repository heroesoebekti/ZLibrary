<?php defined('INDEX_AUTH') or exit('Direct access denied.'); ?>
<nav class="container mx-auto px-6 pt-10">
    <ol class="flex items-center space-x-2 text-sm text-slate-400 dynamic-breadcrumb">
        <li><a href="<?= BASE_URL ?>" class="transition"><?= __('Home') ?></a></li>
        <li>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </li>
        <li class="text-slate-600 font-medium truncate"><?= htmlspecialchars_decode($post['judul']) ?></li>
    </ol>
</nav>

<article class="container mx-auto px-6 py-12 max-w-4xl">
    <header class="mb-12 flex flex-col md:flex-row gap-6 md:gap-10 items-start">
        <div class="w-32 h-32 md:w-48 md:h-48 shrink-0 mx-auto md:mx-0">
            <div class="relative group h-full">
                <div class="absolute -inset-1 rounded-2xl blur opacity-20 group-hover:opacity-40 transition duration-700" style="background-image: linear-gradient(to right, var(--nav-bg), var(--nav-accent));"></div>
                <div class="relative h-full rounded-2xl overflow-hidden shadow-md bg-white">
                    <?= $asset::render_image($post['gambar'], "w-full h-full object-cover transform hover:scale-110 transition duration-700") ?>
                </div>
            </div>
        </div>

        <div class="flex-1">
            <div class="inline-block px-3 py-1 rounded-md font-bold uppercase tracking-[0.2em] text-[9px] mb-3 dynamic-post-badge">
                <?= htmlspecialchars_decode($post['kategori']) ?>
            </div>
            <h1 class="text-2xl md:text-4xl font-extrabold text-slate-900 mb-4 leading-tight tracking-tight">
                <?= htmlspecialchars_decode($post['judul']) ?>
            </h1>
            <div class="flex items-center gap-4 text-slate-500 text-xs mt-4">
                <div class="flex items-center gap-2">
                    <div class="w-5 h-5 rounded-full flex items-center justify-center dynamic-post-icon">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                        </svg>
                    </div>
                    <span class="font-semibold text-slate-700"><?= htmlspecialchars_decode($post['author'] ?? __('Administrator')) ?></span>
                </div>
                <span class="text-slate-300">•</span>
                <span><?= date('d M Y', strtotime($post['tanggal_dibuat'])) ?></span>
            </div>
        </div>
    </header>

    <div class="prose prose-slate prose-lg max-w-none text-slate-700 leading-relaxed mb-16">
        <?= $post['isi'] ?>
    </div>

    <div class="mt-20">
        <div class="flex items-center gap-4 mb-8">
            <h2 class="text-xl font-bold text-slate-900 shrink-0"><?= __('Related News') ?></h2>
            <div class="h-[1px] w-full bg-slate-100"></div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <?php foreach ($related_posts as $related): ?>
                <a href="<?= BASE_URL ?>/post/<?= $related['slug'] ?>" class="group flex items-center gap-4 p-3 rounded-2xl hover:bg-slate-50 transition border border-transparent hover:border-slate-100">
                    <div class="w-20 h-20 shrink-0 rounded-xl overflow-hidden bg-slate-100">
                        <?= $asset::render_image($related['gambar'], "w-full h-full object-cover group-hover:scale-110 transition duration-500") ?>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-800 line-clamp-2 transition dynamic-post-title-link"><?= htmlspecialchars_decode($related['judul']) ?></h3>
                        <span class="text-[10px] text-slate-400 block mt-1"><?= date('d M Y', strtotime($related['tanggal_dibuat'])) ?></span>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <footer class="mt-16 pt-8 border-t border-slate-100 flex flex-wrap justify-between items-center gap-6">
        <div class="flex items-center gap-3">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest"><?= __('Tags:') ?></span>
            <div class="flex flex-wrap gap-2">
                <?php 
                if (!empty($post['tags'])) {
                    $tagsArray = explode(',', $post['tags']);
                    foreach ($tagsArray as $tag) {
                        $tag = trim($tag);
                        if (!empty($tag)) {
                            echo '<span class="text-[10px] bg-slate-100 px-3 py-1 rounded-full text-slate-600 transition cursor-pointer dynamic-tag">#' . htmlspecialchars_decode($tag) . '</span>';
                        }
                    }
                } else {
                    echo '<span class="text-xs text-slate-400 italic">' . __('No tags available') . '</span>';
                }
                ?>
            </div>
        </div>
        
        <div class="flex items-center gap-2">
            <button onclick="window.print()" class="flex items-center gap-2 px-4 py-2 rounded-full bg-slate-50 text-slate-500 hover:bg-slate-900 hover:text-white transition text-[10px] font-bold uppercase tracking-wider">
                <?= __('Print Article') ?>
            </button>
        </div>
    </footer>
</article>