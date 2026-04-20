<div class="home-section-inner py-8">

    {{-- ══════════════════════════════════════
         HEADER
    ══════════════════════════════════════ --}}
    <div class="flex items-start justify-between mb-8 gap-4 flex-wrap">
        <div>
            <p class="home-section-label">Selamat datang,</p>
            <h1 class="font-mono text-2xl font-bold" style="color: var(--c-text); letter-spacing: -0.02em;">
                {{ auth()->user()->nama_lengkap }}
            </h1>
            <p class="text-sm mt-1" style="color: var(--c-text-dim);">
                {{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
            </p>
        </div>
        <div class="flex gap-2">
            @if ($tiketMenunggu > 0 || $tiketDiproses > 0)
                <a href="{{ route('user.lapor.index') }}" wire:navigate class="button-v2 variant-outline size-sm is-icon">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                    </svg>
                    Lihat Laporan
                    <span
                        class="inline-flex items-center justify-center w-4 h-4 rounded-full text-[10px] font-bold font-mono ml-0.5"
                        style="background: var(--c-orange); color: #fff;">
                        {{ $tiketMenunggu + $tiketDiproses }}
                    </span>
                </a>
            @endif
            <a href="{{ route('user.lapor.create') }}" wire:navigate class="button-v2 is-icon size-sm">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2.5">
                    <line x1="12" y1="5" x2="12" y2="19" />
                    <line x1="5" y1="12" x2="19" y2="12" />
                </svg>
                Buat Laporan
            </a>
        </div>
    </div>

    {{-- ══════════════════════════════════════
         STATS ROW
    ══════════════════════════════════════ --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-8">

        {{-- Laptop Baik --}}
        <div class="card" style="padding: 1.375rem; animation-delay: 0s;">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs font-mono uppercase tracking-wider" style="color: var(--c-text-muted);">Laptop Aktif
                </p>
                <div class="w-8 h-8 rounded-lg flex items-center justify-center"
                    style="background: var(--c-green-dim); color: var(--c-green);">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <rect x="2" y="3" width="20" height="14" rx="2" />
                        <path d="M8 21h8M12 17v4" />
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold font-mono" style="color: var(--c-green);">{{ $laptopBaik }}</p>
            <p class="text-xs mt-1.5" style="color: var(--c-text-muted);">dari {{ $totalLaptop }} total laptop</p>
        </div>

        {{-- Dalam Perbaikan --}}
        <div class="card" style="padding: 1.375rem; animation-delay: 0.06s;">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs font-mono uppercase tracking-wider" style="color: var(--c-text-muted);">Diperbaiki</p>
                <div class="w-8 h-8 rounded-lg flex items-center justify-center"
                    style="background: var(--c-accent-dim); color: var(--c-accent);">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path
                            d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z" />
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold font-mono" style="color: var(--c-accent);">{{ $laptopDiperbaiki }}</p>
            <p class="text-xs mt-1.5" style="color: var(--c-text-muted);">sedang dalam perbaikan</p>
        </div>

        {{-- Tiket Aktif --}}
        <div class="card" style="padding: 1.375rem; animation-delay: 0.12s;">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs font-mono uppercase tracking-wider" style="color: var(--c-text-muted);">Tiket Aktif
                </p>
                <div class="w-8 h-8 rounded-lg flex items-center justify-center"
                    style="background: var(--c-orange-dim); color: var(--c-orange);">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <circle cx="12" cy="12" r="10" />
                        <polyline points="12 6 12 12 16 14" />
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold font-mono" style="color: var(--c-orange);">
                {{ $tiketMenunggu + $tiketDiproses }}</p>
            <p class="text-xs mt-1.5" style="color: var(--c-text-muted);">{{ $tiketMenunggu }} menunggu ·
                {{ $tiketDiproses }} diproses</p>
        </div>

        {{-- Total Selesai --}}
        <div class="card" style="padding: 1.375rem; animation-delay: 0.18s;">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs font-mono uppercase tracking-wider" style="color: var(--c-text-muted);">Selesai</p>
                <div class="w-8 h-8 rounded-lg flex items-center justify-center"
                    style="background: var(--c-surface-3); color: var(--c-text-dim);">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <polyline points="20 6 9 17 4 12" />
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold font-mono" style="color: var(--c-text);">{{ $tiketSelesai }}</p>
            <p class="text-xs mt-1.5" style="color: var(--c-text-muted);">dari {{ $tiketTotal }} total tiket</p>
        </div>

    </div>

    {{-- ══════════════════════════════════════
         ASET LAPTOP
    ══════════════════════════════════════ --}}
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-mono font-bold text-base" style="color: var(--c-text);">Aset Laptop Saya</h2>
        </div>

        @if ($laptopDetail->isEmpty())
            <div class="card flex flex-col items-center gap-3 py-12">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.5" style="color: var(--c-text-muted);">
                    <rect x="2" y="3" width="20" height="14" rx="2" />
                    <path d="M8 21h8M12 17v4" />
                </svg>
                <p class="text-sm" style="color: var(--c-text-dim);">Belum ada laptop yang terdaftar atas nama Anda.
                </p>
                <p class="text-xs" style="color: var(--c-text-muted);">Hubungi admin IT untuk pendaftaran aset.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach ($laptopDetail as $item)
                    @php
                        $lp = $item['laptop'];
                        $kondisiCfg = match ($lp->status_kondisi) {
                            'Baik' => ['color' => 'var(--c-green)', 'bg' => 'var(--c-green-dim)', 'label' => 'Baik'],
                            'Rusak' => ['color' => 'var(--c-red)', 'bg' => 'var(--c-red-dim)', 'label' => 'Rusak'],
                            'Dalam Perbaikan' => [
                                'color' => 'var(--c-accent)',
                                'bg' => 'var(--c-accent-dim)',
                                'label' => 'Diperbaiki',
                            ],
                            default => [
                                'color' => 'var(--c-text-dim)',
                                'bg' => 'var(--c-surface-3)',
                                'label' => $lp->status_kondisi,
                            ],
                        };
                        $usiaCfg = match ($item['kondisi_usia']) {
                            'kritis' => ['color' => 'var(--c-red)', 'label' => 'Kritis'],
                            'perlu_perhatian' => ['color' => 'var(--c-orange)', 'label' => 'Perlu Perhatian'],
                            default => ['color' => 'var(--c-green)', 'label' => 'Normal'],
                        };
                    @endphp
                    <div class="card"
                        style="padding: 0; overflow: hidden; animation-delay: {{ $loop->index * 0.08 }}s;">
                        {{-- Card header --}}
                        <div class="flex items-start justify-between gap-3 p-5 pb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0"
                                    style="background: {{ $kondisiCfg['bg'] }}; color: {{ $kondisiCfg['color'] }};">
                                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <rect x="2" y="3" width="20" height="14" rx="2" />
                                        <path d="M8 21h8M12 17v4" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-mono text-sm font-bold" style="color: var(--c-text);">
                                        {{ $lp->merek->nama_merek ?? '—' }} {{ $lp->tipe_model }}
                                    </p>
                                    <p class="text-xs mt-0.5 font-mono" style="color: var(--c-text-muted);">
                                        {{ $lp->kode_aset }}</p>
                                </div>
                            </div>
                            <span class="text-xs font-mono font-semibold px-2.5 py-1 rounded-full flex-shrink-0"
                                style="background: {{ $kondisiCfg['bg'] }}; color: {{ $kondisiCfg['color'] }};">
                                {{ $kondisiCfg['label'] }}
                            </span>
                        </div>

                        {{-- Info grid --}}
                        <div class="grid grid-cols-3 gap-0 px-5 pb-4"
                            style="border-top: 1px solid var(--c-border); border-bottom: 1px solid var(--c-border); padding-top: 0.875rem; margin-bottom: 0;">
                            <div class="text-center py-2">
                                <p class="text-xs font-mono mb-1" style="color: var(--c-text-muted);">Pengadaan</p>
                                <p class="text-xs font-medium" style="color: var(--c-text);">
                                    {{ $lp->tgl_pengadaan->format('M Y') }}</p>
                            </div>
                            <div class="text-center py-2"
                                style="border-left: 1px solid var(--c-border); border-right: 1px solid var(--c-border);">
                                <p class="text-xs font-mono mb-1" style="color: var(--c-text-muted);">Usia</p>
                                <p class="text-xs font-medium" style="color: var(--c-text);">
                                    {{ $item['usia_tahun'] > 0 ? $item['usia_tahun'] . ' thn' : $item['usia_bulan'] . ' bln' }}
                                </p>
                            </div>
                            <div class="text-center py-2">
                                <p class="text-xs font-mono mb-1" style="color: var(--c-text-muted);">Kerusakan</p>
                                <p class="text-xs font-medium"
                                    style="color: {{ $lp->total_kerusakan_count > 3 ? 'var(--c-orange)' : 'var(--c-text)' }};">
                                    {{ $lp->total_kerusakan_count }}x
                                </p>
                            </div>
                        </div>

                        {{-- Usia bar --}}
                        @if ($item['usia_persen'] !== null)
                            <div class="px-5 py-3.5">
                                <div class="flex items-center justify-between mb-1.5">
                                    <span class="text-xs font-mono" style="color: var(--c-text-muted);">Usia
                                        Pakai</span>
                                    <span class="text-xs font-mono font-semibold"
                                        style="color: {{ $usiaCfg['color'] }};">
                                        {{ $item['usia_persen'] }}% — {{ $usiaCfg['label'] }}
                                    </span>
                                </div>
                                <div class="h-1.5 w-full rounded-full" style="background: var(--c-border);">
                                    <div class="h-full rounded-full transition-all duration-700"
                                        style="width: {{ $item['usia_persen'] }}%; background: {{ $usiaCfg['color'] }};">
                                    </div>
                                </div>
                                <p class="text-[10px] mt-1" style="color: var(--c-text-muted);">
                                    Usia optimal {{ $lp->merek->rata_usia_optimal ?? '?' }} tahun
                                </p>
                            </div>
                        @else
                            <div class="px-5 py-3.5">
                                <p class="text-xs" style="color: var(--c-text-muted);">Data usia optimal tidak
                                    tersedia.</p>
                            </div>
                        @endif

                        {{-- Last maintenance --}}
                        <div class="flex items-center gap-2 px-5 py-3"
                            style="border-top: 1px solid var(--c-border); background: var(--c-surface-2);">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2"
                                style="color: var(--c-text-muted); flex-shrink: 0;">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                                <line x1="16" y1="2" x2="16" y2="6" />
                                <line x1="8" y1="2" x2="8" y2="6" />
                                <line x1="3" y1="10" x2="21" y2="10" />
                            </svg>
                            <span class="text-xs" style="color: var(--c-text-muted);">
                                Maintenance terakhir:
                                <span style="color: var(--c-text-dim);">
                                    {{ $lp->tgl_last_maintenance ? $lp->tgl_last_maintenance->format('d M Y') : 'Belum ada' }}
                                </span>
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- ══════════════════════════════════════
         BAWAH: Laporan Terbaru + Maintenance
    ══════════════════════════════════════ --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

        {{-- Laporan Terbaru --}}
        <div>
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-mono font-bold text-base" style="color: var(--c-text);">Laporan Terbaru</h2>
                <a href="{{ route('user.lapor.index') }}" wire:navigate
                    class="text-xs font-mono flex items-center gap-1 transition-colors"
                    style="color: var(--c-accent);" x-data x-on:mouseenter="$el.style.opacity='0.7'"
                    x-on:mouseleave="$el.style.opacity='1'">
                    Lihat semua
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5">
                        <polyline points="9 18 15 12 9 6" />
                    </svg>
                </a>
            </div>

            <div class="flex flex-col gap-3">
                @forelse ($laporanTerbaru as $laporan)
                    @php
                        $sCfg = match ($laporan->status_tiket) {
                            'Menunggu' => ['color' => 'var(--c-orange)', 'bg' => 'var(--c-orange-dim)'],
                            'Diproses' => ['color' => 'var(--c-accent)', 'bg' => 'var(--c-accent-dim)'],
                            'Selesai' => ['color' => 'var(--c-green)', 'bg' => 'var(--c-green-dim)'],
                            default => ['color' => 'var(--c-text-dim)', 'bg' => 'var(--c-surface-3)'],
                        };
                        $pCfg = match ($laporan->prioritas) {
                            'Tinggi' => ['color' => 'var(--c-red)', 'bg' => 'var(--c-red-dim)'],
                            'Sedang' => ['color' => 'var(--c-orange)', 'bg' => 'var(--c-orange-dim)'],
                            default => ['color' => 'var(--c-text-muted)', 'bg' => 'var(--c-surface-3)'],
                        };
                    @endphp
                    <div class="card" style="padding: 1rem;">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0"
                                style="background: {{ $sCfg['bg'] }}; color: {{ $sCfg['color'] }};">
                                <span class="text-[10px] font-mono font-bold">
                                    #{{ str_pad($laporan->id_laporan, 3, '0', STR_PAD_LEFT) }}
                                </span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium line-clamp-1 mb-1.5" style="color: var(--c-text);">
                                    {{ $laporan->keluhan_user }}
                                </p>
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="text-[10px] font-mono font-semibold px-2 py-0.5 rounded-full"
                                        style="background: {{ $sCfg['bg'] }}; color: {{ $sCfg['color'] }};">
                                        {{ $laporan->status_tiket }}
                                    </span>
                                    <span class="text-[10px] font-mono px-2 py-0.5 rounded-full"
                                        style="background: {{ $pCfg['bg'] }}; color: {{ $pCfg['color'] }};">
                                        {{ $laporan->prioritas }}
                                    </span>
                                    <span class="text-[10px]" style="color: var(--c-text-muted);">
                                        {{ $laporan->tgl_lapor->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                            @if ($laporan->status_tiket === 'Menunggu')
                                <a href="{{ route('user.lapor.edit', $laporan->id_laporan) }}" wire:navigate
                                    class="flex items-center justify-center w-7 h-7 rounded-lg flex-shrink-0 transition-all"
                                    style="background: var(--c-surface-3); color: var(--c-text-muted);" x-data
                                    x-on:mouseenter="$el.style.background='var(--c-accent-dim)'; $el.style.color='var(--c-accent)'"
                                    x-on:mouseleave="$el.style.background='var(--c-surface-3)'; $el.style.color='var(--c-text-muted)'">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="card flex flex-col items-center gap-2 py-10" style="border-style: dashed;">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.5" style="color: var(--c-text-muted);">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <polyline points="14 2 14 8 20 8" />
                        </svg>
                        <p class="text-xs" style="color: var(--c-text-muted);">Belum ada laporan kerusakan.</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Jadwal Maintenance --}}
        <div>
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-mono font-bold text-base" style="color: var(--c-text);">Maintenance Mendatang</h2>
            </div>

            <div class="flex flex-col gap-3">
                @forelse ($maintenanceMendatang as $jadwal)
                    @php
                        $tipeCfg = match ($jadwal->tipe_maintenance) {
                            'Rutin' => ['color' => 'var(--c-green)', 'bg' => 'var(--c-green-dim)'],
                            'Darurat' => ['color' => 'var(--c-red)', 'bg' => 'var(--c-red-dim)'],
                            'Preventif' => ['color' => 'var(--c-purple)', 'bg' => 'rgba(167,139,250,0.12)'],
                            default => ['color' => 'var(--c-text-dim)', 'bg' => 'var(--c-surface-3)'],
                        };
                        $selisihHari = now()->diffInDays($jadwal->tgl_jadwal_maintenance, false);
                    @endphp
                    <div class="card" style="padding: 1rem;">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0"
                                style="background: {{ $tipeCfg['bg'] }}; color: {{ $tipeCfg['color'] }};">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                                    <line x1="16" y1="2" x2="16" y2="6" />
                                    <line x1="8" y1="2" x2="8" y2="6" />
                                    <line x1="3" y1="10" x2="21" y2="10" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium mb-1" style="color: var(--c-text);">
                                    {{ $jadwal->laptop->merek->nama_merek ?? '' }} {{ $jadwal->laptop->tipe_model }}
                                </p>
                                <p class="text-xs mb-1.5" style="color: var(--c-text-dim);">
                                    {{ $jadwal->deskripsi_maintenance ?? 'Tidak ada deskripsi.' }}
                                </p>
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="text-[10px] font-mono font-semibold px-2 py-0.5 rounded-full"
                                        style="background: {{ $tipeCfg['bg'] }}; color: {{ $tipeCfg['color'] }};">
                                        {{ $jadwal->tipe_maintenance }}
                                    </span>
                                    <span class="text-[10px] font-mono flex items-center gap-1"
                                        style="color: {{ $selisihHari <= 3 ? 'var(--c-orange)' : 'var(--c-text-muted)' }};">
                                        <svg width="9" height="9" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2">
                                            <circle cx="12" cy="12" r="10" />
                                            <polyline points="12 6 12 12 16 14" />
                                        </svg>
                                        {{ $jadwal->tgl_jadwal_maintenance->format('d M Y') }}
                                        @if ($selisihHari <= 7)
                                            · {{ $selisihHari }} hari lagi
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="card flex flex-col items-center gap-2 py-10" style="border-style: dashed;">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.5" style="color: var(--c-text-muted);">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                            <line x1="16" y1="2" x2="16" y2="6" />
                            <line x1="8" y1="2" x2="8" y2="6" />
                            <line x1="3" y1="10" x2="21" y2="10" />
                        </svg>
                        <p class="text-xs" style="color: var(--c-text-muted);">Tidak ada jadwal maintenance mendatang.
                        </p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>

</div>
