<?php
$layoutBlocks = (isset($savedLayout) && is_array($savedLayout)) ? $savedLayout : [];
$allVars = get_defined_vars();

if (!function_exists('renderLayoutRecursive')) {
    function renderLayoutRecursive($items, $model, $context = [], $isNested = false) {
        if (!is_array($items) || empty($items)) return;

        foreach ($items as $item) {
            if (isset($item['type']) && $item['type'] === 'block') {
                $lt = $item['layout'] ?? 'full';
                $gridCols = 'grid-cols-12';

                echo (!$isNested) ? '<section class="w-full py-12 md:py-20"><div class="container mx-auto px-6 md:px-12">' : '<div class="w-full my-8">';
                echo '<div class="grid grid-cols-12 gap-y-12 lg:gap-x-16 lg:gap-y-0">';

                if (isset($item['columns']) && is_array($item['columns'])) {
                    foreach ($item['columns'] as $pos => $children) {
                        $span = 'col-span-12';
                        $isSidebar = false;
                        if ($lt === '3-1-col') {
                            $span = ($pos === 'c1') ? 'lg:col-span-9' : 'lg:col-span-3';
                            if ($pos === 'c2') $isSidebar = true;
                        } elseif ($lt === '1-3-col') {
                            $span = ($pos === 'c1') ? 'lg:col-span-3' : 'lg:col-span-9';
                            if ($pos === 'c1') $isSidebar = true;
                        } elseif ($lt === '2-1-col') {
                            $span = ($pos === 'c1') ? 'lg:col-span-8' : 'lg:col-span-4';
                            if ($pos === 'c2') $isSidebar = true;
                        } elseif ($lt === '1-2-col') {
                            $span = ($pos === 'c1') ? 'lg:col-span-4' : 'lg:col-span-8';
                            if ($pos === 'c1') $isSidebar = true;
                        } elseif ($lt === '2-col') {
                            $span = 'lg:col-span-6';
                        } elseif ($lt === '3-col') {
                            $span = 'lg:col-span-4';
                        } elseif ($lt === '4-col') {
                            $span = 'md:col-span-6 lg:col-span-3';
                        }

                        if ($isSidebar) {
                            echo '<aside class="' . $span . ' col-span-12">';
                            echo '<div class="lg:sticky lg:top-28 space-y-10">';
                            renderLayoutRecursive($children, $model, $context, true);
                            echo '</div>';
                            echo '</aside>';
                        } else {
                            echo '<div class="' . $span . ' col-span-12 flex flex-col gap-10">';
                            renderLayoutRecursive($children, $model, $context, true);
                            echo '</div>';
                        }
                    }
                }
                echo '</div>';
                echo (!$isNested) ? '</div></section>' : '</div>';
            } 
            elseif (isset($item['type']) && $item['type'] === 'widget') {
                $w_id = (int)$item['id'];
                $is_ins = (isset($item['is_instance']) && ($item['is_instance'] === 'true' || $item['is_instance'] === true));
                
                if ($model) {
                    $widget_info = $model->getWidgetContent($w_id, $is_ins);
                    if ($widget_info) {
                        $w_type = $item['widget_type'] ?? 'custom_widget'; 
                        $file = BASE_PATH . "/widgets/" . $w_type . ".php";
                        
                        echo '<div class="widget-item w-full">';
                        if (file_exists($file)) {
                            extract($context, EXTR_SKIP);
                            $data = $widget_info; 
                            include $file; 
                        } else {
                            echo '<div class="bg-white p-8 rounded-[1.5rem] border border-slate-100 shadow-sm">';
                            if (!empty($widget_info['title'])) {
                                echo '<h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-6 flex items-center gap-2">';
                                echo '<span class="w-1.5 h-4 bg-blue-500 rounded-full"></span>' . htmlspecialchars($widget_info['title']) . '</h3>';
                            }
                            echo '<div class="prose max-w-none text-slate-600">' . $widget_info['content'] . '</div>';
                            echo '</div>';
                        }
                        echo '</div>';
                    }
                }
            }
        }
    }
}
?>

<section class="relative bg-slate-900 py-28 md:py-40 overflow-hidden banner">
    <div class="absolute inset-0 z-0">
        <?php $hero_img = defined('SITE_HERO') ? SITE_HERO : 'default-hero.jpg'; ?>
        <img src="<?= BASE_URL ?>/assets/img/default/<?= $hero_img ?>?auto=format&fit=crop&q=80&w=2000" 
             class="w-full h-full object-cover opacity-30" alt="Hero Background">
        <div class="absolute inset-0 bg-gradient-to-r from-slate-900 via-slate-900/80 to-transparent"></div>
    </div>
    <div class="container mx-auto px-6 md:px-12 relative z-10">
        <div class="max-w-4xl">
            <h1 class="text-5xl md:text-7xl font-extrabold text-white mb-6 leading-[1.1] tracking-tight">
                <?= defined('SITE_TAGLINE_MAIN') ? SITE_TAGLINE_MAIN : __('Welcome') ?> <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-300">
                    <?= defined('SITE_TAGLINE_SUBMAIN') ? SITE_TAGLINE_SUBMAIN : '' ?>
                </span>
            </h1>
            <p class="text-lg md:text-xl text-slate-300 max-w-2xl font-light">
                <?= defined('SITE_DESCRIPTION') ? SITE_DESCRIPTION : '' ?>
            </p>
        </div>
    </div>
</section>

<main id="dynamic-widgets" class="bg-white">
    <?php 
    if (!empty($layoutBlocks)) {
        renderLayoutRecursive($layoutBlocks, $widgetModel ?? null, $allVars);
    } else {
        echo '<div class="py-20 text-center text-slate-400">No layout configured.</div>';
    }
    ?>
</main>