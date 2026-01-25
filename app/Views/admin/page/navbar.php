<div class="w-full mx-auto">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6">
        <div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight flex items-center gap-3">
                <div class="w-2 h-10 bg-indigo-600 rounded-full"></div> <?= __('Navigation') ?>
            </h1>
            <p class="mt-2 text-slate-500 font-medium max-w-xl">
                <?= __('Organize your website menu structure. Drag and drop items to reorder or move them between main menus and sub-menus.') ?>
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <div class="lg:col-span-4">
            <div class="bg-white rounded-custom shadow-sm border border-slate-200 p-7 sticky top-8">
                <h2 class="text-[10px] font-black text-slate-400 uppercase mb-6 tracking-widest flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full <?= $is_edit ? 'bg-amber-500' : 'bg-indigo-600' ?>"></span>
                    <?= $is_edit ? __('Edit Menu Item') : __('Add New Menu') ?>
                </h2>
                
                <form action="<?= BASE_URL ?>/admin/navbar/save" method="POST" class="space-y-5">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                    <input type="hidden" name="id" value="<?= $edit_data['id'] ?? '' ?>">
                    
                    <div>
                        <label class="text-[10px] font-black uppercase text-slate-400 block mb-1.5 tracking-widest"><?= __('Position / Parent') ?></label>
                        <select name="parent_id" class="w-full bg-slate-50 border border-slate-200 rounded-custom px-4 py-3 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                            <option value="NULL">-- <?= __('TOP LEVEL (MAIN)') ?> --</option>
                            <?php foreach($parents as $o): ?>
                                <option value="<?= $o['id'] ?>" <?= (isset($edit_data) && $edit_data['parent_id'] == $o['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($o['nama_menu']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div>
                        <label class="text-[10px] font-black uppercase text-slate-400 block mb-1.5 tracking-widest"><?= __('Menu Label') ?></label>
                        <input type="text" name="nama_menu" required value="<?= $edit_data['nama_menu'] ?? '' ?>" 
                               placeholder="<?= __('e.g. Services, About Us') ?>"
                               class="w-full bg-slate-50 border border-slate-200 rounded-custom px-4 py-3 text-sm font-bold text-slate-800 focus:bg-white focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                    </div>
                    
                    <div>
                        <label class="text-[10px] font-black uppercase text-slate-400 block mb-1.5 tracking-widest"><?= __('Target URL / Slug') ?></label>
                        <input type="text" name="url_menu" required value="<?= $edit_data['url'] ?? '' ?>" 
                               placeholder="<?= __('e.g. /services or https://google.com') ?>"
                               class="w-full bg-slate-50 border border-slate-200 rounded-custom px-4 py-3 text-xs font-mono text-indigo-600 focus:bg-white focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                    </div>
                    
                    <button type="submit" class="w-full py-4 rounded-custom <?= $is_edit ? 'bg-amber-600 shadow-amber-100' : 'bg-indigo-600 shadow-indigo-100' ?> text-white font-black text-xs uppercase tracking-widest hover:opacity-90 transition-all shadow-xl active:scale-95 flex justify-center items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        <?= __('SAVE NAVIGATION') ?>
                    </button>
                    
                    <?php if($is_edit): ?>
                        <a href="<?= BASE_URL ?>/admin/navbar" class="block text-center text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-rose-600 mt-4 transition-colors">
                            <?= __('Cancel & Create New') ?>
                        </a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <div class="lg:col-span-8">
            <div id="main-menu-wrapper" class="space-y-4 connected-sortable" data-parent-id="NULL">
                <?php foreach($parents as $parent): ?>
                <div class="bg-white rounded-custom shadow-sm border border-slate-200 overflow-hidden main-menu-item group" data-id="<?= $parent['id'] ?>">
                    <div class="p-4 flex justify-between items-center bg-white border-b border-slate-50 group-hover:bg-slate-50/50 transition-colors">
                        <div class="flex items-center gap-4">
                            <div class="drag-handle cursor-move text-slate-300 hover:text-indigo-600 p-1">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M10 9h4V5h-4v4zm0 10h4v-4h-4v4zm-6-6h4v-4H4v4zm12 0h4v-4h-4v4z"/></svg>
                            </div>
                            <div>
                                <div class="font-bold text-slate-800 text-sm tracking-tight"><?= htmlspecialchars($parent['nama_menu']) ?></div>
                                <div class="text-[10px] text-slate-400 font-mono italic"><?= $parent['url'] ?></div>
                            </div>
                        </div>
                        <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="?edit=<?= $parent['id'] ?>" class="p-2 border rounded-custom hover:bg-white hover:text-indigo-600 transition-all text-slate-400 shadow-sm" title="<?= __('Edit') ?>">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </a>
                            <a href="<?= BASE_URL ?>/admin/navbar/delete/<?= $parent['id'] ?>" class="p-2 border rounded-custom hover:bg-white hover:text-rose-600 transition-all text-slate-400 shadow-sm" onclick="return confirm('<?= __('Delete this menu and all its submenus?') ?>')">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </a>
                        </div>
                    </div>
                    
                    <div class="submenu-list connected-sortable bg-slate-50/50 p-3 space-y-2 min-h-[10px]" data-parent-id="<?= $parent['id'] ?>">
                        <?php 
                        $sub_query = $model->getSubmenus($parent['id'])->fetchAll(PDO::FETCH_ASSOC); 
                        foreach($sub_query as $sub): 
                        ?>
                        <div class="submenu-item bg-white flex justify-between items-center p-3 pl-8 border rounded-lg border-slate-200 shadow-sm hover:border-indigo-200 transition-all" data-id="<?= $sub['id'] ?>">
                            <div class="flex items-center gap-3">
                                <div class="drag-handle cursor-move text-slate-300 hover:text-indigo-600">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M10 9h4V5h-4v4zm0 10h4v-4h-4v4zm-6-6h4v-4H4v4zm12 0h4v-4h-4v4z"/></svg>
                                </div>
                                <div>
                                    <div class="text-xs font-bold text-slate-700"><?= htmlspecialchars($sub['nama_menu']) ?></div>
                                    <div class="text-[9px] text-slate-400 font-mono"><?= $sub['url'] ?></div>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <a href="?edit=<?= $sub['id'] ?>" class="text-[9px] font-black text-slate-400 hover:text-indigo-600 uppercase tracking-widest transition-colors"><?= __('Edit') ?></a>
                                <a href="<?= BASE_URL ?>/admin/navbar/delete/<?= $sub['id'] ?>" class="text-[9px] font-black text-slate-400 hover:text-rose-600 uppercase tracking-widest transition-colors" onclick="return confirm('<?= __('Delete this submenu?') ?>')"><?= __('Delete') ?></a>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <div class="mt-6 p-4 bg-indigo-50 rounded-custom border border-indigo-100 flex items-center gap-3">
                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="text-[11px] text-indigo-700 font-medium italic"><?= __('Changes to the order are saved automatically after dragging.') ?></p>
            </div>
        </div>
    </div>
</div>

<style>
    .sortable-ghost { opacity: 0.3; background: #e0e7ff !important; border: 2px dashed #6366f1 !important; }
    .sortable-chosen { background: #f8fafc; }
    .drag-over { background-color: rgba(99, 102, 241, 0.05) !important; outline: 2px dashed #6366f1; }
</style>

<script>
$(document).ready(function() {
    function saveNavigation(orderArr, newParentId = null, menuId = null) {
        const csrfToken = $('input[name="csrf_token"]').val();
        const params = new URLSearchParams();
        params.append('csrf_token', csrfToken);
        params.append('order', JSON.stringify(orderArr));
        
        if (newParentId !== null && menuId !== null) {
            params.append('new_parent_id', newParentId);
            params.append('menu_id', menuId);
        }

        fetch('<?= BASE_URL ?>/admin/navbar/saveOrder', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: params.toString()
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                toastr.success('<?= __('Menu structure updated successfully') ?>');
            } else {
                toastr.error(data.message || 'Error');
            }
        })
        .catch(err => toastr.error('Error'));
    }

    const sortableConfig = {
        group: 'nested-menu',
        animation: 250,
        handle: '.drag-handle',
        ghostClass: 'sortable-ghost',
        chosenClass: 'sortable-chosen',
        fallbackOnBody: true,
        swapThreshold: 0.65,
        
        onDragOver: function(evt) {
            $('.connected-sortable').removeClass('drag-over');
            if (evt.to.classList.contains('submenu-list')) {
                $(evt.to).addClass('drag-over');
            }
        },

        onEnd: function(evt) {
            $('.connected-sortable').removeClass('drag-over');
            
            let menuId = evt.item.getAttribute('data-id');
            let newParentId = evt.to.getAttribute('data-parent-id'); 
            
            let order = [];
            $(evt.to).children().each(function() {
                let id = $(this).data('id');
                if(id) order.push(id);
            });

            saveNavigation(order, newParentId, menuId);
        }
    };

    Sortable.create(document.getElementById('main-menu-wrapper'), sortableConfig);

    $('.submenu-list').each(function() {
        Sortable.create(this, sortableConfig);
    });
});
</script>