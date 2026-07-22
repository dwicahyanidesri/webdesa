@if ($paginator->hasPages())
    @php
        $current = $paginator->currentPage();
        $last = $paginator->lastPage();
        $start = max($current - 2, 1);
        $end = min($start + 4, $last);
        $start = max($end - 4, 1);
    @endphp

    <nav role="navigation" aria-label="Navigasi Halaman" class="flex items-center gap-3">
        <p class="hidden sm:block shrink-0 text-sm text-emerald-900/50">
            Menampilkan <span class="font-medium text-emerald-900">{{ $paginator->firstItem() }}</span>&ndash;<span class="font-medium text-emerald-900">{{ $paginator->lastItem() }}</span> dari <span class="font-medium text-emerald-900">{{ $paginator->total() }}</span> data
        </p>

        <div class="flex items-center gap-1.5 overflow-x-auto scroll-smooth snap-x snap-mandatory py-1 [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none]">
            {{-- Sebelumnya --}}
            @if ($paginator->onFirstPage())
                <span class="shrink-0 snap-start h-9 w-9 flex items-center justify-center rounded-full text-emerald-900/25 cursor-not-allowed" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="shrink-0 snap-start h-9 w-9 flex items-center justify-center rounded-full text-emerald-900 bg-white border border-emerald-900/10 hover:bg-emerald-900/5 hover:border-emerald-900/25 transition-colors" aria-label="Sebelumnya">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                </a>
            @endif

            {{-- Halaman 1 + elipsis --}}
            @if ($start > 1)
                <a href="{{ $paginator->url(1) }}" class="shrink-0 snap-start h-9 w-9 flex items-center justify-center rounded-full text-sm text-emerald-900/70 hover:bg-emerald-900/5 hover:text-emerald-900 transition-colors">1</a>
                @if ($start > 2)
                    <span class="shrink-0 h-9 w-9 flex items-center justify-center text-sm text-emerald-900/30">&hellip;</span>
                @endif
            @endif

            {{-- Nomor halaman di sekitar halaman aktif --}}
            @for ($page = $start; $page <= $end; $page++)
                @if ($page == $current)
                    <span aria-current="page" class="shrink-0 snap-start h-9 w-9 flex items-center justify-center rounded-full bg-emerald-700 text-cream-50 text-sm font-semibold">{{ $page }}</span>
                @else
                    <a href="{{ $paginator->url($page) }}" class="shrink-0 snap-start h-9 w-9 flex items-center justify-center rounded-full text-sm text-emerald-900/70 hover:bg-emerald-900/5 hover:text-emerald-900 transition-colors" aria-label="Ke halaman {{ $page }}">{{ $page }}</a>
                @endif
            @endfor

            {{-- Elipsis + halaman terakhir --}}
            @if ($end < $last)
                @if ($end < $last - 1)
                    <span class="shrink-0 h-9 w-9 flex items-center justify-center text-sm text-emerald-900/30">&hellip;</span>
                @endif
                <a href="{{ $paginator->url($last) }}" class="shrink-0 snap-start h-9 w-9 flex items-center justify-center rounded-full text-sm text-emerald-900/70 hover:bg-emerald-900/5 hover:text-emerald-900 transition-colors">{{ $last }}</a>
            @endif

            {{-- Selanjutnya --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="shrink-0 snap-start h-9 w-9 flex items-center justify-center rounded-full text-emerald-900 bg-white border border-emerald-900/10 hover:bg-emerald-900/5 hover:border-emerald-900/25 transition-colors" aria-label="Selanjutnya">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                </a>
            @else
                <span class="shrink-0 h-9 w-9 flex items-center justify-center rounded-full text-emerald-900/25 cursor-not-allowed" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                </span>
            @endif
        </div>
    </nav>
@endif
