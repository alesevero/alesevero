<div class="mx-auto min-h-screen max-w-[1100px] px-12 py-[12vh]">
    @if (empty($photos))
        <p class="text-lg text-[#8a8a86]">Nothing here yet.</p>
    @else
        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3">
            @foreach ($photos as $photo)
                <a wire:key="{{ $photo->slug }}" href="{{ asset($photo->image) }}" target="_blank" rel="noopener" class="group block">
                    <img src="{{ asset($photo->image) }}" alt="{{ $photo->alt ?? $photo->title }}" loading="lazy" class="aspect-[4/5] w-full object-cover" />
                    @if ($photo->caption)
                        <p class="mt-2 text-sm text-[#8a8a86] group-hover:text-inherit">{{ $photo->caption }}</p>
                    @endif
                </a>
            @endforeach
        </div>
    @endif
</div>
