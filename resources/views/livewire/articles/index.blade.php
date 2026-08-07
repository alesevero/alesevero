<div class="mx-auto min-h-screen max-w-[900px] px-6 py-[12vh] sm:px-12">
    @include('partials.site-nav')

    @if (empty($articles))
        <p class="text-lg text-[#8a8a86]">Nothing published yet.</p>
    @else
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
                    @if ($article->excerpt)
                        <span class="ml-3 text-base text-[#8a8a86]">— {{ $article->excerpt }}</span>
                    @endif
                </li>
            @endforeach
        </ul>
    @endif
</div>
