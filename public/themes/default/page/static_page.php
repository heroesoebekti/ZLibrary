<nav class="container mx-auto px-6 pt-10">
    <ol class="flex items-center space-x-2 text-sm text-slate-400 font-medium">
        <li><a href="<?= BASE_URL ?>" class="hover:text-blue-600 transition"><?= __('Home') ?></a></li>
        <li>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </li>
        <li class="text-slate-600 truncate"><?= htmlspecialchars_decode($post['judul']) ?></li>
    </ol>
</nav>

<article class="container mx-auto px-6 py-12 max-w-4xl">
    <header class="mb-16 pb-12 border-b border-slate-100">
        <div class="inline-block px-3 py-1 rounded-md bg-blue-50 text-blue-600 font-bold uppercase tracking-[0.2em] text-[10px] mb-6">
            <?= htmlspecialchars_decode($post['kategori'] ?? __('Information')) ?>
        </div>
        
        <h1 class="text-3xl md:text-5xl font-black text-slate-900 mb-8 leading-[1.15] tracking-tight">
            <?= htmlspecialchars_decode($post['judul']) ?>
        </h1>

        <div class="flex items-center gap-4 text-slate-500">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-slate-900 flex items-center justify-center text-white shadow-lg">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                    </svg>
                </div>
                <div class="flex flex-col leading-none">
                    <span class="text-[10px] uppercase tracking-widest text-slate-400 font-bold mb-1"><?= __('Written By') ?></span>
                    <span class="text-sm font-bold text-slate-800"><?= htmlspecialchars_decode($post['author'] ?? __('Administrator')) ?></span>
                </div>
            </div>
        </div>
    </header>

    <div class="prose prose-slate prose-lg max-w-none text-slate-700 leading-relaxed 
                prose-headings:text-slate-900 prose-headings:font-bold
                prose-p:mb-6 prose-blockquote:italic prose-blockquote:text-blue-600 prose-blockquote:border-blue-500
                prose-img:rounded-2xl prose-img:shadow-xl">
        <?= $post['isi'] ?>
    </div>

    <?php if(!empty($related_posts)): ?>
    <div class="mt-24">
        <div class="flex items-center gap-4 mb-10">
            <h2 class="text-xl font-black text-slate-900 shrink-0 tracking-tight uppercase"><?= __('Read Also') ?></h2>
            <div class="h-px w-full bg-slate-100"></div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">
            <?php foreach ($related_posts as $related): ?>
                <a href="<?= BASE_URL ?>/post/<?= $related['slug'] ?>" class="group block border-l-2 border-transparent hover:border-blue-600 pl-4 transition-all">
                    <h3 class="text-base font-bold text-slate-800 line-clamp-2 group-hover:text-blue-600 transition tracking-tight">
                        <?= htmlspecialchars_decode($related['judul']) ?>
                    </h3>
                    <span class="text-[10px] font-bold text-blue-500 uppercase tracking-widest mt-2 block opacity-0 group-hover:opacity-100 transition"><?= __('Read More &rarr;') ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <footer class="mt-20 pt-8 border-t border-slate-100 flex flex-wrap justify-between items-center gap-6">
        <div class="flex items-center gap-4">
            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest"><?= __('Tags') ?></span>
            <div class="flex flex-wrap gap-2">
                <?php 
                if (!empty($post['tags'])) {
                    $tagsArray = explode(',', $post['tags']);
                    foreach ($tagsArray as $tag) {
                        $tag = trim($tag);
                        if (!empty($tag)) {
                            echo '<span class="text-[11px] font-bold text-slate-500 hover:text-blue-600 transition cursor-pointer">#' . htmlspecialchars($tag) . '</span>';
                        }
                    }
                }
                ?>
            </div>
        </div>
        
        <button onclick="window.print()" class="text-slate-400 hover:text-slate-900 transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
            </svg>
            <span class="text-[10px] font-bold uppercase tracking-tighter"><?= __('Print Page') ?></span>
        </button>
    </footer>
</article>