<?php

namespace App\Livewire;

use App\Articles\Article;
use App\Articles\ArticleRepository;
use App\Photos\Project;
use App\Photos\ProjectRepository;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.public')]
class Home extends Component
{
    public function render()
    {
        $articles = array_map(
            fn (Article $article): array => [
                'date' => $article->date,
                'title' => $article->title,
                'href' => $article->isExternal() ? $article->externalUrl : route('articles.show', $article->slug),
                'external' => $article->isExternal(),
                'tag' => 'Writing',
                'meta' => $article->excerpt,
            ],
            app(ArticleRepository::class)->published(),
        );

        $projects = array_map(
            fn (Project $project): array => [
                'date' => $project->date,
                'title' => $project->title,
                'href' => route('photos.show', $project->slug),
                'external' => false,
                'tag' => 'Photography',
                'meta' => count($project->photos).' '.Str::plural('photo', count($project->photos)),
            ],
            app(ProjectRepository::class)->all(),
        );

        $feed = [...$articles, ...$projects];

        usort($feed, fn (array $a, array $b): int => $b['date'] <=> $a['date']);

        return view('livewire.home', ['feed' => $feed]);
    }
}
