<?php

namespace App\Livewire\Articles;

use App\Articles\ArticleRepository;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.public')]
#[Title('Writing')]
class Index extends Component
{
    public function render()
    {
        return view('livewire.articles.index', [
            'articles' => app(ArticleRepository::class)->published(),
        ]);
    }
}
