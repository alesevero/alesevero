<div class="mx-auto min-h-screen max-w-[640px] px-6 py-[12vh]">
    <a href="{{ route('articles.index') }}" class="text-sm text-[#8a8a86] hover:text-inherit hover:underline hover:underline-offset-4" wire:navigate>&larr; Writing</a>

    <p class="mt-6 mb-2 text-sm text-[#8a8a86]">{{ $date }}</p>
    <h1 class="text-wrap-balance mb-10 text-3xl leading-tight">{{ $title }}</h1>
    <div class="[&_a]:underline [&_a]:underline-offset-4 [&_p]:mb-6 text-lg leading-[1.8]">
        {!! $html !!}
    </div>
</div>
