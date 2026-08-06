<?php

namespace App\Livewire;

use App\Articles\ArticleRepository;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.public')]
class Home extends Component
{
    public function render()
    {
        return view('livewire.home', [
            'articles' => app(ArticleRepository::class)->published(),
        ]);
    }
}
