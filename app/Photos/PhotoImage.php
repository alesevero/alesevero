<?php

namespace App\Photos;

final readonly class PhotoImage
{
    public function __construct(
        public string $image,
        public ?string $alt = null,
        public ?string $caption = null,
    ) {}
}
