<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between group hover:border-indigo-500 transition-all">
        <div>
            <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] mb-1"><?= __('Total Posts') ?></p>
            <h2 class="text-4xl font-black text-slate-800 tracking-tight"><?= $count_berita ?></h2>
        </div>
        <div class="w-12 h-12 bg-slate-50 flex items-center justify-center rounded-xl border border-slate-100 group-hover:bg-indigo-600 group-hover:text-white transition-all">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v12a2 2 0 01-2 2z"></path></svg>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between group hover:border-indigo-500 transition-all">
        <div>
            <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] mb-1"><?= __('Total Articles') ?></p>
            <h2 class="text-4xl font-black text-slate-800 tracking-tight"><?= $count_artikel ?></h2>
        </div>
        <div class="w-12 h-12 bg-slate-50 flex items-center justify-center rounded-xl border border-slate-100 group-hover:bg-indigo-600 group-hover:text-white transition-all">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between group hover:border-indigo-500 transition-all">
        <div>
            <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] mb-1"><?= __('Total Information') ?></p>
            <h2 class="text-4xl font-black text-slate-800 tracking-tight"><?= $count_info ?></h2>
        </div>
        <div class="w-12 h-12 bg-slate-50 flex items-center justify-center rounded-xl border border-slate-100 group-hover:bg-indigo-600 group-hover:text-white transition-all">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
        </div>
    </div>
</div>

<div class="bg-slate-900 rounded-3xl p-10 text-white relative overflow-hidden shadow-xl mb-10">
    <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-600/20 blur-[80px] rounded-full -mr-20 -mt-20"></div>
    <div class="relative z-10">
        <div class="inline-block px-3 py-1 bg-indigo-600 text-[10px] font-black uppercase tracking-widest mb-4 rounded"><?= __('Verified System') ?></div>
        <h2 class="text-4xl font-black mb-2 uppercase tracking-tight"><?= _('Welcome') ?>, <?= explode(' ', $admin_name)[0] ?></h2>
        <p class="text-slate-400 max-w-xl text-sm leading-relaxed">
            <?= __('Manage all content assets, navigation, and digital information through the interface') ?> <span class="text-indigo-400 font-bold italic">ZLibrary CMS</span>.
        </p>
    </div>
</div>