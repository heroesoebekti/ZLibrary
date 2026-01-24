<?php
/**
 * Widget Name: Nomor Pokok Perpustakaan
 * Widget Category: Footer
 * Widget Description: Menampilkan Nomor Pokok Perpustakaan secara Statis.
 */
?>
                    <div class="relative p-5 border border-slate-800 rounded-2xl bg-slate-900/30 overflow-hidden group">
                        <div class="absolute top-0 right-0 w-16 h-16 bg-yellow-400/5 -mr-8 -mt-8 rounded-full blur-2xl"></div>
                        <div class="relative z-10">
                            <div class="flex items-center gap-2 mb-2">
                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.64.3 1.241.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"></path>
                                </svg>
                                <span class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]"><?= __('Library Identification Number') ?></span>
                            </div>
                            <div class="text-xl font-mono font-bold text-white group-hover:text-yellow-400 transition-colors">
                                <?= SITE_NPP ?>
                            </div>
                        </div>
                    </div>