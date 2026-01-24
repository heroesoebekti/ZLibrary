<?php
/**
 * Widget Name: Weather Forecast
 * Widget Category: Integration
 * Widget Description: Deteksi cuaca otomatis berdasarkan lokasi pengunjung (IP Geolocation).
 * Widget Config: {
"fallback_city": { "label": "Kota Cadangan", "type": "text", "default": "Jakarta" },
"accent_color": { "label": "Warna Aksen", "type": "color", "default": "#0ea5e9" }
}
 */

$info = (isset($data) && is_array($data)) ? $data : [];
$raw_content = json_decode($info['content'] ?? '{}', true) ?: [];
$color    = $raw_content['accent_color']['default'] ?? ($raw_content['accent_color'] ?? '#0ea5e9');
$fallback = $raw_content['fallback_city']['default'] ?? ($raw_content['fallback_city'] ?? 'Jakarta');
$ip_keys = ['HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR'];
$client_ip = '';
foreach ($ip_keys as $key) {
    if (array_key_exists($key, $_SERVER) === true) {
        foreach (explode(',', $_SERVER[$key]) as $ip) {
            $ip = trim($ip);
            if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                $client_ip = $ip;
                break 2;
            }
        }
    }
}
$geoContext = stream_context_create(["http" => ["timeout" => 2]]);
$geoUrl = "http://ip-api.com/json/{$client_ip}?fields=status,city,lat,lon";
$geoResponse = @file_get_contents($geoUrl, false, $geoContext);
$geoData = json_decode($geoResponse, true);
if ($geoData && $geoData['status'] === 'success') {
    $city = $geoData['city'];
    $lat  = $geoData['lat'];
    $lon  = $geoData['lon'];
} else {
    $city = $fallback;
    $lat  = "-6.2088"; 
    $lon  = "106.8456";
}
$weatherUrl = "https://api.open-meteo.com/v1/forecast?latitude={$lat}&longitude={$lon}&current_weather=true";
$weatherResponse = @file_get_contents($weatherUrl, false, $geoContext);
$weather = json_decode($weatherResponse, true);
$temp = $weather['current_weather']['temperature'] ?? '--';
$code = $weather['current_weather']['weathercode'] ?? 0;
function getWeatherStatus($code) {
    if ($code == 0) return 'Cerah';
    if ($code <= 3) return 'Cerah Berawan';
    if ($code >= 51 && $code <= 67) return 'Hujan Ringan';
    if ($code >= 71 && $code <= 82) return 'Hujan Deras';
    return 'Berawan';
}
?>

<div class="weather-widget rounded-xl border border-slate-200 bg-white overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300">
    <div class="p-4 flex items-center justify-between">
        <div class="z-10">
            <div class="flex items-center gap-1.5">
                <div class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full opacity-75" style="background-color: <?= $color ?>"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2" style="background-color: <?= $color ?>"></span>
                </div>
                <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">
                    <?= htmlspecialchars($city) ?>
                </span>
            </div>

            <div class="text-4xl font-black text-slate-800 mt-1 tracking-tighter flex items-start">
                <?= round($temp) ?><span class="text-lg font-light text-slate-400 mt-1">°C</span>
            </div>

            <div class="flex items-center gap-2 mt-1">
                <span class="px-2 py-0.5 rounded-full text-[9px] font-bold text-white uppercase" style="background: <?= $color ?>">
                    <?= getWeatherStatus($code) ?>
                </span>
                <span class="text-[9px] text-slate-400 font-medium italic">Auto-located</span>
            </div>
        </div>
        
        <div class="relative">
            <div class="absolute inset-0 blur-2xl opacity-30 rounded-full scale-150" style="background: <?= $color ?>"></div>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-14 h-14 relative z-10" style="color: <?= $color ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <?php if ($code <= 3): ?>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3v1m0 16v1m9-9h-1M4 9H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z" />
                <?php else: ?>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
                <?php endif; ?>
            </svg>
        </div>
    </div>
    
    <div class="h-1 w-full opacity-30" style="background: linear-gradient(90deg, transparent, <?= $color ?>, transparent)"></div>
</div>