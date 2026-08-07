<div class="mx-auto min-h-screen max-w-[900px] px-6 py-[12vh] sm:px-12">
    @include('partials.site-nav')

    <div class="max-w-[64ch]">
        <p class="mb-2 text-sm text-[#8a8a86]">{{ $date }}</p>
        <h1 class="text-wrap-balance mb-10 text-3xl leading-tight">{{ $title }}</h1>
        <div class="[&_a]:underline [&_a]:underline-offset-4 [&_p]:mb-6 text-lg leading-[1.8]">
            {!! $html !!}
        </div>
    </div>
</div>
