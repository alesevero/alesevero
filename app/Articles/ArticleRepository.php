<?php

namespace App\Articles;

use League\CommonMark\CommonMarkConverter;
use Symfony\Component\Yaml\Yaml;

class ArticleRepository
{
    /**
     * All articles, sorted newest first. Drafts included — filter with published() for public views.
     *
     * @return array<int, Article>
     */
    public function all(): array
    {
        // Cache plain arrays, not Article objects: readonly properties can't survive
        // the default unserialize() (it bypasses the constructor), which corrupts the object.
        $rows = cache()->remember('articles.all', now()->addDay(), function (): array {
            $files = glob(config('content.articles_path').'/*.md') ?: [];

            $articles = array_map($this->parse(...), $files);

            usort($articles, fn (Article $a, Article $b): int => $b->date <=> $a->date);

            return array_map($this->toArray(...), $articles);
        });

        return array_map($this->fromArray(...), $rows);
    }

    /**
     * Articles safe to show publicly: no drafts, unless viewing locally or authenticated.
     *
     * @return array<int, Article>
     */
    public function published(): array
    {
        if (app()->environment('local') || auth()->check()) {
            return $this->all();
        }

        return array_values(array_filter($this->all(), fn (Article $article): bool => ! $article->draft));
    }

    public function findBySlug(string $slug): ?Article
    {
        foreach ($this->all() as $article) {
            if ($article->slug === $slug) {
                return $article;
            }
        }

        return null;
    }

    private function parse(string $path): Article
    {
        $slug = pathinfo($path, PATHINFO_FILENAME);
        $raw = file_get_contents($path);

        [$frontMatter, $body] = $this->splitFrontMatter($raw);

        $html = $frontMatter['external_url'] ?? null
            ? null
            : (new CommonMarkConverter)->convert($body)->getContent();

        $date = $frontMatter['date'] ?? 'now';

        return new Article(
            title: $frontMatter['title'] ?? $slug,
            date: match (true) {
                $date instanceof \DateTimeInterface => \DateTimeImmutable::createFromInterface($date),
                is_int($date) => new \DateTimeImmutable('@'.$date),
                default => new \DateTimeImmutable((string) $date),
            },
            slug: $slug,
            draft: (bool) ($frontMatter['draft'] ?? false),
            externalUrl: $frontMatter['external_url'] ?? null,
            excerpt: $frontMatter['excerpt'] ?? null,
            html: $html,
        );
    }

    /**
     * @return array<string, mixed>
     */
    private function toArray(Article $article): array
    {
        return [
            'title' => $article->title,
            'date' => $article->date->format(\DateTimeInterface::ATOM),
            'slug' => $article->slug,
            'draft' => $article->draft,
            'externalUrl' => $article->externalUrl,
            'excerpt' => $article->excerpt,
            'html' => $article->html,
        ];
    }

    /**
     * @param  array<string, mixed>  $row
     */
    private function fromArray(array $row): Article
    {
        return new Article(
            title: $row['title'],
            date: new \DateTimeImmutable($row['date']),
            slug: $row['slug'],
            draft: $row['draft'],
            externalUrl: $row['externalUrl'],
            excerpt: $row['excerpt'],
            html: $row['html'],
        );
    }

    /**
     * @return array{0: array<string, mixed>, 1: string}
     */
    private function splitFrontMatter(string $raw): array
    {
        if (! str_starts_with($raw, '---')) {
            return [[], $raw];
        }

        $parts = explode('---', $raw, 3);

        if (count($parts) < 3) {
            return [[], $raw];
        }

        [, $yaml, $body] = $parts;

        return [Yaml::parse($yaml) ?? [], ltrim($body)];
    }
}
