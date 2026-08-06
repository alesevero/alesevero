<?php

namespace App\Photos;

final readonly class Photo
{
    public function __construct(
        public string $title,
        public \DateTimeImmutable $date,
        public string $slug,
        public string $image,
        public ?string $alt = null,
        public ?string $caption = null,
    ) {}
}
