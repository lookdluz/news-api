<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource {

    /** @return array<string,mixed> */
    public function toArray(Request $request): array {
        return [
            'id' => $this->id,
            'source' => $this->source,
            'author' => $this->author,
            'title' => $this->title,
            'description' => $this->description,
            'url' => $this->url,
            'url_to_image' => $this->url_to_image,
            'published_at' => optional($this->published_at)->toIso8601String(),
            'content' => $this->content,
            'category' => $this->category,
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}