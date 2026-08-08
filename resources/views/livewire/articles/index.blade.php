<div class="mx-auto min-h-screen max-w-[900px] px-6 py-[12vh] sm:px-12">
    @include('partials.site-nav')

    <main>
        <h1 class="mb-10 text-[28px] leading-[1.6] font-normal">Writing</h1>

        @if (empty($articles))
            <p class="text-lg text-[#8a8a86]">Nothing published yet.</p>
        @else
            <ul class="list-none space-y-6 p-0">
                @foreach ($articles as $article)
                    <li wire:key="{{ $article->slug }}" class="text-[22px]">
                        @if ($article->isExternal())
                            <a
                                href="{{ $article->externalUrl }}"
                                target="_blank"
                                rel="noopener"
                                aria-label="{{ $article->title }} (opens in new tab)"
                                class="hover:underline hover:underline-offset-4"
                            >
                                {{ $article->title }}
                            </a>
                        @else
                            <a
                                href="{{ route('articles.show', $article->slug) }}"
                                class="hover:underline hover:underline-offset-4"
                                wire:navigate
                            >
                                {{ $article->title }}
                            </a>
                        @endif
                        <span class="ml-3 text-base text-[#8a8a86]">
                            {{ $article->date->format('F Y') }}
                            @if ($article->excerpt)
                                &middot; {{ $article->excerpt }}
                            @endif
                        </span>
                    </li>
                @endforeach
            </ul>
        @endif
    </main>
</div>
