<?php
/**
 * Widget Name: Currency Rates (IDR Base)
 * Widget Category: Sidebar Widget
 * Widget Description: Menampilkan kurs mata uang.
 */

if (!headers_sent()) {
    header("Content-Security-Policy: default-src 'self'; connect-src 'self' https://open.er-api.com; style-src 'self' 'unsafe-inline';");
}

$info = (isset($data) && is_array($data)) ? $data : [];
$config = json_decode($info['content'] ?? '{}', true) ?: [];
$baseCurrency = $config['base'] ?? 'USD';
$targetStrings = $config['targets'] ?? 'IDR,EUR,SGD,JPY,MYR';
$targets = explode(',', $targetStrings);
$color = $config['color'] ?? '#059669';

$apiUrl = "https://open.er-api.com/v6/latest/{$baseCurrency}";
$ctx = stream_context_create([
    "http" => [
        "timeout" => 3,
        "header" => "User-Agent: PHP-Currency-Widget/1.0\r\n"
    ]
]);

$response = @file_get_contents($apiUrl, false, $ctx);
$apiData = json_decode((string)$response, true);
$rates = [];

if ($apiData && isset($apiData['result']) && $apiData['result'] === 'success') {
    foreach ($targets as $symbol) {
        $symbol = trim(strtoupper($symbol));
        if (isset($apiData['rates'][$symbol])) {
            $rates[$symbol] = $apiData['rates'][$symbol];
        }
    }
}
$symbols = [
    'IDR' => 'Rp', 'USD' => '$', 'EUR' => '€', 
    'JPY' => '¥', 'SGD' => 'S$', 'MYR' => 'RM',
    'GBP' => '£', 'AUD' => 'A$'
];
?>

<div class="currency-widget rounded-2xl border border-slate-200 bg-white overflow-hidden shadow-sm transition-all hover:shadow-md">
    
    <div class="p-4 flex items-center justify-between border-b border-slate-50" style="background: <?= $color ?>08">
        <div class="flex items-center gap-3">
            <div class="p-2 rounded-xl" style="background: <?= $color ?>15">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" style="color: <?= $color ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <h4 class="text-xs font-black text-slate-800 uppercase tracking-wider leading-none mb-1">
                    <?= htmlspecialchars((string)($info['title'] ?? 'Kurs Mata Uang')) ?>
                </h4>
                <div class="flex items-center gap-1.5">
                    <span class="flex h-1.5 w-1.5 rounded-full bg-green-500"></span>
                    <span class="text-[9px] text-slate-400 font-bold uppercase tracking-tighter">Base: 1 <?= $baseCurrency ?></span>
                </div>
            </div>
        </div>
        <div class="text-right">
            <span class="text-[10px] font-mono font-bold text-slate-300 block italic"><?= date('H:i') ?> WIB</span>
        </div>
    </div>

    <div class="divide-y divide-slate-50">
        <?php if (!empty($rates)): ?>
            <?php foreach ($rates as $currency => $value): ?>
                <div class="group flex items-center justify-between p-3.5 hover:bg-slate-50/80 transition-all">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-6 bg-slate-100 rounded shadow-sm text-[10px] flex items-center justify-center font-bold text-slate-500 border border-slate-200 group-hover:border-slate-300 transition-colors">
                            <?= $currency ?>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs font-bold text-slate-700"><?= $currency ?></span>
                            <span class="text-[9px] text-slate-400 leading-none">Global Market</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="flex items-center justify-end gap-1">
                            <span class="text-[13px] font-black text-slate-900 tracking-tight">
                                <?= ($currency === 'IDR') ? number_format($value, 0, ',', '.') : number_format($value, 2, '.', ',') ?>
                            </span>
                            <span class="text-[10px] font-bold text-slate-400"><?= $symbols[$currency] ?? '' ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="p-8 text-center bg-slate-50/30">
                <div class="mb-3 flex justify-center">
                    <svg class="w-8 h-8 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1">Data Offline</p>
                <p class="text-[9px] text-slate-300">Gagal terhubung ke penyedia layanan kurs mata uang.</p>
            </div>
        <?php endif; ?>
    </div>

    <a href="#" class="p-2.5 bg-slate-50/50 border-t border-slate-100 flex items-center justify-center gap-2 group hover:bg-slate-100 transition-colors">
        <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest group-hover:text-slate-600 transition-colors">Lihat Semua Kurs</span>
        <svg class="w-3 h-3 text-slate-300 group-hover:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
    </a>
</div>