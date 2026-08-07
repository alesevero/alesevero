<?php

use Illuminate\Support\Facades\File;

test('home page loads and links to writing, photos, and about', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertSee(route('articles.index'), false)
        ->assertSee(route('photos.index'), false)
        ->assertSee(route('about'), false);
});

test('about page loads', function () {
    $this->get(route('about'))->assertOk();
});

test('home shows an empty state when there are no published articles', function () {
    config(['content.articles_path' => storage_path('framework/testing/articles-'.uniqid())]);
    File::ensureDirectoryExists(config('content.articles_path'));
    cache()->forget('articles.all');

    $this->get(route('home'))
        ->assertOk()
        ->assertSee('Nothing published yet.');

    File::deleteDirectory(config('content.articles_path'));
    cache()->forget('articles.all');
});
