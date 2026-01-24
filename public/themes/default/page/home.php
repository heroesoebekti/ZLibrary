<?php
$layoutBlocks = (isset($savedLayout) && is_array($savedLayout)) ? $savedLayout : [];
$allVars = get_defined_vars();

if (!function_exists('renderLayoutRecursive')) {
    function renderLayoutRecursive($items, $model, $context = [], $isNested = false) {
        if (!is_array($items) || empty($items)) return;

        foreach ($items as $item) {
            if (isset($item['type']) && $item['type'] === 'block') {
                $lt = $item['layout'] ?? 'full';
                $gridCols = 'grid-cols-1';

                switch($lt) {
                    case '2-col':   $gridCols = 'grid-cols-1 md:grid-cols-2'; break;
                    case '3-col':   $gridCols = 'grid-cols-1 md:grid-cols-3'; break;
                    case '4-col':   $gridCols = 'grid-cols-1 md:grid-cols-2 lg:grid-cols-4'; break;
                    case '1-2-col': 
                    case '2-1-col': $gridCols = 'grid-cols-12'; break;
                    default:        $gridCols = 'grid-cols-1'; break;
                }

                echo (!$isNested) ? '<section class="w-full py-10"><div class="container mx-auto px-6">' : '<div class="w-full my-4">';
                echo '<div class="grid ' . $gridCols . ' gap-8 lg:gap-12">';

                if (isset($item['columns']) && is_array($item['columns'])) {
                    foreach ($item['columns'] as $pos => $children) {
                        $span = 'col-span-12';
                        if ($lt === '1-2-col') {
                            $span = ($pos === 'c1') ? 'lg:col-span-3' : 'lg:col-span-9';
                        } elseif ($lt === '2-1-col') {
                            $span = ($pos === 'c1') ? 'lg:col-span-9' : 'lg:col-span-3';
                        } elseif ($lt === 'full') {
                            $span = 'col-span-12';
                        } else {
                            $span = 'md:col-span-1';
                        }

                        echo '<div class="' . $span . ' flex flex-col gap-6">';
                        renderLayoutRecursive($children, $model, $context, true);
                        echo '</div>';
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
                            echo '<div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">';
                            if (!empty($widget_info['title'])) {
                                echo '<h3 class="text-xl font-bold mb-4 text-slate-800">' . htmlspecialchars($widget_info['title']) . '</h3>';
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

<section class="relative bg-slate-900 py-28 md:py-44 overflow-hidden banner">
    <div class="absolute inset-0 z-0">
        <?php $hero_img = defined('SITE_HERO') ? SITE_HERO : 'default-hero.jpg'; ?>
        <img src="<?= BASE_URL ?>/assets/img/default/<?= $hero_img ?>?auto=format&fit=crop&q=80&w=2000" 
             class="w-full h-full object-cover opacity-40" alt="<?= __('Hero Background') ?>">
        <div class="absolute inset-0 bg-gradient-to-r from-slate-900 via-slate-900/80 to-transparent"></div>
    </div>

    <div class="absolute top-0 right-0 w-1/3 h-full bg-blue-600/20 blur-[120px] rounded-full z-1"></div>

    <div class="container mx-auto px-6 relative z-10">
        <div class="max-w-4xl">
            <div class="inline-flex items-center gap-3 px-4 py-2 bg-blue-500/10 border border-blue-400/20 backdrop-blur-md rounded-full mb-8">
                <span class="w-2 h-2 bg-blue-400 rounded-full animate-pulse"></span>
                <span class="text-xs font-bold text-blue-400 tracking-widest uppercase">NPP: <?= defined('SITE_NPP') ? SITE_NPP : '-' ?></span>
            </div>
            
            <h1 class="text-5xl md:text-7xl font-extrabold text-white mb-6 leading-[1.1] tracking-tight">
                <?= defined('SITE_TAGLINE_MAIN') ? SITE_TAGLINE_MAIN : __('Welcome') ?> <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-300">
                    <?= defined('SITE_TAGLINE_SUBMAIN') ? SITE_TAGLINE_SUBMAIN : '' ?>
                </span>
            </h1>
            
            <p class="text-lg md:text-xl text-slate-300 mb-10 leading-relaxed max-w-2xl font-light">
                <?= defined('SITE_DESCRIPTION') ? SITE_DESCRIPTION : '' ?>
            </p>
        </div>
    </div>
</section>

<main id="dynamic-widgets" class="pb-24 -mt-10 relative z-20">
    <?php 
    if (!empty($layoutBlocks)) {
        renderLayoutRecursive($layoutBlocks, $widgetModel ?? null, $allVars);
    } else {
        echo '<div class="container mx-auto px-6">';
        echo '  <div class="py-20 text-center bg-white rounded-3xl shadow-sm border-2 border-dashed border-slate-200">';
        echo '      <p class="text-slate-400 font-medium">' . __("No widgets configured yet.") . '</p>';
        echo '      <p class="text-slate-300 text-sm mt-2">' . __("Please configure layout in Admin Panel.") . '</p>';
        echo '  </div>';
        echo '</div>';
    }
    ?>
</main>