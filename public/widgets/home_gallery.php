<?php
/**
 * Widget Name: Gallery Kegiatan
 */

$display_title = $widget_data['widget_name'] ?? 'Gallery Kegiatan';
?>

<section class="bg-slate-50 border-t border-slate-100">
    <div class="container mx-auto px-6">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <span class="text-blue-600 font-bold text-xs uppercase tracking-[0.3em]">Visual Story</span>
            <h2 class="text-4xl font-extrabold text-slate-900 mt-3 mb-4">
                <?= htmlspecialchars($display_title ?? '', ENT_QUOTES, 'UTF-8') ?>
            </h2>
            <p class="text-slate-500 font-light">Momen-momen berharga dalam upaya meningkatkan literasi dan kolaborasi akademik.</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <?php if (!empty($galleries) && is_array($galleries)): ?>
                <?php foreach($galleries as $g): 
                    // Logika penentuan ukuran kotak berdasarkan data database
                    $tipe = $g['tipe_layout'] ?? 'standard';
                    $class_box = "aspect-square"; // default
                    
                    if ($tipe == 'large') {
                        $class_box = "col-span-2 row-span-2 aspect-square md:aspect-auto";
                    } elseif ($tipe == 'wide') {
                        $class_box = "col-span-2 h-48 md:h-64";
                    }
                ?>
                <div class="group relative overflow-hidden rounded-3xl shadow-lg <?= $class_box ?>">
                    <img src="<?= BASE_URL ?>/assets/img/gallery/<?= $g['gambar'] ?>" 
                         class="w-full h-full object-cover group-hover:scale-110 transition duration-700"
                         alt="<?= htmlspecialchars($g['judul'] ?? 'Gallery Image') ?>">
                    
                    <div class="absolute inset-0 bg-slate-900/60 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex flex-col justify-center items-center text-white p-4 text-center">
                        <?php if(!empty($g['kategori'])): ?>
                            <span class="bg-white/20 px-3 py-1 rounded-full text-[10px] mb-2 backdrop-blur-md uppercase tracking-widest">
                                <?= htmlspecialchars($g['kategori']) ?>
                            </span>
                        <?php endif; ?>
                        <h4 class="text-sm md:text-lg font-bold"><?= htmlspecialchars($g['judul'] ?? '') ?></h4>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-span-full py-20 text-center border-2 border-dashed border-slate-200 rounded-3xl">
                    <p class="text-slate-400">Belum ada foto gallery untuk ditampilkan.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>