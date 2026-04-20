<div>
    {{-- Header --}}
    <div style="padding: 2rem 2rem 0">
        <div style="max-width:1400px;margin:0 auto">
            <div
                style="display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;flex-wrap:wrap;margin-bottom:2rem">
                <div>
                    <div
                        style="font-family:var(--font-mono);font-size:0.6875rem;letter-spacing:0.1em;text-transform:uppercase;color:var(--c-accent);margin-bottom:0.5rem">
                        Kepala IT / Maintenance
                    </div>
                    <h1
                        style="font-family:var(--font-mono);font-size:1.75rem;font-weight:700;color:var(--c-text);letter-spacing:-0.02em;margin:0 0 0.375rem">
                        Jadwal Maintenance
                    </h1>
                    <p style="font-size:0.875rem;color:var(--c-text-dim);margin:0">
                        Kelola dan pantau semua jadwal perawatan laptop.
                    </p>
                </div>
                <a href="{{ route('kepala.maintenance.create') }}"
                    style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.65rem 1.25rem;border-radius:var(--radius-md);background:var(--c-accent);color:#fff;font-size:0.875rem;font-weight:600;text-decoration:none;transition:all 0.2s;box-shadow:0 0 20px rgba(79,142,247,0.3)"
                    onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 28px rgba(79,142,247,0.4)'"
                    onmouseout="this.style.transform='';this.style.boxShadow='0 0 20px rgba(79,142,247,0.3)'">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5">
                        <path d="M12 5v14M5 12h14" />
                    </svg>
                    Buat Jadwal
                </a>
            </div>

            {{-- Stats strip --}}
            <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;margin-bottom:2rem">
                @php
                    $stats = [
                        [
                            'label' => 'Total Jadwal',
                            'value' => $jadwals->total(),
                            'color' => 'var(--c-accent)',
                            'bg' => 'var(--c-accent-dim)',
                            'icon' =>
                                '<path d="M8 2v4M16 2v4M3 10h18M3 6a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V6z"/>',
                        ],
                        [
                            'label' => 'Dijadwalkan',
                            'value' => $jadwals->getCollection()->where('status', 'Dijadwalkan')->count(),
                            'color' => 'var(--c-orange)',
                            'bg' => 'var(--c-orange-dim)',
                            'icon' => '<circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>',
                        ],
                        [
                            'label' => 'Selesai',
                            'value' => $jadwals->getCollection()->where('status', 'Selesai')->count(),
                            'color' => 'var(--c-green)',
                            'bg' => 'var(--c-green-dim)',
                            'icon' => '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="M22 4 12 14.01l-3-3"/>',
                        ],
                        [
                            'label' => 'Dibatalkan',
                            'value' => $jadwals->getCollection()->where('status', 'Dibatalkan')->count(),
                            'color' => 'var(--c-red)',
                            'bg' => 'var(--c-red-dim)',
                            'icon' => '<circle cx="12" cy="12" r="10"/><path d="m15 9-6 6M9 9l6 6"/>',
                        ],
                    ];
                @endphp
                @foreach ($stats as $s)
                    <div
                        style="background:var(--c-surface);border:1px solid var(--c-border);border-radius:var(--radius-lg);padding:1.25rem;display:flex;align-items:center;gap:1rem">
                        <div
                            style="width:40px;height:40px;border-radius:var(--radius-md);background:{{ $s['bg'] }};color:{{ $s['color'] }};display:flex;align-items:center;justify-content:center;flex-shrink:0">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">{!! $s['icon'] !!}</svg>
                        </div>
                        <div>
                            <div
                                style="font-family:var(--font-mono);font-size:1.375rem;font-weight:700;color:var(--c-text);line-height:1">
                                {{ $s['value'] }}</div>
                            <div style="font-size:0.6875rem;color:var(--c-text-dim);margin-top:3px">{{ $s['label'] }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Filter bar --}}
            <div
                style="background:var(--c-surface);border:1px solid var(--c-border);border-radius:var(--radius-lg);padding:1rem 1.25rem;margin-bottom:1.5rem;display:flex;gap:0.75rem;flex-wrap:wrap;align-items:center">
                <div style="position:relative;flex:1;min-width:200px">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2"
                        style="position:absolute;left:0.75rem;top:50%;transform:translateY(-50%);color:var(--c-text-muted)">
                        <circle cx="11" cy="11" r="8" />
                        <path d="m21 21-4.35-4.35" />
                    </svg>
                    <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari laptop / teknisi..."
                        style="padding-left:2.25rem;background:var(--c-surface-2);border:1px solid var(--c-border);border-radius:var(--radius-md);color:var(--c-text);font-size:0.8125rem;height:36px;width:100%">
                </div>

                <select wire:model.live="filterStatus"
                    style="background:var(--c-surface-2);border:1px solid var(--c-border);border-radius:var(--radius-md);color:var(--c-text);font-size:0.8125rem;height:36px;padding:0 2rem 0 0.75rem;min-width:140px;cursor:pointer">
                    <option value="">Semua Status</option>
                    <option value="Dijadwalkan">Dijadwalkan</option>
                    <option value="Selesai">Selesai</option>
                    <option value="Dibatalkan">Dibatalkan</option>
                </select>

                <select wire:model.live="filterTipe"
                    style="background:var(--c-surface-2);border:1px solid var(--c-border);border-radius:var(--radius-md);color:var(--c-text);font-size:0.8125rem;height:36px;padding:0 2rem 0 0.75rem;min-width:140px;cursor:pointer">
                    <option value="">Semua Tipe</option>
                    <option value="Rutin">Rutin</option>
                    <option value="Darurat">Darurat</option>
                    <option value="Preventif">Preventif</option>
                </select>

                @if ($search || $filterStatus || $filterTipe)
                    <button wire:click="resetFilter"
                        style="display:inline-flex;align-items:center;gap:0.375rem;padding:0 0.875rem;height:36px;border-radius:var(--radius-md);background:var(--c-red-dim);color:var(--c-red);border:1px solid transparent;font-size:0.8125rem;cursor:pointer;transition:all 0.15s"
                        onmouseover="this.style.borderColor='var(--c-red)'"
                        onmouseout="this.style.borderColor='transparent'">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5">
                            <path d="M18 6 6 18M6 6l12 12" />
                        </svg>
                        Reset
                    </button>
                @endif
            </div>
        </div>
    </div>

    {{-- Table area --}}
    <div style="padding:0 2rem 2rem">
        <div style="max-width:1400px;margin:0 auto">
            <div
                style="background:var(--c-surface);border:1px solid var(--c-border);border-radius:var(--radius-lg);overflow:hidden">

                {{-- Loading overlay --}}
                <div wire:loading.flex
                    style="position:absolute;inset:0;background:rgba(8,10,15,0.6);z-index:10;align-items:center;justify-content:center;border-radius:var(--radius-lg)">
                    <div style="display:flex;flex-direction:column;align-items:center;gap:0.75rem">
                        <div
                            style="width:32px;height:32px;border:2px solid var(--c-border-bright);border-top-color:var(--c-accent);border-radius:50%;animation:spin 0.7s linear infinite">
                        </div>
                        <span
                            style="font-family:var(--font-mono);font-size:0.6875rem;color:var(--c-text-dim)">Memuat...</span>
                    </div>
                </div>

                <table style="width:100%;border-collapse:collapse">
                    <thead>
                        <tr style="border-bottom:1px solid var(--c-border);background:var(--c-surface-2)">
                            @php
                                $cols = [
                                    ['key' => 'id_jadwal', 'label' => '#'],
                                    ['key' => 'laptop', 'label' => 'Laptop'],
                                    ['key' => 'teknisi', 'label' => 'Teknisi'],
                                    ['key' => 'tipe_maintenance', 'label' => 'Tipe'],
                                    ['key' => 'tgl_jadwal_maintenance', 'label' => 'Jadwal'],
                                    ['key' => 'status', 'label' => 'Status'],
                                    ['key' => 'biaya_maintenance', 'label' => 'Biaya'],
                                    ['key' => null, 'label' => 'Aksi'],
                                ];
                            @endphp
                            @foreach ($cols as $col)
                                <th style="padding:0.875rem 1rem;text-align:left;font-family:var(--font-mono);font-size:0.6875rem;letter-spacing:0.06em;text-transform:uppercase;color:var(--c-text-dim);white-space:nowrap;{{ $col['key'] ? 'cursor:pointer' : '' }}"
                                    @if ($col['key']) wire:click="sortBy('{{ $col['key'] }}')" @endif>
                                    <span style="display:inline-flex;align-items:center;gap:0.375rem">
                                        {{ $col['label'] }}
                                        @if ($col['key'] && $sortBy === $col['key'])
                                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2.5" style="color:var(--c-accent)">
                                                @if ($sortDir === 'asc')
                                                    <path d="m18 15-6-6-6 6" />
                                                @else
                                                    <path d="m6 9 6 6 6-6" />
                                                @endif
                                            </svg>
                                        @endif
                                    </span>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jadwals as $j)
                            @php
                                $statusColor = match ($j->status) {
                                    'Dijadwalkan' => ['bg' => 'var(--c-orange-dim)', 'text' => 'var(--c-orange)'],
                                    'Selesai' => ['bg' => 'var(--c-green-dim)', 'text' => 'var(--c-green)'],
                                    'Dibatalkan' => ['bg' => 'var(--c-red-dim)', 'text' => 'var(--c-red)'],
                                    default => ['bg' => 'var(--c-surface-3)', 'text' => 'var(--c-text-dim)'],
                                };
                                $tipeColor = match ($j->tipe_maintenance) {
                                    'Darurat' => ['bg' => 'var(--c-red-dim)', 'text' => 'var(--c-red)'],
                                    'Preventif' => ['bg' => 'rgba(167,139,250,0.12)', 'text' => 'var(--c-purple)'],
                                    default => ['bg' => 'var(--c-accent-dim)', 'text' => 'var(--c-accent)'],
                                };
                            @endphp
                            <tr wire:key="jadwal-{{ $j->id_jadwal }}"
                                style="border-bottom:1px solid var(--c-border);transition:background 0.15s"
                                onmouseover="this.style.background='var(--c-surface-2)'"
                                onmouseout="this.style.background=''">
                                <td
                                    style="padding:0.875rem 1rem;font-family:var(--font-mono);font-size:0.6875rem;color:var(--c-text-muted)">
                                    #{{ $j->id_jadwal }}</td>
                                <td style="padding:0.875rem 1rem">
                                    <div style="font-size:0.8125rem;font-weight:600;color:var(--c-text)">
                                        {{ $j->laptop->kode_aset }}</div>
                                    <div style="font-size:0.6875rem;color:var(--c-text-dim);margin-top:2px">
                                        {{ $j->laptop->tipe_model }}</div>
                                </td>
                                <td style="padding:0.875rem 1rem">
                                    @if ($j->teknisi)
                                        <div style="font-size:0.8125rem;color:var(--c-text)">
                                            {{ $j->teknisi->nama_lengkap }}</div>
                                    @else
                                        <span style="font-size:0.75rem;color:var(--c-text-muted)">—</span>
                                    @endif
                                </td>
                                <td style="padding:0.875rem 1rem">
                                    <span
                                        style="display:inline-block;padding:0.2rem 0.625rem;border-radius:20px;font-family:var(--font-mono);font-size:0.625rem;letter-spacing:0.04em;background:{{ $tipeColor['bg'] }};color:{{ $tipeColor['text'] }}">
                                        {{ $j->tipe_maintenance }}
                                    </span>
                                </td>
                                <td
                                    style="padding:0.875rem 1rem;font-family:var(--font-mono);font-size:0.75rem;color:var(--c-text-dim);white-space:nowrap">
                                    {{ $j->tgl_jadwal_maintenance->format('d M Y') }}
                                    @if ($j->tgl_selesai_maintenance)
                                        <div style="font-size:0.625rem;color:var(--c-text-muted);margin-top:2px">selesai
                                            {{ $j->tgl_selesai_maintenance->format('d M Y') }}</div>
                                    @endif
                                </td>
                                <td style="padding:0.875rem 1rem">
                                    <span
                                        style="display:inline-block;padding:0.2rem 0.625rem;border-radius:20px;font-family:var(--font-mono);font-size:0.625rem;letter-spacing:0.04em;background:{{ $statusColor['bg'] }};color:{{ $statusColor['text'] }}">
                                        {{ $j->status }}
                                    </span>
                                </td>
                                <td
                                    style="padding:0.875rem 1rem;font-family:var(--font-mono);font-size:0.75rem;color:var(--c-text-dim)">
                                    {{ $j->biaya_maintenance ? 'Rp ' . number_format($j->biaya_maintenance, 0, ',', '.') : '—' }}
                                </td>
                                <td style="padding:0.875rem 1rem">
                                    <div style="display:flex;align-items:center;gap:0.5rem">
                                        <a href="{{ route('kepala.maintenance.edit', $j->id_jadwal) }}"
                                            style="display:inline-flex;align-items:center;justify-content:center;width:30px;height:30px;border-radius:var(--radius-sm);background:var(--c-accent-dim);color:var(--c-accent);border:1px solid transparent;transition:all 0.15s;text-decoration:none"
                                            title="Edit" onmouseover="this.style.borderColor='var(--c-accent)'"
                                            onmouseout="this.style.borderColor='transparent'">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                            </svg>
                                        </a>
                                        <button wire:click="confirmDelete({{ $j->id_jadwal }})"
                                            style="display:inline-flex;align-items:center;justify-content:center;width:30px;height:30px;border-radius:var(--radius-sm);background:var(--c-red-dim);color:var(--c-red);border:1px solid transparent;cursor:pointer;transition:all 0.15s"
                                            title="Hapus" onmouseover="this.style.borderColor='var(--c-red)'"
                                            onmouseout="this.style.borderColor='transparent'">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2">
                                                <polyline points="3 6 5 6 21 6" />
                                                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                                                <path d="M10 11v6M14 11v6" />
                                                <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" style="padding:4rem;text-align:center">
                                    <div style="display:flex;flex-direction:column;align-items:center;gap:1rem">
                                        <div
                                            style="width:52px;height:52px;border-radius:var(--radius-md);background:var(--c-surface-2);display:flex;align-items:center;justify-content:center;color:var(--c-text-muted)">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="1.5">
                                                <rect x="3" y="4" width="18" height="18" rx="2"
                                                    ry="2" />
                                                <line x1="16" y1="2" x2="16" y2="6" />
                                                <line x1="8" y1="2" x2="8" y2="6" />
                                                <line x1="3" y1="10" x2="21" y2="10" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div
                                                style="font-family:var(--font-mono);font-size:0.875rem;color:var(--c-text-dim)">
                                                Tidak ada jadwal ditemukan</div>
                                            <div style="font-size:0.75rem;color:var(--c-text-muted);margin-top:4px">
                                                Coba ubah filter atau buat jadwal baru</div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination --}}
                @if ($jadwals->hasPages())
                    <div
                        style="padding:1rem 1.25rem;border-top:1px solid var(--c-border);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:0.75rem">
                        <div style="font-size:0.75rem;color:var(--c-text-dim)">
                            Menampilkan {{ $jadwals->firstItem() }}–{{ $jadwals->lastItem() }} dari
                            {{ $jadwals->total() }} jadwal
                        </div>
                        <div>{{ $jadwals->links() }}</div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Delete Confirm Modal --}}
    @if ($confirmingDelete)
        <div style="position:fixed;inset:0;z-index:50;display:flex;align-items:center;justify-content:center;padding:1rem"
            x-data x-init="$el.style.animation = 'fadeInUp 0.2s ease both'">
            <div style="position:absolute;inset:0;background:rgba(3,7,16,0.75);backdrop-filter:blur(6px)"
                wire:click="$set('confirmingDelete',false)"></div>
            <div
                style="position:relative;background:var(--c-surface-2);border:1px solid var(--c-border-bright);border-radius:var(--radius-xl);padding:2rem;width:100%;max-width:420px;box-shadow:var(--shadow-lg)">
                <div
                    style="width:48px;height:48px;border-radius:var(--radius-md);background:var(--c-red-dim);color:var(--c-red);display:flex;align-items:center;justify-content:center;margin-bottom:1.25rem">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path
                            d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                        <line x1="12" y1="9" x2="12" y2="13" />
                        <line x1="12" y1="17" x2="12.01" y2="17" />
                    </svg>
                </div>
                <h3
                    style="font-family:var(--font-mono);font-size:1.0625rem;font-weight:700;color:var(--c-text);margin:0 0 0.5rem">
                    Hapus Jadwal?</h3>
                <p style="font-size:0.875rem;color:var(--c-text-dim);margin:0 0 1.5rem;line-height:1.6">Data jadwal
                    maintenance ini akan dihapus permanen dan tidak bisa dikembalikan.</p>
                <div style="display:flex;gap:0.75rem">
                    <button wire:click="$set('confirmingDelete',false)"
                        style="flex:1;padding:0.65rem;border-radius:var(--radius-md);background:var(--c-surface-3);color:var(--c-text-dim);border:1px solid var(--c-border);font-size:0.875rem;cursor:pointer;transition:all 0.15s"
                        onmouseover="this.style.borderColor='var(--c-border-bright)'"
                        onmouseout="this.style.borderColor='var(--c-border)'">
                        Batal
                    </button>
                    <button wire:click="deleteJadwal"
                        style="flex:1;padding:0.65rem;border-radius:var(--radius-md);background:var(--c-red);color:#fff;border:none;font-size:0.875rem;font-weight:600;cursor:pointer;transition:all 0.15s"
                        onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
                        Ya, Hapus
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
