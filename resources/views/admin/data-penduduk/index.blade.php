@extends('layouts.admin')

@section('title', 'Dashboard Statistik Data Penduduk')

@section('content')
<div x-data="dataPendudukDashboard()" x-init="init()" class="space-y-5">

    @if ($totalTerdata === 0)
        <div class="rounded-2xl bg-gold-400/10 border border-gold-500/30 text-gold-600 px-5 py-4 text-sm">
            Belum ada data penduduk. Tambahkan data lewat menu <a href="{{ route('admin.penduduk.create') }}" class="underline font-medium">Kelola Data Penduduk</a> untuk mengisi dashboard ini.
        </div>
    @endif

    <!-- Kartu ringkasan utama -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="rounded-2xl bg-emerald-950 px-4 py-4 sm:px-6 sm:py-5">
            <p class="text-2xl sm:text-3xl font-display font-semibold text-gold-400" x-text="fmt(stats?.jumlah_anak)">0</p>
            <p class="text-xs uppercase tracking-wide text-cream-200/60 mt-1">Jumlah Anak</p>
        </div>
        <div class="rounded-2xl bg-emerald-950 px-4 py-4 sm:px-6 sm:py-5">
            <p class="text-2xl sm:text-3xl font-display font-semibold text-gold-400" x-text="fmt(stats?.jumlah_ibu_rumah_tangga)">0</p>
            <p class="text-xs uppercase tracking-wide text-cream-200/60 mt-1">Jumlah Ibu Rumah Tangga</p>
        </div>
        <div class="rounded-2xl bg-emerald-950 px-4 py-4 sm:px-6 sm:py-5">
            <p class="text-2xl sm:text-3xl font-display font-semibold text-gold-400" x-text="fmt(stats?.jumlah_kepala_keluarga)">0</p>
            <p class="text-xs uppercase tracking-wide text-cream-200/60 mt-1">Jumlah Kepala Keluarga</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">

        <!-- Kolom kanan (desktop) / atas (mobile): filter -->
        <div class="order-1 lg:order-2 lg:col-span-3">
            <div class="rounded-2xl bg-emerald-950 text-cream-100 p-4 sm:p-5 lg:sticky lg:top-20">
                <h2 class="font-display font-semibold text-gold-400 mb-5">Filter Data</h2>

                <div class="mb-6">
                    <p class="text-[11px] uppercase tracking-widest text-cream-200/40 mb-2">Rukun Tetangga (RT)</p>
                    <div class="flex flex-wrap gap-1.5">
                        <button type="button" @click="setDraft('rt', 'semua')"
                                :class="draft.rt === 'semua' ? 'bg-emerald-600 text-cream-50' : 'bg-cream-50/5 text-cream-200/70 hover:bg-cream-50/10'"
                                class="rounded-lg px-3 py-1.5 text-xs transition-colors cursor-pointer">Semua RT</button>
                        @foreach ($rtList as $rt)
                            <button type="button" @click="setDraft('rt', '{{ $rt }}')"
                                    :class="draft.rt === '{{ $rt }}' ? 'bg-emerald-600 text-cream-50' : 'bg-cream-50/5 text-cream-200/70 hover:bg-cream-50/10'"
                                    class="rounded-lg px-3 py-1.5 text-xs transition-colors cursor-pointer">{{ $rt }}</button>
                        @endforeach
                    </div>
                </div>

                <div class="mb-6">
                    <p class="text-[11px] uppercase tracking-widest text-cream-200/40 mb-2">Pilih Dusun</p>
                    <div class="space-y-1">
                        <button type="button" @click="setDraft('dusun', 'semua')"
                                :class="draft.dusun === 'semua' ? 'bg-emerald-600 text-cream-50' : 'text-cream-200/70 hover:bg-cream-50/5'"
                                class="w-full text-left rounded-lg px-3 py-1.5 text-xs transition-colors cursor-pointer">Semua Dusun</button>
                        @foreach ($dusunList as $dusun)
                            <button type="button" @click="setDraft('dusun', '{{ $dusun }}')"
                                    :class="draft.dusun === '{{ $dusun }}' ? 'bg-emerald-600 text-cream-50' : 'text-cream-200/70 hover:bg-cream-50/5'"
                                    class="w-full text-left rounded-lg px-3 py-1.5 text-xs transition-colors cursor-pointer">{{ $dusun }}</button>
                        @endforeach
                    </div>
                </div>

                <div class="mb-2">
                    <p class="text-[11px] uppercase tracking-widest text-cream-200/40 mb-2">Pendidikan Terakhir</p>
                    <div class="space-y-1">
                        <button type="button" @click="setDraft('pendidikan', 'semua')"
                                :class="draft.pendidikan === 'semua' ? 'bg-emerald-600 text-cream-50' : 'text-cream-200/70 hover:bg-cream-50/5'"
                                class="w-full text-left rounded-lg px-3 py-1.5 text-xs transition-colors cursor-pointer">Semua Tingkat</button>
                        @foreach ($pendidikanList as $key => $label)
                            <button type="button" @click="setDraft('pendidikan', '{{ $key }}')"
                                    :class="draft.pendidikan === '{{ $key }}' ? 'bg-emerald-600 text-cream-50' : 'text-cream-200/70 hover:bg-cream-50/5'"
                                    class="w-full text-left rounded-lg px-3 py-1.5 text-xs transition-colors cursor-pointer">{{ $label }}</button>
                        @endforeach
                    </div>
                </div>

                <div class="mt-6 pt-5 border-t border-cream-50/10">
                    <p x-show="dirty" x-cloak class="text-[11px] text-gold-400 mb-2">Ada perubahan filter yang belum diterapkan.</p>
                    <button type="button" @click="applyFilters()" :disabled="loading"
                            class="w-full rounded-lg bg-gold-500 hover:bg-gold-600 disabled:opacity-50 disabled:cursor-not-allowed text-emerald-950 font-semibold py-2.5 text-sm transition-colors flex items-center justify-center gap-2 cursor-pointer">
                        <svg x-show="loading" x-cloak class="h-4 w-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                        <span x-text="loading ? 'Memuat…' : 'Terapkan Filter'"></span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Kolom utama: sebaran per dusun + statistik & chart -->
        <div class="order-2 lg:order-1 lg:col-span-9 space-y-5">

            <!-- Sebaran per dusun: kartu lebar penuh agar chart tidak sempit -->
            <div class="rounded-2xl bg-white border border-emerald-900/10 p-4 sm:p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                    <div>
                        <h2 class="font-display font-semibold text-lg text-emerald-950" x-text="stats?.sebaran_title ?? 'Jumlah Penduduk Sesuai Dusun'">Jumlah Penduduk Sesuai Dusun</h2>
                        <p class="text-xs text-emerald-900/50 mt-0.5">Sebaran penduduk menyesuaikan otomatis dengan filter yang diterapkan</p>
                    </div>
                    <div class="text-left sm:text-right shrink-0">
                        <p class="text-3xl font-display font-semibold text-emerald-950" x-text="fmt(stats?.total)">0</p>
                        <p class="text-xs text-emerald-900/50">Total Penduduk (sesuai filter)</p>
                    </div>
                </div>
                <div class="relative h-72 sm:h-80">
                    <canvas id="chartDusun"></canvas>
                </div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4">
                <div class="rounded-2xl bg-white border border-emerald-900/10 px-4 py-3">
                    <p class="text-xs text-emerald-900/50">Total</p>
                    <p class="text-xl font-display font-semibold text-emerald-950" x-text="fmt(stats?.total)">0</p>
                </div>
                <div class="rounded-2xl bg-white border border-emerald-900/10 px-4 py-3">
                    <p class="text-xs text-emerald-900/50">Perempuan</p>
                    <p class="text-xl font-display font-semibold text-emerald-950" x-text="fmt(stats?.perempuan)">0</p>
                </div>
                <div class="rounded-2xl bg-white border border-emerald-900/10 px-4 py-3">
                    <p class="text-xs text-emerald-900/50">Laki-Laki</p>
                    <p class="text-xl font-display font-semibold text-emerald-950" x-text="fmt(stats?.laki_laki)">0</p>
                </div>
                <div class="rounded-2xl bg-white border border-emerald-900/10 px-4 py-3">
                    <p class="text-xs text-emerald-900/50 mb-1.5">Status Sekolah</p>
                    <div class="h-2 rounded-full bg-cream-200 overflow-hidden">
                        <div class="h-full bg-emerald-600 rounded-full transition-all" :style="`width: ${stats?.persen_bersekolah ?? 0}%`"></div>
                    </div>
                    <p class="text-[11px] text-emerald-900/50 mt-1">
                        <span x-text="stats?.persen_bersekolah ?? 0"></span>% Bersekolah
                    </p>
                </div>
            </div>

            <div class="grid sm:grid-cols-2 gap-5">
                <div class="rounded-2xl bg-white border border-emerald-900/10 p-4 sm:p-5">
                    <h3 class="font-display font-semibold text-sm text-emerald-950 mb-3">Usia &amp; Jenis Kelamin</h3>
                    <div class="relative h-64 sm:h-72">
                        <canvas id="chartUsia"></canvas>
                    </div>
                </div>
                <div class="rounded-2xl bg-white border border-emerald-900/10 p-4 sm:p-5">
                    <h3 class="font-display font-semibold text-sm text-emerald-950 mb-3">Status Ekonomi</h3>
                    <div class="relative h-64 sm:h-72">
                        <canvas id="chartEkonomi"></canvas>
                    </div>
                </div>
            </div>

            <div class="grid sm:grid-cols-3 gap-5">
                <div class="rounded-2xl bg-white border border-emerald-900/10 p-4 sm:p-5">
                    <h3 class="font-display font-semibold text-sm text-emerald-950 mb-3">Penerima Bantuan</h3>
                    <div class="relative h-56">
                        <canvas id="chartBantuan"></canvas>
                    </div>
                </div>
                <div class="rounded-2xl bg-white border border-emerald-900/10 p-4 sm:p-5">
                    <h3 class="font-display font-semibold text-sm text-emerald-950 mb-3">Status Nikah</h3>
                    <div class="relative h-56">
                        <canvas id="chartNikah"></canvas>
                    </div>
                </div>
                <div class="rounded-2xl bg-white border border-emerald-900/10 p-4 sm:p-5">
                    <h3 class="font-display font-semibold text-sm text-emerald-950 mb-3">Pendidikan</h3>
                    <div class="relative h-56">
                        <canvas id="chartPendidikan"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
    function dataPendudukDashboard() {
        return {
            // "filters" = filter yang sudah diterapkan & dipakai untuk fetch terakhir.
            // "draft"   = pilihan sementara di panel, baru dikirim saat tombol "Terapkan Filter" ditekan.
            filters: { rt: 'semua', dusun: 'semua', pendidikan: 'semua' },
            draft: { rt: 'semua', dusun: 'semua', pendidikan: 'semua' },
            dirty: false,
            stats: null,
            loading: false,
            requestId: 0,
            abortController: null,
            charts: {},

            palette: {
                deep: '#123023',
                emerald: '#1f4f3a',
                mid: '#55916d',
                light: '#83b393',
                gold: '#c9821f',
                goldLight: '#dda13a',
            },

            fmt(n) {
                return new Intl.NumberFormat('id-ID').format(n ?? 0);
            },

            async init() {
                await this.fetchStats();
                this.buildCharts();
            },

            setDraft(type, value) {
                this.draft[type] = value;
                this.dirty = JSON.stringify(this.draft) !== JSON.stringify(this.filters);
            },

            async applyFilters() {
                this.filters = { ...this.draft };
                this.dirty = false;
                await this.fetchStats();
                this.updateCharts();
            },

            async fetchStats() {
                // Batalkan permintaan sebelumnya yang belum selesai supaya tidak ada
                // dua respons yang saling menimpa (penyebab dashboard terasa lambat/nge-crash).
                if (this.abortController) {
                    this.abortController.abort();
                }
                const controller = new AbortController();
                this.abortController = controller;
                const myRequestId = ++this.requestId;

                this.loading = true;
                const params = new URLSearchParams(this.filters);

                try {
                    const res = await fetch(`{{ route('admin.data-penduduk.stats') }}?${params.toString()}`, {
                        headers: { Accept: 'application/json' },
                        signal: controller.signal,
                    });
                    const data = await res.json();

                    // Abaikan respons yang sudah usang (bukan permintaan terakhir).
                    if (myRequestId === this.requestId) {
                        this.stats = data;
                    }
                } catch (error) {
                    if (error.name !== 'AbortError') {
                        console.error('Gagal memuat statistik data penduduk:', error);
                    }
                } finally {
                    if (myRequestId === this.requestId) {
                        this.loading = false;
                    }
                }
            },

            buildCharts() {
                const s = this.stats;
                const p = this.palette;

                this.charts.dusun = new Chart(document.getElementById('chartDusun'), {
                    type: 'bar',
                    data: {
                        labels: s.sebaran.map(d => d.label),
                        datasets: [{ data: s.sebaran.map(d => d.total), backgroundColor: p.emerald, borderRadius: 8, hoverBackgroundColor: p.gold, barPercentage: 0.55, categoryPercentage: 0.7 }],
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: { mode: 'nearest', axis: 'y', intersect: false },
                        plugins: {
                            legend: { display: false },
                            tooltip: { callbacks: { label: (ctx) => `${ctx.parsed.x} orang` } },
                        },
                        scales: {
                            x: { beginAtZero: true, ticks: { precision: 0, font: { size: 12 } }, grid: { color: 'rgba(18,48,35,0.06)' } },
                            y: { ticks: { font: { size: 13, weight: '500' } }, grid: { display: false } },
                        },
                    },
                });

                this.charts.usia = new Chart(document.getElementById('chartUsia'), {
                    type: 'bar',
                    data: {
                        labels: s.usia_jenis_kelamin.map(u => u.label),
                        datasets: [
                            { label: 'Perempuan', data: s.usia_jenis_kelamin.map(u => u.perempuan), backgroundColor: p.gold },
                            { label: 'Laki-Laki', data: s.usia_jenis_kelamin.map(u => u.laki_laki), backgroundColor: p.deep },
                        ],
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: { mode: 'nearest', axis: 'y', intersect: false },
                        plugins: {
                            legend: { position: 'bottom', labels: { boxWidth: 10, font: { size: 10 } } },
                            tooltip: { callbacks: { label: (ctx) => `${ctx.dataset.label}: ${ctx.parsed.x} orang` } },
                        },
                        scales: { x: { stacked: true, ticks: { precision: 0 } }, y: { stacked: true } },
                    },
                });

                this.charts.ekonomi = new Chart(document.getElementById('chartEkonomi'), {
                    type: 'doughnut',
                    data: {
                        labels: s.status_ekonomi.map(e => e.label),
                        datasets: [{ data: s.status_ekonomi.map(e => e.total), backgroundColor: [p.gold, p.mid, p.deep] }],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { position: 'bottom', labels: { boxWidth: 10, font: { size: 10 } } } },
                    },
                });

                this.charts.bantuan = new Chart(document.getElementById('chartBantuan'), {
                    type: 'bar',
                    data: {
                        labels: s.penerima_bantuan.map(b => b.label),
                        datasets: [{ data: s.penerima_bantuan.map(b => b.total), backgroundColor: p.emerald, borderRadius: 4 }],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false }, tooltip: { callbacks: { label: (ctx) => `${ctx.parsed.y} orang` } } },
                        scales: { x: { ticks: { font: { size: 9 } } }, y: { beginAtZero: true, ticks: { precision: 0 } } },
                    },
                });

                this.charts.nikah = new Chart(document.getElementById('chartNikah'), {
                    type: 'bar',
                    data: {
                        labels: s.status_nikah.map(n => n.label),
                        datasets: [{ data: s.status_nikah.map(n => n.total), backgroundColor: p.gold, borderRadius: 4 }],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false }, tooltip: { callbacks: { label: (ctx) => `${ctx.parsed.y} orang` } } },
                        scales: { x: { ticks: { font: { size: 9 } } }, y: { beginAtZero: true, ticks: { precision: 0 } } },
                    },
                });

                this.charts.pendidikan = new Chart(document.getElementById('chartPendidikan'), {
                    type: 'pie',
                    data: {
                        labels: s.pendidikan.map(x => x.label),
                        datasets: [{
                            data: s.pendidikan.map(x => x.total),
                            backgroundColor: [p.deep, p.gold, p.light, p.emerald, p.goldLight, '#a8672a'],
                        }],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { position: 'bottom', labels: { boxWidth: 10, font: { size: 9 } } } },
                    },
                });
            },

            updateCharts() {
                const s = this.stats;

                this.charts.dusun.data.labels = s.sebaran.map(d => d.label);
                this.charts.dusun.data.datasets[0].data = s.sebaran.map(d => d.total);
                this.charts.dusun.update();

                this.charts.usia.data.labels = s.usia_jenis_kelamin.map(u => u.label);
                this.charts.usia.data.datasets[0].data = s.usia_jenis_kelamin.map(u => u.perempuan);
                this.charts.usia.data.datasets[1].data = s.usia_jenis_kelamin.map(u => u.laki_laki);
                this.charts.usia.update();

                this.charts.ekonomi.data.datasets[0].data = s.status_ekonomi.map(e => e.total);
                this.charts.ekonomi.update();

                this.charts.bantuan.data.datasets[0].data = s.penerima_bantuan.map(b => b.total);
                this.charts.bantuan.update();

                this.charts.nikah.data.datasets[0].data = s.status_nikah.map(n => n.total);
                this.charts.nikah.update();

                this.charts.pendidikan.data.datasets[0].data = s.pendidikan.map(x => x.total);
                this.charts.pendidikan.update();
            },
        };
    }
</script>
@endsection
