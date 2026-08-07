<?php

use Illuminate\Support\Facades\File;

function writeArticle(string $path, string $slug, string $frontMatter, string $body = 'Body.'): void
{
    File::put("{$path}/{$slug}.md", "---\n{$frontMatter}\n---\n{$body}");
}

beforeEach(function () {
    $this->articlesPath = storage_path('framework/testing/articles-'.uniqid());
    File::ensureDirectoryExists($this->articlesPath);
    config(['content.articles_path' => $this->articlesPath]);
    cache()->forget('articles.all');
});

afterEach(function () {
    File::deleteDirectory($this->articlesPath);
    cache()->forget('articles.all');
});

test('index lists published articles newest first, excludes drafts', function () {
    writeArticle($this->articlesPath, 'older', "title: Older post\ndate: 2026-06-01");
    writeArticle($this->articlesPath, 'newer', "title: Newer post\ndate: 2026-07-01");
    writeArticle($this->articlesPath, 'unpublished', "title: Not ready\ndate: 2026-08-01\ndraft: true");

    $response = $this->get(route('articles.index'));

    $response->assertOk();
    $response->assertSeeInOrder(['Newer post', 'Older post']);
    $response->assertDontSee('Not ready');
});

test('index links external articles straight to their url', function () {
    writeArticle($this->articlesPath, 'elsewhere', "title: Published elsewhere\ndate: 2026-06-01\nexternal_url: https://example.com/essay");

    $this->get(route('articles.index'))
        ->assertSee('https://example.com/essay', false);
});

test('show renders a published article', function () {
    writeArticle($this->articlesPath, 'hello', "title: Hello\ndate: 2026-06-01", 'Body content here.');

    $this->get(route('articles.show', 'hello'))
        ->assertOk()
        ->assertSee('Hello')
        ->assertSee('Body content here.');
});

test('show 404s for a draft when logged out', function () {
    writeArticle($this->articlesPath, 'draft-post', "title: Draft\ndate: 2026-06-01\ndraft: true");

    expect(app()->environment('local'))->toBeFalse();

    $this->get(route('articles.show', 'draft-post'))
        ->assertNotFound();
});

test('show 404s for an external article slug', function () {
    writeArticle($this->articlesPath, 'elsewhere', "title: Published elsewhere\ndate: 2026-06-01\nexternal_url: https://example.com/essay");

    $this->get(route('articles.show', 'elsewhere'))
        ->assertNotFound();
});

test('index shows an empty state when there are no articles', function () {
    $this->get(route('articles.index'))
        ->assertOk()
        ->assertSee('Nothing published yet.');
});

test('show links back to the writing index', function () {
    writeArticle($this->articlesPath, 'hello', "title: Hello\ndate: 2026-06-01");

    $this->get(route('articles.show', 'hello'))
        ->assertSee(route('articles.index'), false);
});
