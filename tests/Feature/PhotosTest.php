<?php

use Illuminate\Support\Facades\File;

beforeEach(function () {
    $this->photosPath = storage_path('framework/testing/photos-'.uniqid());
    File::ensureDirectoryExists($this->photosPath);
    config(['content.photos_path' => $this->photosPath]);
    cache()->forget('photos.all');
});

afterEach(function () {
    File::deleteDirectory($this->photosPath);
    cache()->forget('photos.all');
});

test('index shows an empty state with no photos', function () {
    $this->get(route('photos.index'))
        ->assertOk()
        ->assertSee('Nothing here yet.');
});

test('index lists photos by their metadata', function () {
    File::put("{$this->photosPath}/alfama.yaml", <<<'YAML'
    title: Alfama stairwell
    date: 2026-07-02
    image: images/photos/alfama.jpg
    alt: A narrow stairwell in Alfama
    caption: Lisbon, July
    YAML);

    $this->get(route('photos.index'))
        ->assertOk()
        ->assertSee('Lisbon, July')
        ->assertSee('images/photos/alfama.jpg', false);
});
