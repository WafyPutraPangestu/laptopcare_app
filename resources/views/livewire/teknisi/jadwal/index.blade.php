<div class="home-section-inner py-8" x-data="{ showModal: @entangle('showDetailModal') }">

    {{-- Flash Message --}}
    @if (session()->has('success'))
        <div class="mb-6 flex items-center gap-3 px-4 py-3 rounded-lg border"
            style="background: var(--c-green-dim); border-color: var(--c-green); color: var(--c-green);" x-data
            x-init="setTimeout(() => $el.remove(), 4000)">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M20 6L9 17l-5-5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            <span style="font-size: 0.875rem; font-weight: 500;">{{ session('success') }}</span>
        </div>
    @endif

    {{-- Header --}}
    <div class="flex flex-col gap-1 mb-8">
        <div class="home-hero__label" style="margin-bottom: 0; align-self: flex-start;">
            <span class="home-hero__dot"></span>
            TEKNISI PANEL
        </div>
        <h1
            style="font-family: var(--font-mono); font-size: clamp(1.5rem, 3vw, 2rem); font-weight: 700; color: var(--c-text); letter-spacing: -0.02em; margin-top: 0.75rem;">
            Jadwal Maintenance
        </h1>
        <p style="font-size: 0.9rem; color: var(--c-text-dim); margin-top: 0.25rem;">
            Kelola dan perbarui status jadwal perawatan laptop yang ditugaskan ke Anda.
        </p>
    </div>

    {{-- Stats Row --}}
    <div class="grid grid-cols-3 gap-4 mb-8">
        @php
            $tabConfig = [
                'Dijadwalkan' => [
                    'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
                    'color' => 'var(--c-accent)',
                    'dimColor' => 'var(--c-accent-dim)',
                ],
                'Selesai' => [
                    'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                    'color' => 'var(--c-green)',
                    'dimColor' => 'var(--c-green-dim)',
                ],
                'Dibatalkan' => [
                    'icon' => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z',
                    'color' => 'var(--c-red)',
                    'dimColor' => 'var(--c-red-dim)',
                ],
            ];
        @endphp

        @foreach ($tabConfig as $tab => $cfg)
            <button wire:click="setTab('{{ $tab }}')" class="card text-left transition-all"
                style="padding: 1.25rem 1.5rem; cursor: pointer; border: 1px solid {{ $activeTab === $tab ? $cfg['color'] : 'var(--c-border)' }}; background: {{ $activeTab === $tab ? $cfg['dimColor'] : 'var(--c-surface)' }};">
                <div class="flex items-center justify-between mb-3">
                    <div
                        style="width: 36px; height: 36px; border-radius: var(--radius-sm); background: {{ $cfg['dimColor'] }}; display: flex; align-items: center; justify-content: center; color: {{ $cfg['color'] }};">
                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path d="{{ $cfg['icon'] }}" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    @if ($activeTab === $tab)
                        <div
                            style="width: 6px; height: 6px; border-radius: 50%; background: {{ $cfg['color'] }}; box-shadow: 0 0 8px {{ $cfg['color'] }};">
                        </div>
                    @endif
                </div>
                <div
                    style="font-family: var(--font-mono); font-size: 1.75rem; font-weight: 700; color: {{ $cfg['color'] }}; line-height: 1;">
                    {{ $counts[$tab] }}
                </div>
                <div style="font-size: 0.75rem; color: var(--c-text-dim); margin-top: 0.25rem;">{{ $tab }}
                </div>
            </button>
        @endforeach
    </div>

    {{-- Filters --}}
    <div class="flex flex-col gap-3 mb-6 md:flex-row md:items-center md:justify-between">
        {{-- Search --}}
        <div style="position: relative; flex: 1; max-width: 380px;">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                style="position: absolute; left: 0.875rem; top: 50%; transform: translateY(-50%); color: var(--c-text-muted); pointer-events: none;">
                <circle cx="11" cy="11" r="8" />
                <path d="M21 21l-4.35-4.35" stroke-linecap="round" />
            </svg>
            <input wire:model.live.debounce.350ms="search" type="text" placeholder="Cari kode aset, model, merek..."
                style="padding-left: 2.5rem; width: 100%;">
        </div>

        {{-- Tipe Filter --}}
        <div class="flex gap-2">
            @foreach (['', 'Rutin', 'Darurat', 'Preventif'] as $tipe)
                <button wire:click="$set('filterTipe', '{{ $tipe }}')"
                    style="padding: 0.4rem 0.875rem; border-radius: var(--radius-sm); font-size: 0.75rem; font-weight: 500; border: 1px solid {{ $filterTipe === $tipe ? 'var(--c-accent)' : 'var(--c-border)' }}; background: {{ $filterTipe === $tipe ? 'var(--c-accent-dim)' : 'var(--c-surface-2)' }}; color: {{ $filterTipe === $tipe ? 'var(--c-accent)' : 'var(--c-text-dim)' }}; cursor: pointer; transition: all 0.15s; white-space: nowrap;">
                    {{ $tipe === '' ? 'Semua Tipe' : $tipe }}
                </button>
            @endforeach
        </div>
    </div>

    {{-- Loading Indicator --}}
    <div wire:loading.flex
        style="align-items: center; gap: 0.5rem; margin-bottom: 1rem; color: var(--c-text-dim); font-size: 0.8125rem;">
        <div
            style="width: 14px; height: 14px; border: 2px solid var(--c-border); border-top-color: var(--c-accent); border-radius: 50%; animation: spin 0.7s linear infinite;">
        </div>
        Memuat data...
    </div>

    {{-- Table --}}
    <div class="card" style="padding: 0; overflow: hidden;">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 1px solid var(--c-border); background: var(--c-surface-2);">
                        <th
                            style="padding: 0.875rem 1.25rem; text-align: left; font-family: var(--font-mono); font-size: 0.6875rem; letter-spacing: 0.07em; text-transform: uppercase; color: var(--c-text-muted); font-weight: 600; white-space: nowrap;">
                            Laptop</th>
                        <th
                            style="padding: 0.875rem 1.25rem; text-align: left; font-family: var(--font-mono); font-size: 0.6875rem; letter-spacing: 0.07em; text-transform: uppercase; color: var(--c-text-muted); font-weight: 600; white-space: nowrap;">
                            Tipe</th>
                        <th
                            style="padding: 0.875rem 1.25rem; text-align: left; font-family: var(--font-mono); font-size: 0.6875rem; letter-spacing: 0.07em; text-transform: uppercase; color: var(--c-text-muted); font-weight: 600; white-space: nowrap;">
                            Jadwal</th>
                        <th
                            style="padding: 0.875rem 1.25rem; text-align: left; font-family: var(--font-mono); font-size: 0.6875rem; letter-spacing: 0.07em; text-transform: uppercase; color: var(--c-text-muted); font-weight: 600; white-space: nowrap;">
                            Pengguna</th>
                        <th
                            style="padding: 0.875rem 1.25rem; text-align: left; font-family: var(--font-mono); font-size: 0.6875rem; letter-spacing: 0.07em; text-transform: uppercase; color: var(--c-text-muted); font-weight: 600; white-space: nowrap;">
                            Status</th>
                        <th
                            style="padding: 0.875rem 1.25rem; text-align: center; font-family: var(--font-mono); font-size: 0.6875rem; letter-spacing: 0.07em; text-transform: uppercase; color: var(--c-text-muted); font-weight: 600;">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jadwals as $jadwal)
                        @php
                            $isOverdue = $jadwal->status === 'Dijadwalkan' && $jadwal->tgl_jadwal_maintenance < now();
                        @endphp
                        <tr wire:key="jadwal-{{ $jadwal->id_jadwal }}"
                            style="border-bottom: 1px solid var(--c-border); transition: background 0.15s; {{ $isOverdue ? 'background: rgba(247,86,79,0.04);' : '' }}"
                            onmouseenter="this.style.background='var(--c-surface-2)'"
                            onmouseleave="this.style.background='{{ $isOverdue ? 'rgba(247,86,79,0.04)' : 'transparent' }}'">

                            {{-- Laptop --}}
                            <td style="padding: 1rem 1.25rem;">
                                <div style="display: flex; align-items: center; gap: 0.75rem;">
                                    <div
                                        style="width: 36px; height: 36px; border-radius: var(--radius-sm); background: var(--c-accent-dim); border: 1px solid rgba(79,142,247,0.2); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                        <svg width="16" height="16" fill="none" stroke="var(--c-accent)"
                                            stroke-width="1.8" viewBox="0 0 24 24">
                                            <rect x="2" y="3" width="20" height="14" rx="2" />
                                            <path d="M8 21h8m-4-4v4" stroke-linecap="round" />
                                        </svg>
                                    </div>
                                    <div>
                                        <div
                                            style="font-family: var(--font-mono); font-size: 0.75rem; font-weight: 700; color: var(--c-accent);">
                                            {{ $jadwal->laptop->kode_aset }}</div>
                                        <div style="font-size: 0.8125rem; color: var(--c-text); margin-top: 1px;">
                                            {{ $jadwal->laptop->merek->nama_merek }} {{ $jadwal->laptop->tipe_model }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- Tipe --}}
                            <td style="padding: 1rem 1.25rem;">
                                @php
                                    $tipeCfg = [
                                        'Rutin' => ['bg' => 'var(--c-accent-dim)', 'color' => 'var(--c-accent)'],
                                        'Darurat' => ['bg' => 'var(--c-red-dim)', 'color' => 'var(--c-red)'],
                                        'Preventif' => ['bg' => 'var(--c-green-dim)', 'color' => 'var(--c-green)'],
                                    ];
                                    $tc = $tipeCfg[$jadwal->tipe_maintenance] ?? [
                                        'bg' => 'var(--c-surface-3)',
                                        'color' => 'var(--c-text-dim)',
                                    ];
                                @endphp
                                <span
                                    style="display: inline-flex; align-items: center; gap: 0.3rem; padding: 0.2rem 0.625rem; border-radius: 20px; background: {{ $tc['bg'] }}; color: {{ $tc['color'] }}; font-size: 0.6875rem; font-weight: 600; font-family: var(--font-mono); letter-spacing: 0.04em; text-transform: uppercase;">
                                    {{ $jadwal->tipe_maintenance }}
                                </span>
                            </td>

                            {{-- Jadwal --}}
                            <td style="padding: 1rem 1.25rem;">
                                <div style="font-size: 0.8125rem; color: var(--c-text); font-weight: 500;">
                                    {{ $jadwal->tgl_jadwal_maintenance->format('d M Y') }}
                                </div>
                                <div
                                    style="font-size: 0.6875rem; color: {{ $isOverdue ? 'var(--c-red)' : 'var(--c-text-dim)' }}; margin-top: 2px; display: flex; align-items: center; gap: 0.25rem;">
                                    @if ($isOverdue)
                                        <svg width="11" height="11" fill="none" stroke="currentColor"
                                            stroke-width="2" viewBox="0 0 24 24">
                                            <circle cx="12" cy="12" r="10" />
                                            <path d="M12 8v4l3 3" stroke-linecap="round" />
                                        </svg>
                                        Terlambat {{ now()->diffForHumans($jadwal->tgl_jadwal_maintenance, true) }}
                                    @else
                                        {{ $jadwal->tgl_jadwal_maintenance->diffForHumans() }}
                                    @endif
                                </div>
                            </td>

                            {{-- Pengguna Laptop --}}
                            <td style="padding: 1rem 1.25rem;">
                                @if ($jadwal->laptop->user)
                                    <div style="font-size: 0.8125rem; color: var(--c-text);">
                                        {{ $jadwal->laptop->user->nama_lengkap }}</div>
                                    <div style="font-size: 0.6875rem; color: var(--c-text-dim); margin-top: 2px;">
                                        {{ $jadwal->laptop->user->unit_kerja ?? '-' }}</div>
                                @else
                                    <span
                                        style="font-size: 0.75rem; color: var(--c-text-muted); font-style: italic;">Tidak
                                        ada pengguna</span>
                                @endif
                            </td>

                            {{-- Status --}}
                            <td style="padding: 1rem 1.25rem;">
                                @php
                                    $stCfg = [
                                        'Dijadwalkan' => [
                                            'bg' => 'var(--c-accent-dim)',
                                            'color' => 'var(--c-accent)',
                                            'dot' => true,
                                        ],
                                        'Selesai' => [
                                            'bg' => 'var(--c-green-dim)',
                                            'color' => 'var(--c-green)',
                                            'dot' => false,
                                        ],
                                        'Dibatalkan' => [
                                            'bg' => 'var(--c-red-dim)',
                                            'color' => 'var(--c-red)',
                                            'dot' => false,
                                        ],
                                    ];
                                    $sc = $stCfg[$jadwal->status] ?? [
                                        'bg' => 'var(--c-surface-3)',
                                        'color' => 'var(--c-text-dim)',
                                        'dot' => false,
                                    ];
                                @endphp
                                <span
                                    style="display: inline-flex; align-items: center; gap: 0.375rem; padding: 0.25rem 0.625rem; border-radius: 20px; background: {{ $sc['bg'] }}; color: {{ $sc['color'] }}; font-size: 0.6875rem; font-weight: 600; font-family: var(--font-mono); letter-spacing: 0.04em;">
                                    @if ($sc['dot'])
                                        <span
                                            style="width: 5px; height: 5px; border-radius: 50%; background: currentColor; box-shadow: 0 0 6px currentColor; animation: pulse 2s infinite;"></span>
                                    @endif
                                    {{ $jadwal->status }}
                                </span>
                            </td>

                            {{-- Aksi --}}
                            <td style="padding: 1rem 1.25rem; text-align: center;">
                                <button wire:click="openDetail({{ $jadwal->id_jadwal }})"
                                    style="display: inline-flex; align-items: center; gap: 0.375rem; padding: 0.375rem 0.875rem; border-radius: var(--radius-sm); background: var(--c-surface-3); border: 1px solid var(--c-border-bright); color: var(--c-text-dim); font-size: 0.75rem; font-weight: 500; cursor: pointer; transition: all 0.15s;"
                                    onmouseenter="this.style.color='var(--c-text)'; this.style.borderColor='var(--c-accent)'; this.style.background='var(--c-accent-dim)';"
                                    onmouseleave="this.style.color='var(--c-text-dim)'; this.style.borderColor='var(--c-border-bright)'; this.style.background='var(--c-surface-3)';">
                                    <svg width="13" height="13" fill="none" stroke="currentColor"
                                        stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Detail
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="padding: 4rem 1.5rem; text-align: center;">
                                <div style="display: flex; flex-direction: column; align-items: center; gap: 1rem;">
                                    <div
                                        style="width: 56px; height: 56px; border-radius: var(--radius-lg); background: var(--c-surface-3); border: 1px solid var(--c-border); display: flex; align-items: center; justify-content: center;">
                                        <svg width="24" height="24" fill="none"
                                            stroke="var(--c-text-muted)" stroke-width="1.5" viewBox="0 0 24 24">
                                            <rect x="3" y="4" width="18" height="18" rx="2" />
                                            <path d="M16 2v4M8 2v4M3 10h18" stroke-linecap="round" />
                                        </svg>
                                    </div>
                                    <div>
                                        <div
                                            style="font-size: 0.9375rem; font-weight: 600; color: var(--c-text); margin-bottom: 0.25rem;">
                                            Tidak ada jadwal</div>
                                        <div style="font-size: 0.8125rem; color: var(--c-text-dim);">
                                            Tidak ada jadwal dengan status <strong
                                                style="color: var(--c-text);">{{ $activeTab }}</strong>
                                            @if ($search || $filterTipe)
                                                yang sesuai filter
                                            @endif.
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($jadwals->hasPages())
            <div style="padding: 1rem 1.25rem; border-top: 1px solid var(--c-border); background: var(--c-surface-2);">
                {{ $jadwals->links() }}
            </div>
        @endif
    </div>

    {{-- Detail / Update Modal --}}
    <div x-show="showModal" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        style="display: none; position: fixed; inset: 0; z-index: 9999; overflow-y: auto; padding: 1.5rem;"
        aria-modal="true">

        {{-- Backdrop --}}
        <div style="position: fixed; inset: 0; background: rgba(3,7,16,0.75); backdrop-filter: blur(6px);"
            wire:click="closeModal"></div>

        {{-- Modal Content --}}
        <div x-show="showModal" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95 translate-y-2"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            style="position: relative; max-width: 620px; width: 100%; margin: 0 auto; background: var(--c-surface); border: 1px solid var(--c-border-bright); border-radius: var(--radius-xl); overflow: hidden; box-shadow: var(--shadow-lg);">

            @if ($this->selectedJadwal)
                @php $j = $this->selectedJadwal; @endphp

                {{-- Modal Header --}}
                <div
                    style="padding: 1.5rem; border-bottom: 1px solid var(--c-border); background: var(--c-surface-2); display: flex; align-items: flex-start; justify-content: space-between; gap: 1rem;">
                    <div>
                        <div
                            style="font-family: var(--font-mono); font-size: 0.6875rem; color: var(--c-accent); letter-spacing: 0.07em; text-transform: uppercase; margin-bottom: 0.375rem;">
                            Detail Jadwal</div>
                        <h2
                            style="font-family: var(--font-mono); font-size: 1.125rem; font-weight: 700; color: var(--c-text); letter-spacing: -0.01em;">
                            {{ $j->laptop->merek->nama_merek }} {{ $j->laptop->tipe_model }}
                        </h2>
                        <span
                            style="font-family: var(--font-mono); font-size: 0.75rem; color: var(--c-accent); margin-top: 2px; display: block;">{{ $j->laptop->kode_aset }}</span>
                    </div>
                    <button wire:click="closeModal"
                        style="width: 32px; height: 32px; border-radius: var(--radius-sm); background: var(--c-surface-3); border: 1px solid var(--c-border); color: var(--c-text-dim); display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.15s; flex-shrink: 0;"
                        onmouseenter="this.style.background='var(--c-red-dim)'; this.style.color='var(--c-red)';"
                        onmouseleave="this.style.background='var(--c-surface-3)'; this.style.color='var(--c-text-dim)';">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path d="M18 6L6 18M6 6l12 12" stroke-linecap="round" />
                        </svg>
                    </button>
                </div>

                {{-- Info Grid --}}
                <div style="padding: 1.5rem; border-bottom: 1px solid var(--c-border);">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.875rem;">
                        @php
                            $infoItems = [
                                ['label' => 'Tipe Maintenance', 'value' => $j->tipe_maintenance, 'mono' => true],
                                ['label' => 'Status Saat Ini', 'value' => $j->status, 'mono' => true],
                                [
                                    'label' => 'Tanggal Dijadwalkan',
                                    'value' => $j->tgl_jadwal_maintenance->format('d M Y, H:i'),
                                    'mono' => false,
                                ],
                                [
                                    'label' => 'Pengguna Laptop',
                                    'value' => $j->laptop->user?->nama_lengkap ?? 'Tidak Ada',
                                    'mono' => false,
                                ],
                                [
                                    'label' => 'Unit Kerja',
                                    'value' => $j->laptop->user?->unit_kerja ?? '-',
                                    'mono' => false,
                                ],
                                ['label' => 'Nomor Seri', 'value' => $j->laptop->nomor_seri ?? '-', 'mono' => true],
                            ];
                        @endphp
                        @foreach ($infoItems as $item)
                            <div
                                style="background: var(--c-surface-2); border: 1px solid var(--c-border); border-radius: var(--radius-md); padding: 0.875rem;">
                                <div
                                    style="font-family: var(--font-mono); font-size: 0.625rem; letter-spacing: 0.07em; text-transform: uppercase; color: var(--c-text-muted); margin-bottom: 0.375rem;">
                                    {{ $item['label'] }}</div>
                                <div
                                    style="font-size: 0.875rem; color: var(--c-text); font-weight: 500; {{ $item['mono'] ? 'font-family: var(--font-mono);' : '' }}">
                                    {{ $item['value'] }}</div>
                            </div>
                        @endforeach
                    </div>

                    @if ($j->deskripsi_maintenance)
                        <div
                            style="margin-top: 0.875rem; background: var(--c-surface-2); border: 1px solid var(--c-border); border-radius: var(--radius-md); padding: 0.875rem;">
                            <div
                                style="font-family: var(--font-mono); font-size: 0.625rem; letter-spacing: 0.07em; text-transform: uppercase; color: var(--c-text-muted); margin-bottom: 0.375rem;">
                                Deskripsi</div>
                            <p style="font-size: 0.875rem; color: var(--c-text-dim); line-height: 1.65;">
                                {{ $j->deskripsi_maintenance }}</p>
                        </div>
                    @endif
                </div>

                {{-- Update Form --}}
                <div style="padding: 1.5rem;">
                    <div
                        style="font-family: var(--font-mono); font-size: 0.6875rem; letter-spacing: 0.07em; text-transform: uppercase; color: var(--c-text-muted); margin-bottom: 1rem;">
                        Perbarui Status</div>

                    {{-- Status Select --}}
                    <div style="margin-bottom: 1rem;">
                        <label
                            style="display: block; font-size: 0.8125rem; font-weight: 500; color: var(--c-text-dim); margin-bottom: 0.5rem;">Status
                            Baru</label>
                        <select wire:model="statusBaru" style="width: 100%;">
                            <option value="Dijadwalkan">Dijadwalkan</option>
                            <option value="Selesai">Selesai</option>
                            <option value="Dibatalkan">Dibatalkan</option>
                        </select>
                    </div>

                    {{-- Catatan Teknisi --}}
                    <div style="margin-bottom: 1rem;">
                        <label
                            style="display: block; font-size: 0.8125rem; font-weight: 500; color: var(--c-text-dim); margin-bottom: 0.5rem;">Catatan
                            Teknisi</label>
                        <textarea wire:model="catatanTeknisi" rows="3"
                            placeholder="Tuliskan catatan teknis selama proses maintenance..." style="width: 100%; resize: vertical;"></textarea>
                    </div>

                    {{-- Hasil Maintenance --}}
                    <div style="margin-bottom: 1.5rem;">
                        <label
                            style="display: block; font-size: 0.8125rem; font-weight: 500; color: var(--c-text-dim); margin-bottom: 0.5rem;">Hasil
                            Maintenance</label>
                        <textarea wire:model="hasilMaintenance" rows="3"
                            placeholder="Jelaskan hasil dan temuan dari maintenance ini..." style="width: 100%; resize: vertical;"></textarea>
                    </div>

                    {{-- Actions --}}
                    <div style="display: flex; gap: 0.75rem; justify-content: flex-end;">
                        <button wire:click="closeModal"
                            style="padding: 0.625rem 1.25rem; border-radius: var(--radius-md); background: var(--c-surface-3); border: 1px solid var(--c-border); color: var(--c-text-dim); font-size: 0.875rem; font-weight: 500; cursor: pointer; transition: all 0.15s;"
                            onmouseenter="this.style.color='var(--c-text)'; this.style.borderColor='var(--c-border-bright)';"
                            onmouseleave="this.style.color='var(--c-text-dim)'; this.style.borderColor='var(--c-border)';">
                            Batal
                        </button>
                        <button wire:click="updateStatus" wire:loading.attr="disabled"
                            style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.625rem 1.5rem; border-radius: var(--radius-md); background: var(--c-accent); border: none; color: #fff; font-size: 0.875rem; font-weight: 600; cursor: pointer; transition: all 0.2s; box-shadow: 0 0 20px rgba(79,142,247,0.25);"
                            onmouseenter="this.style.background='#6ba3f9'; this.style.transform='translateY(-1px)';"
                            onmouseleave="this.style.background='var(--c-accent)'; this.style.transform='none';">
                            <span wire:loading.remove wire:target="updateStatus">
                                <svg width="14" height="14" fill="none" stroke="currentColor"
                                    stroke-width="2.5" viewBox="0 0 24 24" style="display: none;">
                                    <path d="M20 6L9 17l-5-5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                            <span wire:loading wire:target="updateStatus">
                                <div
                                    style="width: 14px; height: 14px; border: 2px solid rgba(255,255,255,0.3); border-top-color: #fff; border-radius: 50%; animation: spin 0.7s linear infinite; display: inline-block;">
                                </div>
                            </span>
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            @else
                <div style="padding: 3rem; text-align: center; color: var(--c-text-muted);">
                    <div wire:loading>
                        <div
                            style="width: 32px; height: 32px; border: 3px solid var(--c-border); border-top-color: var(--c-accent); border-radius: 50%; animation: spin 0.7s linear infinite; margin: 0 auto;">
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

</div>
