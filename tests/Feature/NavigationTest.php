<?php

use Illuminate\Support\Facades\File;
use Illuminate\Testing\TestResponse;

function assertHasSiteNav(TestResponse $response): void
{
    $response->assertOk()
        ->assertSee(route('home'), false)
        ->assertSee(route('articles.index'), false)
        ->assertSee(route('photos.index'), false)
        ->assertSee(route('work.index'), false)
        ->assertSee(route('about'), false);
}

test('every index page links to home, writing, photos, work, and about', function (string $routeName) {
    assertHasSiteNav($this->get(route($routeName)));
})->with(['home', 'articles.index', 'photos.index', 'work.index', 'about']);

test('an article show page links to home, writing, photos, work, and about', function () {
    $path = storage_path('framework/testing/articles-'.uniqid());
    File::ensureDirectoryExists($path);
    config(['content.articles_path' => $path]);
    cache()->forget('articles.all');

    File::put("{$path}/hello.md", "---\ntitle: Hello\ndate: 2026-06-01\n---\nBody.");

    assertHasSiteNav($this->get(route('articles.show', 'hello')));

    File::deleteDirectory($path);
    cache()->forget('articles.all');
});

test('a photos project show page links to home, writing, photos, work, and about', function () {
    $path = storage_path('framework/testing/photos-'.uniqid());
    File::ensureDirectoryExists($path);
    config(['content.photos_path' => $path]);
    cache()->forget('photos.projects');

    File::put("{$path}/lisbon.yaml", "title: Lisbon\ndate: 2026-07-02\nphotos: []");

    assertHasSiteNav($this->get(route('photos.show', 'lisbon')));

    File::deleteDirectory($path);
    cache()->forget('photos.projects');
});
