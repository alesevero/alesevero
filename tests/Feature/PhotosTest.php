<?php

use Illuminate\Support\Facades\File;

beforeEach(function () {
    $this->photosPath = storage_path('framework/testing/photos-'.uniqid());
    File::ensureDirectoryExists($this->photosPath);
    config(['content.photos_path' => $this->photosPath]);
    cache()->forget('photos.projects');
});

afterEach(function () {
    File::deleteDirectory($this->photosPath);
    cache()->forget('photos.projects');
});

test('index shows an empty state with no projects', function () {
    $this->get(route('photos.index'))
        ->assertOk()
        ->assertSee('Nothing here yet.');
});

test('index lists projects by their cover and photo count', function () {
    File::put("{$this->photosPath}/lisbon.yaml", <<<'YAML'
    title: Lisbon
    date: 2026-07-02
    cover: images/photos/alfama.jpg
    photos:
      - image: images/photos/alfama.jpg
      - image: images/photos/tram.jpg
    YAML);

    $this->get(route('photos.index'))
        ->assertOk()
        ->assertSee('Lisbon')
        ->assertSee('2 photos')
        ->assertSee('images/photos/alfama.jpg', false);
});

test('show renders a project with its photos', function () {
    File::put("{$this->photosPath}/lisbon.yaml", <<<'YAML'
    title: Lisbon
    date: 2026-07-02
    description: A week in July.
    photos:
      - image: images/photos/alfama.jpg
        caption: Alfama stairwell
      - image: images/photos/tram.jpg
    YAML);

    $this->get(route('photos.show', 'lisbon'))
        ->assertOk()
        ->assertSee('Lisbon')
        ->assertSee('A week in July.')
        ->assertSee('Alfama stairwell')
        ->assertSee('images/photos/tram.jpg', false);
});

test('show 404s for an unknown project', function () {
    $this->get(route('photos.show', 'nonexistent'))
        ->assertNotFound();
});

test('show links back to the projects index', function () {
    File::put("{$this->photosPath}/lisbon.yaml", "title: Lisbon\ndate: 2026-07-02\nphotos: []");

    $this->get(route('photos.show', 'lisbon'))
        ->assertSee(route('photos.index'), false);
});

test('show renders an empty state for a project with no photos', function () {
    File::put("{$this->photosPath}/lisbon.yaml", "title: Lisbon\ndate: 2026-07-02\nphotos: []");

    $this->get(route('photos.show', 'lisbon'))
        ->assertOk()
        ->assertSee('No photos yet.');
});
