<section class="bg-[#0f172a] text-white py-12 md:py-20 border-b border-white/5 font-smooth">
    <div class="container mx-auto px-6">
        <div id="dynamic-footer-content" class="prose-invert">
            <?php 
            $footerLayout = $savedFooterLayout; 
            $allVars = get_defined_vars();

            if (!function_exists('renderLayoutFooterRecursive')) {
                function renderLayoutFooterRecursive($items, $model, $context = []) {
                    if (!is_array($items) || empty($items)) return;

                    foreach ($items as $item) {
                        if (isset($item['type']) && $item['type'] === 'block') {
                            $lt = $item['layout'] ?? 'full';
                            echo '<div class="grid grid-cols-1 md:grid-cols-12 gap-y-10 md:gap-x-12 mb-12">';

                            if (isset($item['columns']) && is_array($item['columns'])) {
                                foreach ($item['columns'] as $pos => $children) {
                                    $span = 'md:col-span-12'; 
                                    if ($lt === '2-col') { 
                                        $span = 'md:col-span-6'; 
                                    } elseif ($lt === '3-col') { 
                                        $span = 'md:col-span-4'; 
                                    } elseif ($lt === '4-col') { 
                                        $span = 'md:col-span-6 lg:col-span-3'; 
                                    } elseif ($lt === '1-2-col') { 
                                        $span = ($pos === 'c1') ? 'md:col-span-4' : 'md:col-span-8'; 
                                    } elseif ($lt === '2-1-col') { 
                                        $span = ($pos === 'c1') ? 'md:col-span-8' : 'md:col-span-4'; 
                                    }

                                    echo '<div class="' . $span . ' flex flex-col gap-6">';
                                    renderLayoutFooterRecursive($children, $model, $context);
                                    echo '</div>';
                                }
                            }
                            echo '</div>';
                        } elseif (isset($item['type']) && $item['type'] === 'widget') {
                            if (isset($model)) {
                                $is_inst = (isset($item['is_instance']) && ($item['is_instance'] === 'true' || $item['is_instance'] === true || $item['is_instance'] == 1));
                                $widget_info = $model->getWidgetContent((int)$item['id'], $is_inst);

                                if ($widget_info) {
                                    $w_type = $item['widget_type'] ?? 'custom_widget'; 
                                    $file = BASE_PATH . "/widgets/" . $w_type . ".php";
                                    
                                    echo '<div class="widget-item w-full">';
                                    if (file_exists($file)) {
                                        extract($context, EXTR_SKIP);
                                        $data = $widget_info; 
                                        include $file; 
                                    } else {
                                        if (($widget_info['show_title'] ?? '1') == '1') {
                                            echo '<h4 class="text-sm font-black text-blue-400 uppercase tracking-[0.2em] mb-4 flex items-center gap-2">';
                                            echo '<span class="w-1.5 h-1.5 bg-blue-500 rounded-full"></span>' . htmlspecialchars($widget_info['title']) . '</h4>';
                                        }
                                        echo '<div class="text-slate-400 text-sm leading-relaxed">' . $widget_info['content'] . '</div>';
                                    }
                                    echo '</div>';
                                }
                            }
                        }
                    }
                }
            }

            if (is_array($footerLayout) && !empty($footerLayout)) {
                renderLayoutFooterRecursive($footerLayout, $widgetModel, $allVars);
            }
            ?>
        </div>
    </div>
</section>

<footer class="bg-[#0b1120] py-8 border-t border-white/[0.02]">
    <div class="container mx-auto px-6">
        <div class="flex flex-col md:flex-row justify-between items-center gap-8">
            <div class="flex flex-col md:flex-row items-center gap-2 md:gap-4 text-[11px] font-medium">
                <span class="text-slate-500 text-center">
                    &copy; <?= date('Y') ?> <span class="text-slate-300 font-bold"><?= SITE_TITLE .' '.SITE_SUBTITLE ?></span>
                </span>
                <span class="hidden md:block w-px h-3 bg-slate-800"></span>
                <span class="text-slate-500 italic">
                    <?= __('Powered by') ?> 
                    <span onclick="openLegal('tagline')" class="text-blue-500/80 font-bold not-italic cursor-pointer hover:text-blue-400"> 
                        ZLibrary CMS
                    </span>
                </span>
            </div>

            <div class="flex flex-wrap justify-center items-center gap-x-6 gap-y-3">
                <button onclick="openLegal('privasi')" class="text-[10px] font-bold text-slate-500 hover:text-yellow-500 uppercase tracking-widest transition-colors"><?= __('Privacy') ?></button>
                <button onclick="openLegal('ketentuan')" class="text-[10px] font-bold text-slate-500 hover:text-yellow-500 uppercase tracking-widest transition-colors"><?= __('Terms') ?></button>
                <button onclick="openLegal('bantuan')" class="text-[10px] font-bold text-slate-500 hover:text-yellow-500 uppercase tracking-widest transition-colors"><?= __('Help') ?></button>
            </div>
        </div>
    </div>
</footer>

    <div id="modal-legal" class="fixed inset-0 hidden items-center justify-center bg-slate-950/80 backdrop-blur-sm p-4 transition-all duration-300" style="z-index: 99999 !important;">
        <div id="modal-content" class="bg-white w-full max-w-2xl rounded-2xl shadow-2xl overflow-hidden transform transition-all duration-300 scale-95 opacity-0">
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                <h3 id="modal-title" class="text-lg font-bold text-slate-800"></h3>
                <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div id="modal-body" class="px-6 py-8 max-h-[70vh] overflow-y-auto text-slate-600 leading-relaxed text-sm"></div>
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end">
                <button onclick="closeModal()" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl transition-all shadow-lg shadow-blue-500/20">
                    <?= __('Close') ?>
                </button>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        const $modal = $('#modal-legal');
        const $content = $('#modal-content');
        $('body').prepend($modal);

        const legalData = {
            privasi: {
                title: "<?= __('Privacy Policy') ?>",
                content: `
                    <p class="mb-4"><?= __('We deeply value your privacy. Here is a summary of our policy:') ?></p>
                    <ul class="list-disc pl-5 space-y-2">
                        <li><strong><?= __('Visit Data:') ?></strong> <?= __('We record statistical visit data to improve library services.') ?></li>
                        <li><strong><?= __('Account Data:') ?></strong> <?= __('Your login data is securely encrypted and not shared with any third party.') ?></li>
                        <li><strong><?= __('Storage:') ?></strong> <?= __('We use the latest security standards on the ZLibrary system to prevent illegal access.') ?></li>
                    </ul>`
            },
            ketentuan: {
                title: "<?= __('Terms & Conditions') ?>",
                content: `
                    <p class="mb-4 text-justify"><?= __('By using this website, you agree to the following rules:') ?></p>
                    <ol class="list-decimal pl-5 space-y-2">
                        <li><?= sprintf(__('This website is used solely for the academic interests of %s %s'), SITE_TITLE, SITE_SUBTITLE) ?></li>
                        <li><?= __('Any actions that damage the system (hacking, spamming, or data scraping) are prohibited.') ?></li>
                        <li><?= sprintf(__('All content on this website is protected by copyright owned by %s %s'), SITE_TITLE, SITE_SUBTITLE) ?></li>
                    </ol>`
            },
            bantuan: {
                title: "<?= __('Help Center') ?>",
                content: `
                    <div class="space-y-4">
                        <div class="p-4 bg-blue-50 border-l-4 border-blue-500 rounded-r-lg text-blue-800">
                            <strong><?= __('Need technical help?') ?></strong> <?= __('Contact our IT Support team via email:') ?> <strong><?= CONTACT_EMAIL ?></strong>
                        </div>
                        <p><strong><?= __('Short FAQ:') ?></strong></p>
                        <details class="cursor-pointer mb-2 group">
                            <summary class="font-bold border-b border-slate-100 py-2 group-hover:text-blue-600 transition-colors"><?= __('How to view the book list?') ?></summary>
                            <p class="pl-4 py-2 text-slate-500"><?= __('You can go to the Online Catalog menu or use the search field on the main page.') ?></p>
                        </details>
                        <details class="cursor-pointer group">
                            <summary class="font-bold border-b border-slate-100 py-2 group-hover:text-blue-600 transition-colors"><?= __('Who manages this website?') ?></summary>
                            <p class="pl-4 py-2 text-slate-500"><?= __('This website was developed using the ZLibrary engine for easy library administration.') ?></p>
                        </details>
                    </div>`
            },
            tagline: {
                title: "<?= __('About') ?>",
                content: `
                    <div class="text-center">
                        <div class="flex items-center justify-center gap-3 mb-4">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center shadow-lg shadow-blue-500/20">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <div class="text-left">
                                <h2 class="text-xl font-black text-slate-900 leading-none">ZLibrary CMS</h2>
                                <p class="text-[10px] text-blue-500 font-bold uppercase tracking-tighter">v1.0 Beta</p>
                            </div>
                        </div>
                        <div class="border border-slate-100 rounded-xl p-3 bg-slate-50/50">
                            <p class="text-[9px] text-slate-400 uppercase tracking-widest mb-1"><?= __('Developed by') ?></p>
                            <p class="text-sm font-bold text-slate-800">Heru Subekti</p>
                            <a href="mailto:heroe_soebekti@yahoo.co.id" class="text-[10px] text-blue-600 hover:underline">heroe_soebekti@yahoo.co.id</a>
                        </div>
                        <p class="mt-4 text-[11px] leading-relaxed text-slate-400 italic">
                            "<?= __('A lightweight, simple, and powerful library web publishing CMS.') ?>"
                        </p>
                    </div>`
            }
        };

        window.openLegal = function(type) {
            const data = legalData[type];
            if (!data) return;

            $('#modal-title').text(data.title);
            $('#modal-body').html(data.content);

            $modal.removeClass('hidden').addClass('flex').hide().fadeIn(300);
            setTimeout(() => {
                $content.removeClass('scale-95 opacity-0').addClass('scale-100 opacity-100');
            }, 10);
            $('body').addClass('overflow-hidden');
        };

        window.closeModal = function() {
            $content.removeClass('scale-100 opacity-100').addClass('scale-95 opacity-0');
            $modal.fadeOut(300, function() {
                $(this).removeClass('flex').addClass('hidden');
                $('body').removeClass('overflow-hidden');
            });
        };

        $modal.on('click', function(e) {
            if (e.target === this) closeModal();
        });

        $(document).on('keydown', function(e) {
            if (e.key === "Escape") closeModal();
        });
    });
    </script>
</body>
</html>