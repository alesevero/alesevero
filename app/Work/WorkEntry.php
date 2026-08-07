<?php

namespace App\Work;

enum WorkEntryType: string
{
    case Job = 'job';
    case Product = 'product';
}

final readonly class WorkEntry
{
    public function __construct(
        public string $slug,
        public WorkEntryType $type,
        public string $name,
        public ?string $role,
        public ?string $description,
        public ?string $url,
        public \DateTimeImmutable $start,
        public ?\DateTimeImmutable $end = null,
    ) {}

    public function isOngoing(): bool
    {
        return $this->end === null;
    }
}
