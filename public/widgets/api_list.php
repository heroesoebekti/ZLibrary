<?php
/**
 * Widget Name: Dynamic API List
 * Widget Category: Integration
 * Widget Description: Menampilkan data dari API publik/eksternal secara dinamis.
 * Widget Config: {
"api_url": { "label": "Endpoint URL", "type": "text", "default": "https://jsonplaceholder.typicode.com/posts" },
"limit": { "label": "Jumlah Data", "type": "number", "default": "5" },
"accent_color": { "label": "Warna Tema", "type": "color", "default": "#4f46e5" }
}
 */

$info = (isset($data) && is_array($data)) ? $data : [];
$content_raw = json_decode($info['content'] ?? '{}', true) ?: [];
$apiUrl = 'https://jsonplaceholder.typicode.com/posts';
$limit  = 5;
$color  = '#4f46e5';
if (!empty($content_raw)) {
    $apiUrl = (isset($content_raw['api_url']['default'])) ? $content_raw['api_url']['default'] : ($content_raw['api_url'] ?? $apiUrl);
    $limit  = (isset($content_raw['limit']['default']))  ? $content_raw['limit']['default']  : ($content_raw['limit'] ?? $limit);
    $color  = (isset($content_raw['accent_color']['default'])) ? $content_raw['accent_color']['default'] : ($content_raw['accent_color'] ?? $color);
}

$fetchData = [];
if (!empty($apiUrl) && filter_var($apiUrl, FILTER_VALIDATE_URL)) {
    $opts = [
        "http" => [
            "method" => "GET",
            "header" => "Accept: application/json\r\n",
            "timeout" => 3
        ]
    ];
    $context = stream_context_create($opts);
    $response = @file_get_contents($apiUrl, false, $context);
    
    if ($response) {
        $json = json_decode($response, true);
        if (is_array($json)) {
            $items = isset($json['data']) ? $json['data'] : (isset($json['results']) ? $json['results'] : $json);
            $fetchData = array_slice($items, 0, (int)$limit);
        }
    }
}
?>

<div class="api-widget border rounded-lg overflow-hidden bg-white shadow-sm mb-4" style="border-color: <?= $color ?>40">
    <div class="p-3 font-bold text-white flex justify-between items-center" style="background: <?= $color ?>">
        <span class="text-[10px] uppercase tracking-widest">
            <?= htmlspecialchars($info['title'] ?? 'API Live Data') ?>
        </span>
        <span class="text-[9px] font-normal opacity-70 px-2 py-0.5 bg-black/20 rounded">
            <?= parse_url($apiUrl, PHP_URL_HOST) ?>
        </span>
    </div>

    <div class="p-4">
        <?php if (!empty($fetchData)): ?>
            <div class="space-y-3">
                <?php foreach ($fetchData as $item): 
                    $title = $item['title'] ?? ($item['name'] ?? ($item['username'] ?? 'No Title'));
                ?>
                    <div class="group border-b border-slate-50 pb-2 last:border-0 hover:bg-slate-50/50 transition-all">
                        <div class="flex items-start gap-2">
                            <div class="w-1.5 h-1.5 mt-1.5 rounded-full shrink-0" style="background: <?= $color ?>"></div>
                            <div class="text-[11px] font-semibold text-slate-700 leading-relaxed group-hover:text-indigo-600">
                                <?= htmlspecialchars($title) ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="py-4 text-center">
                <div class="text-xl mb-1">⚠️</div>
                <p class="text-[10px] text-slate-400 italic">Gagal memuat data atau URL API tidak valid.</p>
            </div>
        <?php endif; ?>
    </div>
</div>