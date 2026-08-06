<?php

namespace App\Articles;

final readonly class Article
{
    public function __construct(
        public string $title,
        public \DateTimeImmutable $date,
        public string $slug,
        public bool $draft = false,
        public ?string $externalUrl = null,
        public ?string $excerpt = null,
        public ?string $html = null,
    ) {}

    public function isExternal(): bool
    {
        return $this->externalUrl !== null;
    }
}
