<nav class="mb-10 text-sm">
    <a
        href="{{ route('home') }}"
        class="text-[#8a8a86] hover:underline hover:underline-offset-4 md:hidden"
        @if (request()->routeIs('home')) aria-current="page" @endif
        wire:navigate
    >A|</a>
    <a
        href="{{ route('home') }}"
        @class([
            'hidden text-[#8a8a86] hover:text-inherit hover:underline hover:underline-offset-4 md:inline',
            'underline underline-offset-4 text-inherit' => request()->routeIs('home'),
        ])
        @if (request()->routeIs('home')) aria-current="page" @endif
        wire:navigate
    >Alexandre Severo</a>
    <span class="mx-2 text-[#8a8a86]">&middot;</span>
    <a
        href="{{ route('work.index') }}"
        @class(['hover:underline hover:underline-offset-4', 'underline underline-offset-4' => request()->routeIs('work.*')])
        @if (request()->routeIs('work.*')) aria-current="page" @endif
        wire:navigate
    >Work</a>
    <span class="mx-2 text-[#8a8a86]">&middot;</span>
    <a
        href="{{ route('articles.index') }}"
        @class(['hover:underline hover:underline-offset-4', 'underline underline-offset-4' => request()->routeIs('articles.*')])
        @if (request()->routeIs('articles.*')) aria-current="page" @endif
        wire:navigate
    >Writing</a>
    <span class="mx-2 text-[#8a8a86]">&middot;</span>
    <a
        href="{{ route('photos.index') }}"
        @class(['hover:underline hover:underline-offset-4', 'underline underline-offset-4' => request()->routeIs('photos.*')])
        @if (request()->routeIs('photos.*')) aria-current="page" @endif
        wire:navigate
    >Photography</a>
    <span class="mx-2 text-[#8a8a86]">&middot;</span>
    <a
        href="{{ route('about') }}"
        @class(['hover:underline hover:underline-offset-4', 'underline underline-offset-4' => request()->routeIs('about')])
        @if (request()->routeIs('about')) aria-current="page" @endif
        wire:navigate
    >About</a>
</nav>
