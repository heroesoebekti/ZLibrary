<?php
/**
 * Widget Name: Advanced Stat Counter
 * Widget Category: Sidebar Widget
 * Widget Description: Tracking Harian, Bulanan, dan Geolocation Negara.
 */

use App\Helpers\Security;

$w_id = (int)($data['id'] ?? 0);
$is_instance = (isset($item['is_instance']) && ($item['is_instance'] === 'true' || $item['is_instance'] === true));

$stats = json_decode($data['content'] ?? '[]', true) ?: [
    'total' => 0,
    'daily' => [],
    'monthly' => [],
    'countries' => []
];

Security::secureSession();

if ($w_id > 0 && !isset($_SESSION['v_stat_' . $w_id])) {
    $today = date('Y-m-d');
    $month = date('Y-m');
    $stats['total']++;
    $stats['daily'][$today] = ($stats['daily'][$today] ?? 0) + 1;
    $stats['monthly'][$month] = ($stats['monthly'][$month] ?? 0) + 1;
    $user_ip = $_SERVER['REMOTE_ADDR'];
    if ($user_ip !== '::1' && $user_ip !== '127.0.0.1') {
        $geo_ctx = stream_context_create(["http" => ["timeout" => 2]]);
        $geo_req = @file_get_contents("http://ip-api.com/json/{$user_ip}?fields=countryCode", false, $geo_ctx);
        $geo_res = json_decode($geo_req, true);
        $country = $geo_res['countryCode'] ?? 'Unknown';
    } else {
        $country = 'Local';
    }
    $stats['countries'][$country] = ($stats['countries'][$country] ?? 0) + 1;
    if (count($stats['daily']) > 30) array_shift($stats['daily']);
    if (isset($widgetModel)) {
        $widgetModel->updateWidgetContent($w_id, json_encode($stats), $is_instance);
    }
    
    $_SESSION['v_stat_' . $w_id] = true;
}
$total_kunjungan = number_format($stats['total'], 0, ',', '.');
$hari_ini = $stats['daily'][date('Y-m-d')] ?? 1;
$bulan_ini = $stats['monthly'][date('Y-m')] ?? 1;
?>

<div class="stat-widget-advanced bg-slate-900 rounded-[2.5rem] p-1 border border-white/10 shadow-2xl overflow-hidden">
    <div class="text-center py-8 bg-gradient-to-b from-white/5 to-transparent">
        <span class="text-[10px] font-black text-emerald-500 uppercase tracking-[0.4em] mb-2 block">Anda Adalah Pengunjung Ke:</span>
        <div class="text-6xl font-mono font-black text-white tracking-tighter">
            <?= $total_kunjungan ?>
        </div>
    </div>

    <div class="grid grid-cols-2 border-t border-white/10">
        <div class="p-5 border-r border-white/10 text-center">
            <span class="text-[9px] text-slate-500 font-bold uppercase block mb-1">Hari Ini</span>
            <span class="text-xl font-bold text-white"><?= number_format($hari_ini, 0, ',', '.') ?></span>
        </div>
        <div class="p-5 text-center">
            <span class="text-[9px] text-slate-500 font-bold uppercase block mb-1">Bulan Ini</span>
            <span class="text-xl font-bold text-white"><?= number_format($bulan_ini, 0, ',', '.') ?></span>
        </div>
    </div>

    <div class="p-6 bg-black/20">
        <span class="text-[9px] text-slate-400 font-black uppercase tracking-widest block mb-4 text-center">Asal Negara Terbanyak</span>
        <div class="space-y-3">
            <?php 
            arsort($stats['countries']); 
            $top_countries = array_slice($stats['countries'], 0, 3);
            foreach ($top_countries as $code => $count): 
            ?>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="text-[10px] font-mono text-slate-400"><?= $code ?></span>
                    <div class="h-1.5 w-24 bg-slate-800 rounded-full overflow-hidden">
                        <?php $perc = ($stats['total'] > 0) ? ($count / $stats['total'] * 100) : 0; ?>
                        <div class="h-full bg-emerald-500" style="width: <?= $perc ?>%"></div>
                    </div>
                </div>
                <span class="text-[10px] font-bold text-white"><?= $count ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="p-4 flex items-center justify-center gap-2 bg-emerald-500/5">
        <span class="relative flex h-2 w-2">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
            <span class="bg-emerald-500 rounded-full h-2 w-2"></span>
        </span>
        <span class="text-[8px] font-black text-emerald-500/80 uppercase tracking-widest">Global IP Tracker Active</span>
    </div>
</div>