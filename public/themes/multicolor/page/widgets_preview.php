<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Preview Layout' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .widget-placeholder {
            background-image: radial-gradient(#e2e8f0 1px, transparent 1px);
            background-size: 20px 20px;
        }
    </style>
</head>
<body class="bg-white">

    <div class="fixed top-0 left-0 w-full bg-slate-900 text-white text-center py-2 text-[10px] font-bold uppercase tracking-[0.2em] z-[9999] shadow-lg">
        <span class="opacity-50"><?= __('Preview Mode') ?></span> — <?= __('Changes not yet published') ?>
    </div>

    <div class="pt-12 pb-20">
        <?php if (isset($layout) && is_array($layout)): ?>
            <?php foreach ($layout as $block): ?>
                <?php if (isset($block['type']) && $block['type'] === 'block'): ?>
                    
                    <section class="w-full py-8 border-b border-slate-50">
                        <div class="container mx-auto px-4">
                            <?php 
                            // Logika Grid CSS
                            $gridClass = 'grid gap-6 ';
                            $lt = $block['layout'] ?? 'full';
                            switch ($lt) {
                                case 'full':    $gridClass .= 'grid-cols-1'; break;
                                case '2-col':   $gridClass .= 'grid-cols-1 md:grid-cols-2'; break;
                                case '3-col':   $gridClass .= 'grid-cols-1 md:grid-cols-3'; break;
                                case '4-col':   $gridClass .= 'grid-cols-1 md:grid-cols-2 lg:grid-cols-4'; break;
                                case '1-2-col': $gridClass .= 'grid-cols-12'; break;
                                case '2-1-col': $gridClass .= 'grid-cols-12'; break;
                                default:        $gridClass .= 'grid-cols-1';
                            }
                            ?>

                            <div class="<?= $gridClass ?>">
                                <?php if (isset($block['columns']) && is_array($block['columns'])): ?>
                                    <?php foreach ($block['columns'] as $pos => $widgets): ?>
                                        <?php 
                                        // Logika Column Span
                                        $colSpan = '';
                                        if ($lt === '1-2-col') {
                                            $colSpan = ($pos === 'c1') ? 'col-span-12 md:col-span-4' : 'col-span-12 md:col-span-8';
                                        } elseif ($lt === '2-1-col') {
                                            $colSpan = ($pos === 'c1') ? 'col-span-12 md:col-span-8' : 'col-span-12 md:col-span-4';
                                        }
                                        ?>

                                        <div class="<?= $colSpan ?> space-y-6">
                                            <?php if (is_array($widgets) && count($widgets) > 0): ?>
                                                <?php foreach ($widgets as $w): ?>
                                                    
                                                    <div class="group relative bg-white border border-slate-200 rounded-3xl p-8 shadow-sm hover:shadow-md transition-all duration-300 min-h-[150px] flex flex-col justify-center items-center text-center overflow-hidden widget-placeholder">
                                                        <div class="absolute top-0 right-0 bg-slate-100 text-slate-400 px-3 py-1 rounded-bl-xl text-[9px] font-black tracking-widest uppercase">
                                                            <?= htmlspecialchars($w['id']) ?>
                                                        </div>
                                                        
                                                        <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                                            </svg>
                                                        </div>
                                                        
                                                        <h4 class="text-slate-800 font-bold text-sm uppercase tracking-tight">
                                                            Widget Component
                                                        </h4>
                                                        <p class="text-slate-400 text-xs mt-1">
                                                            ID: <?= htmlspecialchars($w['id']) ?>
                                                        </p>

                                                        <?php 
                                                            // include BASE_PATH . '/widgets/' . $w['id'] . '.php'; 
                                                        ?>
                                                    </div>

                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <div class="h-24 border-2 border-dashed border-slate-100 rounded-3xl flex items-center justify-center">
                                                    <span class="text-[10px] text-slate-300 font-bold uppercase tracking-widest">Empty Column</span>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </section>

                <?php endif; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="flex flex-col items-center justify-center min-h-[60vh] text-center">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-slate-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <h3 class="text-slate-400 font-bold uppercase text-xs tracking-widest"><?= __('No layout data to preview.') ?></h3>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>