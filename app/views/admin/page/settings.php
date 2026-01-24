<div class="w-full mx-auto p-4 md:p-0">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6">
        <div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight flex items-center gap-3">
                <div class="w-2 h-10 bg-indigo-600 rounded-full"></div> <?= __('Settings') ?>
            </h1>
            <p class="mt-2 text-slate-500 font-medium"><?= __('Manage your website visual identity, meta information, and system configuration.') ?></p>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">
        <aside class="w-full lg:w-72 flex-shrink-0">
            <div class="bg-white border border-slate-200 rounded-custom p-3 shadow-sm sticky top-8">
                <div class="px-4 py-3 mb-2">
                    <span class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400"><?= __('Configuration Groups') ?></span>
                </div>
                <nav class="space-y-1">
                    <?php $i = 0; foreach($grouped_settings as $group => $items): ?>
                        <button onclick="openTab(event, 'tab-<?= $group ?>')" 
                                class="tab-link w-full flex items-center gap-3 px-4 py-3 rounded-xl transition-all <?= $i === 0 ? 'bg-slate-900 text-white shadow-lg shadow-slate-200' : 'text-slate-500 hover:bg-slate-50' ?>">
                            <div class="w-1.5 h-1.5 rounded-full <?= $i === 0 ? 'bg-indigo-400' : 'bg-slate-200' ?>"></div>
                            <span class="text-xs font-black uppercase tracking-widest"><?= htmlspecialchars(__($group)) ?></span>
                        </button>
                    <?php $i++; endforeach; ?>
                </nav>
            </div>
        </aside>

        <div class="flex-1">
            <form action="<?= BASE_URL ?>/admin/setting/save" method="POST" enctype="multipart/form-data" id="settingsForm">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

                <?php $i = 0; foreach($grouped_settings as $group => $items): ?>
                <div id="tab-<?= $group ?>" class="tab-content animate-fadeIn <?= $i === 0 ? '' : 'hidden' ?> space-y-4">
                    
                    <div class="bg-slate-100/50 px-6 py-3 rounded-t-xl border-x border-t border-slate-200">
                        <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest"><?= __($group) ?> <?= __('Details') ?></span>
                    </div>

                    <?php foreach($items as $s): ?>
                    <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm hover:border-indigo-200 transition-colors group">
                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                            
                            <div class="lg:col-span-4 pt-2">
                                <label class="block text-[11px] font-black uppercase text-slate-400 tracking-widest mb-1 group-hover:text-indigo-600 transition-colors">
                                    <?= __(str_replace('_', ' ', $s['setting_name'])) ?>
                                </label>
                                <p class="text-[10px] text-slate-400 italic font-medium"><?= __('System Key:') ?> <span class="font-mono"><?= $s['setting_name'] ?></span></p>
                            </div>

                            <div class="lg:col-span-8">
                                <?php if($s['setting_type'] === 'file'): ?>
                                    <div class="flex items-center gap-6 p-4 bg-slate-50 rounded-custom border-2 border-dashed border-slate-200 group-hover:border-indigo-300 transition-all">
                                        <div class="w-20 h-20 bg-white rounded-xl border border-slate-200 overflow-hidden flex-shrink-0 shadow-sm flex items-center justify-center relative">
                                            <?php $path = !empty($s['setting_value']) ? BASE_URL . '/assets/img/default/' . $s['setting_value'] . '?t=' . time() : ''; ?>
                                            <img id="prev-<?= $s['setting_name'] ?>" src="<?= $path ?>" class="w-full h-full object-contain p-2 <?= empty($s['setting_value']) ? 'hidden' : '' ?>">
                                            <div id="placeholder-<?= $s['setting_name'] ?>" class="text-slate-300 <?= !empty($s['setting_value']) ? 'hidden' : '' ?>">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            </div>
                                        </div>

                                        <div class="space-y-3">
                                            <p class="text-[10px] text-slate-500 font-bold leading-tight"><?= __('Recommended size depends on the use case.') ?></p>
                                            <label class="cursor-pointer bg-slate-900 text-white px-5 py-2.5 rounded-lg text-[10px] font-black uppercase tracking-widest hover:bg-indigo-600 transition-all inline-flex items-center gap-2 shadow-lg active:scale-95">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/></svg>
                                                <?= __('Browse File') ?>
                                                <input type="file" name="files[<?= $s['setting_name'] ?>]" onchange="previewImage(this, '<?= $s['setting_name'] ?>')" class="hidden" accept="image/*">
                                            </label>
                                        </div>
                                    </div>

                                <?php elseif($s['setting_type'] === 'textarea'): ?>
                                    <textarea name="sets[<?= $s['setting_name'] ?>]" rows="4" class="w-full px-5 py-4 rounded-custom bg-slate-50 border border-slate-200 focus:bg-white focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500 outline-none transition-all text-sm font-medium text-slate-700 leading-relaxed"><?= $s['setting_value'] ?></textarea>
                                
                                <?php elseif($s['setting_name'] === 'default_language'): ?>
                                    <div class="relative">
                                        <select name="sets[<?= $s['setting_name'] ?>]" class="w-full appearance-none px-5 py-4 rounded-custom bg-slate-50 border border-slate-200 focus:bg-white focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500 outline-none text-sm font-black text-slate-700 uppercase tracking-wider cursor-pointer transition-all">
                                            <option value="id_ID" <?= $s['setting_value'] == 'id_ID' ? 'selected' : '' ?>>Bahasa Indonesia</option>
                                            <option value="en_US" <?= $s['setting_value'] == 'en_US' ? 'selected' : '' ?>>English (US)</option>
                                        </select>
                                        <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="3" d="M19 9l-7 7-7-7"/></svg>
                                        </div>
                                    </div>

                                <?php else: ?>
                                    <input type="<?= $s['setting_type'] ?>" name="sets[<?= $s['setting_name'] ?>]" value="<?= $s['setting_value'] ?>" 
                                           class="w-full px-5 py-4 rounded-custom bg-slate-50 border border-slate-200 focus:bg-white focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500 outline-none transition-all text-sm font-bold text-slate-700">
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php $i++; endforeach; ?>

                <div class="mt-12 flex justify-end">
                    <button type="submit" class="w-full md:w-auto flex items-center justify-center gap-4 bg-indigo-600 text-white px-12 py-5 rounded-custom font-black text-xs uppercase tracking-[0.25em] hover:bg-slate-900 transition-all shadow-xl shadow-indigo-100 active:scale-[0.98]">
                        <?= __('save all changes') ?>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fadeIn { animation: fadeIn 0.4s ease-out forwards; }
    .rounded-custom { border-radius: 1rem; }
</style>

<script>
function openTab(evt, tabId) {
    document.querySelectorAll(".tab-content").forEach(el => el.classList.add("hidden"));

    document.querySelectorAll(".tab-link").forEach(el => {
        el.classList.remove("bg-slate-900", "text-white", "shadow-lg", "shadow-slate-200");
        el.classList.add("text-slate-500");
        const dot = el.querySelector('div');
        if(dot) dot.classList.replace("bg-indigo-400", "bg-slate-200");
    });

    const activeTab = document.getElementById(tabId);
    if(activeTab) {
        activeTab.classList.remove("hidden");
    }

    const btn = evt.currentTarget;
    btn.classList.add("bg-slate-900", "text-white", "shadow-lg", "shadow-slate-200");
    btn.classList.remove("text-slate-500");
    const activeDot = btn.querySelector('div');
    if(activeDot) activeDot.classList.replace("bg-slate-200", "bg-indigo-400");

    if(window.innerWidth < 1024 && activeTab) {
        activeTab.scrollIntoView({ behavior: 'smooth' });
    }
}

function previewImage(input, name) {
    const preview = document.getElementById('prev-' + name);
    const placeholder = document.getElementById('placeholder-' + name);
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            if(placeholder) placeholder.classList.add('hidden');

            if(typeof toastr !== 'undefined') {
                toastr.info('<?= __("Preview updated. Don\'t forget to save!") ?>');
            }
        }
        reader.readAsDataURL(input.files[0]);
    }
}

let formModified = false;
document.getElementById('settingsForm').addEventListener('change', () => formModified = true);
document.getElementById('settingsForm').addEventListener('submit', () => formModified = false);

window.addEventListener('beforeunload', (e) => {
    if (formModified) {
        e.preventDefault();
        e.returnValue = '';
    }
});
</script>