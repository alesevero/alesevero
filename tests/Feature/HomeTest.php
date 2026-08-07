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

test('home shows an empty state when there are no articles or photo projects', function () {
    $articlesPath = storage_path('framework/testing/articles-'.uniqid());
    $photosPath = storage_path('framework/testing/photos-'.uniqid());
    File::ensureDirectoryExists($articlesPath);
    File::ensureDirectoryExists($photosPath);
    config(['content.articles_path' => $articlesPath, 'content.photos_path' => $photosPath]);
    cache()->forget('articles.all');
    cache()->forget('photos.projects');

    $this->get(route('home'))
        ->assertOk()
        ->assertSee('Nothing published yet.');

    File::deleteDirectory($articlesPath);
    File::deleteDirectory($photosPath);
    cache()->forget('articles.all');
    cache()->forget('photos.projects');
});

test('home feed interleaves articles and photo projects by date', function () {
    $articlesPath = storage_path('framework/testing/articles-'.uniqid());
    $photosPath = storage_path('framework/testing/photos-'.uniqid());
    File::ensureDirectoryExists($articlesPath);
    File::ensureDirectoryExists($photosPath);
    config(['content.articles_path' => $articlesPath, 'content.photos_path' => $photosPath]);
    cache()->forget('articles.all');
    cache()->forget('photos.projects');

    File::put("{$articlesPath}/older.md", "---\ntitle: Older article\ndate: 2026-06-01\n---\nBody.");
    File::put("{$photosPath}/newer.yaml", "title: Newer project\ndate: 2026-07-01\nphotos:\n  - image: images/photos/a.jpg");

    $this->get(route('home'))
        ->assertOk()
        ->assertSeeInOrder(['Newer project', 'Photography', '1 photo', 'Older article', 'Writing']);

    File::deleteDirectory($articlesPath);
    File::deleteDirectory($photosPath);
    cache()->forget('articles.all');
    cache()->forget('photos.projects');
});
