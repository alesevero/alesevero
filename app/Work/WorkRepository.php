<?php

namespace App\Work;

use Illuminate\Support\Str;
use Symfony\Component\Yaml\Yaml;

class WorkRepository
{
    /**
     * All entries, jobs and projects alike. A `primary: true` entry always sorts first
     * (the main gig, regardless of when a side project started); otherwise ongoing entries
     * sort before finished ones, then by start date descending. Jobs live in work.yaml,
     * projects in projects.yaml — each a YAML list of entries, not one file per entry.
     *
     * @return array<int, WorkEntry>
     */
    public function all(): array
    {
        // Cache plain arrays, not WorkEntry objects: readonly properties can't survive
        // the default unserialize() (it bypasses the constructor), which corrupts the object.
        $rows = cache()->remember('work.all', now()->addDay(), function (): array {
            $entries = [
                ...$this->parseFile('work.yaml', WorkEntryType::Job),
                ...$this->parseFile('projects.yaml', WorkEntryType::Project),
            ];

            usort($entries, function (WorkEntry $a, WorkEntry $b): int {
                if ($a->primary !== $b->primary) {
                    return $a->primary ? -1 : 1;
                }

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
    public function projects(): array
    {
        return array_values(array_filter($this->all(), fn (WorkEntry $entry): bool => $entry->type === WorkEntryType::Project));
    }

    /**
     * @return array<int, WorkEntry>
     */
    private function parseFile(string $filename, WorkEntryType $type): array
    {
        $path = config('content.work_path').'/'.$filename;

        if (! file_exists($path)) {
            return [];
        }

        $rows = Yaml::parseFile($path) ?? [];

        return array_map(fn (array $row): WorkEntry => $this->parseEntry($row, $type), $rows);
    }

    /**
     * @param  array<string, mixed>  $row
     */
    private function parseEntry(array $row, WorkEntryType $type): WorkEntry
    {
        $name = $row['name'] ?? 'Untitled';

        return new WorkEntry(
            slug: Str::slug($name),
            type: $type,
            name: $name,
            role: $row['role'] ?? null,
            description: $row['description'] ?? null,
            url: $row['url'] ?? null,
            start: $this->toDate($row['start'] ?? 'now'),
            end: isset($row['end']) ? $this->toDate($row['end']) : null,
            primary: (bool) ($row['primary'] ?? false),
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
            'primary' => $entry->primary,
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
            primary: $row['primary'],
        );
    }
}
