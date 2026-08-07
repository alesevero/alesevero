<?php

namespace App\Livewire\Work;

use App\Work\WorkRepository;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.public')]
#[Title('Work')]
class Index extends Component
{
    public function render()
    {
        $work = app(WorkRepository::class);

        return view('livewire.work.index', [
            'jobs' => $work->jobs(),
            'products' => $work->products(),
        ]);
    }
}
