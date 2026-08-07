<?php

namespace App\Livewire\Photos;

use App\Photos\ProjectRepository;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.public')]
class Show extends Component
{
    public string $title;

    public ?string $description;

    /**
     * @var array<int, array{image: string, alt: ?string, caption: ?string}>
     */
    public array $photos;

    public function mount(string $slug, ProjectRepository $projects): void
    {
        $project = $projects->findBySlug($slug);

        abort_if($project === null, 404);

        $this->title = $project->title;
        $this->description = $project->description;
        $this->photos = array_map(
            fn ($p): array => ['image' => $p->image, 'alt' => $p->alt, 'caption' => $p->caption],
            $project->photos,
        );
    }

    public function render()
    {
        return view('livewire.photos.show')
            ->title($this->title);
    }
}
