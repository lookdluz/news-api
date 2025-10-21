<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class NewsApiService
{
    private string $base;
    private string $key;

    public function __construct()
    {
        $this->base = env('NEWSAPI_BASE', 'https://newsapi.org/v2');
        $this->key  = env('NEWSAPI_KEY', '');
    }

    public function topHeadlines(array $params = []): array
    {
        $query = array_filter([
            'apiKey'   => $this->key,
            'q'        => $params['q'] ?? null,
            'category' => $params['category'] ?? env('NEWSAPI_CATEGORY', 'technology'),
            'country'  => $params['country'] ?? env('NEWSAPI_COUNTRY', 'us'),
            'from'     => $params['from'] ?? null,
            'to'       => $params['to'] ?? null,
            'page'     => $params['page'] ?? 1,
            'pageSize' => $params['pageSize'] ?? 50,
        ]);

        $response = Http::timeout(10)->get(rtrim($this->base, '/') . '/top-headlines', $query);
        $response->throw();

        return $response->json();
    }
}
