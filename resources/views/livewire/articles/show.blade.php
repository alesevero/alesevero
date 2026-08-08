<div class="mx-auto min-h-screen max-w-[900px] px-6 py-[12vh] sm:px-12">
    @include('partials.site-nav')

    <main class="max-w-[64ch]">
        <p class="mb-2 text-sm text-[#8a8a86]">{{ $date }}</p>
        <h1 class="text-wrap-balance mb-10 text-3xl leading-tight">{{ $title }}</h1>
        <div class="[&_a]:underline [&_a]:underline-offset-4 [&_p]:mb-6 [&_h2]:mb-4 [&_h2]:mt-10 [&_h2]:text-2xl [&_h2]:leading-tight [&_h3]:mb-4 [&_h3]:mt-8 [&_h3]:text-xl [&_h3]:leading-tight [&_ul]:mb-6 [&_ul]:list-disc [&_ul]:pl-6 [&_ol]:mb-6 [&_ol]:list-decimal [&_ol]:pl-6 [&_li]:mb-2 [&_blockquote]:mb-6 [&_blockquote]:pl-6 [&_blockquote]:text-[#8a8a86] [&_pre]:mb-6 [&_pre]:overflow-x-auto [&_pre]:text-base [&_code]:text-base text-lg leading-[1.8]">
            {!! $html !!}
        </div>
    </main>

    <div class="mt-[12vh]">
        @include('partials.site-nav')
    </div>
</div>
