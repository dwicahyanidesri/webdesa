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
    <div class="grid sm:grid-cols-3 gap-4">
        <div class="rounded-2xl bg-emerald-950 px-6 py-5">
            <p class="text-3xl font-display font-semibold text-gold-400" x-text="fmt(stats?.jumlah_anak)">0</p>
            <p class="text-xs uppercase tracking-wide text-cream-200/60 mt-1">Jumlah Anak</p>
        </div>
        <div class="rounded-2xl bg-emerald-950 px-6 py-5">
            <p class="text-3xl font-display font-semibold text-gold-400" x-text="fmt(stats?.jumlah_ibu_rumah_tangga)">0</p>
            <p class="text-xs uppercase tracking-wide text-cream-200/60 mt-1">Jumlah Ibu Rumah Tangga</p>
        </div>
        <div class="rounded-2xl bg-emerald-950 px-6 py-5">
            <p class="text-3xl font-display font-semibold text-gold-400" x-text="fmt(stats?.jumlah_kepala_keluarga)">0</p>
            <p class="text-xs uppercase tracking-wide text-cream-200/60 mt-1">Jumlah Kepala Keluarga</p>
        </div>
    </div>

    <div class="grid lg:grid-cols-12 gap-5">

        <!-- Kolom kiri: sebaran per dusun -->
        <div class="lg:col-span-3">
            <div class="rounded-2xl bg-white border border-emerald-900/10 p-5 h-full flex flex-col">
                <h2 class="font-display font-semibold text-emerald-950 mb-4">Jumlah Penduduk Sesuai Dusun</h2>
                <div class="flex-1 min-h-[280px]">
                    <canvas id="chartDusun"></canvas>
                </div>
                <div class="mt-4 pt-4 border-t border-emerald-900/10 text-right">
                    <p class="text-2xl font-display font-semibold text-emerald-950" x-text="fmt(stats?.total)">0</p>
                    <p class="text-xs text-emerald-900/50">Total Penduduk (sesuai filter)</p>
                </div>
            </div>
        </div>

        <!-- Kolom tengah: statistik & chart -->
        <div class="lg:col-span-6 space-y-5">
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
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
                <div class="rounded-2xl bg-white border border-emerald-900/10 p-5">
                    <h3 class="font-display font-semibold text-sm text-emerald-950 mb-3">Usia &amp; Jenis Kelamin</h3>
                    <canvas id="chartUsia" height="200"></canvas>
                </div>
                <div class="rounded-2xl bg-white border border-emerald-900/10 p-5">
                    <h3 class="font-display font-semibold text-sm text-emerald-950 mb-3">Status Ekonomi</h3>
                    <canvas id="chartEkonomi" height="200"></canvas>
                </div>
            </div>

            <div class="grid sm:grid-cols-3 gap-5">
                <div class="rounded-2xl bg-white border border-emerald-900/10 p-5">
                    <h3 class="font-display font-semibold text-sm text-emerald-950 mb-3">Penerima Bantuan</h3>
                    <canvas id="chartBantuan" height="220"></canvas>
                </div>
                <div class="rounded-2xl bg-white border border-emerald-900/10 p-5">
                    <h3 class="font-display font-semibold text-sm text-emerald-950 mb-3">Status Nikah</h3>
                    <canvas id="chartNikah" height="220"></canvas>
                </div>
                <div class="rounded-2xl bg-white border border-emerald-900/10 p-5">
                    <h3 class="font-display font-semibold text-sm text-emerald-950 mb-3">Pendidikan</h3>
                    <canvas id="chartPendidikan" height="220"></canvas>
                </div>
            </div>
        </div>

        <!-- Kolom kanan: filter -->
        <div class="lg:col-span-3">
            <div class="rounded-2xl bg-emerald-950 text-cream-100 p-5 lg:sticky lg:top-20">
                <h2 class="font-display font-semibold text-gold-400 mb-5">Filter Data</h2>

                <div class="mb-6">
                    <p class="text-[11px] uppercase tracking-widest text-cream-200/40 mb-2">Rukun Tetangga (RT)</p>
                    <div class="flex flex-wrap gap-1.5">
                        <button type="button" @click="setFilter('rt', 'semua')"
                                :class="filters.rt === 'semua' ? 'bg-emerald-600 text-cream-50' : 'bg-cream-50/5 text-cream-200/70 hover:bg-cream-50/10'"
                                class="rounded-lg px-3 py-1.5 text-xs transition">Semua RT</button>
                        @foreach ($rtList as $rt)
                            <button type="button" @click="setFilter('rt', '{{ $rt }}')"
                                    :class="filters.rt === '{{ $rt }}' ? 'bg-emerald-600 text-cream-50' : 'bg-cream-50/5 text-cream-200/70 hover:bg-cream-50/10'"
                                    class="rounded-lg px-3 py-1.5 text-xs transition">{{ $rt }}</button>
                        @endforeach
                    </div>
                </div>

                <div class="mb-6">
                    <p class="text-[11px] uppercase tracking-widest text-cream-200/40 mb-2">Pilih Dusun</p>
                    <div class="space-y-1">
                        <button type="button" @click="setFilter('dusun', 'semua')"
                                :class="filters.dusun === 'semua' ? 'bg-emerald-600 text-cream-50' : 'text-cream-200/70 hover:bg-cream-50/5'"
                                class="w-full text-left rounded-lg px-3 py-1.5 text-xs transition">Semua Dusun</button>
                        @foreach ($dusunList as $dusun)
                            <button type="button" @click="setFilter('dusun', '{{ $dusun }}')"
                                    :class="filters.dusun === '{{ $dusun }}' ? 'bg-emerald-600 text-cream-50' : 'text-cream-200/70 hover:bg-cream-50/5'"
                                    class="w-full text-left rounded-lg px-3 py-1.5 text-xs transition">{{ $dusun }}</button>
                        @endforeach
                    </div>
                </div>

                <div>
                    <p class="text-[11px] uppercase tracking-widest text-cream-200/40 mb-2">Pendidikan Terakhir</p>
                    <div class="space-y-1">
                        <button type="button" @click="setFilter('pendidikan', 'semua')"
                                :class="filters.pendidikan === 'semua' ? 'bg-emerald-600 text-cream-50' : 'text-cream-200/70 hover:bg-cream-50/5'"
                                class="w-full text-left rounded-lg px-3 py-1.5 text-xs transition">Semua Tingkat</button>
                        @foreach ($pendidikanList as $key => $label)
                            <button type="button" @click="setFilter('pendidikan', '{{ $key }}')"
                                    :class="filters.pendidikan === '{{ $key }}' ? 'bg-emerald-600 text-cream-50' : 'text-cream-200/70 hover:bg-cream-50/5'"
                                    class="w-full text-left rounded-lg px-3 py-1.5 text-xs transition">{{ $label }}</button>
                        @endforeach
                    </div>
                </div>

                <div x-show="loading" x-cloak class="mt-6 text-xs text-cream-200/50">Memuat data&hellip;</div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
    function dataPendudukDashboard() {
        return {
            filters: { rt: 'semua', dusun: 'semua', pendidikan: 'semua' },
            stats: null,
            loading: false,
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

            async setFilter(type, value) {
                this.filters[type] = value;
                await this.fetchStats();
                this.updateCharts();
            },

            async fetchStats() {
                this.loading = true;
                const params = new URLSearchParams(this.filters);
                try {
                    const res = await fetch(`{{ route('admin.data-penduduk.stats') }}?${params.toString()}`, {
                        headers: { Accept: 'application/json' },
                    });
                    this.stats = await res.json();
                } finally {
                    this.loading = false;
                }
            },

            buildCharts() {
                const s = this.stats;
                const p = this.palette;

                this.charts.dusun = new Chart(document.getElementById('chartDusun'), {
                    type: 'bar',
                    data: {
                        labels: s.per_dusun.map(d => d.label),
                        datasets: [{ data: s.per_dusun.map(d => d.total), backgroundColor: p.emerald, borderRadius: 6 }],
                    },
                    options: {
                        indexAxis: 'y',
                        plugins: { legend: { display: false } },
                        scales: { x: { beginAtZero: true, ticks: { precision: 0 } } },
                        maintainAspectRatio: false,
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
                        plugins: { legend: { position: 'bottom', labels: { boxWidth: 10, font: { size: 10 } } } },
                        scales: { x: { stacked: true }, y: { stacked: true, ticks: { precision: 0 } } },
                    },
                });

                this.charts.ekonomi = new Chart(document.getElementById('chartEkonomi'), {
                    type: 'doughnut',
                    data: {
                        labels: s.status_ekonomi.map(e => e.label),
                        datasets: [{ data: s.status_ekonomi.map(e => e.total), backgroundColor: [p.gold, p.mid, p.deep] }],
                    },
                    options: { plugins: { legend: { position: 'bottom', labels: { boxWidth: 10, font: { size: 10 } } } } },
                });

                this.charts.bantuan = new Chart(document.getElementById('chartBantuan'), {
                    type: 'bar',
                    data: {
                        labels: s.penerima_bantuan.map(b => b.label),
                        datasets: [{ data: s.penerima_bantuan.map(b => b.total), backgroundColor: p.emerald, borderRadius: 4 }],
                    },
                    options: {
                        plugins: { legend: { display: false } },
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
                        plugins: { legend: { display: false } },
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
                    options: { plugins: { legend: { position: 'bottom', labels: { boxWidth: 10, font: { size: 9 } } } } },
                });
            },

            updateCharts() {
                const s = this.stats;

                this.charts.dusun.data.labels = s.per_dusun.map(d => d.label);
                this.charts.dusun.data.datasets[0].data = s.per_dusun.map(d => d.total);
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
