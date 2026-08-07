# Product

<!-- impeccable:product-schema 1 -->

## Platform

web

## Users

Primarily a professional audience: potential clients, collaborators, and employers evaluating Alexandre Severo's engineering and creative work. Secondarily, anyone following his writing or photography — no assumed prior relationship.

## Product Purpose

A personal site that doubles as a professional presence: a place to publish writing (markdown-based articles, including links out to pieces published elsewhere) and a photography portfolio, while also surfacing his software engineering work — his role at Musora and the products he's shipped under his own studio, Sunup Studios (e.g. Soundcheck, soundcheck.sh). Success is a visitor coming away with an accurate, credible sense of who he is and what he's built or written, without any admin/CMS overhead for him to maintain it.

## Positioning

No fixed editorial niche — writing and photography are an open personal log ("whatever I feel like"), not a themed publication. What differentiates the site is the combination: working software engineer with shipped independent products (Sunup Studios), alongside personal writing and photography, presented with minimal design rather than a portfolio-template feel.

## Operating Context

Content is authored as files, not through an admin UI:
- Articles: markdown files with YAML frontmatter in `resources/articles/*.md` (supports `draft: true` and `external_url` for pieces published elsewhere).
- Photos: image files in `public/images/photos/`, each with a YAML sidecar in `resources/photos/*.yaml` (title, date, image path, alt, caption).
- Work: two YAML list files, `resources/work/work.yaml` and `resources/work/projects.yaml` (each a list of entries — add a new job/project by adding a list item, not a new file).
No database-backed content; the content path is configurable (`config/content.php`) so tests never touch real content directories.

## Capabilities and Constraints

- Stack: Laravel + Livewire 4 (Flux UI components), Tailwind. No React/Inertia (migrated away from it).
- Full-page Livewire components for Home (`/`), Writing index/show (`/writing`, `/writing/{slug}`), Photos (`/photos`), Work (`/work`), About (`/about`).
- Drafts are hidden from the public unless viewing locally or authenticated. Note: authentication is currently disabled (see below), so in production this reduces to local-only.
- External articles (`external_url` set) link straight out and 404 on their own `/writing/{slug}` route.
- No comments, no CMS, no image upload flow — content additions are manual file drops.
- Work/professional section shipped: `/work` lists jobs and projects from two YAML list files, `resources/work/work.yaml` and `resources/work/projects.yaml` (each a list of entries, not one file per entry) — currently Musora and Sunup Studios under Work, Soundcheck under Projects.
- Authentication (Fortify + Passkeys) is installed but not wired up — routes are explicitly disabled (`Fortify::ignoreRoutes()`, `Passkeys::ignoreRoutes()`) since the site has no current need for login/registration/settings. Easy to re-enable later; the packages and actions are untouched.
- Custom error pages exist for 403/404/419/429/500/503 (`resources/views/errors/*.blade.php`), self-contained (no Livewire dependency).

## Brand Commitments

- Name: Alexandre Severo.
- Current role: Senior/Staff Software Engineer at Musora.
- Runs Sunup Studios, his own indie studio/label for shipping independent products.
- Shipped product under Sunup Studios: Soundcheck (soundcheck.sh).
- Domain/handle: alesevero (site), placeholder contact `alexandre@severo.dev` used in scaffolding — not yet confirmed as the real contact address.

## Evidence on Hand

- No real bio text written yet — homepage and About page currently carry placeholder copy the user must edit directly.
- 3 placeholder/test articles exist in `resources/articles/` (published, draft, external-link examples) — for testing the pipeline, not real content.
- 4 real photos uploaded to `public/images/photos/` with YAML sidecars in `resources/photos/`; titles are still placeholders ("Photo 1"–"4") pending real captions.
- No case studies, testimonials, or press — none should be fabricated.
- Musora and Soundcheck/Sunup Studios have no on-site representation yet (no logos, links, or copy captured).

## Product Principles

1. Content lives in files the user edits directly — no admin UI, no database, to keep upkeep near zero.
2. Extreme minimalism: quiet typography and whitespace over chrome, cards, or decoration.
3. The site must read as credible to a professional visitor (potential client/employer) while staying a genuine personal log, not a marketing page.
4. Never fabricate bio copy, testimonials, or work history — placeholders are left obviously blank until the user supplies real text.
5. Drafts and unpublished work stay private by default; publishing is an explicit, file-level action.

## Accessibility & Inclusion

No product-specific requirement established beyond standard web accessibility (semantic HTML, keyboard focus, alt text on photos via the YAML sidecar's `alt` field).
