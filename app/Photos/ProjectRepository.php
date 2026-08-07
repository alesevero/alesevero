<?php

namespace App\Photos;

use Symfony\Component\Yaml\Yaml;

class ProjectRepository
{
    /**
     * All projects, sorted newest first. Each is a .yaml file: project metadata
     * plus a `photos:` list (image, alt, caption) — images live in public/images/photos.
     *
     * @return array<int, Project>
     */
    public function all(): array
    {
        // Cache plain arrays, not Project objects: readonly properties can't survive
        // the default unserialize() (it bypasses the constructor), which corrupts the object.
        $rows = cache()->remember('photos.projects', now()->addDay(), function (): array {
            $files = glob(config('content.photos_path').'/*.yaml') ?: [];

            $projects = array_map($this->parse(...), $files);

            usort($projects, fn (Project $a, Project $b): int => $b->date <=> $a->date);

            return array_map($this->toArray(...), $projects);
        });

        return array_map($this->fromArray(...), $rows);
    }

    public function findBySlug(string $slug): ?Project
    {
        foreach ($this->all() as $project) {
            if ($project->slug === $slug) {
                return $project;
            }
        }

        return null;
    }

    private function parse(string $path): Project
    {
        $slug = pathinfo($path, PATHINFO_FILENAME);
        $frontMatter = Yaml::parseFile($path) ?? [];

        $date = $frontMatter['date'] ?? 'now';

        $photos = array_map(
            fn (array $p): PhotoImage => new PhotoImage(
                image: $p['image'] ?? '',
                alt: $p['alt'] ?? null,
                caption: $p['caption'] ?? null,
            ),
            $frontMatter['photos'] ?? [],
        );

        return new Project(
            title: $frontMatter['title'] ?? $slug,
            date: match (true) {
                $date instanceof \DateTimeInterface => \DateTimeImmutable::createFromInterface($date),
                is_int($date) => new \DateTimeImmutable('@'.$date),
                default => new \DateTimeImmutable((string) $date),
            },
            slug: $slug,
            cover: $frontMatter['cover'] ?? ($photos[0]->image ?? ''),
            description: $frontMatter['description'] ?? null,
            photos: $photos,
        );
    }

    /**
     * @return array<string, mixed>
     */
    private function toArray(Project $project): array
    {
        return [
            'title' => $project->title,
            'date' => $project->date->format(\DateTimeInterface::ATOM),
            'slug' => $project->slug,
            'cover' => $project->cover,
            'description' => $project->description,
            'photos' => array_map(
                fn (PhotoImage $p): array => ['image' => $p->image, 'alt' => $p->alt, 'caption' => $p->caption],
                $project->photos,
            ),
        ];
    }

    /**
     * @param  array<string, mixed>  $row
     */
    private function fromArray(array $row): Project
    {
        return new Project(
            title: $row['title'],
            date: new \DateTimeImmutable($row['date']),
            slug: $row['slug'],
            cover: $row['cover'],
            description: $row['description'],
            photos: array_map(
                fn (array $p): PhotoImage => new PhotoImage($p['image'], $p['alt'], $p['caption']),
                $row['photos'],
            ),
        );
    }
}
