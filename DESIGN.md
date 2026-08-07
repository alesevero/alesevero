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
  container-sm: "480px"
  container-md: "640px"
  container-lg: "900px"
  container-xl: "1100px"
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
**The One Ink Rule.** There is no accent color anywhere in the system. Every visual distinction (link vs. text, heading vs. body) is made with size, weight positioning, or the whisper-gray recession — never with hue.

## Typography

**Body Font:** Instrument Sans (with `ui-sans-serif, system-ui, sans-serif` fallback)

**Character:** A single humanist sans carries every role from a 28px opening line down to 14px captions — no serif, no monospace, no second family. The pairing decision is that there is no pairing; consistency of voice matters more than contrast between roles.

### Hierarchy
- **Intro** (400, 28px, 1.6 line-height, max 24ch): the opening line on the homepage — name plus the inline links to Writing/Photos/About.
- **Title** (400, 30px, 1.2 line-height): article `<h1>` on a Writing show page.
- **List item** (400, 22px, 1.4 line-height): every list row — homepage recent-articles list, Writing index, Photos captions use a smaller label size instead.
- **Body** (400, 18px, 1.8 line-height, ~64ch max width): article body copy and the About page paragraph. Wide line-height carries the "quiet reading" feel.
- **Label** (400, 14px, 1.4 line-height): dates, excerpts, captions — always rendered in whisper gray, never ink.

### Named Rules
**The No-Weight Rule.** Nothing on the site is bold. Hierarchy comes from size and color (ink vs. whisper) only; introducing a heavier weight anywhere would be the first thing to look "designed."

## Layout

Single centered column per page, no sidebar, no multi-column grid except the photo index. Containers are Tailwind arbitrary max-widths chosen per page's content, not a shared grid system: `640px` (About, article show — optimized for reading measure), `900px` (Home, Writing index), `1100px` (Photos index, wider to hold the 2–3 column image grid). Horizontal padding is `px-6` to `px-12` depending on container.

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

### Lists (articles, homepage preview)
- **Style:** `list-none`, vertical `space-y-6`, no dividers, no bullets, no numbering.
- **Row:** a list-item-sized link, optionally followed by a whisper-gray excerpt inline on the same line (`— {excerpt}`).

### Photo grid
Photography is organized as projects, not a flat photo stream: `/photos` lists projects, `/photos/{slug}` shows one project's photos. Both levels reuse the same grid.
- **Style:** CSS grid, 2 columns under `sm`, 3 at `sm` and above, `gap-4` (index uses `gap-y-10` for the extra title/count line under each cover). Each tile is a full-bleed `<a>` wrapping an `aspect-[4/5] object-cover` image with an optional whisper-gray caption or title below it.
- **Project card** (index): cover image, then title at list-item size (22px) that underlines on hover, then a whisper-gray "N photos" count below it.
- **Photo tile** (project show page): cover image, then an optional whisper-gray caption; clicking opens the full image directly (`target="_blank"`), same as the old flat grid.
- **Hover:** caption/title text shifts from whisper gray to inherited (full ink) color, or gains an underline — the only feedback in the system, never a color change on the image itself.
- **Empty state:** a single whisper-gray "Nothing here yet." line, no illustration or placeholder graphic.

### Navigation
There is no persistent nav bar or header. Navigation is three inline text links embedded in the homepage's intro sentence (Writing / Photographs / About); most pages have no way back except the browser's back button or re-visiting `/`. This is a deliberate consequence of The Flat Ground / Quiet Page rules, not an oversight.

**Confirmed exception:** any page one level below an index that a visitor might browse in sequence carries a single plain-text back link (whisper gray, brightens/underlines on hover, positioned above the page's own title) to its parent list — a nav bar or breadcrumb was never introduced, just this one inline link. In use on the Photos project page (`← Photographs`) and the Writing article page (`← Writing`). Index pages themselves (`/writing`, `/photos`, `/about`) stay without one, reachable only from the homepage's intro sentence, same as before.

## Do's and Don'ts

### Do:
- **Do** keep every new page to a single centered column at one of the four established container widths (480/640/900/1100px).
- **Do** use whisper gray (`#8a8a86`) for any secondary/metadata text (dates, captions, counts) — never for primary content or links.
- **Do** use `hover:underline hover:underline-offset-4` as the only interactive-state treatment for links.
- **Do** use viewport-relative vertical padding (`vh` units) for page-level rhythm rather than fixed px page margins.

### Don't:
- **Don't** add a shadow, border, or border-radius anywhere — The Flat Ground Rule is absolute.
- **Don't** introduce a second typeface, a bold weight, or an accent color — The One Ink Rule and The No-Weight Rule are absolute.
- **Don't** add card containers, chips, badges, or icon systems — the system has no container components at all, only text and images.
- **Don't** add a persistent header/nav bar without deciding explicitly that The Quiet Page's no-chrome stance is being revised — it isn't a gap to silently fill.
