<?php

namespace App\Work;

use Symfony\Component\Yaml\Yaml;

class WorkRepository
{
    /**
     * All entries, jobs and products alike. Ongoing entries (no end date) sort first,
     * then by start date descending.
     *
     * @return array<int, WorkEntry>
     */
    public function all(): array
    {
        // Cache plain arrays, not WorkEntry objects: readonly properties can't survive
        // the default unserialize() (it bypasses the constructor), which corrupts the object.
        $rows = cache()->remember('work.all', now()->addDay(), function (): array {
            $files = glob(config('content.work_path').'/*.yaml') ?: [];

            $entries = array_map($this->parse(...), $files);

            usort($entries, function (WorkEntry $a, WorkEntry $b): int {
                if ($a->isOngoing() !== $b->isOngoing()) {
                    return $a->isOngoing() ? -1 : 1;
                }

                return $b->start <=> $a->start;
            });

            return array_map($this->toArray(...), $entries);
        });

        return array_map($this->fromArray(...), $rows);
    }

    /**
     * @return array<int, WorkEntry>
     */
    public function jobs(): array
    {
        return array_values(array_filter($this->all(), fn (WorkEntry $entry): bool => $entry->type === WorkEntryType::Job));
    }

    /**
     * @return array<int, WorkEntry>
     */
    public function products(): array
    {
        return array_values(array_filter($this->all(), fn (WorkEntry $entry): bool => $entry->type === WorkEntryType::Product));
    }

    private function parse(string $path): WorkEntry
    {
        $slug = pathinfo($path, PATHINFO_FILENAME);
        $frontMatter = Yaml::parseFile($path) ?? [];

        return new WorkEntry(
            slug: $slug,
            type: WorkEntryType::from($frontMatter['type'] ?? 'job'),
            name: $frontMatter['name'] ?? $slug,
            role: $frontMatter['role'] ?? null,
            description: $frontMatter['description'] ?? null,
            url: $frontMatter['url'] ?? null,
            start: $this->toDate($frontMatter['start'] ?? 'now'),
            end: isset($frontMatter['end']) ? $this->toDate($frontMatter['end']) : null,
        );
    }

    private function toDate(mixed $date): \DateTimeImmutable
    {
        return match (true) {
            $date instanceof \DateTimeInterface => \DateTimeImmutable::createFromInterface($date),
            is_int($date) => new \DateTimeImmutable('@'.$date),
            default => new \DateTimeImmutable((string) $date),
        };
    }

    /**
     * @return array<string, mixed>
     */
    private function toArray(WorkEntry $entry): array
    {
        return [
            'slug' => $entry->slug,
            'type' => $entry->type->value,
            'name' => $entry->name,
            'role' => $entry->role,
            'description' => $entry->description,
            'url' => $entry->url,
            'start' => $entry->start->format(\DateTimeInterface::ATOM),
            'end' => $entry->end?->format(\DateTimeInterface::ATOM),
        ];
    }

    /**
     * @param  array<string, mixed>  $row
     */
    private function fromArray(array $row): WorkEntry
    {
        return new WorkEntry(
            slug: $row['slug'],
            type: WorkEntryType::from($row['type']),
            name: $row['name'],
            role: $row['role'],
            description: $row['description'],
            url: $row['url'],
            start: new \DateTimeImmutable($row['start']),
            end: $row['end'] !== null ? new \DateTimeImmutable($row['end']) : null,
        );
    }
}
