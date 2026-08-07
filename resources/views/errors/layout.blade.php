<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-[#FDFDFC] text-[#1b1b18] dark:bg-[#0a0a0a] dark:text-[#EDEDEC]">
        <div class="mx-auto min-h-screen max-w-[900px] px-6 py-[12vh] sm:px-12">
            @include('partials.site-nav')

            <p class="max-w-[24ch] text-[28px] leading-[1.6] text-wrap-balance">{{ $message }}</p>
            @isset($description)
                <p class="mt-4 max-w-[48ch] text-lg leading-[1.8] text-[#8a8a86]">{{ $description }}</p>
            @endisset
        </div>

        @fluxScripts
    </body>
</html>
