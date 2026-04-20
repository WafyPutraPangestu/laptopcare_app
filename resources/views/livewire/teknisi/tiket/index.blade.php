<div x-data="{ modalOpen: @entangle('showModal') }" class="home-page">
    {{-- ===================== PAGE HEADER ===================== --}}
    <div style="padding: 2rem 1.5rem 0; max-width: 1400px; margin: 0 auto;">
        <div style="margin-bottom: 0.5rem;">
            <span
                style="font-family: var(--font-mono); font-size: 0.6875rem; letter-spacing: 0.1em; text-transform: uppercase; color: var(--c-accent);">
                Panel Teknisi
            </span>
        </div>
        <div
            style="display: flex; align-items: flex-end; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-bottom: 2rem;">
            <div>
                <h1
                    style="font-family: var(--font-mono); font-size: 1.75rem; font-weight: 700; color: var(--c-text); letter-spacing: -0.02em; line-height: 1.1;">
                    Tiket Masuk
                </h1>
                <p style="font-size: 0.875rem; color: var(--c-text-dim); margin-top: 0.375rem;">
                    Kelola dan selesaikan laporan kerusakan laptop yang masuk.
                </p>
            </div>
            {{-- Status dot --}}
            <div class="ap-status-pill">
                <span class="ap-status-dot"></span>
                Live Update
            </div>
        </div>

        {{-- Flash message --}}
        @if (session()->has('success'))
            <div
                style="background: var(--c-green-dim); border: 1px solid var(--c-green); border-radius: var(--radius-md); padding: 0.75rem 1.25rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.625rem; animation: fadeInUp 0.3s ease both;">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="var(--c-green)"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
                <span style="font-size: 0.875rem; color: var(--c-green);">{{ session('success') }}</span>
            </div>
        @endif

        {{-- ===================== STATS CARDS ===================== --}}
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 2rem;">
            {{-- Menunggu --}}
            <div class="card" style="padding: 1.25rem; display: flex; align-items: center; gap: 1rem;">
                <div
                    style="width: 42px; height: 42px; border-radius: var(--radius-md); background: var(--c-orange-dim); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="var(--c-orange)"
                        stroke-width="1.8">
                        <circle cx="12" cy="12" r="10" />
                        <polyline points="12 6 12 12 16 14" />
                    </svg>
                </div>
                <div>
                    <div
                        style="font-family: var(--font-mono); font-size: 1.5rem; font-weight: 700; color: var(--c-orange); line-height: 1;">
                        {{ $stats['menunggu'] }}</div>
                    <div style="font-size: 0.6875rem; color: var(--c-text-dim); margin-top: 3px;">Menunggu</div>
                </div>
            </div>
            {{-- Diproses --}}
            <div class="card" style="padding: 1.25rem; display: flex; align-items: center; gap: 1rem;">
                <div
                    style="width: 42px; height: 42px; border-radius: var(--radius-md); background: var(--c-accent-dim); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="var(--c-accent)"
                        stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <div>
                    <div
                        style="font-family: var(--font-mono); font-size: 1.5rem; font-weight: 700; color: var(--c-accent); line-height: 1;">
                        {{ $stats['diproses'] }}</div>
                    <div style="font-size: 0.6875rem; color: var(--c-text-dim); margin-top: 3px;">Diproses</div>
                </div>
            </div>
            {{-- Selesai --}}
            <div class="card" style="padding: 1.25rem; display: flex; align-items: center; gap: 1rem;">
                <div
                    style="width: 42px; height: 42px; border-radius: var(--radius-md); background: var(--c-green-dim); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="var(--c-green)"
                        stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <div
                        style="font-family: var(--font-mono); font-size: 1.5rem; font-weight: 700; color: var(--c-green); line-height: 1;">
                        {{ $stats['selesai'] }}</div>
                    <div style="font-size: 0.6875rem; color: var(--c-text-dim); margin-top: 3px;">Selesai Hari Ini</div>
                </div>
            </div>
            {{-- Urgent --}}
            <div class="card"
                style="padding: 1.25rem; display: flex; align-items: center; gap: 1rem; border-color: {{ $stats['urgent'] > 0 ? 'var(--c-red)' : 'var(--c-border)' }};">
                <div
                    style="width: 42px; height: 42px; border-radius: var(--radius-md); background: var(--c-red-dim); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="var(--c-red)"
                        stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div>
                    <div
                        style="font-family: var(--font-mono); font-size: 1.5rem; font-weight: 700; color: var(--c-red); line-height: 1;">
                        {{ $stats['urgent'] }}</div>
                    <div style="font-size: 0.6875rem; color: var(--c-text-dim); margin-top: 3px;">Prioritas Tinggi</div>
                </div>
            </div>
        </div>

        {{-- ===================== FILTER BAR ===================== --}}
        <div class="card-transparent-border"
            style="padding: 1rem 1.25rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap;">
            {{-- Search --}}
            <div style="position: relative; flex: 1; min-width: 220px;">
                <svg style="position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%); pointer-events: none; opacity: 0.4;"
                    width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="var(--c-text)"
                    stroke-width="2">
                    <circle cx="11" cy="11" r="8" />
                    <line x1="21" y1="21" x2="16.65" y2="16.65" />
                </svg>
                <input wire:model.live.debounce.300ms="search" type="text"
                    placeholder="Cari kode aset, nama, keluhan..." style="padding-left: 2.25rem; width: 100%;">
            </div>
            {{-- Filter Status --}}
            <select wire:model.live="filterStatus" style="width: auto; min-width: 150px;">
                <option value="">Semua Status</option>
                <option value="Menunggu">Menunggu</option>
                <option value="Diproses">Diproses</option>
                <option value="Selesai">Selesai</option>
            </select>
            {{-- Filter Prioritas --}}
            <select wire:model.live="filterPrioritas" style="width: auto; min-width: 150px;">
                <option value="">Semua Prioritas</option>
                <option value="Tinggi">Tinggi</option>
                <option value="Sedang">Sedang</option>
                <option value="Rendah">Rendah</option>
            </select>
        </div>

        {{-- ===================== TABLE ===================== --}}
        <div class="card" style="padding: 0; overflow: hidden;">
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; font-size: 0.8125rem;">
                    <thead>
                        <tr style="border-bottom: 1px solid var(--c-border); background: var(--c-surface-2);">
                            <th
                                style="padding: 0.875rem 1.25rem; text-align: left; font-family: var(--font-mono); font-size: 0.625rem; letter-spacing: 0.08em; text-transform: uppercase; color: var(--c-text-dim); font-weight: 400; white-space: nowrap;">
                                Prioritas</th>
                            <th
                                style="padding: 0.875rem 1.25rem; text-align: left; font-family: var(--font-mono); font-size: 0.625rem; letter-spacing: 0.08em; text-transform: uppercase; color: var(--c-text-dim); font-weight: 400;">
                                Tiket</th>
                            <th
                                style="padding: 0.875rem 1.25rem; text-align: left; font-family: var(--font-mono); font-size: 0.625rem; letter-spacing: 0.08em; text-transform: uppercase; color: var(--c-text-dim); font-weight: 400;">
                                Pelapor</th>
                            <th
                                style="padding: 0.875rem 1.25rem; text-align: left; font-family: var(--font-mono); font-size: 0.625rem; letter-spacing: 0.08em; text-transform: uppercase; color: var(--c-text-dim); font-weight: 400;">
                                Laptop</th>
                            <th
                                style="padding: 0.875rem 1.25rem; text-align: left; font-family: var(--font-mono); font-size: 0.625rem; letter-spacing: 0.08em; text-transform: uppercase; color: var(--c-text-dim); font-weight: 400;">
                                Status</th>
                            <th
                                style="padding: 0.875rem 1.25rem; text-align: left; font-family: var(--font-mono); font-size: 0.625rem; letter-spacing: 0.08em; text-transform: uppercase; color: var(--c-text-dim); font-weight: 400;">
                                Tanggal Lapor</th>
                            <th
                                style="padding: 0.875rem 1.25rem; text-align: right; font-family: var(--font-mono); font-size: 0.625rem; letter-spacing: 0.08em; text-transform: uppercase; color: var(--c-text-dim); font-weight: 400;">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody wire:loading.class="opacity-50">
                        @forelse ($tikets as $tiket)
                            <tr style="border-bottom: 1px solid var(--c-border); transition: background 0.15s;" x-data
                                @mouseenter="$el.style.background='var(--c-surface-2)'"
                                @mouseleave="$el.style.background=''">
                                {{-- Prioritas --}}
                                <td style="padding: 1rem 1.25rem; white-space: nowrap;">
                                    @if ($tiket->prioritas === 'Tinggi')
                                        <span
                                            style="display: inline-flex; align-items: center; gap: 0.35rem; font-family: var(--font-mono); font-size: 0.625rem; letter-spacing: 0.05em; text-transform: uppercase; color: var(--c-red); background: var(--c-red-dim); border: 1px solid var(--c-red); border-radius: 4px; padding: 0.2rem 0.55rem;">
                                            <span
                                                style="width:5px; height:5px; border-radius: 50%; background: var(--c-red); display: inline-block;"></span>
                                            Tinggi
                                        </span>
                                    @elseif($tiket->prioritas === 'Sedang')
                                        <span
                                            style="display: inline-flex; align-items: center; gap: 0.35rem; font-family: var(--font-mono); font-size: 0.625rem; letter-spacing: 0.05em; text-transform: uppercase; color: var(--c-orange); background: var(--c-orange-dim); border: 1px solid var(--c-orange); border-radius: 4px; padding: 0.2rem 0.55rem;">
                                            <span
                                                style="width:5px; height:5px; border-radius: 50%; background: var(--c-orange); display: inline-block;"></span>
                                            Sedang
                                        </span>
                                    @else
                                        <span
                                            style="display: inline-flex; align-items: center; gap: 0.35rem; font-family: var(--font-mono); font-size: 0.625rem; letter-spacing: 0.05em; text-transform: uppercase; color: var(--c-text-dim); background: var(--c-surface-3); border: 1px solid var(--c-border); border-radius: 4px; padding: 0.2rem 0.55rem;">
                                            <span
                                                style="width:5px; height:5px; border-radius: 50%; background: var(--c-text-muted); display: inline-block;"></span>
                                            Rendah
                                        </span>
                                    @endif
                                </td>
                                {{-- Tiket info --}}
                                <td style="padding: 1rem 1.25rem; max-width: 260px;">
                                    <div
                                        style="font-family: var(--font-mono); font-size: 0.6875rem; color: var(--c-text-muted); margin-bottom: 3px;">
                                        #{{ str_pad($tiket->id_laporan, 4, '0', STR_PAD_LEFT) }}</div>
                                    <div
                                        style="color: var(--c-text); font-weight: 500; line-height: 1.4; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                                        {{ $tiket->keluhan_user }}</div>
                                </td>
                                {{-- Pelapor --}}
                                <td style="padding: 1rem 1.25rem; white-space: nowrap;">
                                    <div style="color: var(--c-text); font-weight: 500;">
                                        {{ $tiket->user->nama_lengkap }}</div>
                                    <div style="font-size: 0.6875rem; color: var(--c-text-dim); margin-top: 2px;">
                                        {{ $tiket->user->unit_kerja ?? '-' }}</div>
                                </td>
                                {{-- Laptop --}}
                                <td style="padding: 1rem 1.25rem; white-space: nowrap;">
                                    <div
                                        style="font-family: var(--font-mono); font-size: 0.75rem; color: var(--c-accent);">
                                        {{ $tiket->laptop->kode_aset }}</div>
                                    <div style="font-size: 0.6875rem; color: var(--c-text-dim); margin-top: 2px;">
                                        {{ $tiket->laptop->merek->nama_merek }} {{ $tiket->laptop->tipe_model }}</div>
                                </td>
                                {{-- Status --}}
                                <td style="padding: 1rem 1.25rem; white-space: nowrap;">
                                    @if ($tiket->status_tiket === 'Menunggu')
                                        <span
                                            style="font-family: var(--font-mono); font-size: 0.625rem; letter-spacing: 0.05em; text-transform: uppercase; color: var(--c-orange); background: var(--c-orange-dim); border-radius: 4px; padding: 0.2rem 0.55rem;">Menunggu</span>
                                    @elseif($tiket->status_tiket === 'Diproses')
                                        <span
                                            style="font-family: var(--font-mono); font-size: 0.625rem; letter-spacing: 0.05em; text-transform: uppercase; color: var(--c-accent); background: var(--c-accent-dim); border-radius: 4px; padding: 0.2rem 0.55rem;">Diproses</span>
                                    @else
                                        <span
                                            style="font-family: var(--font-mono); font-size: 0.625rem; letter-spacing: 0.05em; text-transform: uppercase; color: var(--c-green); background: var(--c-green-dim); border-radius: 4px; padding: 0.2rem 0.55rem;">Selesai</span>
                                    @endif
                                </td>
                                {{-- Tanggal --}}
                                <td style="padding: 1rem 1.25rem; white-space: nowrap;">
                                    <div style="font-size: 0.8125rem; color: var(--c-text);">
                                        {{ $tiket->tgl_lapor->format('d M Y') }}</div>
                                    <div style="font-size: 0.6875rem; color: var(--c-text-dim); margin-top: 2px;">
                                        {{ $tiket->tgl_lapor->format('H:i') }}</div>
                                </td>
                                {{-- Aksi --}}
                                <td style="padding: 1rem 1.25rem; text-align: right; white-space: nowrap;">
                                    @if ($tiket->status_tiket !== 'Selesai')
                                        <button wire:click="prosesTicket({{ $tiket->id_laporan }})"
                                            wire:loading.attr="disabled" class="button-v2 size-sm"
                                            style="gap: 0.375rem;">
                                            <svg width="13" height="13" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Proses
                                        </button>
                                    @else
                                        <span style="font-size: 0.75rem; color: var(--c-text-muted);">—</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="padding: 3rem; text-align: center;">
                                    <div
                                        style="color: var(--c-text-muted); font-family: var(--font-mono); font-size: 0.75rem; letter-spacing: 0.05em;">
                                        Tidak ada tiket ditemukan.
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($tikets->hasPages())
                <div style="padding: 1rem 1.25rem; border-top: 1px solid var(--c-border);">
                    {{ $tikets->links() }}
                </div>
            @endif
        </div>

        <div style="height: 3rem;"></div>
    </div>

    {{-- ===================== MODAL PROSES TIKET ===================== --}}
    <div x-show="modalOpen" x-cloak
        style="position: fixed; inset: 0; z-index: 9000; display: flex; align-items: center; justify-content: center; padding: 1rem;">
        {{-- Backdrop --}}
        <div x-show="modalOpen" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" @click="$wire.closeModal()"
            style="position: absolute; inset: 0; background: rgba(3, 7, 16, 0.75); backdrop-filter: blur(4px);"></div>

        {{-- Modal Panel --}}
        <div x-show="modalOpen" x-transition:enter="transition ease-out duration-250"
            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-4"
            style="position: relative; width: 100%; max-width: 760px; max-height: 90vh; overflow-y: auto; background: var(--c-surface); border: 1px solid var(--c-border-bright); border-radius: var(--radius-xl); box-shadow: var(--shadow-lg);">
            {{-- Modal Header --}}
            <div
                style="display: flex; align-items: center; justify-content: space-between; padding: 1.5rem 1.75rem; border-bottom: 1px solid var(--c-border); position: sticky; top: 0; background: var(--c-surface); z-index: 10; border-radius: var(--radius-xl) var(--radius-xl) 0 0;">
                <div>
                    <h2
                        style="font-family: var(--font-mono); font-size: 1rem; font-weight: 700; color: var(--c-text); letter-spacing: -0.01em;">
                        Proses & Selesaikan Tiket
                    </h2>
                    @if (!empty($activeTiket))
                        <div
                            style="font-family: var(--font-mono); font-size: 0.6875rem; color: var(--c-text-muted); margin-top: 3px;">
                            #{{ str_pad($activeTiket['id_laporan'] ?? 0, 4, '0', STR_PAD_LEFT) }} ·
                            {{ $activeTiket['kode_aset'] ?? '' }}
                        </div>
                    @endif
                </div>
                <button @click="$wire.closeModal()"
                    style="width: 32px; height: 32px; border-radius: var(--radius-sm); border: 1px solid var(--c-border); background: var(--c-surface-2); color: var(--c-text-dim); display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.15s;"
                    @mouseenter="$el.style.borderColor='var(--c-border-bright)'"
                    @mouseleave="$el.style.borderColor='var(--c-border)'">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Info Tiket (read-only) --}}
            @if (!empty($activeTiket))
                <div
                    style="padding: 1.25rem 1.75rem; background: var(--c-surface-2); border-bottom: 1px solid var(--c-border);">
                    <div
                        style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem 1.5rem; font-size: 0.8125rem;">
                        <div>
                            <div
                                style="font-family: var(--font-mono); font-size: 0.625rem; letter-spacing: 0.06em; text-transform: uppercase; color: var(--c-text-muted); margin-bottom: 4px;">
                                Pelapor</div>
                            <div style="color: var(--c-text); font-weight: 500;">{{ $activeTiket['nama_user'] ?? '' }}
                            </div>
                            <div style="font-size: 0.6875rem; color: var(--c-text-dim);">
                                {{ $activeTiket['unit_kerja'] ?? '' }}</div>
                        </div>
                        <div>
                            <div
                                style="font-family: var(--font-mono); font-size: 0.625rem; letter-spacing: 0.06em; text-transform: uppercase; color: var(--c-text-muted); margin-bottom: 4px;">
                                Laptop</div>
                            <div style="color: var(--c-accent); font-family: var(--font-mono); font-size: 0.8125rem;">
                                {{ $activeTiket['kode_aset'] ?? '' }}</div>
                            <div style="font-size: 0.6875rem; color: var(--c-text-dim);">
                                {{ ($activeTiket['merek'] ?? '') . ' ' . ($activeTiket['tipe_model'] ?? '') }}</div>
                        </div>
                        <div>
                            <div
                                style="font-family: var(--font-mono); font-size: 0.625rem; letter-spacing: 0.06em; text-transform: uppercase; color: var(--c-text-muted); margin-bottom: 4px;">
                                Prioritas</div>
                            @php $prio = $activeTiket['prioritas'] ?? 'Sedang'; @endphp
                            <span
                                style="font-family: var(--font-mono); font-size: 0.6875rem; padding: 0.2rem 0.65rem; border-radius: 4px; background: {{ $prio === 'Tinggi' ? 'var(--c-red-dim)' : ($prio === 'Sedang' ? 'var(--c-orange-dim)' : 'var(--c-surface-3)') }}; color: {{ $prio === 'Tinggi' ? 'var(--c-red)' : ($prio === 'Sedang' ? 'var(--c-orange)' : 'var(--c-text-dim)') }};">
                                {{ $prio }}
                            </span>
                        </div>
                    </div>
                    <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid var(--c-border);">
                        <div
                            style="font-family: var(--font-mono); font-size: 0.625rem; letter-spacing: 0.06em; text-transform: uppercase; color: var(--c-text-muted); margin-bottom: 6px;">
                            Keluhan User</div>
                        <p style="font-size: 0.875rem; color: var(--c-text); line-height: 1.6;">
                            {{ $activeTiket['keluhan_user'] ?? '' }}</p>
                    </div>
                </div>
            @endif

            {{-- Form --}}
            <form wire:submit="simpanPerbaikan" style="padding: 1.75rem;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">

                    {{-- Komponen Rusak --}}
                    <div style="grid-column: 1 / -1;">
                        <label
                            style="display: block; font-family: var(--font-mono); font-size: 0.6875rem; letter-spacing: 0.05em; text-transform: uppercase; color: var(--c-text-dim); margin-bottom: 0.5rem;">
                            Komponen Rusak <span style="color: var(--c-red);">*</span>
                        </label>
                        <input wire:model="komponen_rusak" type="text"
                            placeholder="Contoh: Baterai, RAM, Keyboard...">
                        @error('komponen_rusak')
                            <span
                                style="font-size: 0.75rem; color: var(--c-red); margin-top: 4px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Referensi Komponen (opsional) --}}
                    <div>
                        <label
                            style="display: block; font-family: var(--font-mono); font-size: 0.6875rem; letter-spacing: 0.05em; text-transform: uppercase; color: var(--c-text-dim); margin-bottom: 0.5rem;">
                            Referensi Komponen
                        </label>
                        <select wire:model="id_komponen">
                            <option value="">— Pilih dari master —</option>
                            @foreach ($komponen as $k)
                                <option value="{{ $k->id_komponen }}">{{ $k->nama_komponen }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Kategori --}}
                    <div>
                        <label
                            style="display: block; font-family: var(--font-mono); font-size: 0.6875rem; letter-spacing: 0.05em; text-transform: uppercase; color: var(--c-text-dim); margin-bottom: 0.5rem;">
                            Kategori <span style="color: var(--c-red);">*</span>
                        </label>
                        <select wire:model="kategori_rusak">
                            <option value="Hardware">Hardware</option>
                            <option value="Software">Software</option>
                            <option value="Jaringan">Jaringan</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                        @error('kategori_rusak')
                            <span
                                style="font-size: 0.75rem; color: var(--c-red); margin-top: 4px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Tingkat Kesulitan --}}
                    <div>
                        <label
                            style="display: block; font-family: var(--font-mono); font-size: 0.6875rem; letter-spacing: 0.05em; text-transform: uppercase; color: var(--c-text-dim); margin-bottom: 0.5rem;">
                            Tingkat Kesulitan <span style="color: var(--c-red);">*</span>
                        </label>
                        <select wire:model="tingkat_kesulitan">
                            <option value="Mudah">Mudah</option>
                            <option value="Sedang">Sedang</option>
                            <option value="Sulit">Sulit</option>
                        </select>
                    </div>

                    {{-- Tgl Selesai --}}
                    <div>
                        <label
                            style="display: block; font-family: var(--font-mono); font-size: 0.6875rem; letter-spacing: 0.05em; text-transform: uppercase; color: var(--c-text-dim); margin-bottom: 0.5rem;">
                            Tanggal Selesai <span style="color: var(--c-red);">*</span>
                        </label>
                        <input wire:model="tgl_selesai" type="date">
                        @error('tgl_selesai')
                            <span
                                style="font-size: 0.75rem; color: var(--c-red); margin-top: 4px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Biaya --}}
                    <div>
                        <label
                            style="display: block; font-family: var(--font-mono); font-size: 0.6875rem; letter-spacing: 0.05em; text-transform: uppercase; color: var(--c-text-dim); margin-bottom: 0.5rem;">
                            Biaya Perbaikan (Rp)
                        </label>
                        <input wire:model="biaya_perbaikan" type="number" min="0" placeholder="0">
                    </div>

                    {{-- Spare Part --}}
                    <div style="grid-column: 1 / -1;">
                        <label
                            style="display: block; font-family: var(--font-mono); font-size: 0.6875rem; letter-spacing: 0.05em; text-transform: uppercase; color: var(--c-text-dim); margin-bottom: 0.5rem;">
                            Spare Part Digunakan
                        </label>
                        <input wire:model="spare_part_digunakan" type="text"
                            placeholder="Contoh: RAM DDR4 8GB, Baterai OEM...">
                    </div>

                    {{-- Tindakan Penyelesaian --}}
                    <div style="grid-column: 1 / -1;">
                        <label
                            style="display: block; font-family: var(--font-mono); font-size: 0.6875rem; letter-spacing: 0.05em; text-transform: uppercase; color: var(--c-text-dim); margin-bottom: 0.5rem;">
                            Tindakan Penyelesaian <span style="color: var(--c-red);">*</span>
                        </label>
                        <textarea wire:model="tindakan_penyelesaian" rows="3"
                            placeholder="Jelaskan langkah-langkah perbaikan yang dilakukan..."></textarea>
                        @error('tindakan_penyelesaian')
                            <span
                                style="font-size: 0.75rem; color: var(--c-red); margin-top: 4px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Rekomendasi --}}
                    <div style="grid-column: 1 / -1;">
                        <label
                            style="display: block; font-family: var(--font-mono); font-size: 0.6875rem; letter-spacing: 0.05em; text-transform: uppercase; color: var(--c-text-dim); margin-bottom: 0.5rem;">
                            Rekomendasi Perawatan
                        </label>
                        <textarea wire:model="rekomendasi_perawatan" rows="2" placeholder="Saran untuk mencegah kerusakan berulang..."></textarea>
                    </div>

                    {{-- Recurring checkbox --}}
                    <div style="grid-column: 1 / -1;">
                        <label
                            style="display: flex; align-items: center; gap: 0.625rem; cursor: pointer; user-select: none;">
                            <input wire:model="apakah_terjadi_ulang" type="checkbox"
                                style="width: 16px; height: 16px; accent-color: var(--c-accent); cursor: pointer;">
                            <span style="font-size: 0.875rem; color: var(--c-text-dim);">
                                Kerusakan ini pernah terjadi sebelumnya (recurring issue)
                            </span>
                        </label>
                    </div>
                </div>

                {{-- Footer action --}}
                <div
                    style="display: flex; align-items: center; justify-content: flex-end; gap: 0.75rem; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--c-border);">
                    <button type="button" @click="$wire.closeModal()" class="button-v2 variant-outline size-sm">
                        Batal
                    </button>
                    <button type="submit" class="button-v2 size-sm" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="simpanPerbaikan"
                            style="display: flex; align-items: center; gap: 0.375rem;">
                            <svg width="13" height="13" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            Selesaikan Tiket
                        </span>
                        <span wire:loading wire:target="simpanPerbaikan"
                            style="display: flex; align-items: center; gap: 0.375rem;">
                            <svg style="animation: spin 1s linear infinite;" width="13" height="13"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Menyimpan...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
