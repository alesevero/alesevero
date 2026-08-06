<?php

namespace App\Photos;

use Symfony\Component\Yaml\Yaml;

class PhotoRepository
{
    /**
     * All photos, sorted newest first. Each is a .yaml file with frontmatter
     * (title, date, image, alt, caption) — the image itself lives in public/images/photos.
     *
     * @return array<int, Photo>
     */
    public function all(): array
    {
        // Cache plain arrays, not Photo objects: readonly properties can't survive
        // the default unserialize() (it bypasses the constructor), which corrupts the object.
        $rows = cache()->remember('photos.all', now()->addMinutes(5), function (): array {
            $files = glob(config('content.photos_path').'/*.yaml') ?: [];

            $photos = array_map($this->parse(...), $files);

            usort($photos, fn (Photo $a, Photo $b): int => $b->date <=> $a->date);

            return array_map($this->toArray(...), $photos);
        });

        return array_map($this->fromArray(...), $rows);
    }

    private function parse(string $path): Photo
    {
        $slug = pathinfo($path, PATHINFO_FILENAME);
        $frontMatter = Yaml::parseFile($path) ?? [];

        $date = $frontMatter['date'] ?? 'now';

        return new Photo(
            title: $frontMatter['title'] ?? $slug,
            date: match (true) {
                $date instanceof \DateTimeInterface => \DateTimeImmutable::createFromInterface($date),
                is_int($date) => new \DateTimeImmutable('@'.$date),
                default => new \DateTimeImmutable((string) $date),
            },
            slug: $slug,
            image: $frontMatter['image'] ?? '',
            alt: $frontMatter['alt'] ?? null,
            caption: $frontMatter['caption'] ?? null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    private function toArray(Photo $photo): array
    {
        return [
            'title' => $photo->title,
            'date' => $photo->date->format(\DateTimeInterface::ATOM),
            'slug' => $photo->slug,
            'image' => $photo->image,
            'alt' => $photo->alt,
            'caption' => $photo->caption,
        ];
    }

    /**
     * @param  array<string, mixed>  $row
     */
    private function fromArray(array $row): Photo
    {
        return new Photo(
            title: $row['title'],
            date: new \DateTimeImmutable($row['date']),
            slug: $row['slug'],
            image: $row['image'],
            alt: $row['alt'],
            caption: $row['caption'],
        );
    }
}
