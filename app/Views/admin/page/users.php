<?php defined('INDEX_AUTH') or exit('Direct access denied.'); ?>
<div class="w-full mx-auto">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6">
        <div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight flex items-center gap-3">
                <div class="w-2 h-10 bg-indigo-600 rounded-full"></div> <?= __('Manage User') ?>
            </h1>
            <p class="text-slate-500 font-medium mt-1"><?= __('Create and manage administrative user accounts and their access levels.') ?></p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <div class="lg:col-span-4">
            <div class="bg-white rounded-custom border border-slate-200 shadow-sm sticky top-8 overflow-hidden">
                <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                    <h3 id="form-title" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400"><?= __('User Input Form') ?></h3>
                    <span id="edit-badge" class="hidden px-2 py-0.5 rounded bg-amber-100 text-amber-600 text-[9px] font-black uppercase"><?= __('Edit Mode') ?></span>
                </div>
                
                <form id="formUser" action="<?= BASE_URL ?>/admin/user/save" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
                    <input type="hidden" name="user_id" id="user_id" value="0">
                    <input type="hidden" name="current_foto" id="current_foto" value="">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                    
                    <div class="flex flex-col items-center gap-4 py-2">
                        <div class="relative group">
                            <div id="avatar-container" class="w-32 h-32 rounded-custom border-2 border-dashed border-slate-200 overflow-hidden bg-slate-50 flex items-center justify-center transition-all group-hover:border-indigo-300">
                                <img id="avatar-preview" class="w-full h-full object-cover hidden">
                                <div id="avatar-placeholder" class="text-center">
                                    <svg id="avatar-svg" class="w-12 h-21 text-slate-300 mx-auto" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                    </svg>
                                    <p class="text-[9px] font-black text-slate-400 uppercase mt-2"><?= __('Upload Foto') ?></p>
                                </div>
                            </div>
                            <label class="absolute -bottom-2 -right-2 bg-slate-900 text-white p-3 rounded-custom cursor-pointer hover:bg-indigo-600 shadow-xl border-4 border-white transition-all active:scale-90">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/></svg>
                                <input type="file" name="foto" id="inputFoto" class="hidden" accept="image/*">
                            </label>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="text-[10px] font-black uppercase text-slate-400 block mb-1.5 tracking-widest"><?= __('Full Name') ?></label>
                            <input type="text" name="nama_lengkap" id="u_nama" required class="w-full px-4 py-3 rounded-custom bg-slate-50 border border-slate-200 outline-none focus:ring-2 focus:ring-indigo-500 text-sm font-bold text-slate-700 transition-all">
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-[10px] font-black uppercase text-slate-400 block mb-1.5 tracking-widest"><?= __('Username') ?></label>
                                <input type="text" name="username" id="u_user" required class="w-full px-4 py-3 rounded-custom bg-slate-50 border border-slate-200 text-xs font-black uppercase outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                            </div>
                            <div>
                                <label class="text-[10px] font-black uppercase text-slate-400 block mb-1.5 tracking-widest"><?= __('Role') ?></label>
                                <select name="role" id="u_role" class="w-full px-4 py-3 rounded-custom bg-slate-50 border border-slate-200 text-xs font-black uppercase outline-none focus:ring-2 focus:ring-indigo-500 transition-all cursor-pointer">
                                    <option value="operator">Operator</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="text-[10px] font-black uppercase text-slate-400 block mb-1.5 tracking-widest"><?= __('Password') ?></label>
                            <input type="password" name="password" id="u_pass" class="w-full px-4 py-3 rounded-custom bg-slate-50 border border-slate-200 text-sm outline-none focus:ring-2 focus:ring-indigo-500 transition-all" placeholder="••••••••">
                            <p id="pass-hint" class="hidden text-[10px] text-amber-500 mt-2 italic font-medium">
                                * <?= __('Leave blank if you don\'t want to change the password') ?>
                            </p>
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full bg-slate-900 text-white py-4 rounded-custom font-black text-xs uppercase tracking-[0.2em] hover:bg-indigo-600 transition-all shadow-lg shadow-indigo-100 active:scale-[0.98]">
                            <?= __('Save User Data') ?>
                        </button>
                        <button type="button" id="btn-reset" class="hidden w-full mt-3 py-2 text-[10px] font-black uppercase text-slate-400 hover:text-rose-500 transition-colors tracking-widest">
                            <?= __('Cancel Edit') ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="lg:col-span-8">
            <div class="bg-white rounded-custom border border-slate-200 shadow-sm overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-slate-50/80 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-5 text-[10px] font-black uppercase text-slate-400 tracking-widest"><?= __('User Identity') ?></th>
                            <th class="px-6 py-5 text-[10px] font-black uppercase text-slate-400 tracking-widest text-center"><?= __('Authority') ?></th>
                            <th class="px-6 py-5 text-[10px] font-black uppercase text-slate-400 tracking-widest text-right"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php if (empty($users)): ?>
                                <tr>
                                    <td colspan="4" class="py-10 text-center text-slate-400 font-medium italic">
                                        <?= __('No user data found.') ?>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($users as $u): ?>
                                <tr class="hover:bg-slate-50/50 transition-colors group">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 rounded-full bg-slate-100 border border-slate-200 overflow-hidden flex-shrink-0">
                                                <?php if (!empty($u['foto'])): ?>
                                                    <img src="<?= BASE_URL ?>/assets/img/users/<?= $u['foto'] ?>" class="w-full h-full object-cover">
                                                <?php else: ?>
                                                    <div class="w-full h-full flex items-center justify-center text-slate-400">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div>
                                                <div class="text-sm font-black text-slate-800 tracking-tight"><?= htmlspecialchars($u['nama_lengkap']) ?></div>
                                                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">@<?= htmlspecialchars($u['username']) ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-2.5 py-1 rounded text-[10px] font-black uppercase tracking-wider <?= $u['role'] === 'admin' ? 'bg-indigo-50 text-indigo-600' : 'bg-emerald-50 text-emerald-600' ?>">
                                            <?= $u['role'] ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <button onclick='editUser(<?= json_encode($u) ?>)' class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-white border border-transparent hover:border-slate-200 rounded-lg transition-all shadow-sm">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                            </button>
                                            <a href="<?= BASE_URL ?>/admin/user/delete/<?= $u['id'] ?>" onclick="return confirm('<?= __('Are you sure you want to delete this user?') ?>')" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-white border border-transparent hover:border-slate-200 rounded-lg transition-all shadow-sm">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#inputFoto').on('change', function() {
        const file = this.files[0];
        if (file) {
            if (!file.type.startsWith('image/')) {
                alert('<?= __("Please upload an image file.") ?>');
                return;
            }
            let reader = new FileReader();
            reader.onload = function(e) {
                $('#avatar-preview').attr('src', e.target.result).removeClass('hidden');
                $('#avatar-placeholder').addClass('hidden');
            }
            reader.readAsDataURL(file);
        }
    });

    $('#btn-reset').on('click', function() {
        $('#formUser')[0].reset();
        $('#user_id').val(0);
        $('#current_foto').val('');
        $('#edit-badge, #btn-reset, #pass-hint').addClass('hidden');
        $('#avatar-preview').addClass('hidden').attr('src', '');
        $('#avatar-placeholder').removeClass('hidden');
        $('#u_pass').attr('placeholder', '••••••••');
        $('#form-title').text('<?= __('User Input Form') ?>');
    });
});

function editUser(data) {
    $('html, body').animate({ scrollTop: 0 }, 'smooth');
    
    $('#user_id').val(data.id);
    $('#current_foto').val(data.foto);
    $('#u_nama').val(data.nama_lengkap);
    $('#u_user').val(data.username);
    $('#u_role').val(data.role);
    
    $('#form-title').text('<?= __('Update User Account') ?>');
    $('#edit-badge, #btn-reset, #pass-hint').removeClass('hidden');
    $('#u_pass').attr('placeholder', '<?= __('Change Password?') ?>');

    if (data.foto) {
        $('#avatar-preview').attr('src', '<?= BASE_URL ?>/assets/img/users/' + data.foto).removeClass('hidden');
        $('#avatar-placeholder').addClass('hidden');
    } else {
        const fallback = 'https://ui-avatars.com/api/?background=6366f1&color=fff&name=' + encodeURIComponent(data.nama_lengkap);
        $('#avatar-preview').attr('src', fallback).removeClass('hidden');
        $('#avatar-placeholder').addClass('hidden');
    }
}
</script>