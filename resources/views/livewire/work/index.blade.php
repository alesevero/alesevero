<div class="mx-auto min-h-screen max-w-[900px] px-6 py-[12vh] sm:px-12">
    @include('partials.site-nav')

    <div class="mb-[10vh] max-w-[64ch] text-lg leading-[1.8] [&_a]:underline [&_a]:underline-offset-4 [&_p]:mb-6">
        <p>Most of my work starts with the same question:</p>
        <p>Can this be simpler?</p>
        <p>At <a href="https://musora.com" target="_blank" rel="noopener">Musora</a>, I work as a Senior Software Engineer building and shaping the systems behind online music education — from backend architecture to the engineering practices around it.</p>
        <p>At <a href="https://sunupstudios.ca" target="_blank" rel="noopener">Sunup Studios</a>, I get to explore smaller ideas: independent software built carefully, intentionally, and for humans.</p>
        <p>And with <a href="https://soundcheck.sh" target="_blank" rel="noopener">Soundcheck</a>, I'm building tools around one of my favorite parts of software development — that moment when something you've been working on is finally ready to go out into the world.</p>
        <p>I care about the invisible parts of software: good boundaries, thoughtful decisions, maintainable systems, and the little details that make building things feel good.</p>
    </div>

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
        <p class="mb-6 text-[22px]">Projects</p>
        @if (empty($projects))
            <p class="text-base text-[#8a8a86]">Nothing here yet.</p>
        @else
            <ul class="list-none space-y-6 p-0">
                @foreach ($projects as $project)
                    <li wire:key="{{ $project->slug }}">
                        <p class="text-lg">
                            @if ($project->url)
                                <a href="{{ $project->url }}" target="_blank" rel="noopener" class="hover:underline hover:underline-offset-4">{{ $project->name }}</a>
                            @else
                                {{ $project->name }}
                            @endif
                        </p>
                        <p class="text-sm text-[#8a8a86]">
                            @if ($project->description)
                                {{ $project->description }} &middot;
                            @endif
                            {{ $project->start->format('F Y') }}
                        </p>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
