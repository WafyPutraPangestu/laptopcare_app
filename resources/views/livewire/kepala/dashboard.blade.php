<div style="padding: 2rem 0 4rem;">
    <div class="home-section-inner">

        {{-- ══════════ HEADER ══════════ --}}
        <div style="margin-bottom: 2.5rem; animation: fadeUp 0.5s ease both;">
            <p class="home-section-label">Kepala IT · Overview</p>
            <div style="display:flex; align-items:flex-end; justify-content:space-between; flex-wrap:wrap; gap:1rem;">
                <div>
                    <h1 class="home-section-title" style="margin-bottom:0.25rem;">
                        Dashboard
                    </h1>
                    <p style="font-size:0.875rem; color:var(--c-text-dim);">
                        Selamat datang, <strong style="color:var(--c-text);">{{ auth()->user()->nama_lengkap }}</strong>
                        <span
                            style="font-family:var(--font-mono); font-size:0.75rem; color:var(--c-text-muted); margin-left:0.5rem;">
                            {{ now()->translatedFormat('l, d F Y') }}
                        </span>
                    </p>
                </div>
                <div class="ap-status-pill">
                    <span class="ap-status-dot"></span>
                    Sistem Aktif
                </div>
            </div>
        </div>

        {{-- ══════════ STAT CARDS ══════════ --}}
        <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:1rem; margin-bottom:1.5rem;">

            {{-- Total Laptop --}}
            <div class="card" style="padding:1.5rem; animation-delay:0s;">
                <div
                    style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:1.25rem;">
                    <div
                        style="width:40px;height:40px;border-radius:var(--radius-md);background:var(--c-accent-dim);display:flex;align-items:center;justify-content:center;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--c-accent)"
                            stroke-width="2">
                            <rect x="2" y="3" width="20" height="14" rx="2" />
                            <line x1="8" y1="21" x2="16" y2="21" />
                            <line x1="12" y1="17" x2="12" y2="21" />
                        </svg>
                    </div>
                    <span
                        style="font-family:var(--font-mono);font-size:2rem;font-weight:700;color:var(--c-accent);line-height:1;">
                        {{ $stats['total_laptop'] }}
                    </span>
                </div>
                <p style="font-size:0.8125rem;font-weight:600;color:var(--c-text);margin:0 0 6px;">Total Laptop</p>
                <div style="display:flex;gap:0.5rem;flex-wrap:wrap;">
                    <span
                        style="font-size:0.625rem;font-family:var(--font-mono);padding:2px 8px;border-radius:20px;background:var(--c-green-dim);color:var(--c-green);">
                        {{ $stats['laptop_baik'] }} Baik
                    </span>
                    <span
                        style="font-size:0.625rem;font-family:var(--font-mono);padding:2px 8px;border-radius:20px;background:var(--c-red-dim);color:var(--c-red);">
                        {{ $stats['laptop_rusak'] }} Rusak
                    </span>
                </div>
            </div>

            {{-- Tiket Menunggu --}}
            <div class="card" style="padding:1.5rem; animation-delay:0.07s;">
                <div
                    style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:1.25rem;">
                    <div
                        style="width:40px;height:40px;border-radius:var(--radius-md);background:var(--c-orange-dim);display:flex;align-items:center;justify-content:center;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--c-orange)"
                            stroke-width="2">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" y1="8" x2="12" y2="12" />
                            <line x1="12" y1="16" x2="12.01" y2="16" />
                        </svg>
                    </div>
                    <span
                        style="font-family:var(--font-mono);font-size:2rem;font-weight:700;color:var(--c-orange);line-height:1;">
                        {{ $stats['tiket_menunggu'] }}
                    </span>
                </div>
                <p style="font-size:0.8125rem;font-weight:600;color:var(--c-text);margin:0 0 6px;">Menunggu</p>
                <span style="font-size:0.6875rem;color:var(--c-text-dim);">
                    {{ $stats['tiket_diproses'] }} sedang diproses
                </span>
            </div>

            {{-- Selesai Bulan Ini --}}
            <div class="card" style="padding:1.5rem; animation-delay:0.14s;">
                <div
                    style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:1.25rem;">
                    <div
                        style="width:40px;height:40px;border-radius:var(--radius-md);background:var(--c-green-dim);display:flex;align-items:center;justify-content:center;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--c-green)"
                            stroke-width="2">
                            <polyline points="20 6 9 17 4 12" />
                        </svg>
                    </div>
                    <span
                        style="font-family:var(--font-mono);font-size:2rem;font-weight:700;color:var(--c-green);line-height:1;">
                        {{ $stats['tiket_selesai_bulan'] }}
                    </span>
                </div>
                <p style="font-size:0.8125rem;font-weight:600;color:var(--c-text);margin:0 0 6px;">Selesai Bulan Ini</p>
                <span style="font-size:0.6875rem;color:var(--c-text-dim);">
                    {{ now()->translatedFormat('F Y') }}
                </span>
            </div>

            {{-- Jadwal Upcoming --}}
            <div class="card" style="padding:1.5rem; animation-delay:0.21s;">
                <div
                    style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:1.25rem;">
                    <div
                        style="width:40px;height:40px;border-radius:var(--radius-md);background:rgba(167,139,250,.12);display:flex;align-items:center;justify-content:center;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--c-purple)"
                            stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" />
                            <line x1="16" y1="2" x2="16" y2="6" />
                            <line x1="8" y1="2" x2="8" y2="6" />
                            <line x1="3" y1="10" x2="21" y2="10" />
                        </svg>
                    </div>
                    <span
                        style="font-family:var(--font-mono);font-size:2rem;font-weight:700;color:var(--c-purple);line-height:1;">
                        {{ $stats['jadwal_upcoming'] }}
                    </span>
                </div>
                <p style="font-size:0.8125rem;font-weight:600;color:var(--c-text);margin:0 0 6px;">Jadwal Maintenance
                </p>
                <span style="font-size:0.6875rem;color:var(--c-text-dim);">Akan datang</span>
            </div>

        </div>

        {{-- ══════════ STATUS LAPTOP BAR ══════════ --}}
        @php
            $total = max($stats['total_laptop'], 1);
            $baikPct = round(($stats['laptop_baik'] / $total) * 100);
            $rusakPct = round(($stats['laptop_rusak'] / $total) * 100);
            $perbaikanPct = round(($stats['laptop_perbaikan'] / $total) * 100);
        @endphp
        <div class="card" style="padding:1.25rem 1.5rem; margin-bottom:1.5rem; animation-delay:0.28s;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:0.875rem;">
                <p
                    style="font-family:var(--font-mono);font-size:0.6875rem;color:var(--c-text-dim);letter-spacing:.08em;text-transform:uppercase;margin:0;">
                    Status Kondisi Laptop</p>
                <div style="display:flex;gap:1rem;">
                    <span style="font-size:0.6875rem;color:var(--c-green);display:flex;align-items:center;gap:4px;">
                        <span
                            style="width:8px;height:8px;border-radius:50%;background:var(--c-green);display:inline-block;"></span>
                        Baik {{ $baikPct }}%
                    </span>
                    <span style="font-size:0.6875rem;color:var(--c-orange);display:flex;align-items:center;gap:4px;">
                        <span
                            style="width:8px;height:8px;border-radius:50%;background:var(--c-orange);display:inline-block;"></span>
                        Perbaikan {{ $perbaikanPct }}%
                    </span>
                    <span style="font-size:0.6875rem;color:var(--c-red);display:flex;align-items:center;gap:4px;">
                        <span
                            style="width:8px;height:8px;border-radius:50%;background:var(--c-red);display:inline-block;"></span>
                        Rusak {{ $rusakPct }}%
                    </span>
                </div>
            </div>
            <div style="height:8px;border-radius:99px;overflow:hidden;background:var(--c-surface-3);display:flex;">
                <div style="width:{{ $baikPct }}%;background:var(--c-green);transition:width .6s ease;"></div>
                <div style="width:{{ $perbaikanPct }}%;background:var(--c-orange);transition:width .6s ease;"></div>
                <div style="width:{{ $rusakPct }}%;background:var(--c-red);transition:width .6s ease;"></div>
            </div>
        </div>

        {{-- ══════════ CHART + LAPORAN TERBARU ══════════ --}}
        <div style="display:grid;grid-template-columns:1fr 1.55fr;gap:1rem;margin-bottom:1.5rem;">

            {{-- Bar Chart Kerusakan --}}
            <div class="card" style="padding:1.5rem; animation-delay:0.35s;" x-data="{
                months: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'],
                data: {{ json_encode($chartData) }},
                get maxVal() { return Math.max(...this.data, 1) },
                pct(v) { return Math.round((v / this.maxVal) * 100) }
            }">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;">
                    <p
                        style="font-family:var(--font-mono);font-size:0.6875rem;color:var(--c-text-dim);letter-spacing:.08em;text-transform:uppercase;margin:0;">
                        Kerusakan Bulanan · {{ now()->year }}
                    </p>
                    <span style="font-family:var(--font-mono);font-size:0.6875rem;color:var(--c-accent);">
                        Total: <span x-text="data.reduce((a,b)=>a+b,0)"></span>
                    </span>
                </div>

                {{-- Bars --}}
                <div style="display:flex;align-items:flex-end;gap:5px;height:110px;">
                    <template x-for="(v,i) in data" :key="i">
                        <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:3px;">
                            <span
                                style="font-family:var(--font-mono);font-size:0.5rem;color:var(--c-text-muted);min-height:12px;"
                                x-text="v > 0 ? v : ''"></span>
                            <div x-tooltip="v"
                                :style="`
                                                                                                     height:${pct(v)}%;
                                                                                                     min-height:3px;
                                                                                                     width:100%;
                                                                                                     border-radius:3px 3px 0 0;
                                                                                                     background: ${i === {{ now()->month - 1 }} ? 'var(--c-accent)' : 'var(--c-surface-3)'};
                                                                                                     border: 1px solid ${i === {{ now()->month - 1 }} ? 'var(--c-accent)' : 'var(--c-border)'};
                                                                                                     opacity: ${v > 0 ? 1 : 0.4};
                                                                                                     transition: height .5s ease, background .2s;
                                                                                                     cursor:default;
                                                                                                 `"
                                @mouseenter="$el.style.background = 'var(--c-accent)'"
                                @mouseleave="$el.style.background = (i === {{ now()->month - 1 }}) ? 'var(--c-accent)' : 'var(--c-surface-3)'">
                            </div>
                        </div>
                    </template>
                </div>

                {{-- X Labels --}}
                <div style="display:flex;gap:5px;margin-top:5px;">
                    <template x-for="(m,i) in months" :key="i">
                        <div :style="`
                                                                            flex:1;
                                                                            text-align:center;
                                                                            font-family:var(--font-mono);
                                                                            font-size:0.5rem;
                                                                            color: ${i === {{ now()->month - 1 }} ? 'var(--c-accent)' : 'var(--c-text-muted)'};
                                                                        `"
                            x-text="m"></div>
                    </template>
                </div>
            </div>

            {{-- Laporan Terbaru --}}
            <div class="card" style="padding:1.5rem; animation-delay:0.42s;">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.25rem;">
                    <p
                        style="font-family:var(--font-mono);font-size:0.6875rem;color:var(--c-text-dim);letter-spacing:.08em;text-transform:uppercase;margin:0;">
                        Laporan Terbaru
                    </p>
                    <a href="{{ route('kepala.laporan') }}"
                        style="font-size:0.75rem;color:var(--c-accent);font-family:var(--font-mono);display:flex;align-items:center;gap:4px;">
                        Lihat semua
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <line x1="5" y1="12" x2="19" y2="12" />
                            <polyline points="12 5 19 12 12 19" />
                        </svg>
                    </a>
                </div>

                <div style="display:flex;flex-direction:column;gap:0.5rem;">
                    @forelse($laporanTerbaru as $lap)
                        @php
                            $sc = match ($lap->status_tiket) {
                                'Menunggu' => ['bg' => 'var(--c-orange-dim)', 'txt' => 'var(--c-orange)'],
                                'Diproses' => ['bg' => 'var(--c-accent-dim)', 'txt' => 'var(--c-accent)'],
                                'Selesai' => ['bg' => 'var(--c-green-dim)', 'txt' => 'var(--c-green)'],
                                default => ['bg' => 'var(--c-surface-3)', 'txt' => 'var(--c-text-dim)'],
                            };
                            $pc = match ($lap->prioritas) {
                                'Tinggi' => 'var(--c-red)',
                                'Sedang' => 'var(--c-orange)',
                                default => 'var(--c-text-muted)',
                            };
                        @endphp
                        <div style="display:flex;align-items:center;gap:0.75rem;padding:0.75rem;background:var(--c-surface-2);border-radius:var(--radius-md);border:1px solid var(--c-border);transition:border-color .15s;"
                            onmouseenter="this.style.borderColor='var(--c-border-bright)'"
                            onmouseleave="this.style.borderColor='var(--c-border)'">
                            {{-- Prioritas dot --}}
                            <div
                                style="width:6px;height:6px;border-radius:50%;background:{{ $pc }};flex-shrink:0;box-shadow:0 0 6px {{ $pc }};">
                            </div>

                            <div
                                style="width:34px;height:34px;border-radius:var(--radius-sm);background:var(--c-surface-3);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                    stroke="var(--c-text-muted)" stroke-width="2">
                                    <rect x="2" y="3" width="20" height="14" rx="2" />
                                    <line x1="8" y1="21" x2="16" y2="21" />
                                    <line x1="12" y1="17" x2="12" y2="21" />
                                </svg>
                            </div>

                            <div style="flex:1;min-width:0;">
                                <p
                                    style="font-size:0.8125rem;font-weight:600;color:var(--c-text);margin:0 0 2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                    {{ $lap->laptop?->kode_aset ?? '-' }}
                                    <span style="font-weight:400;color:var(--c-text-dim);">·
                                        {{ $lap->user?->nama_lengkap ?? '-' }}</span>
                                </p>
                                <p
                                    style="font-size:0.6875rem;color:var(--c-text-muted);margin:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                    {{ Str::limit($lap->keluhan_user, 55) }}
                                </p>
                            </div>

                            <div
                                style="display:flex;flex-direction:column;align-items:flex-end;gap:3px;flex-shrink:0;">
                                <span
                                    style="font-size:0.625rem;font-family:var(--font-mono);padding:2px 8px;border-radius:20px;background:{{ $sc['bg'] }};color:{{ $sc['txt'] }};">
                                    {{ $lap->status_tiket }}
                                </span>
                                <span
                                    style="font-size:0.5625rem;color:var(--c-text-muted);font-family:var(--font-mono);">
                                    {{ $lap->tgl_lapor->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div style="text-align:center;padding:2rem;color:var(--c-text-muted);">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1.5"
                                style="margin:0 auto 0.5rem;display:block;opacity:.4;">
                                <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" />
                                <polyline points="14 2 14 8 20 8" />
                            </svg>
                            <p style="font-size:0.8125rem;">Belum ada laporan</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- ══════════ JADWAL MAINTENANCE UPCOMING ══════════ --}}
        <div class="card" style="padding:1.5rem; animation-delay:0.49s;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.25rem;">
                <p
                    style="font-family:var(--font-mono);font-size:0.6875rem;color:var(--c-text-dim);letter-spacing:.08em;text-transform:uppercase;margin:0;">
                    Jadwal Maintenance Upcoming
                </p>
                <a href="{{ route('kepala.maintenance.index') }}"
                    style="font-size:0.75rem;color:var(--c-accent);font-family:var(--font-mono);display:flex;align-items:center;gap:4px;">
                    Kelola
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <line x1="5" y1="12" x2="19" y2="12" />
                        <polyline points="12 5 19 12 12 19" />
                    </svg>
                </a>
            </div>

            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:0.75rem;">
                @forelse($jadwalUpcoming as $j)
                    @php
                        $tc = match ($j->tipe_maintenance) {
                            'Rutin' => [
                                'border' => 'var(--c-accent)',
                                'bg' => 'var(--c-accent-dim)',
                                'txt' => 'var(--c-accent)',
                            ],
                            'Darurat' => [
                                'border' => 'var(--c-red)',
                                'bg' => 'var(--c-red-dim)',
                                'txt' => 'var(--c-red)',
                            ],
                            'Preventif' => [
                                'border' => 'var(--c-green)',
                                'bg' => 'var(--c-green-dim)',
                                'txt' => 'var(--c-green)',
                            ],
                            default => [
                                'border' => 'var(--c-border-bright)',
                                'bg' => 'var(--c-surface-3)',
                                'txt' => 'var(--c-text-dim)',
                            ],
                        };
                        $daysLeft = now()->diffInDays($j->tgl_jadwal_maintenance, false);
                    @endphp
                    <div style="padding:1rem;background:var(--c-surface-2);border:1px solid var(--c-border);border-left:3px solid {{ $tc['border'] }};border-radius:var(--radius-md);transition:transform .2s,border-color .2s;"
                        onmouseenter="this.style.transform='translateX(3px)';this.style.borderColor='var(--c-border-bright)'"
                        onmouseleave="this.style.transform='translateX(0)';this.style.borderColor='var(--c-border)'">
                        <div
                            style="display:flex;align-items:center;justify-content:space-between;margin-bottom:0.625rem;">
                            <span
                                style="font-size:0.625rem;font-family:var(--font-mono);padding:2px 8px;border-radius:20px;background:{{ $tc['bg'] }};color:{{ $tc['txt'] }};">
                                {{ $j->tipe_maintenance }}
                            </span>
                            <span
                                style="font-size:0.625rem;font-family:var(--font-mono);color:{{ $daysLeft <= 1 ? 'var(--c-red)' : ($daysLeft <= 3 ? 'var(--c-orange)' : 'var(--c-text-muted)') }};">
                                @if ($daysLeft === 0)
                                    Hari ini
                                @elseif($daysLeft === 1)
                                    Besok
                                @else
                                    {{ $daysLeft }}h lagi
                                @endif
                            </span>
                        </div>
                        <p
                            style="font-size:0.875rem;font-weight:600;color:var(--c-text);margin:0 0 2px;font-family:var(--font-mono);">
                            {{ $j->laptop?->kode_aset ?? '-' }}
                        </p>
                        <p style="font-size:0.75rem;color:var(--c-text-dim);margin:0 0 6px;">
                            {{ $j->laptop?->tipe_model ?? '' }}
                        </p>
                        <div style="display:flex;align-items:center;gap:5px;">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none"
                                stroke="var(--c-text-muted)" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                            <span style="font-size:0.6875rem;color:var(--c-text-muted);">
                                {{ $j->teknisi?->nama_lengkap ?? 'Belum ditugaskan' }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div style="grid-column:1/-1;text-align:center;padding:2rem;color:var(--c-text-muted);">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.5" style="margin:0 auto 0.5rem;display:block;opacity:.4;">
                            <rect x="3" y="4" width="18" height="18" rx="2" />
                            <line x1="16" y1="2" x2="16" y2="6" />
                            <line x1="8" y1="2" x2="8" y2="6" />
                            <line x1="3" y1="10" x2="21" y2="10" />
                        </svg>
                        <p style="font-size:0.8125rem;">Tidak ada jadwal mendatang</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>
