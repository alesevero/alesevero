<?php

namespace App\Photos;

final readonly class Project
{
    /**
     * @param  array<int, PhotoImage>  $photos
     */
    public function __construct(
        public string $title,
        public \DateTimeImmutable $date,
        public string $slug,
        public string $cover,
        public ?string $description = null,
        public array $photos = [],
    ) {}
}
