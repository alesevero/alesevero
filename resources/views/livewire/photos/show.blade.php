<div class="mx-auto min-h-screen max-w-[1100px] px-6 py-[12vh] sm:px-12">
    <a href="{{ route('photos.index') }}" class="text-sm text-[#8a8a86] hover:text-inherit hover:underline hover:underline-offset-4" wire:navigate>&larr; Photographs</a>

    <p class="mt-6 mb-10 text-[28px] leading-[1.6]">{{ $title }}</p>
    @if ($description)
        <p class="mb-10 max-w-[64ch] text-lg leading-[1.8] text-[#8a8a86]">{{ $description }}</p>
    @endif

    @if (empty($photos))
        <p class="text-lg text-[#8a8a86]">No photos yet.</p>
    @else
        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3">
            @foreach ($photos as $photo)
                <a wire:key="{{ $photo['image'] }}" href="{{ asset($photo['image']) }}" target="_blank" rel="noopener" class="group block">
                    <img src="{{ asset($photo['image']) }}" alt="{{ $photo['alt'] ?? $title }}" loading="lazy" class="aspect-[4/5] w-full object-cover" />
                    @if ($photo['caption'])
                        <p class="mt-2 text-sm text-[#8a8a86] group-hover:text-inherit">{{ $photo['caption'] }}</p>
                    @endif
                </a>
            @endforeach
        </div>
    @endif
</div>
