---
name: alesevero
description: A quiet, flat personal site for writing and photography — no chrome, no cards, text on plain ground.
colors:
  paper: "#FDFDFC"
  ink: "#1b1b18"
  paper-dark: "#0a0a0a"
  ink-dark: "#EDEDEC"
  whisper: "#8a8a86"
typography:
  body:
    fontFamily: "'Instrument Sans', ui-sans-serif, system-ui, sans-serif"
    fontSize: "18px"
    fontWeight: 400
    lineHeight: 1.8
    letterSpacing: "normal"
  intro:
    fontFamily: "'Instrument Sans', ui-sans-serif, system-ui, sans-serif"
    fontSize: "28px"
    fontWeight: 400
    lineHeight: 1.6
    letterSpacing: "normal"
  title:
    fontFamily: "'Instrument Sans', ui-sans-serif, system-ui, sans-serif"
    fontSize: "30px"
    fontWeight: 400
    lineHeight: 1.2
    letterSpacing: "normal"
  list-item:
    fontFamily: "'Instrument Sans', ui-sans-serif, system-ui, sans-serif"
    fontSize: "22px"
    fontWeight: 400
    lineHeight: 1.4
    letterSpacing: "normal"
  label:
    fontFamily: "'Instrument Sans', ui-sans-serif, system-ui, sans-serif"
    fontSize: "14px"
    fontWeight: 400
    lineHeight: 1.4
    letterSpacing: "normal"
rounded:
  none: "0px"
spacing:
  section-y: "12vh"
  section-y-lg: "20vh"
  shell: "900px"
  reading-measure: "64ch"
components:
  link-inline:
    textColor: "{colors.ink}"
  link-inline-hover:
    textColor: "{colors.ink}"
---

# Design System: alesevero

## Overview

**Creative North Star: "The Quiet Page"**

Plain text on plain ground; the words are the only thing performing. There is no navbar, no card, no button styling, no icon system — a page is a max-width column of text with generous top-of-viewport air (`12vh`–`20vh` vertical padding) and a handful of underlined inline links. The system exists to disappear: nothing here should read as "designed" in the sense of decorated. Confirmed rejections: no serif display face (an earlier design pass explored Georgia/slab serif treatments — the shipped system is plain Instrument Sans throughout, sans-serif only), no accent color, no chrome of any kind (no header bar, no card borders, no button backgrounds).

**Key Characteristics:**
- One typeface (Instrument Sans) at five sizes, no serif, no display face
- Two-color palette per theme (ink/paper) plus one whisper gray for secondary text
- Zero elevation, zero radius — completely flat
- Layout is a single centered column; width and vertical rhythm carry all the hierarchy
- Links are the only interactive affordance: plain text, underline only on hover/focus

## Colors

The palette is two near-monochrome pairs (light/dark) plus one muted gray — no accent hue at all.

### Primary
- **Paper** (`#FDFDFC` light / `#0a0a0a` dark): the page background. Off-white rather than pure white, off-black rather than pure black — a slight warmth so the flat ground doesn't feel clinical.
- **Ink** (`#1b1b18` light / `#EDEDEC` dark): all primary text and link color. No separate link color — links are ink, distinguished only by underline on interaction.

### Neutral
- **Whisper gray** (`#8a8a86`, same value in both themes): secondary text only — dates, captions, excerpts. Never used for anything a visitor needs to act on; its whole job is to recede so ink stays the only full-contrast text on the page.

### Named Rules
**The One Ink Rule.** There is no accent color anywhere in the system. Every visual distinction (link vs. text, heading vs. body) is made with size, weight positioning, or the whisper-gray recession — never with hue. The sole exception is the photo Lightbox's scrim (see Components), which is deliberately theme-independent rather than an accent color — it doesn't add a hue, it opts out of the light/dark pairing entirely for one isolated, self-contained surface.

## Typography

**Body Font:** Instrument Sans (with `ui-sans-serif, system-ui, sans-serif` fallback)

**Character:** A single humanist sans carries every role from a 28px opening line down to 14px captions — no serif, no monospace, no second family. The pairing decision is that there is no pairing; consistency of voice matters more than contrast between roles.

### Hierarchy
- **Intro** (400, 28px, 1.6 line-height, max 24ch): the opening line on the homepage — name plus the inline links to Writing/Photos/About.
- **Title** (400, 30px, 1.2 line-height): article `<h1>` on a Writing show page.
- **List item** (400, 22px, 1.4 line-height): every list row — homepage feed, Writing index, Photos captions use a smaller label size instead.
- **Body** (400, 18px, 1.8 line-height, ~64ch max width): article body copy and the About page paragraph. Wide line-height carries the "quiet reading" feel.
- **Label** (400, 14px, 1.4 line-height): dates, excerpts, captions — always rendered in whisper gray, never ink.

### Named Rules
**The No-Weight Rule.** Nothing on the site is bold. Hierarchy comes from size and color (ink vs. whisper) only; introducing a heavier weight anywhere would be the first thing to look "designed."

## Layout

Single centered column per page, no sidebar. Every page shares one outer shell — `max-w-[900px] mx-auto px-6 sm:px-12 py-[12vh]` — so the site-nav partial and page edges never shift width when navigating between pages. This replaced an earlier per-page-width approach (640/900/1100px) that made the frame jump on every navigation; the shell is now a fixed invariant, not a per-page choice.

Long-form reading content (Article show, About) still caps its own measure at `max-w-[64ch]` — nested *inside* the 900px shell, not a competing page width. This is a reading-comfort constraint on the text column, distinct from the page's outer frame; the nav above it still spans the full shell.

### Named Rules
**The One Shell Rule.** Every page uses the same `900px` outer container. A page may narrow its own content further for reading measure (`max-w-[64ch]`) or widen an inner element up to the shell's edge, but the shell itself is never resized per page — that's what caused the width-jump this rule replaced.

Vertical rhythm is viewport-relative, not a fixed spacing scale: `py-[12vh]` top/bottom page padding is the standard; the homepage adds `mb-[20vh]` after its intro line and before its footer to keep the page feeling unhurried rather than dense. There is no responsive breakpoint tier beyond the photo grid's `sm:grid-cols-3` (2 columns below `sm`, 3 above) — text columns reflow naturally at their max-width and need no explicit mobile treatment.

## Elevation & Depth

Fully flat. No `box-shadow` anywhere in the system, no borders, no tonal surface layering. Depth is not represented at all — every element sits directly on the page background at the same visual plane. This is a confirmed, held rule, not a placeholder for later polish.

### Named Rules
**The Flat Ground Rule.** No shadows, no radius, no borders, ever. If a future component seems to need depth to read correctly, the fix is spacing or type weight, not a shadow.

## Shapes

No radius anywhere (`rounded: none` — effectively `0px` on every element, including the photo grid images). No borders. The only geometry in the system is the `aspect-[4/5]` crop Tailwind applies to photo grid thumbnails via `object-cover`; everything else is unconstrained text flow.

## Components

### Links (the only interactive primitive)
- **Style:** plain ink-colored text, no underline at rest.
- **Hover / Focus:** `hover:underline hover:underline-offset-4`. No color change, no background, no transform — underline is the entire affordance.
- **External links** (`target="_blank" rel="noopener"`): visually identical to internal links; the destination is not signaled by icon or color, only by context (excerpt text, or landing outside the site).

### Lists (Writing index, homepage feed)
- **Style:** `list-none`, vertical `space-y-6`, no dividers, no bullets, no numbering.
- **Row:** a list-item-sized link, optionally followed by a whisper-gray secondary line inline on the same line (`— {meta}`).
- **Homepage feed:** merges published articles and photo projects into one reverse-chronological list — not articles-only. Each row is a link to the article or project, followed by a whisper-gray secondary line: a plain-text type tag ("Writing" or "Photography" — text, never a colored chip or icon, per The Flat Ground / no-badges rule) and, middot-separated, the article's excerpt or the project's photo count ("Photography · 4 photos").

### Work entry (`/work`)
The page opens with a short prose intro (Body role, same `max-w-[64ch] text-lg leading-[1.8]` treatment as About) before either list — real first-person copy about how the person works, not boilerplate. A standalone one-line question in it ("Can this be simpler?") gets its own paragraph for emphasis, but no different weight, size, or color than the surrounding prose — The No-Weight Rule holds even for the most quotable line on the page; separation *is* the emphasis. Company/product mentions inline in the prose (Musora, Sunup Studios, Soundcheck) link out and carry `underline` at rest, same as Article body copy — links embedded in running text need a visible affordance the reader can't infer from position, unlike a list row or nav item, which stay underline-on-hover-only because the position itself signals "clickable."

Below the intro: two independent sections, Work then Projects, each its own heading (list-item size, 22px, no underline — it's a label, not a link) and its own list using the same `list-none space-y-6` rhythm as the Lists component above, with a two-line row instead of one: name (+ role, whisper-gray, inline) on the first line, description + date range (whisper-gray, middot-separated) on the second. Dates render as month + year ("June 2023"), not a bare year. An ongoing entry (`end: null`) reads "June 2023–present"; a finished one reads "June 2023–March 2024". Each section gets its own independent "Nothing here yet." empty state — one section having entries doesn't imply the other must.

Sort order within a section: a `primary: true` entry always comes first — the main gig stays on top even if a side project's `start` date is later — then ongoing entries before finished ones, then by `start` descending. `primary` exists because date-based sorting alone can't express "this one is definitionally the top entry regardless of when the others started."

### Photo grid
Photography is organized as projects, not a flat photo stream: `/photos` lists projects, `/photos/{slug}` shows one project's photos. Both levels reuse the same grid.
- **Style:** CSS grid, 2 columns under `sm`, 3 at `sm` and above, `gap-4` (index uses `gap-y-10` for the extra title/count line under each cover). Each tile is a full-bleed `<a>` wrapping an `aspect-[4/5] object-cover` image with an optional whisper-gray caption or title below it.
- **Project card** (index): cover image, then title at list-item size (22px) that underlines on hover, then a whisper-gray "N photos" count below it.
- **Photo tile** (project show page): cover image, then an optional whisper-gray caption; clicking opens the photo in the in-page lightbox (see Signature Component below) rather than navigating away.
- **Hover:** caption/title text shifts from whisper gray to inherited (full ink) color, or gains an underline — the only feedback in the system, never a color change on the image itself.
- **Empty state:** a single whisper-gray "Nothing here yet." line, no illustration or placeholder graphic.

### Lightbox (signature component)
Clicking any photo tile on a project page opens it full-screen in an Alpine-powered overlay — the exhibition viewing experience, not a new tab. This is the one place in the system that departs from the light/dark theme pairing on purpose: the scrim is always near-black (`#0a0a0a` at 95% opacity) regardless of site theme, because the metaphor is a gallery wall under low light, not a themed surface. Everything else about it stays inside the established vocabulary — no icon library, no shadow, no radius.
- **Open/close:** click a tile, `Escape`, click the backdrop, or the "Close" text control (top-right, whisper gray, brightens on hover) all close it. One authored transition: 200ms opacity fade, disabled site-wide under `prefers-reduced-motion: reduce`.
- **Image:** centered, `object-contain` (never cropped, unlike the grid tiles), capped at `78vh` / `90vw`.
- **Caption + position:** a caption line in `#EDEDEC` (full contrast against the dark scrim, not whisper gray — this is the one surface where the caption *is* primary content) and a small "N / total" counter beneath it in whisper gray.
- **Prev / Next:** plain text controls (`← Prev`, `Next →`) below the image, same glyph-plus-word idiom as the back links — never a bare arrow icon. Hidden entirely when the project has only one photo. Also reachable via `←`/`→` keys.

### Navigation
There is still no persistent nav bar, header, or breadcrumb component — no box, no background, no border, no sticky positioning, ever. What exists instead is a single reusable partial (`resources/views/partials/site-nav.blade.php`), included at the top of *every* page including Home: `Alexandre Severo · Writing · Photographs · About`, four plain inline links separated by a whisper-gray middot, in the exact type/link style used everywhere else in the system. It scrolls away with the page like any other line of text; it is not fixed, not elevated, not boxed.

Home's intro sentence used to carry its own copy of these links in narrative form ("Writing, photographs, about."). Once the site-nav partial covered every page, that became a duplicate — the intro is now pure identity prose ("Alexandre Severo. I write, and I take photographs.") with no embedded links, and the nav above it is the single place navigation lives.

**Superseded:** the earlier per-page "← parent" back link (used briefly on the Photos project page and the Writing article page) is retired — the site-nav partial supersedes it with full cross-site navigation from every page, not just one level up.

### Named Rules
**The One Partial Rule.** Site-wide navigation lives in exactly one file (`partials/site-nav.blade.php`), included by reference everywhere it's needed. If a page needs a different link set, that's a sign the page's information architecture changed, not a reason to fork the partial.

### Error pages (`resources/views/errors/*.blade.php`)
403/404/419/429/500/503 (plus `4xx`/`5xx` wildcards for anything else) share one layout (`errors/layout.blade.php`): the same shell, the same site-nav, a short plain-language headline (Intro-role, 28px — "This one got lost.", never the HTTP name like "Not Found"), and an optional longer description below it. No visible status code — the headline carries the meaning, not the number. The two lines are typographically distinct on purpose: headline at Intro size in ink, description at Body size (`text-lg`) in whisper gray with a wider measure (`max-w-[48ch]`) — description is optional per page (`@isset`), so a page can ship headline-only. Deliberately self-contained — no Livewire dependency, since a real 500 might originate there; a plain Blade view degrades independently of whatever broke. Auth isn't wired up yet, so nothing currently triggers a real 403 in normal use, but the page exists for when it does.

## Do's and Don'ts

### Do:
- **Do** keep every new page inside the single 900px shell — never introduce a page-specific outer width.
- **Do** use whisper gray (`#8a8a86`) for any secondary/metadata text (dates, captions, counts) — never for primary content or links.
- **Do** use `hover:underline hover:underline-offset-4` for standalone links (nav, list rows, titles) — position already signals they're clickable. For a link embedded inline in running prose (Article body, Work intro), underline it at rest instead (`[&_a]:underline` on the containing block) — the reader can't infer clickability from position there.
- **Do** use viewport-relative vertical padding (`vh` units) for page-level rhythm rather than fixed px page margins.

### Don't:
- **Don't** add a shadow, border, or border-radius anywhere — The Flat Ground Rule is absolute.
- **Don't** introduce a second typeface, a bold weight, or an accent color — The One Ink Rule and The No-Weight Rule are absolute.
- **Don't** add card containers, chips, badges, or icon systems — the system has no container components at all, only text and images.
- **Don't** add a persistent header/nav bar without deciding explicitly that The Quiet Page's no-chrome stance is being revised — it isn't a gap to silently fill.
- **Don't** give a page its own outer container width — The One Shell Rule is absolute; narrow an inner reading column instead.
