<nav class="mb-10 text-sm">
    <a
        href="{{ route('home') }}"
        class="text-[#8a8a86] hover:underline hover:underline-offset-4 md:hidden"
        wire:navigate
    >A|</a>
    <a
        href="{{ route('home') }}"
        class="hidden text-[#8a8a86] hover:text-inherit hover:underline hover:underline-offset-4 md:inline"
        wire:navigate
    >Alexandre Severo</a>
    <span class="mx-2 text-[#8a8a86]">&middot;</span>
    <a href="{{ route('work.index') }}" class="hover:underline hover:underline-offset-4" wire:navigate>Work</a>
    <span class="mx-2 text-[#8a8a86]">&middot;</span>
    <a href="{{ route('articles.index') }}" class="hover:underline hover:underline-offset-4" wire:navigate>Writing</a>
    <span class="mx-2 text-[#8a8a86]">&middot;</span>
    <a href="{{ route('photos.index') }}" class="hover:underline hover:underline-offset-4" wire:navigate>Photography</a>
    <span class="mx-2 text-[#8a8a86]">&middot;</span>
    <a href="{{ route('about') }}" class="hover:underline hover:underline-offset-4" wire:navigate>About</a>
</nav>
