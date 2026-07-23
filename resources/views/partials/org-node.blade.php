<li>
    <div class="org-node w-[21rem] sm:w-96 rounded-2xl bg-white border border-emerald-900/10 shadow-sm overflow-hidden text-center transition hover:-translate-y-0.5 hover:shadow-md hover:border-emerald-700/25">
        <div class="h-64 sm:h-72 w-full bg-emerald-50">
            @if ($node->foto)
                <img src="{{ asset('storage/'.$node->foto) }}" alt="{{ $node->nama }}" class="h-full w-full object-cover" draggable="false">
            @else
                <div class="h-full w-full flex items-center justify-center bg-emerald-100 text-emerald-700 font-display font-semibold text-5xl">
                    {{ strtoupper(substr($node->nama, 0, 1)) }}
                </div>
            @endif
        </div>
        <div class="h-1 bg-gold-500"></div>
        <div class="px-3 py-3.5">
            <p class="font-semibold text-sm sm:text-base text-emerald-950 leading-tight">{{ $node->nama }}</p>
            <p class="text-xs sm:text-sm text-emerald-900/50 mt-1 leading-tight">{{ $node->jabatan }}</p>
        </div>
    </div>

    @if ($node->children->isNotEmpty())
        <ul>
            @foreach ($node->children as $child)
                @include('partials.org-node', ['node' => $child])
            @endforeach
        </ul>
    @endif
</li>
