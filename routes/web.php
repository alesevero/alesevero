<?php

use App\Livewire\About;
use App\Livewire\Articles\Index as ArticlesIndex;
use App\Livewire\Articles\Show as ArticleShow;
use App\Livewire\Home;
use App\Livewire\Photos\Index as PhotosIndex;
use Illuminate\Support\Facades\Route;

Route::livewire('/', Home::class)->name('home');

Route::livewire('writing', ArticlesIndex::class)->name('articles.index');
Route::livewire('writing/{slug}', ArticleShow::class)->name('articles.show');

Route::livewire('photos', PhotosIndex::class)->name('photos.index');

Route::livewire('about', About::class)->name('about');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
