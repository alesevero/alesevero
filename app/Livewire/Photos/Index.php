<?php

namespace App\Livewire\Photos;

use App\Photos\PhotoRepository;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.public')]
#[Title('Photographs')]
class Index extends Component
{
    public function render()
    {
        return view('livewire.photos.index', [
            'photos' => app(PhotoRepository::class)->all(),
        ]);
    }
}
