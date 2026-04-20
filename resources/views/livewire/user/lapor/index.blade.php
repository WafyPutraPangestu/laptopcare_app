<div class="home-section-inner py-8">

    {{-- Flash --}}
    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0 -translate-y-2"
            class="mb-6 flex items-center gap-3 px-4 py-3 rounded-lg border text-sm font-medium"
            style="background: var(--c-green-dim); border-color: rgba(45,212,160,0.3); color: var(--c-green);">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2.5">
                <polyline points="20 6 9 13 4 8" />
                <polyline points="20 6 9 20 4 14" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Header --}}
    <div class="flex items-start justify-between mb-8 gap-4 flex-wrap">
        <div>
            <p class="home-section-label">Sistem Ticketing</p>
            <h1 class="font-mono text-2xl font-bold" style="color: var(--c-text); letter-spacing: -0.02em;">Laporan Saya
            </h1>
            <p class="text-sm mt-1" style="color: var(--c-text-dim);">Pantau status laporan kerusakan laptop Anda.</p>
        </div>
        <a href="{{ route('user.lapor.create') }}" wire:navigate class="button-v2 is-icon">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2.5">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
            </svg>
            Buat Laporan
        </a>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-8">
        @php
            $statCards = [
                ['label' => 'Total Laporan', 'value' => $stats['total'], 'color' => 'var(--c-text)', 'delay' => '0s'],
                [
                    'label' => 'Menunggu',
                    'value' => $stats['menunggu'],
                    'color' => 'var(--c-orange)',
                    'delay' => '0.06s',
                ],
                [
                    'label' => 'Diproses',
                    'value' => $stats['diproses'],
                    'color' => 'var(--c-accent)',
                    'delay' => '0.12s',
                ],
                ['label' => 'Selesai', 'value' => $stats['selesai'], 'color' => 'var(--c-green)', 'delay' => '0.18s'],
            ];
        @endphp
        @foreach ($statCards as $s)
            <div class="card" style="padding: 1.25rem; animation-delay: {{ $s['delay'] }};">
                <p class="text-xs font-mono mb-1 uppercase tracking-wider" style="color: var(--c-text-muted);">
                    {{ $s['label'] }}</p>
                <p class="text-2xl font-bold font-mono" style="color: {{ $s['color'] }};">{{ $s['value'] }}</p>
            </div>
        @endforeach
    </div>

    {{-- Filter --}}
    <div class="card mb-6" style="padding: 1.25rem;">
        <div class="flex flex-wrap gap-3 items-center">
            <div class="relative flex-1 min-w-48">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" width="14" height="14"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    style="color: var(--c-text-muted);">
                    <circle cx="11" cy="11" r="8" />
                    <line x1="21" y1="21" x2="16.65" y2="16.65" />
                </svg>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari keluhan, kode aset..."
                    style="padding-left: 2.25rem; background: var(--c-surface-2);">
            </div>
            <select wire:model.live="filterStatus"
                style="width: auto; min-width: 140px; background: var(--c-surface-2);">
                <option value="">Semua Status</option>
                <option value="Menunggu">Menunggu</option>
                <option value="Diproses">Diproses</option>
                <option value="Selesai">Selesai</option>
            </select>
            <select wire:model.live="filterPrioritas"
                style="width: auto; min-width: 140px; background: var(--c-surface-2);">
                <option value="">Semua Prioritas</option>
                <option value="Rendah">Rendah</option>
                <option value="Sedang">Sedang</option>
                <option value="Tinggi">Tinggi</option>
            </select>
            @if ($search || $filterStatus || $filterPrioritas)
                <button wire:click="$set('search',''); $set('filterStatus',''); $set('filterPrioritas','')"
                    class="flex items-center gap-1.5 text-xs px-3 py-2 rounded-lg"
                    style="color: var(--c-text-dim); background: var(--c-surface-3); border: 1px solid var(--c-border);">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                    Reset
                </button>
            @endif
        </div>
    </div>

    {{-- List Laporan --}}
    <div class="flex flex-col gap-4">
        @forelse ($laporan as $item)
            @php
                $statusCfg = match ($item->status_tiket) {
                    'Menunggu' => [
                        'color' => 'var(--c-orange)',
                        'bg' => 'var(--c-orange-dim)',
                        'icon' => 'M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z',
                    ],
                    'Diproses' => [
                        'color' => 'var(--c-accent)',
                        'bg' => 'var(--c-accent-dim)',
                        'icon' =>
                            'M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z',
                    ],
                    'Selesai' => [
                        'color' => 'var(--c-green)',
                        'bg' => 'var(--c-green-dim)',
                        'icon' => 'M22 11.08V12a10 10 0 1 1-5.93-9.14 M22 4L12 14.01l-3-3',
                    ],
                    default => ['color' => 'var(--c-text-dim)', 'bg' => 'var(--c-surface-3)', 'icon' => ''],
                };
                $prioritasCfg = match ($item->prioritas) {
                    'Tinggi' => ['color' => 'var(--c-red)', 'bg' => 'var(--c-red-dim)'],
                    'Sedang' => ['color' => 'var(--c-orange)', 'bg' => 'var(--c-orange-dim)'],
                    default => ['color' => 'var(--c-text-muted)', 'bg' => 'var(--c-surface-3)'],
                };
            @endphp
            <div wire:key="laporan-{{ $item->id_laporan }}" class="card" style="padding: 0; overflow: hidden;">
                <div class="flex items-start gap-4 p-5">
                    {{-- Status icon --}}
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5"
                        style="background: {{ $statusCfg['bg'] }}; color: {{ $statusCfg['color'] }};">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="{{ $statusCfg['icon'] }}" />
                        </svg>
                    </div>

                    <div class="flex-1 min-w-0">
                        {{-- Top row --}}
                        <div class="flex flex-wrap items-center gap-2 mb-2">
                            <span class="font-mono text-xs font-bold" style="color: var(--c-text);">
                                #{{ str_pad($item->id_laporan, 4, '0', STR_PAD_LEFT) }}
                            </span>
                            <span class="text-xs font-mono px-2 py-0.5 rounded-full font-semibold"
                                style="background: {{ $statusCfg['bg'] }}; color: {{ $statusCfg['color'] }};">
                                {{ $item->status_tiket }}
                            </span>
                            <span class="text-xs font-mono px-2 py-0.5 rounded-full"
                                style="background: {{ $prioritasCfg['bg'] }}; color: {{ $prioritasCfg['color'] }};">
                                {{ $item->prioritas }}
                            </span>
                        </div>

                        {{-- Keluhan --}}
                        <p class="text-sm font-medium mb-2 line-clamp-2" style="color: var(--c-text);">
                            {{ $item->keluhan_user }}
                        </p>

                        {{-- Meta --}}
                        <div class="flex flex-wrap gap-x-4 gap-y-1 text-xs" style="color: var(--c-text-muted);">
                            <span class="flex items-center gap-1.5">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <rect x="2" y="3" width="20" height="14" rx="2" />
                                    <path d="M8 21h8M12 17v4" />
                                </svg>
                                {{ $item->laptop->kode_aset }} — {{ $item->laptop->merek->nama_merek ?? '' }}
                                {{ $item->laptop->tipe_model }}
                            </span>
                            <span class="flex items-center gap-1.5">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10" />
                                    <polyline points="12 6 12 12 16 14" />
                                </svg>
                                {{ $item->tgl_lapor->diffForHumans() }}
                            </span>
                            @if ($item->area_kerja_user)
                                <span class="flex items-center gap-1.5">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                                        <circle cx="12" cy="10" r="3" />
                                    </svg>
                                    {{ $item->area_kerja_user }}
                                </span>
                            @endif
                            @if ($item->tgl_selesai_tiket)
                                <span class="flex items-center gap-1.5" style="color: var(--c-green);">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <polyline points="20 6 9 17 4 12" />
                                    </svg>
                                    Selesai {{ $item->tgl_selesai_tiket->format('d M Y') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center gap-1.5 flex-shrink-0">
                        @if ($item->status_tiket === 'Menunggu')
                            <a href="{{ route('user.lapor.edit', $item->id_laporan) }}" wire:navigate
                                class="flex items-center justify-center w-8 h-8 rounded-lg transition-all"
                                style="color: var(--c-text-dim); background: var(--c-surface-3);" x-data
                                x-on:mouseenter="$el.style.background='var(--c-accent-dim)'; $el.style.color='var(--c-accent)'"
                                x-on:mouseleave="$el.style.background='var(--c-surface-3)'; $el.style.color='var(--c-text-dim)'"
                                title="Edit">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                </svg>
                            </a>
                            <button wire:click="confirmCancel({{ $item->id_laporan }})"
                                class="flex items-center justify-center w-8 h-8 rounded-lg transition-all"
                                style="color: var(--c-text-dim); background: var(--c-surface-3);" x-data
                                x-on:mouseenter="$el.style.background='var(--c-red-dim)'; $el.style.color='var(--c-red)'"
                                x-on:mouseleave="$el.style.background='var(--c-surface-3)'; $el.style.color='var(--c-text-dim)'"
                                title="Batalkan laporan">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <polyline points="3 6 5 6 21 6" />
                                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                                    <path d="M10 11v6M14 11v6" />
                                    <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2" />
                                </svg>
                            </button>
                        @endif
                    </div>
                </div>

                {{-- Progress bar status --}}
                @php
                    $progress = match ($item->status_tiket) {
                        'Menunggu' => 33,
                        'Diproses' => 66,
                        'Selesai' => 100,
                        default => 0,
                    };
                @endphp
                <div class="h-0.5 w-full" style="background: var(--c-border);">
                    <div class="h-full transition-all duration-500 rounded-full"
                        style="width: {{ $progress }}%; background: {{ $statusCfg['color'] }};"></div>
                </div>
            </div>
        @empty
            <div class="card flex flex-col items-center gap-4 py-16">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.5" style="color: var(--c-text-muted);">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                    <polyline points="14 2 14 8 20 8" />
                    <line x1="16" y1="13" x2="8" y2="13" />
                    <line x1="16" y1="17" x2="8" y2="17" />
                    <polyline points="10 9 9 9 8 9" />
                </svg>
                <div class="text-center">
                    <p class="text-sm font-medium mb-1" style="color: var(--c-text-dim);">Belum ada laporan</p>
                    <p class="text-xs" style="color: var(--c-text-muted);">Buat laporan jika laptop Anda mengalami
                        kerusakan.</p>
                </div>
                <a href="{{ route('user.lapor.create') }}" wire:navigate class="button-v2 size-sm is-icon">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5">
                        <line x1="12" y1="5" x2="12" y2="19" />
                        <line x1="5" y1="12" x2="19" y2="12" />
                    </svg>
                    Buat Laporan Pertama
                </a>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if ($laporan->hasPages())
        <div class="mt-6">{{ $laporan->links() }}</div>
    @endif

    {{-- Confirm Cancel Modal --}}
    @if ($confirmCancelId)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="absolute inset-0" style="background: rgba(0,0,0,0.7); backdrop-filter: blur(4px);"
                wire:click="$set('confirmCancelId', null)"></div>
            <div class="relative w-full max-w-sm p-6 rounded-xl"
                style="background: var(--c-surface-2); border: 1px solid var(--c-border-bright);"
                x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100">
                <div class="flex items-start gap-4 mb-5">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0"
                        style="background: var(--c-red-dim); color: var(--c-red);">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path
                                d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                            <line x1="12" y1="9" x2="12" y2="13" />
                            <line x1="12" y1="17" x2="12.01" y2="17" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-mono font-bold text-base mb-1" style="color: var(--c-text);">Batalkan Laporan?
                        </h3>
                        <p class="text-sm" style="color: var(--c-text-dim);">Laporan yang dibatalkan tidak dapat
                            dikembalikan.</p>
                    </div>
                </div>
                <div class="flex gap-3 justify-end">
                    <button wire:click="$set('confirmCancelId', null)"
                        class="button-v2 variant-outline size-sm">Kembali</button>
                    <button wire:click="cancelLaporan" class="button-v2 variant-danger size-sm">Batalkan
                        Laporan</button>
                </div>
            </div>
        </div>
    @endif

</div>
