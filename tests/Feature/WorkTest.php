<?php

use Illuminate\Support\Facades\File;

beforeEach(function () {
    $this->workPath = storage_path('framework/testing/work-'.uniqid());
    File::ensureDirectoryExists($this->workPath);
    config(['content.work_path' => $this->workPath]);
    cache()->forget('work.all');
});

afterEach(function () {
    File::deleteDirectory($this->workPath);
    cache()->forget('work.all');
});

test('shows an empty state for both sections with no entries', function () {
    $this->get(route('work.index'))
        ->assertOk()
        ->assertSeeInOrder(['Work', 'Nothing here yet.', 'Projects', 'Nothing here yet.']);
});

test('lists jobs and projects in their own sections', function () {
    File::put("{$this->workPath}/work.yaml", <<<'YAML'
    - name: Musora
      role: Senior Software Engineer
      start: 2024-01-01
    YAML);
    File::put("{$this->workPath}/projects.yaml", <<<'YAML'
    - name: Soundcheck
      url: https://soundcheck.sh
      start: 2026-01-01
    YAML);

    $this->get(route('work.index'))
        ->assertOk()
        ->assertSeeInOrder(['Work', 'Musora', 'Senior Software Engineer', 'Projects', 'Soundcheck'])
        ->assertSee('https://soundcheck.sh', false);
});

test('a list can hold multiple entries per file', function () {
    File::put("{$this->workPath}/work.yaml", <<<'YAML'
    - name: Company A
      start: 2020-01-01
    - name: Company B
      start: 2022-01-01
    YAML);

    $this->get(route('work.index'))
        ->assertOk()
        ->assertSee('Company A')
        ->assertSee('Company B');
});

test('an ongoing job shows present, a finished one shows its end month and year', function () {
    File::put("{$this->workPath}/work.yaml", <<<'YAML'
    - name: Current Co
      start: 2024-06-05
    - name: Past Co
      start: 2020-01-01
      end: 2023-03-01
    YAML);

    $this->get(route('work.index'))
        ->assertOk()
        ->assertSee('June 2024–present', false)
        ->assertSee('January 2020–March 2023', false);
});

test('intro copy links Musora, Sunup Studios, and Soundcheck to their sites', function () {
    $this->get(route('work.index'))
        ->assertOk()
        ->assertSee('https://musora.com', false)
        ->assertSee('https://sunupstudios.ca', false)
        ->assertSee('https://soundcheck.sh', false);
});

test('ongoing jobs sort before finished ones, regardless of start date', function () {
    File::put("{$this->workPath}/work.yaml", <<<'YAML'
    - name: Older Ongoing
      start: 2020-01-01
    - name: Newer Finished
      start: 2023-01-01
      end: 2024-01-01
    YAML);

    $this->get(route('work.index'))
        ->assertSeeInOrder(['Older Ongoing', 'Newer Finished']);
});

test('a primary entry sorts first even if a later-started entry is also ongoing', function () {
    File::put("{$this->workPath}/work.yaml", <<<'YAML'
    - name: Side Gig
      start: 2026-01-01
    - name: Main Gig
      start: 2020-01-01
      primary: true
    YAML);

    $this->get(route('work.index'))
        ->assertSeeInOrder(['Main Gig', 'Side Gig']);
});
