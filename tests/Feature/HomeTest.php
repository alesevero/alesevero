<?php

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
