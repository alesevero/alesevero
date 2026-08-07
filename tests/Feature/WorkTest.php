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
        ->assertSeeInOrder(['Work', 'Nothing here yet.', 'Products', 'Nothing here yet.']);
});

test('lists jobs and products in their own sections', function () {
    File::put("{$this->workPath}/musora.yaml", "type: job\nname: Musora\nrole: Senior Software Engineer\nstart: 2024-01-01");
    File::put("{$this->workPath}/soundcheck.yaml", "type: product\nname: Soundcheck\nurl: https://soundcheck.sh\nstart: 2026-01-01");

    $this->get(route('work.index'))
        ->assertOk()
        ->assertSeeInOrder(['Work', 'Musora', 'Senior Software Engineer', 'Products', 'Soundcheck'])
        ->assertSee('https://soundcheck.sh', false);
});

test('an ongoing job shows present, a finished one shows its end month and year', function () {
    File::put("{$this->workPath}/current.yaml", "type: job\nname: Current Co\nstart: 2024-06-05");
    File::put("{$this->workPath}/past.yaml", "type: job\nname: Past Co\nstart: 2020-01-01\nend: 2023-03-01");

    $this->get(route('work.index'))
        ->assertOk()
        ->assertSee('June 2024–present', false)
        ->assertSee('January 2020–March 2023', false);
});

test('ongoing jobs sort before finished ones, regardless of start date', function () {
    File::put("{$this->workPath}/older-ongoing.yaml", "type: job\nname: Older Ongoing\nstart: 2020-01-01");
    File::put("{$this->workPath}/newer-finished.yaml", "type: job\nname: Newer Finished\nstart: 2023-01-01\nend: 2024-01-01");

    $this->get(route('work.index'))
        ->assertSeeInOrder(['Older Ongoing', 'Newer Finished']);
});
