<div class="mx-auto min-h-screen max-w-[900px] px-6 py-[12vh] sm:px-12">
    @include('partials.site-nav')

    <div class="mb-[10vh]">
        <p class="mb-6 text-[22px]">Work</p>
        @if (empty($jobs))
            <p class="text-base text-[#8a8a86]">Nothing here yet.</p>
        @else
            <ul class="list-none space-y-6 p-0">
                @foreach ($jobs as $job)
                    <li wire:key="{{ $job->slug }}">
                        <p class="text-lg">
                            @if ($job->url)
                                <a href="{{ $job->url }}" target="_blank" rel="noopener" class="hover:underline hover:underline-offset-4">{{ $job->name }}</a>
                            @else
                                {{ $job->name }}
                            @endif
                            @if ($job->role)
                                <span class="text-[#8a8a86]">— {{ $job->role }}</span>
                            @endif
                        </p>
                        <p class="text-sm text-[#8a8a86]">
                            @if ($job->description)
                                {{ $job->description }} &middot;
                            @endif
                            {{ $job->start->format('F Y') }}–{{ $job->isOngoing() ? 'present' : $job->end->format('F Y') }}
                        </p>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    <div>
        <p class="mb-6 text-[22px]">Products</p>
        @if (empty($products))
            <p class="text-base text-[#8a8a86]">Nothing here yet.</p>
        @else
            <ul class="list-none space-y-6 p-0">
                @foreach ($products as $product)
                    <li wire:key="{{ $product->slug }}">
                        <p class="text-lg">
                            @if ($product->url)
                                <a href="{{ $product->url }}" target="_blank" rel="noopener" class="hover:underline hover:underline-offset-4">{{ $product->name }}</a>
                            @else
                                {{ $product->name }}
                            @endif
                        </p>
                        <p class="text-sm text-[#8a8a86]">
                            @if ($product->description)
                                {{ $product->description }} &middot;
                            @endif
                            {{ $product->start->format('F Y') }}
                        </p>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
