<main class="container mx-auto px-4 py-12">
    <div class="max-w-5xl mx-auto">
        
        <div class="grid grid-cols-1 gap-8">
            <?php if (!empty($posts) && count($posts) > 0): ?>
                
                <?php foreach($posts as $p): ?>
                <article class="flex flex-wrap md:flex-nowrap bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">
                    <div class="w-full md:w-64 h-48 flex-shrink-0 bg-gray-50 border-r border-gray-50">
                        <?= $asset::render_image($p['gambar'], "w-full h-full object-cover") ?>
                    </div>

                    <div class="p-6 flex flex-col justify-between flex-1">
                        <div>
                            <div class="flex items-center gap-3 mb-2">
                                <span class="text-xs font-bold px-2 py-1 rounded bg-blue-100 text-blue-700 uppercase">
                                    <?= strip_tags($p['kategori']); ?>
                                </span>
                                <span class="text-xs text-gray-400">
                                    <?= date('d M Y', strtotime($p['tanggal_dibuat'])); ?>
                                </span>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800 hover:text-blue-600 mb-3">
                                <a href="<?= BASE_URL ?>/post/<?= strip_tags($p['slug']); ?>">
                                    <?= strip_tags($p['judul']); ?>
                                </a>
                            </h2>
                            <p class="text-gray-600 line-clamp-2">
                                <?= mb_strimwidth(strip_tags($p['isi']), 0, 160, "..."); ?>
                            </p>
                        </div>
                        
                        <div class="mt-4">
                            <a href="<?= BASE_URL ?>/post/<?= strip_tags($p['slug']); ?>" class="text-blue-600 font-bold inline-flex items-center group">
                                Baca Selengkapnya
                                <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>

            <?php else: ?>
                <div class="text-center py-20">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                        </svg>
                    </div>
                    <p class="text-gray-500 italic text-xl">Belum ada konten yang tersedia.</p>
                    <a href="<?= BASE_URL ?>" class="mt-4 inline-block text-blue-600 hover:underline">Kembali ke Beranda</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>