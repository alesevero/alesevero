<?php

use Illuminate\Support\Facades\Route;

test('a real 404 renders the custom error page', function () {
    $this->get('/this-route-does-not-exist')
        ->assertNotFound()
        ->assertSee('This one got lost.')
        ->assertSee("The page you were looking for doesn't exist anymore; maybe it never did.");
});

test('a 403 abort renders the custom error page', function () {
    Route::get('/test-403', fn () => abort(403));

    $this->get('/test-403')
        ->assertForbidden()
        ->assertSee('Not everything is meant to be seen.')
        ->assertSee("You don't have access to this page.");
});

test('a 500 abort renders the custom error page', function () {
    Route::get('/test-500', fn () => abort(500));

    $this->get('/test-500')
        ->assertServerError()
        ->assertSee('Something broke on this end, not yours.')
        ->assertSee('The machinery behind the scenes hit a problem. Nothing for you to fix here.');
});

test('every error page links to home, writing, photos, work, and about', function () {
    $this->get('/this-route-does-not-exist')
        ->assertSee(route('home'), false)
        ->assertSee(route('articles.index'), false)
        ->assertSee(route('photos.index'), false)
        ->assertSee(route('work.index'), false)
        ->assertSee(route('about'), false);
});

test('error pages without a description still render (419, 429)', function () {
    expect(view('errors.419', ['code' => '419', 'message' => 'x'])->render())->toContain('x');
    expect(view('errors.429', ['code' => '429', 'message' => 'x'])->render())->toContain('x');
});
