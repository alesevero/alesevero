<div class="mx-auto min-h-screen max-w-[900px] px-6 py-[12vh] sm:px-12">
    @include('partials.site-nav')

    @if (empty($projects))
        <p class="text-lg text-[#8a8a86]">Nothing here yet.</p>
    @else
        <div class="grid grid-cols-2 gap-x-4 gap-y-10 sm:grid-cols-3">
            @foreach ($projects as $project)
                <a
                    wire:key="{{ $project->slug }}"
                    href="{{ route('photos.show', $project->slug) }}"
                    class="group block"
                    wire:navigate
                >
                    <img
                        src="{{ asset($project->cover) }}"
                        alt="{{ $project->title }}"
                        loading="lazy"
                        class="aspect-[4/5] w-full object-cover"
                    />
                    <p class="mt-2 text-[22px] group-hover:underline group-hover:underline-offset-4">
                        {{ $project->title }}
                    </p>
                    <p class="text-sm text-[#8a8a86]">
                        {{ count($project->photos) }} {{ Str::plural('photo', count($project->photos)) }}
                    </p>
                </a>
            @endforeach
        </div>
    @endif
</div>
