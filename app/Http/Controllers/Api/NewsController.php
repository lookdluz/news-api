<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NewsResource;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $req)
    {
        $q = News::query();

        if ($search = $req->string('q')->toString()) {
            $q->where(function($w) use ($search) {
                $w->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        if ($cat = $req->string('category')->toString()) {
            $q->where('category', $cat);
        }

        if ($from = $req->date('date_from')) {
            $q->where('published_at', '>=', $from->startOfDay());
        }

        if ($to = $req->date('date_to')) {
            $q->where('published_at', '<=', $to->endOfDay());
        }

        $q->orderByDesc('published_at');

        return NewsResource::collection($q->paginate(15));
    }

    public function show(News $news)
    {
        return new NewsResource($news);
    }
}
