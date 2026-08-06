<?php

namespace App\Livewire\Articles;

use App\Articles\ArticleRepository;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.public')]
class Show extends Component
{
    public string $title;

    public string $date;

    public string $html;

    public function mount(string $slug, ArticleRepository $articles): void
    {
        $article = $articles->findBySlug($slug);

        abort_if($article === null || $article->isExternal(), 404);
        abort_if($article->draft && ! app()->environment('local') && ! auth()->check(), 404);

        $this->title = $article->title;
        $this->date = $article->date->format('Y-m-d');
        $this->html = $article->html;
    }

    public function render()
    {
        return view('livewire.articles.show')
            ->title($this->title);
    }
}
