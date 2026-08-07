<div
    class="mx-auto min-h-screen max-w-[900px] px-6 py-[12vh] sm:px-12"
    x-data="{
        open: false,
        index: 0,
        photos: @js($photos),
        show(i) { this.index = i; this.open = true; },
        prev() { this.index = (this.index - 1 + this.photos.length) % this.photos.length; },
        next() { this.index = (this.index + 1) % this.photos.length; },
    }"
    @keydown.escape.window="open = false"
    @keydown.arrow-left.window="if (open) prev()"
    @keydown.arrow-right.window="if (open) next()"
>
    @include('partials.site-nav')

    <p class="mb-10 text-[28px] leading-[1.6]">{{ $title }}</p>
    @if ($description)
        <p class="mb-10 max-w-[64ch] text-lg leading-[1.8] text-[#8a8a86]">{{ $description }}</p>
    @endif

    @if (empty($photos))
        <p class="text-lg text-[#8a8a86]">No photos yet.</p>
    @else
        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3">
            @foreach ($photos as $i => $photo)
                <button
                    type="button"
                    wire:key="{{ $photo['image'] }}"
                    class="group block w-full text-left"
                    @click="show({{ $i }})"
                >
                    <img src="{{ $photo['url'] }}" alt="{{ $photo['alt'] ?? $title }}" loading="lazy" class="aspect-[4/5] w-full object-cover" />
                    @if ($photo['caption'])
                        <p class="mt-2 text-sm text-[#8a8a86] group-hover:text-inherit">{{ $photo['caption'] }}</p>
                    @endif
                </button>
            @endforeach
        </div>

        {{-- Exhibition lightbox: deliberately theme-independent (always dark), a scrim for viewing the work rather than a themed surface. --}}
        <div
            x-show="open"
            x-cloak
            x-transition.opacity.duration.200ms
            class="fixed inset-0 z-50 flex flex-col items-center justify-center bg-[#0a0a0a]/95 p-6"
            @click.self="open = false"
        >
            <button
                type="button"
                class="absolute top-6 right-6 text-sm text-[#8a8a86] hover:text-[#EDEDEC] hover:underline hover:underline-offset-4"
                @click="open = false"
            >
                Close
            </button>

            <template x-for="(photo, i) in photos" :key="photo.image">
                <img
                    x-show="index === i"
                    :src="photo.url"
                    :alt="photo.alt ?? ''"
                    class="max-h-[78vh] max-w-[90vw] object-contain"
                />
            </template>

            <p class="mt-4 max-w-[64ch] text-center text-sm text-[#EDEDEC]" x-text="photos[index]?.caption ?? ''"></p>
            <p class="mt-1 text-xs text-[#8a8a86]" x-text="(index + 1) + ' / ' + photos.length"></p>

            <div class="mt-6 flex gap-8 text-sm text-[#8a8a86]" x-show="photos.length > 1">
                <button type="button" class="hover:text-[#EDEDEC] hover:underline hover:underline-offset-4" @click="prev()">&larr; Prev</button>
                <button type="button" class="hover:text-[#EDEDEC] hover:underline hover:underline-offset-4" @click="next()">Next &rarr;</button>
            </div>
        </div>
    @endif
</div>
