<div class="w-full mx-auto">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6">
        <div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight flex items-center gap-3">
                <div class="w-2 h-10 bg-indigo-600 rounded-full"></div>
                <?= __('Manage Gallery') ?>
            </h1>
            <p class="mt-2 text-slate-500 font-medium max-w-xl">
                <?= __('Manage your visual documentation and activity logs. These assets will be displayed in the gallery section of the website.') ?>
            </p>
        </div>
        <?php if($edit_data): ?>
        <a href="<?= BASE_URL ?>/admin/gallery" class="bg-slate-100 hover:bg-slate-200 text-slate-600 px-5 py-2.5 rounded-custom text-xs font-bold flex items-center gap-2 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg> <?= __('Cancel Edit') ?>
        </a>
        <?php endif; ?>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <div class="lg:col-span-4">
            <div class="bg-white p-7 rounded-custom shadow-sm border border-slate-200 sticky top-8">
                <h2 class="text-[10px] font-black mb-6 text-slate-400 uppercase tracking-widest flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full <?= $edit_data ? 'bg-amber-500' : 'bg-indigo-600' ?>"></span>
                    <?= $edit_data ? __('Asset Edit Mode') : __('Add New Asset') ?>
                </h2>
                
                <form action="<?= BASE_URL ?>/admin/gallery/save" method="POST" enctype="multipart/form-data" class="space-y-5">
                    <?php if($edit_data): ?>
                        <input type="hidden" name="id_target" value="<?= $edit_data['id'] ?>">
                        <input type="hidden" name="old_gambar" value="<?= $edit_data['gambar'] ?>">
                    <?php endif; ?>

                    <div>
                        <label class="text-[10px] font-black uppercase text-slate-400 block mb-1.5 tracking-widest"><?= __('Documentation Title') ?></label>
                        <input type="text" name="judul" value="<?= $edit_data['judul'] ?? '' ?>" required placeholder="<?= __('Enter title...') ?>" class="w-full bg-slate-50 rounded-custom px-4 py-3 text-sm font-bold text-slate-800 outline-none border border-slate-200 focus:ring-2 focus:ring-indigo-500 transition-all">
                    </div>

                    <div>
                        <label class="text-[10px] font-black uppercase text-slate-400 block mb-1.5 tracking-widest"><?= __('Category') ?></label>
                        <input type="text" name="kategori" value="<?= $edit_data['kategori'] ?? '' ?>" placeholder="<?= __('e.g. Workshop, Event') ?>" class="w-full bg-slate-50 rounded-custom px-4 py-3 text-sm font-bold text-slate-800 outline-none border border-slate-200 focus:ring-2 focus:ring-indigo-500 transition-all">
                    </div>

                    <div>
                        <label class="text-[10px] font-black uppercase text-slate-400 block mb-1.5 tracking-widest"><?= __('Layout Type') ?></label>
                        <select name="tipe_layout" class="w-full bg-slate-50 rounded-custom px-4 py-3 text-sm font-bold text-slate-600 outline-none border border-slate-200 focus:ring-2 focus:ring-indigo-500 transition-all">
                            <option value="square" <?= ($edit_data && $edit_data['tipe_layout'] == 'square') ? 'selected' : '' ?>><?= __('Standard (Square)') ?></option>
                            <option value="large" <?= ($edit_data && $edit_data['tipe_layout'] == 'large') ? 'selected' : '' ?>><?= __('Highlight (Tall)') ?></option>
                            <option value="wide" <?= ($edit_data && $edit_data['tipe_layout'] == 'wide') ? 'selected' : '' ?>><?= __('Wide') ?></option>
                        </select>
                    </div>

                    <div>
                        <label class="text-[10px] font-black uppercase text-slate-400 block mb-1.5 tracking-widest"><?= __('Image File') ?></label>
                        <?php if($edit_data): ?>
                            <div class="mb-3 rounded-custom overflow-hidden border border-slate-200 aspect-video shadow-sm bg-slate-100">
                                <img src="<?= BASE_URL ?>/assets/img/gallery/<?= $edit_data['gambar'] ?>" class="w-full h-full object-cover">
                            </div>
                        <?php endif; ?>
                        <div class="relative group">
                            <input type="file" name="gambar" id="gallery_file" accept="image/jpeg,image/png,image/webp,image/gif" <?= $edit_data ? '' : 'required' ?> class="block w-full text-[10px] text-slate-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-custom file:border-0 file:text-[9px] file:font-black file:uppercase file:bg-slate-900 file:text-white cursor-pointer hover:file:bg-indigo-600 transition-all">
                            <p class="mt-2 text-[9px] text-slate-400 italic"><?= __('Allowed: JPG, PNG, WEBP, GIF (Max 2MB)') ?></p>
                        </div>
                    </div>

                    <button type="submit" class="w-full py-4 rounded-custom <?= $edit_data ? 'bg-amber-600 hover:bg-amber-700 shadow-amber-100' : 'bg-indigo-600 hover:bg-indigo-700 shadow-indigo-100' ?> text-white font-black uppercase text-xs tracking-widest shadow-xl transition-all active:scale-95 flex justify-center items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        <?= $edit_data ? __('Update Asset') : __('Publish Asset') ?>
                    </button>
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                </form>
            </div>
        </div>

        <div class="lg:col-span-8">
            <div class="bg-white rounded-custom shadow-sm border border-slate-200 overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-slate-50 border-b border-slate-200 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                        <tr>
                            <th class="p-6"><?= __('Visual') ?></th>
                            <th class="p-6"><?= __('Asset Information') ?></th>
                            <th class="p-6 text-right"><?= __('Action') ?></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php foreach($gallery as $row): 
                            $isActive = $row['is_active'] == 1;
                        ?>
                        <tr class="hover:bg-slate-50/50 transition-colors <?= !$isActive ? 'bg-slate-50/30' : ''; ?>">
                            <td class="p-6 w-32">
                                <div class="w-24 h-14 rounded-custom overflow-hidden border border-slate-200 shadow-sm <?= !$isActive ? 'grayscale opacity-40' : ''; ?>">
                                    <img src="<?= BASE_URL ?>/assets/img/gallery/<?= $row['gambar']; ?>" class="w-full h-full object-cover">
                                </div>
                            </td>
                            <td class="p-6">
                                <h4 class="font-bold text-slate-800 text-base mb-2 <?= !$isActive ? 'text-slate-400 line-through' : ''; ?>"><?= $row['judul']; ?></h4>
                                <div class="flex gap-2">
                                    <span class="text-[9px] font-black px-2 py-0.5 bg-indigo-50 text-indigo-600 rounded uppercase border border-indigo-100"><?= $row['kategori']; ?></span>
                                    <span class="text-[9px] font-black px-2 py-0.5 border border-slate-200 rounded text-slate-400 uppercase italic"><?= $row['tipe_layout']; ?></span>
                                </div>
                            </td>
                            <td class="p-6">
                                <div class="flex justify-end gap-2">
                                    <a href="?edit_id=<?= $row['id']; ?>" class="p-2 border rounded-custom hover:text-indigo-600 transition-all text-slate-400 bg-white shadow-sm" title="<?= __('Edit') ?>"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg></a>
                                    
                                    <a href="<?= BASE_URL ?>/admin/gallery/toggle/<?= $row['id']; ?>/<?= $row['is_active']; ?>" class="p-2 border rounded-custom transition-all shadow-sm <?= !$isActive ? 'bg-slate-800 text-white border-slate-800' : 'text-slate-400 bg-white hover:text-emerald-600'; ?>" title="<?= $isActive ? __('Hide') : __('Show') ?>">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <?php if($isActive): ?>
                                                <path stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            <?php else: ?>
                                                <path stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                                            <?php endif; ?>
                                        </svg>
                                    </a>

                                    <a href="<?= BASE_URL ?>/admin/gallery/delete/<?= $row['id']; ?>" onclick="return confirm('<?= __('Permanently delete this asset?') ?>')" class="p-2 border rounded-custom hover:text-rose-600 transition-all text-slate-400 bg-white shadow-sm" title="<?= __('Delete') ?>"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('gallery_file').onchange = function() {
    const file = this.files[0];
    const validImageTypes = ["image/gif", "image/jpeg", "image/png", "image/webp"];
    if (!validImageTypes.includes(file.type)) {
        alert("<?= __('Please select a valid image file (JPG, PNG, WEBP, or GIF).') ?>");
        this.value = "";
    }
};
</script>