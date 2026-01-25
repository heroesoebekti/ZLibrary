<meta name="csrf-token" content="<?= $_SESSION['csrf_token'] ?>">

<style>
    #main-builder, #widget-library-container { font-family: 'Inter', sans-serif; }
    .row-container { margin-bottom: 1rem; }
    .connected-sortable { 
        min-height: 60px; border: 1px dashed #cbd5e1; border-radius: 0.375rem;
        background-color: #f8fafc; transition: all 0.2s ease;
    }
    .connected-sortable:empty::after {
        content: '<?= _("DRAG WIDGET HERE") ?>'; display: flex; align-items: center; justify-content: center;
        height: 60px; color: #94a3b8; font-size: 0.6rem; font-weight: 800; letter-spacing: 0.1em;
    }
    .sortable-ghost { opacity: 0.4; background: #e0e7ff !important; border: 1px solid #6366f1; }
    .drag-handle { cursor: grab; padding: 0 4px; }
    .modal-overlay {
        position: fixed; inset: 0; background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(2px); z-index: 9998; display: none;
    }
    .modal-box {
        position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);
        width: 95%; max-width: 750px; z-index: 9999; display: none;
    }
    .sharp-input { border-radius: 0.25rem !important; border: 1px solid #e2e8f0 !important; }
    .badge-unique {
        font-size: 8px; background: #dcfce7; color: #166534; 
        padding: 1px 5px; border-radius: 2px; font-weight: 800; margin-left: 6px; text-transform: uppercase;
    }
    .layout-tab { transition: all 0.2s; cursor: pointer; }
    .layout-tab.active { background-color: #4f46e5 !important; color: white !important; border-color: #4f46e5 !important; }
    .acc-content.hidden { display: none; }
    .rotate-180 { transform: rotate(180deg); }
</style>

<div id="modalTemplate" class="modal-box">
    <div class="bg-white rounded-md p-6 shadow-xl border border-slate-300">
        <div class="flex justify-between items-center mb-6">
            <h3 class="font-bold text-slate-800 uppercase text-[10px] tracking-widest"><?= _("Select Block Layout") ?></h3>
            <button onclick="closeAllModals()" class="text-slate-400 hover:text-slate-600">✕</button>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <button onclick="addNewRow('full')" class="group p-4 border border-slate-200 rounded hover:border-indigo-500 transition-all text-left">
                <div class="w-full h-8 bg-slate-100 mb-2 rounded border border-slate-200 group-hover:bg-indigo-50"></div>
                <span class="text-[10px] font-bold text-slate-600 uppercase"><?= _("Full Width") ?></span>
            </button>
            <button onclick="addNewRow('2-col')" class="group p-4 border border-slate-200 rounded hover:border-indigo-500 transition-all text-left">
                <div class="grid grid-cols-2 gap-1 mb-2">
                    <div class="h-8 bg-slate-100 rounded border border-slate-200 group-hover:bg-indigo-50"></div>
                    <div class="h-8 bg-slate-100 rounded border border-slate-200 group-hover:bg-indigo-50"></div>
                </div>
                <span class="text-[10px] font-bold text-slate-600 uppercase"><?= _("2 Columns (50:50)") ?></span>
            </button>
            <button onclick="addNewRow('1-2-col')" class="group p-4 border border-slate-200 rounded hover:border-indigo-500 transition-all text-left">
                <div class="grid grid-cols-3 gap-1 mb-2">
                    <div class="col-span-1 h-8 bg-slate-100 rounded border border-slate-200 group-hover:bg-indigo-50"></div>
                    <div class="col-span-2 h-8 bg-slate-100 rounded border border-slate-200 group-hover:bg-indigo-50"></div>
                </div>
                <span class="text-[10px] font-bold text-slate-600 uppercase"><?= _("Narrow - Wide (1:2)") ?></span>
            </button>
            <button onclick="addNewRow('2-1-col')" class="group p-4 border border-slate-200 rounded hover:border-indigo-500 transition-all text-left">
                <div class="grid grid-cols-3 gap-1 mb-2">
                    <div class="col-span-2 h-8 bg-slate-100 rounded border border-slate-200 group-hover:bg-indigo-50"></div>
                    <div class="col-span-1 h-8 bg-slate-100 rounded border border-slate-200 group-hover:bg-indigo-50"></div>
                </div>
                <span class="text-[10px] font-bold text-slate-600 uppercase"><?= _("Wide - Narrow (2:1)") ?></span>
            </button>
            <button onclick="addNewRow('3-col')" class="group p-4 border border-slate-200 rounded hover:border-indigo-500 transition-all text-left">
                <div class="grid grid-cols-3 gap-1 mb-2">
                    <div class="h-8 bg-slate-100 rounded border border-slate-200 group-hover:bg-indigo-50"></div>
                    <div class="h-8 bg-slate-100 rounded border border-slate-200 group-hover:bg-indigo-50"></div>
                    <div class="h-8 bg-slate-100 rounded border border-slate-200 group-hover:bg-indigo-50"></div>
                </div>
                <span class="text-[10px] font-bold text-slate-600 uppercase"><?= _("3 Columns (Equal)") ?></span>
            </button>
            <button onclick="addNewRow('4-col')" class="group p-4 border border-slate-200 rounded hover:border-indigo-500 transition-all text-left">
                <div class="grid grid-cols-4 gap-1 mb-2">
                    <div class="h-8 bg-slate-100 rounded border border-slate-200 group-hover:bg-indigo-50"></div>
                    <div class="h-8 bg-slate-100 rounded border border-slate-200 group-hover:bg-indigo-50"></div>
                    <div class="h-8 bg-slate-100 rounded border border-slate-200 group-hover:bg-indigo-50"></div>
                    <div class="h-8 bg-slate-100 rounded border border-slate-200 group-hover:bg-indigo-50"></div>
                </div>
                <span class="text-[10px] font-bold text-slate-600 uppercase"><?= _("4 Columns (Equal)") ?></span>
            </button>
        </div>
    </div>
</div>

<div class="w-full mx-auto">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6">
        <div>
            <div class="flex gap-2 mb-4">
                <button onclick="switchMode('home')" id="tab-home" class="layout-tab active bg-white border border-slate-200 px-4 py-1.5 rounded-full font-bold text-[9px] uppercase tracking-widest text-slate-500"><?= _("Home Area") ?></button>
                <button onclick="switchMode('footer')" id="tab-footer" class="layout-tab bg-white border border-slate-200 px-4 py-1.5 rounded-full font-bold text-[9px] uppercase tracking-widest text-slate-500"><?= _("Footer Area") ?></button>
            </div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight flex items-center gap-3">
                <div class="w-2 h-10 bg-indigo-600 rounded-full"></div> <span id="page-title"><?= _('Home Manager') ?></span>
            </h1>
            <p id="page-desc" class="mt-2 text-slate-500 font-medium max-w-xl"><?= _('Organize your website home layout structure.') ?></p>
        </div>
        <div class="flex gap-2">
            <button onclick="previewLayout()" class="bg-white text-slate-700 border border-slate-200 px-4 py-2 rounded font-bold text-[10px] uppercase tracking-wider hover:bg-slate-50 transition-all"><?= _("Preview") ?></button>
            <button onclick="openTemplateModal()" class="bg-indigo-600 text-white px-4 py-2 rounded font-bold text-[10px] uppercase tracking-wider hover:bg-indigo-700 shadow-sm transition-all">+ <?= _("Add Block") ?></button>
        </div>
    </div>

    <div class="grid grid-cols-12 gap-6 items-start">
        <div class="col-span-12 lg:col-span-3">
            <div class="bg-slate-50 rounded border border-slate-200 p-4 sticky top-6">
                <h2 class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4"><?= _("Widget Templates") ?></h2>
                <div id="widget-library-container" class="space-y-2">
                    <?php 
                    $grouped = [];
                    foreach($library as $w) {
                        $cat = !empty($w['category']) ? $w['category'] : _('Other');
                        $grouped[$cat][] = $w;
                    }
                    foreach($grouped as $catName => $widgets): 
                    ?>
                    <div class="accordion-item border border-slate-200 rounded overflow-hidden bg-white mb-2">
                        <button type="button" onclick="toggleAccordion(this)" class="w-full flex justify-between items-center px-3 py-2 text-left bg-slate-50 hover:bg-slate-100 transition-all">
                            <span class="text-[9px] font-black text-slate-600 uppercase tracking-widest"><?= $catName ?></span>
                            <span class="acc-arrow text-slate-400 transition-transform" style="font-size:8px">▼</span>
                        </button>
                        <div class="acc-content hidden p-2 space-y-2 bg-white">
                            <?php foreach($widgets as $w): ?>
                            <div class="library-item bg-white text-slate-700 px-3 py-3 rounded border border-slate-200 cursor-grab hover:border-indigo-400 transition-all flex flex-col gap-2" 
                                 data-id="<?= $w['id'] ?>" 
                                 data-name="<?= htmlspecialchars($w['title']) ?>"
                                 data-type="<?= trim($w['widget_type']) ?>">
                                <div class="flex items-center gap-2">
                                    <span class="text-slate-400 font-normal text-[12px]">⠿</span>
                                    <span class="text-[11px] font-bold uppercase tracking-wide text-slate-800"><?= htmlspecialchars($w['title']) ?></span>
                                </div>
                                <?php if(!empty(trim($w['description']))): ?>
                                    <div class="bg-slate-800 text-slate-300 text-[10px] px-2.5 py-1.5 rounded-md font-medium leading-relaxed shadow-sm">
                                        <?= trim($w['description']) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="col-span-12 lg:col-span-9">
            <div class="sticky top-6">
                <div id="main-builder" class="space-y-4 p-4 bg-slate-50 rounded border border-slate-200 min-h-[600px] max-h-[calc(100vh-100px)] overflow-y-auto custom-scrollbar"></div>
            </div>
        </div>
    </div>
</div>

<div id="modalOverlay" class="modal-overlay" onclick="closeAllModals()"></div>

<div id="modalEditWidget" class="modal-box">
    <div class="bg-white rounded-md p-6 shadow-xl border border-slate-300">
        <div class="flex justify-between items-center mb-6">
            <h3 class="font-bold text-slate-800 uppercase text-[10px] tracking-widest"><?= _("Edit Widget Instance") ?></h3>
            <span id="display_status" class="text-[9px] font-bold text-slate-300"></span>
        </div>
        <form id="formEditWidget" class="space-y-4">
            <div class="flex items-center justify-between bg-slate-50 p-3 rounded border border-slate-200">
                <label class="text-[10px] font-bold text-slate-700 uppercase tracking-wider cursor-pointer flex items-center gap-2">
                    <input type="checkbox" id="edit_widget_show_title" class="w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                    <?= _("Display Title on Website") ?>
                </label>
            </div>
            <div>
                <label class="block text-[9px] font-bold text-slate-400 uppercase mb-1"><?= _("Title") ?></label>
                <input type="text" id="edit_widget_title" class="sharp-input w-full px-3 py-2 font-bold text-slate-700 text-xs" required>
            </div>
            <div id="dynamic-fields-container" class="space-y-2 pt-2 border-t border-slate-100"></div>
            <div id="standard-content-area">
                <label class="block text-[9px] font-bold text-slate-400 uppercase mb-1"><?= _("Content (HTML/JS)") ?></label>
                <textarea id="edit_widget_content" rows="12" class="sharp-input w-full px-3 py-2 bg-slate-900 text-green-400 font-mono text-[11px] outline-none"></textarea>
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="closeAllModals()" class="text-[10px] font-bold uppercase text-slate-400"><?= _("Cancel") ?></button>
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded font-bold text-[10px] uppercase hover:bg-indigo-700 transition-all"><?= _("Apply Changes") ?></button>
            </div>
        </form>
    </div>
</div>

<script>
let currentEditingElement = null;
let currentMode = 'home';
const csrf = $('meta[name="csrf-token"]').attr('content');

const layouts = {
    home: <?= !empty($savedLayout) ? $savedLayout : '[]' ?>,
    footer: <?= !empty($savedFooterLayout) ? $savedFooterLayout : '[]' ?>
};

$(document).ready(function() {
    $.ajaxSetup({ data: { csrf_token: csrf } });
    switchMode('home');
    initSortableSystem();

    $('#formEditWidget').on('submit', function(e) {
        e.preventDefault();
        if(!currentEditingElement) return;

        const btn = $(this).find('button[type="submit"]');
        const oldText = btn.text();
        const showTitleVal = $('#edit_widget_show_title').is(':checked') ? '1' : '0';
        
        let finalContent = '';
        const dynamicInputs = $('.dynamic-input');
        
        if(dynamicInputs.length > 0) {
            let configValues = {};
            dynamicInputs.each(function() {
                configValues[$(this).data('key')] = $(this).val();
            });
            finalContent = JSON.stringify(configValues);
        } else {
            finalContent = $('#edit_widget_content').val();
        }

        btn.prop('disabled', true).text('<?= _("SAVING...") ?>');
        $.post('<?= BASE_URL ?>/admin/widget/updateCustomWidget', {
            id: currentEditingElement.attr('data-id'),
            title: $('#edit_widget_title').val(),
            content: finalContent,
            widget_type: currentEditingElement.attr('data-widget-type'),
            is_instance: currentEditingElement.attr('data-is-instance'),
            show_title: showTitleVal
        }, function(res) {
            if(res.success) {
                currentEditingElement.attr('data-id', res.new_id);
                currentEditingElement.attr('data-is-instance', 'true');
                currentEditingElement.attr('data-show-title', showTitleVal);
                const newHtml = createWidgetHTML({
                    id: res.new_id,
                    name: $('#edit_widget_title').val(),
                    widget_type: currentEditingElement.attr('data-widget-type'),
                    is_instance: 'true',
                    show_title: showTitleVal
                });
                currentEditingElement.replaceWith(newHtml);
                toastr.success('<?= _("Widget saved successfully") ?>');
                closeAllModals();
                saveLayout(false); 
            } else {
                toastr.error(res.message || '<?= _("Failed to update widget") ?>');
            }
            btn.prop('disabled', false).text(oldText);
        }, 'json');
    });
});

function toggleAccordion(btn) {
    const $item = $(btn).closest('.accordion-item');
    const $content = $item.find('.acc-content');
    const $arrow = $(btn).find('.acc-arrow');
    if ($content.hasClass('hidden')) {
        $content.removeClass('hidden');
        $arrow.addClass('rotate-180');
    } else {
        $content.addClass('hidden');
        $arrow.removeClass('rotate-180');
    }
}

function openEditModal(btn) {
    currentEditingElement = $(btn).closest('.widget-item');
    const id = currentEditingElement.attr('data-id');
    const isInstance = currentEditingElement.attr('data-is-instance');
    const type = currentEditingElement.attr('data-widget-type');

    $.get('<?= BASE_URL ?>/admin/widget/getWidgetData', { id: id, is_instance: isInstance, widget_type: type }, function(res) {
        if(res.success) {
            $('#edit_widget_title').val(currentEditingElement.find('.w-title').text());
            $('#edit_widget_show_title').prop('checked', currentEditingElement.attr('data-show-title') !== '0');
            
            const dynContainer = $('#dynamic-fields-container').empty();
            let schema = null;

            if (res.config_template && Object.keys(res.config_template).length > 0) {
                schema = res.config_template;
            } else {
                try {
                    const contentParsed = JSON.parse(res.data.content);
                    if (contentParsed && typeof contentParsed === 'object' && Object.values(contentParsed)[0].type) {
                        schema = contentParsed;
                    }
                } catch(e) { schema = null; }
            }

            if (schema) {
                $('#standard-content-area').hide();
                let groups = {};
                Object.keys(schema).forEach(key => {
                    const match = key.match(/\d+/);
                    const groupIndex = match ? match[0] : '0';
                    if (!groups[groupIndex]) groups[groupIndex] = [];
                    groups[groupIndex].push({ key: key, config: schema[key] });
                });

                Object.keys(groups).forEach((groupNum, idx) => {
                    const fields = groups[groupNum];
                    const isFirst = idx === 0 ? '' : 'hidden';
                    const arrowClass = idx === 0 ? 'rotate-180' : '';
                    let groupTitle = groupNum !== '0' ? `ITEM ${groupNum}` : '<?= _("GENERAL SETTINGS") ?>';
                    
                    let fieldsHtml = '<div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-2">';
                    fields.forEach(item => {
                        const field = item.config;
                        const val = field.default || '';
                        let input = field.type === 'textarea' 
                            ? `<textarea data-key="${item.key}" class="dynamic-input sharp-input w-full px-3 py-2 font-bold text-slate-700 text-xs" rows="2">${val}</textarea>`
                            : `<input type="${field.type || 'text'}" data-key="${item.key}" value="${val}" class="dynamic-input sharp-input w-full px-3 py-2 font-bold text-slate-700 text-xs">`;
                        fieldsHtml += `<div><label class="text-[9px] font-black text-slate-400 uppercase tracking-tight">${field.label || item.key}</label>${input}</div>`;
                    });
                    fieldsHtml += '</div>';

                    let accHtml = `
                        <div class="accordion-item border border-slate-200 rounded overflow-hidden">
                            <button type="button" onclick="toggleAccordion(this)" class="w-full flex justify-between items-center bg-slate-50 px-3 py-2 text-left hover:bg-slate-100 transition-all">
                                <span class="text-[9px] font-black text-indigo-600 uppercase tracking-widest">${groupTitle}</span>
                                <span class="acc-arrow text-slate-400 transition-transform ${arrowClass}" style="font-size:8px">▼</span>
                            </button>
                            <div class="acc-content p-3 bg-white ${isFirst}">${fieldsHtml}</div>
                        </div>`;
                    dynContainer.append(accHtml);
                });
            } else {
                $('#standard-content-area').show();
                $('#edit_widget_content').val(res.data.content);
            }
            $('#modalOverlay, #modalEditWidget').fadeIn(200);
        }
    }, 'json');
}

function switchMode(mode) {
    currentMode = mode;
    $('.layout-tab').removeClass('active');
    $(`#tab-${mode}`).addClass('active');
    $('#page-title').text(mode === 'footer' ? '<?= _("Footer Manager") ?>' : '<?= _("Home Manager") ?>');
    $('#page-desc').text(mode === 'footer' ? '<?= _("Organize your website footer layout structure.") ?>' : '<?= _("Organize your website home layout structure.") ?>');
    renderLayout(layouts[mode], '#main-builder');
}

function initSortableSystem() {
    const config = {
        group: 'shared', animation: 150, handle: '.drag-handle',
        onEnd: () => saveLayout(),
        onAdd: function(evt) {
            if (evt.item.classList.contains('library-item')) {
                const item = evt.item;
                $(item).replaceWith(createWidgetHTML({ 
                    id: item.dataset.id, name: item.dataset.name, 
                    widget_type: item.dataset.type, is_instance: 'false', show_title: '1'
                }));
                toastr.info('<?= _("Widget added") ?>');
            }
            saveLayout();
        }
    };
    if(document.getElementById('main-builder')) new Sortable(document.getElementById('main-builder'), config);
    $('.connected-sortable').each(function() { new Sortable(this, config); });
    
    document.querySelectorAll('.acc-content').forEach(el => {
        new Sortable(el, { group: { name: 'shared', pull: 'clone', put: false }, sort: false });
    });
}

function createWidgetHTML(data) {
    const isInstance = String(data.is_instance) === 'true';
    const badge = isInstance ? `<span class="badge-unique"><?= _("Unique") ?></span>` : '';
    const hiddenLabel = data.show_title == '0' ? '<span class="badge-unique" style="background:#fee2e2; color:#b91c1c"><?= _("No Title") ?></span>' : '';
    return `<div class="widget-item bg-white p-3 rounded border border-slate-200 shadow-sm mb-2 flex justify-between items-center group" 
                data-id="${data.id}" data-widget-type="${data.widget_type}" data-is-instance="${data.is_instance}" data-show-title="${data.show_title || '1'}">
        <div class="flex items-center gap-2">
            <div class="drag-handle text-slate-300 font-bold text-xs">⠿</div>
            <span class="text-[11px] font-bold text-slate-700 uppercase w-title">${data.name}</span>
            ${badge} ${hiddenLabel}
        </div>
        <div class="flex gap-3 opacity-0 group-hover:opacity-100 transition-all">
            <button type="button" onclick="openEditModal(this)" class="text-indigo-600 font-bold text-[9px] uppercase hover:underline"><?= _("Settings") ?></button>
            <button type="button" onclick="removeWidget(this)" class="text-rose-400 font-bold text-[9px] uppercase">✕</button>
        </div>
    </div>`;
}

function collectData(cont) {
    let items = [];
    $(cont).children().each(function() {
        const $el = $(this);
        if($el.hasClass('row-container')) {
            let b = { type: 'block', id: $el.data('id'), layout: $el.data('layout'), columns: {} };
            $el.find('.connected-sortable').each(function() { 
                if($(this).closest('.row-container').is($el)) b.columns[$(this).data('pos')] = collectData(this); 
            });
            items.push(b);
        } else if($el.hasClass('widget-item')) { 
            items.push({ 
                type: 'widget', id: $el.attr('data-id'), title: $el.find('.w-title').text(),
                widget_type: $el.attr('data-widget-type'), is_instance: String($el.attr('data-is-instance')),
                show_title: $el.attr('data-show-title')
            }); 
        }
    });
    return items;
}

function renderRecursive(items) {
    if(!Array.isArray(items)) return '';
    return items.map(i => {
        if(i.type === 'block') return createBlockHTML(i);
        return createWidgetHTML({ id: i.id, name: i.title, widget_type: i.widget_type, is_instance: i.is_instance, show_title: i.show_title });
    }).join('');
}

function createBlockHTML(data) {
    const colBase = "connected-sortable p-2";
    let grid = '';
    if(data.layout === 'full') grid = `<div data-pos="c1" class="${colBase}">${renderRecursive(data.columns?.c1)}</div>`;
    else if(data.layout === '2-col') grid = `<div class="grid grid-cols-2 gap-2"><div data-pos="c1" class="${colBase}">${renderRecursive(data.columns?.c1)}</div><div data-pos="c2" class="${colBase}">${renderRecursive(data.columns?.c2)}</div></div>`;
    else if(data.layout === '1-2-col') grid = `<div class="grid grid-cols-3 gap-2"><div data-pos="c1" class="col-span-1 ${colBase}">${renderRecursive(data.columns?.c1)}</div><div data-pos="c2" class="col-span-2 ${colBase}">${renderRecursive(data.columns?.c2)}</div></div>`;
    else if(data.layout === '2-1-col') grid = `<div class="grid grid-cols-3 gap-2"><div data-pos="c1" class="col-span-2 ${colBase}">${renderRecursive(data.columns?.c1)}</div><div data-pos="c2" class="col-span-1 ${colBase}">${renderRecursive(data.columns?.c2)}</div></div>`;
    else if(data.layout === '3-col') grid = `<div class="grid grid-cols-3 gap-2"><div data-pos="c1" class="${colBase}">${renderRecursive(data.columns?.c1)}</div><div data-pos="c2" class="${colBase}">${renderRecursive(data.columns?.c2)}</div><div data-pos="c3" class="${colBase}">${renderRecursive(data.columns?.c3)}</div></div>`;
    else if(data.layout === '4-col') grid = `<div class="grid grid-cols-4 gap-2"><div data-pos="c1" class="${colBase}">${renderRecursive(data.columns?.c1)}</div><div data-pos="c2" class="${colBase}">${renderRecursive(data.columns?.c2)}</div><div data-pos="c3" class="${colBase}">${renderRecursive(data.columns?.c3)}</div><div data-pos="c4" class="${colBase}">${renderRecursive(data.columns?.c4)}</div></div>`;
    
    return `<div class="row-container bg-white rounded border border-slate-200 overflow-hidden shadow-sm mb-4" data-id="${data.id}" data-layout="${data.layout}">
        <div class="px-3 py-1.5 bg-slate-50 flex justify-between items-center border-b border-slate-200 drag-handle cursor-move">
            <span class="text-[9px] font-black text-slate-400 uppercase tracking-wider">${data.layout.replace('-',' ')}</span>
            <button type="button" onclick="removeBlock(this)" class="text-slate-300 hover:text-rose-500">✕</button>
        </div>
        <div class="p-1">${grid}</div>
    </div>`;
}

function renderLayout(data, target) { $(target).html(renderRecursive(data)); initSortableSystem(); }

function saveLayout(showSilent = true) { 
    const layoutData = collectData('#main-builder');
    layouts[currentMode] = layoutData;
    $.post('<?= BASE_URL ?>/admin/widget/saveRecursiveLayout', { layout: JSON.stringify(layoutData), target: currentMode }, function(res) {
        if(showSilent) toastr.success('<?= _("Layout structure saved") ?>');
    }); 
}

function closeAllModals() { $('.modal-box, .modal-overlay').fadeOut(100); }
function openTemplateModal() { $('#modalOverlay, #modalTemplate').fadeIn(200); }

function removeWidget(btn) {
    const $item = $(btn).closest('.widget-item');
    const isInstance = $item.attr('data-is-instance');
    const msg = (isInstance === 'true') ? '<?= _("Delete unique widget permanently?") ?>' : '<?= _("Remove from layout?") ?>';
    if (confirm(msg)) {
        if (isInstance === 'true') {
            $.post('<?= BASE_URL ?>/admin/widget/deleteWidgetInstance', { id: $item.attr('data-id'), is_instance: true }, function(res) {
                if(res.success) { $item.remove(); toastr.error('Deleted'); saveLayout(false); }
            }, 'json');
        } else {
            $item.remove(); saveLayout(false);
        }
    }
}

function removeBlock(btn) { $(btn).closest('.row-container').remove(); toastr.warning('<?= _("Block removed") ?>'); saveLayout(); }

function addNewRow(t) { 
    $('#main-builder').append(createBlockHTML({ id: 'r'+Date.now(), layout: t })); 
    closeAllModals(); initSortableSystem(); saveLayout(false);
}

function previewLayout() { window.open('<?= BASE_URL ?>', '_blank'); }
</script>