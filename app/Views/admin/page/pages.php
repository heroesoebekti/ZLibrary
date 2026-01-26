<?php defined('INDEX_AUTH') or exit('Direct access denied.'); ?>
<div class="w-full mx-auto">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6">
        <div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight flex items-center gap-3">
                <div class="w-2 h-10 bg-indigo-600 rounded-full"></div> <?= __('Pages') ?>
            </h1>
            <p class="mt-2 text-slate-500 font-medium max-w-xl">
                <?= __('Create and manage static pages. Standalone pages will be accessible via link but hidden from the main navigation.') ?>
            </p>
        </div>
        <button id="btn-create" class="px-8 py-4 bg-slate-900 text-white rounded-custom font-black text-xs tracking-widest hover:bg-indigo-600 transition-all shadow-xl active:scale-95">
            + <?= __('CREATE NEW PAGE') ?>
        </button>
    </div>

    <div class="bg-white rounded-custom shadow-sm border border-slate-200 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-slate-50 text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] border-b">
                <tr>
                    <th class="p-6 w-20 text-center">NO</th>
                    <th class="p-6"><?= __('PAGE INFO') ?></th>
                    <th class="p-6"><?= __('SLUG / URL') ?></th>
                    <th class="p-6"><?= __('CONNECTION') ?></th>
                    <th class="p-6 text-right"><?= __('ACTIONS') ?></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                <?php $no=1; if($pages): ?>
                    <?php foreach($pages as $row): ?>
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="p-6 text-center text-slate-400 font-medium"><?= $no++ ?></td>
                        <td class="p-6">
                            <span class="font-bold text-slate-800 block"><?= htmlspecialchars($row['judul']) ?></span>
                            <div class="text-[10px] text-slate-400 mt-1 uppercase tracking-tighter">ID: #<?= $row['id'] ?></div>
                        </td>
                        <td class="p-6">
                            <code class="text-[11px] bg-slate-100 text-slate-600 px-2 py-1 rounded border border-slate-200 font-mono">
                                /page/<?= $row['slug'] ?>
                            </code>
                        </td>
                        <td class="p-6">
                            <?php if(isset($row['is_standalone']) && $row['is_standalone'] == 1): ?>
                                <span class="px-2 py-1 rounded bg-amber-50 text-amber-600 text-[9px] font-black border border-amber-100 uppercase tracking-tighter">Standalone</span>
                            <?php elseif($row['parent_name']): ?>
                                <span class="px-2 py-1 rounded bg-indigo-50 text-indigo-600 text-[9px] font-black border border-indigo-100 uppercase tracking-tighter">Sub: <?= htmlspecialchars($row['parent_name']) ?></span>
                            <?php else: ?>
                                <span class="px-2 py-1 rounded bg-emerald-50 text-emerald-600 text-[9px] font-black border border-emerald-100 uppercase tracking-tighter">Main Menu</span>
                            <?php endif; ?>
                        </td>
                        <td class="p-6 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="<?= BASE_URL ?>/page/<?= $row['slug'] ?>" target="_blank" class="p-2 border rounded-custom hover:text-emerald-600 transition-all text-slate-400 bg-white shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                </a>
                                <button class="btn-edit p-2 border rounded-custom hover:text-indigo-600 transition-all text-slate-400 bg-white shadow-sm" data-json='<?= htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8') ?>'>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>
                                <a href="<?= BASE_URL ?>/admin/page/delete/<?= $row['id'] ?>" onclick="return confirm('<?= __('Are you sure?') ?>')" class="p-2 border rounded-custom hover:text-rose-600 transition-all text-slate-400 bg-white shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5" class="p-20 text-center text-slate-400 font-medium italic"><?= __('No pages found.') ?></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div id="modal-page" class="fixed inset-0 z-[999] overflow-y-auto flex items-center justify-center p-4" style="display: none;">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm modal-overlay"></div>
        <div id="modal-container" class="relative bg-white w-full max-w-7xl rounded-custom shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-200 border-4 border-transparent transition-all duration-500">
            <div class="p-6 border-b flex justify-between items-center bg-slate-50">
                <div class="flex items-center gap-3">
                    <h3 id="modal-title" class="font-black text-slate-800 uppercase tracking-widest text-sm"></h3>
                    <span id="standalone-badge" class="hidden px-2 py-0.5 rounded bg-amber-500 text-white text-[9px] font-black uppercase tracking-tighter animate-pulse">Standalone Mode</span>
                </div>
                <button type="button" class="btn-close text-slate-400 text-2xl hover:text-rose-600 transition-colors">&times;</button>
            </div>
            
            <form id="contentForm" action="<?= BASE_URL ?>/admin/page/save" method="POST" class="p-8">
                <input type="hidden" name="id_target" id="input-id">
                <input type="hidden" name="csrf_token" id="csrf_token_input" value="<?= $_SESSION['csrf_token'] ?>">
                
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                    <div class="lg:col-span-3 space-y-6">
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase block mb-2 tracking-widest"><?= __('Page Title') ?></label>
                            <input type="text" name="judul" id="input-judul" required class="w-full bg-slate-50 border border-slate-200 rounded-custom px-4 py-4 text-xl font-bold text-slate-800 outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase block mb-2 tracking-widest"><?= __('Content') ?></label>
                            <div id="toolbar-container" class="border border-slate-200 bg-slate-50 rounded-t-custom"></div>
                            <div class="border border-slate-200 border-t-0 bg-white shadow-inner rounded-b-custom">
                                <div id="editor-editable" class="p-8 min-h-[550px] prose max-w-none focus:outline-none"></div>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-1 space-y-6">
                        <div id="setting-panel" class="bg-slate-50 p-6 rounded-custom border border-slate-200 space-y-6 transition-colors duration-500">
                            <h4 class="font-black text-slate-800 text-[10px] uppercase tracking-widest border-b pb-4"><?= __('Page Settings') ?></h4>
                            <div>
                                <label class="text-[10px] font-black text-slate-400 uppercase block mb-3 tracking-widest"><?= __('Visibility') ?></label>
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <div class="relative">
                                        <input type="checkbox" name="is_standalone" id="input-standalone" value="1" class="sr-only peer">
                                        <div class="w-11 h-6 bg-slate-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-500"></div>
                                    </div>
                                    <span class="text-sm font-bold text-slate-600 group-hover:text-amber-600 transition-colors"><?= __('Standalone Page') ?></span>
                                </label>
                            </div>
                            <div id="parent-container" class="transition-all duration-300">
                                <label class="text-[10px] font-black text-slate-400 uppercase block mb-2 tracking-widest"><?= __('Menu Placement') ?></label>
                                <select name="parent_id" id="input-parent" class="w-full bg-white border border-slate-200 rounded-custom px-3 py-3 text-sm font-bold text-slate-700 outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                                    <option value="NULL">-- <?= __('AS MAIN MENU') ?> --</option>
                                    <?php foreach($parents as $p): ?>
                                        <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['nama_menu']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <hr class="border-slate-200">
                            <button type="submit" id="btn-save" class="w-full py-4 bg-indigo-600 text-white rounded-custom font-black uppercase text-xs tracking-widest shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition-all active:scale-95">
                                <?= __('Save Page') ?>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
class MyUploadAdapter {
    constructor(loader) { this.loader = loader; }
    upload() {
        return this.loader.file.then(file => new Promise((resolve, reject) => {
            const data = new FormData();
            data.append('upload', file);
            data.append('csrf_token', $('#csrf_token_input').val());
            $.ajax({
                url: '<?= BASE_URL ?>/admin/page/uploadImage',
                type: 'POST',
                data: data,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: res => res.uploaded ? resolve({default: res.url}) : reject(res.error.message),
                error: () => reject('Upload failed')
            });
        }));
    }
}

$(document).ready(function() {
    let editorInstance;

    if (document.querySelector('#editor-editable')) {
        DecoupledEditor.create(document.querySelector('#editor-editable'), {
            extraPlugins: [ function(editor) {
                editor.plugins.get('FileRepository').createUploadAdapter = (loader) => new MyUploadAdapter(loader);
            }]
        }).then(editor => {
            document.querySelector('#toolbar-container').appendChild(editor.ui.view.toolbar.element);
            editorInstance = editor;
        }).catch(error => console.error(error));
    }

    $('#input-standalone').on('change', function() {
        const isStandalone = $(this).is(':checked');
        const $modalContainer = $('#modal-container');
        const $settingPanel = $('#setting-panel');
        const $parentContainer = $('#parent-container');
        const $badge = $('#standalone-badge');
        const $btnSave = $('#btn-save');

        if (isStandalone) {
            $modalContainer.addClass('border-amber-400');
            $settingPanel.addClass('bg-amber-50 border-amber-200');
            $parentContainer.addClass('opacity-20 pointer-events-none blur-[1px]');
            $badge.removeClass('hidden');
            $btnSave.removeClass('bg-indigo-600 shadow-indigo-100').addClass('bg-amber-600 shadow-amber-100');
            $('#input-parent').val('NULL');
        } else {
            $modalContainer.removeClass('border-amber-400');
            $settingPanel.removeClass('bg-amber-50 border-amber-200');
            $parentContainer.removeClass('opacity-20 pointer-events-none blur-[1px]');
            $badge.addClass('hidden');
            $btnSave.addClass('bg-indigo-600 shadow-indigo-100').removeClass('bg-amber-600 shadow-amber-100');
        }
    });

    window.openModal = function(data = null) {
        if (data) {
            $('#modal-title').text('<?= __('Edit Page') ?>');
            $('#input-id').val(data.id);
            $('#input-judul').val(data.judul);
            const isStandalone = (data.is_standalone == 1);
            $('#input-standalone').prop('checked', isStandalone).trigger('change');
            if (!isStandalone) $('#input-parent').val(data.parent_id || 'NULL');
            if (editorInstance) editorInstance.setData(data.isi || '');
        } else {
            $('#modal-title').text('<?= __('Create New Page') ?>');
            $('#input-id').val(0);
            $('#input-judul').val('');
            $('#input-standalone').prop('checked', false).trigger('change');
            $('#input-parent').val('NULL');
            if (editorInstance) editorInstance.setData('');
        }
        $('#modal-page').css('display', 'flex').hide().fadeIn(200);
        $('body').css('overflow', 'hidden');
    }

    $('#contentForm').on('submit', function() {
        if (editorInstance) {
            const content = editorInstance.getData();
            if ($('textarea[name="isi"]').length === 0) {
                $(this).append('<textarea name="isi" class="hidden">' + content + '</textarea>');
            } else {
                $('textarea[name="isi"]').val(content);
            }
        }
    });

    $(document).on('click', '.btn-edit', function() { openModal($(this).data('json')); });
    $('#btn-create').on('click', () => openModal());
    $('.btn-close, .modal-overlay').on('click', () => {
        $('#modal-page').fadeOut(200);
        $('body').css('overflow', 'auto');
    });
});
</script>