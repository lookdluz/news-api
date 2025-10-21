<?php

namespace App\Console\Commands;

use App\Models\News;
use App\Services\NewsApiService;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;

class FetchNewsCommand extends Command
{
    /**
     * Nome do comando no terminal.
     */
    protected $signature = 'news:fetch {--category=} {--q=} {--from=} {--to=} {--pageSize=50}';

    protected $description = 'Busca manchetes da NewsAPI e salva/atualiza no banco de dados.';

    public function handle(NewsApiService $api): int
    {
        $params = [
            'category' => $this->option('category') ?? env('NEWSAPI_CATEGORY', 'technology'),
            'q'        => $this->option('q'),
            'from'     => $this->option('from'),
            'to'       => $this->option('to'),
            'pageSize' => (int) $this->option('pageSize'),
        ];

        $data = $api->topHeadlines($params);
        $articles = Arr::get($data, 'articles', []);
        $count = 0;

        foreach ($articles as $a) {
            if (empty($a['url'])) continue;

            News::updateOrCreate(
                ['url' => $a['url']],
                [
                    'source'       => $a['source']['name'] ?? null,
                    'author'       => $a['author'] ?? null,
                    'title'        => $a['title'] ?? '(sem título)',
                    'description'  => $a['description'] ?? null,
                    'url_to_image' => $a['urlToImage'] ?? null,
                    'published_at' => $a['publishedAt'] ?? now(),
                    'content'      => $a['content'] ?? null,
                    'category'     => $params['category'] ?? null,
                ]
            );

            $count++;
        }

        $this->info("✅ Importados/atualizados: {$count}");
        return self::SUCCESS;
    }
}
