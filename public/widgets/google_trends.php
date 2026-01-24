<?php
/**
 * Widget Name: Google Trending Topics
 *  * Widget Category: Sidebar Widget
 * Widget Description: Menampilkan tren pencarian harian dari Google Trends RSS.
 */

if (!headers_sent()) {
    header("Content-Security-Policy: default-src 'self'; connect-src 'self' https://trends.google.com; img-src 'self' https://*.gstatic.com https://*.google.com data:; style-src 'self' 'unsafe-inline';");
}

$info = (isset($data) && is_array($data)) ? $data : [];
$config = json_decode($info['content'] ?? '{}', true) ?: [];

$geo = strtoupper($config['geo'] ?? 'ID'); 
$limit = (int)($config['limit'] ?? 5);
$color = $config['color'] ?? '#4285F4'; 
$rssUrl = "https://trends.google.com/trends/trendingsearches/daily/rss?geo=" . $geo;
$ctx = stream_context_create([
    "http" => [
        "timeout" => 5,
        "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36\r\n"
    ]
]);

$xmlString = @file_get_contents($rssUrl, false, $ctx);
$trends = [];

if ($xmlString) {
    $xml = @simplexml_load_string($xmlString);
    if ($xml && isset($xml->channel->item)) {
        foreach ($xml->channel->item as $item) {
            $ns_ht = $item->children('https://trends.google.com/trends/trendingsearches/daily');     
            $trends[] = [
                'title'   => (string)$item->title,
                'traffic' => (string)$ns_ht->approx_traffic,
                'link'    => (string)$item->link,
                'picture' => (string)$ns_ht->picture
            ];
            
            if (count($trends) >= $limit) break;
        }
    }
}
?>

<div class="google-trends-widget rounded-2xl border border-slate-200 bg-white overflow-hidden shadow-sm transition-all hover:shadow-md">
    
    <div class="p-4 flex items-center justify-between border-b border-slate-50" style="background: <?= $color ?>05">
        <div class="flex items-center gap-2">
            <div class="p-1.5 rounded-lg" style="background: <?= $color ?>15">
                <svg viewBox="0 0 24 24" class="w-4 h-4" fill="<?= $color ?>">
                    <path d="M21.35 11.1L12.18 2.1c-.37-.38-.97-.38-1.35 0L1.65 11.1c-.38.37-.38.97 0 1.35l2.12 2.12c.38.37.98.37 1.35 0L11 8.71V21c0 .55.45 1 1 1s1-.45 1-1V8.71l5.88 5.88c.37.37.98.37 1.35 0l2.12-2.12c.38-.38.38-.98 0-1.35z"/>
                </svg>
            </div>
            <div>
                <h4 class="text-[11px] font-black text-slate-800 uppercase tracking-wider leading-none">
                    <?= htmlspecialchars((string)($info['title'] ?? 'Trending Topics')) ?>
                </h4>
                <span class="text-[9px] text-slate-400 font-bold uppercase">Wilayah: <?= $geo ?></span>
            </div>
        </div>
        <span class="text-[9px] font-mono font-bold text-slate-300"><?= date('H:i') ?></span>
    </div>

    <div class="divide-y divide-slate-50">
        <?php if (!empty($trends)): ?>
            <?php foreach ($trends as $index => $item): ?>
                <a href="<?= htmlspecialchars($item['link']) ?>" target="_blank" rel="noopener" class="flex items-center p-3.5 hover:bg-slate-50/80 transition-all group">
                    <div class="text-xl font-black text-slate-100 group-hover:text-slate-200 w-8 shrink-0 transition-colors">
                        <?= $index + 1 ?>
                    </div>
                    
                    <div class="flex-1 px-3">
                        <div class="text-xs font-bold text-slate-700 leading-tight group-hover:text-blue-600 transition-colors line-clamp-1">
                            <?= htmlspecialchars($item['title']) ?>
                        </div>
                        <div class="flex items-center gap-1.5 mt-1">
                            <span class="w-1 h-1 rounded-full bg-blue-400"></span>
                            <span class="text-[10px] text-slate-400 font-medium">
                                <?= $item['traffic'] ?> pencarian
                            </span>
                        </div>
                    </div>

                    <?php if($item['picture']): ?>
                        <div class="w-12 h-12 rounded-xl bg-slate-100 overflow-hidden shrink-0 border border-slate-100 shadow-sm">
                            <img src="<?= htmlspecialchars($item['picture']) ?>" 
                                 alt="<?= htmlspecialchars($item['title']) ?>" 
                                 class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500 scale-105 group-hover:scale-110"
                                 loading="lazy">
                        </div>
                    <?php endif; ?>
                </a>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="p-10 text-center">
                <div class="w-12 h-12 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest italic">Data tidak tersedia</p>
                <p class="text-[9px] text-slate-300 mt-1">Gagal mengambil tren terbaru dari Google.</p>
            </div>
        <?php endif; ?>
    </div>

    <a href="https://trends.google.com/trends/trendingsearches/daily?geo=<?= $geo ?>" target="_blank" rel="noopener" class="block p-3 bg-slate-50/50 text-center border-t border-slate-50 group hover:bg-slate-100 transition-colors">
        <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest group-hover:text-slate-600">
            Selengkapnya di Google Trends
        </span>
    </a>
</div>