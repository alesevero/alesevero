{{-- Edit the bio line below directly — no real content wired in yet. --}}
<div class="mx-auto min-h-screen max-w-[900px] px-6 py-[12vh] sm:px-12">
    <p class="mb-[20vh] max-w-[24ch] text-[28px] leading-[1.6] text-wrap-balance">
        Alexandre Severo. I write, and I take photographs.
        <a href="{{ route('articles.index') }}" class="hover:underline hover:underline-offset-4" wire:navigate>Writing</a>,
        <a href="{{ route('photos.index') }}" class="hover:underline hover:underline-offset-4" wire:navigate>photographs</a>,
        <a href="{{ route('about') }}" class="hover:underline hover:underline-offset-4" wire:navigate>about</a>.
    </p>

    @if (! empty($articles))
        <ul class="list-none space-y-6 p-0">
            @foreach ($articles as $article)
                <li wire:key="{{ $article->slug }}" class="text-[22px]">
                    @if ($article->isExternal())
                        <a href="{{ $article->externalUrl }}" target="_blank" rel="noopener" class="hover:underline hover:underline-offset-4">
                            {{ $article->title }}
                        </a>
                    @else
                        <a href="{{ route('articles.show', $article->slug) }}" class="hover:underline hover:underline-offset-4" wire:navigate>
                            {{ $article->title }}
                        </a>
                    @endif
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-lg text-[#8a8a86]">Nothing published yet.</p>
    @endif

    {{-- Edit the address below, or remove it. --}}
    <footer class="mt-[10vh] text-[15px] text-[#8a8a86]">alexandre@severo.dev</footer>
</div>
