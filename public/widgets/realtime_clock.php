<?php
/**
 * Widget Name: Realtime Clock (Compact)
 * Widget Category: Footer
 * Widget Description: Tampilan Jam Realtime yang lebih ringkas dengan margin.
 */
?>

<div class="clock-widget p-4">
    <div class="bg-slate-900/50 border border-white/5 rounded-xl p-3 backdrop-blur-sm max-w-fit">
        <div class="flex items-baseline gap-1 justify-start">
            <span id="clock-h" class="text-2xl font-mono font-black text-white">00</span>
            <span class="text-lg font-mono font-bold text-blue-500 animate-pulse">:</span>
            <span id="clock-m" class="text-2xl font-mono font-black text-white">00</span>
            <span class="text-lg font-mono font-bold text-blue-500">:</span>
            <span id="clock-s" class="text-2xl font-mono font-black text-yellow-400">00</span>
        </div>
        
        <div id="clock-date" class="mt-1 text-[10px] font-bold text-slate-500 uppercase tracking-widest">
            Loading date...
        </div>
    </div>
</div>

<script>
(function() {
    function updateClock() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        
        const hElem = document.getElementById('clock-h');
        const mElem = document.getElementById('clock-m');
        const sElem = document.getElementById('clock-s');
        const dElem = document.getElementById('clock-date');

        if(hElem) hElem.textContent = hours;
        if(mElem) mElem.textContent = minutes;
        if(sElem) sElem.textContent = seconds;
        
        if(dElem) {
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            dElem.textContent = now.toLocaleDateString('id-ID', options);
        }
    }
    setInterval(updateClock, 1000);
    updateClock();
})();
</script>