<?php

namespace App\Livewire\Photos;

use App\Photos\ProjectRepository;
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
            'projects' => app(ProjectRepository::class)->all(),
        ]);
    }
}
