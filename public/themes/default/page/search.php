<section class="relative bg-slate-900 py-16 overflow-hidden">
    <div class="absolute top-0 right-0 -translate-y-12 translate-x-12 w-64 h-64 bg-blue-500/10 rounded-full blur-3xl"></div>
    
    <div class="container mx-auto px-6 relative z-10">
        <nav class="flex mb-4 text-sm text-slate-400 gap-2 items-center">
            <a href="<?= BASE_URL ?>" class="hover:text-white transition"><?= __('Home') ?></a>
            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"></path></svg>
            <span><?= __('Search') ?></span>
        </nav>
        <h1 class="text-3xl md:text-4xl font-extrabold text-white">
            <?= __('Search Results:') ?> <span class="text-yellow-400">"<?= strip_tags($keyword) ?>"</span>
        </h1>
        <p class="text-slate-400 mt-2 flex items-center gap-2">
            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            <?= sprintf(__('Found %d relevant content'), count($results ?? [])) ?>
        </p>
    </div>
</section>

<main class="container mx-auto px-6 py-12">
    <div class="max-w-4xl mx-auto">
        <?php if (!empty($results) && is_array($results)): ?>
            <div class="grid gap-6">
                <?php foreach($results as $row): ?>
                    <article class="group bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-xl hover:border-blue-300 transition-all duration-300">
                        <div class="flex items-center gap-3 mb-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold tracking-wide uppercase 
                                <?= $row['category'] == 'berita' ? 'bg-emerald-100 text-emerald-700' : ($row['category'] == 'artikel' ? 'bg-yellow-100 text-red-700' : 'bg-blue-100 text-blue-700') ?>">
                                <?= $row['category']?>
                            </span>
                        </div>
                        
                        <h2 class="text-2xl font-bold text-slate-900 group-hover:text-blue-600 transition">
                            <a href="<?= BASE_URL ?>/<?= $row['tipe'] ?>/<?= $row['slug'] ?>">
                                <?= strip_tags($row['judul']) ?>
                            </a>
                        </h2>
                        
                        <p class="text-slate-600 text-sm mt-3 line-clamp-2 leading-relaxed">
                            <?= substr(strip_tags($row['isi']), 0, 160) ?>...
                        </p>

                        <div class="mt-5 pt-4 border-t border-slate-50 flex items-center justify-between">
                            <a href="<?= BASE_URL ?>/<?= $row['tipe'] ?>/<?= $row['slug'] ?>" class="inline-flex items-center gap-2 text-sm font-bold text-blue-600 group/link">
                                <?= __('Read More') ?>
                                <svg class="w-4 h-4 transform group-hover/link:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-20 bg-slate-50 rounded-3xl border-2 border-dashed border-slate-200">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-slate-100 rounded-full mb-6 text-slate-300">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800"><?= __('No results found') ?></h3>
                <p class="text-slate-500 mt-2 max-w-sm mx-auto">
                    <?= sprintf(__('We couldn\'t find any matches for "%s".'), strip_tags($keyword)) ?>
                </p>
                <div class="mt-8">
                    <a href="<?= BASE_URL ?>" class="px-8 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-200 transition">
                        <?= __('Back to Home') ?>
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>