<div class="mx-auto min-h-screen max-w-[900px] px-6 py-[12vh] sm:px-12">
    @include('partials.site-nav')

    <main>
        <h1 class="text-wrap-balance mb-[20vh] max-w-[24ch] text-[28px] leading-[1.6] font-normal">
            Senior software engineer at Musora. I run Sunup Studios, write, and take photographs on the side.
        </h1>

        @if (! empty($feed))
            <ul class="list-none space-y-6 p-0">
                @foreach ($feed as $item)
                    <li wire:key="{{ $item['href'] }}" class="text-[22px]">
                        @if ($item['external'])
                            <a
                                href="{{ $item['href'] }}"
                                target="_blank"
                                rel="noopener"
                                class="hover:underline hover:underline-offset-4"
                            >
                                {{ $item['title'] }}
                            </a>
                        @else
                            <a
                                href="{{ $item['href'] }}"
                                class="hover:underline hover:underline-offset-4"
                                wire:navigate
                            >
                                {{ $item['title'] }}
                            </a>
                        @endif
                        <span class="ml-3 text-base text-[#8a8a86]">
                            {{ $item['tag'] }}
                            @if ($item['meta'])
                                &middot; {{ $item['meta'] }}
                            @endif
                        </span>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-lg text-[#8a8a86]">Nothing published yet.</p>
        @endif
    </main>
</div>
