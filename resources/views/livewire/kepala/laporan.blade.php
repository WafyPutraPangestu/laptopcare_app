<div>
    <div class="max-w-[1400px] mx-auto px-6 py-8">

        {{-- Header --}}
        <div class="flex items-start justify-between mb-8 gap-4 flex-wrap">
            <div>
                <p class="font-mono text-xs tracking-widest uppercase mb-2" style="color:var(--c-accent)">Kepala IT</p>
                <h1 class="font-mono text-2xl font-bold tracking-tight" style="color:var(--c-text)">Laporan & Analitik
                </h1>
                <p class="text-sm mt-1" style="color:var(--c-text-dim)">Data operasional untuk pengambilan keputusan
                    strategis</p>
            </div>
            <div class="flex items-center gap-3">
                <select wire:model.live="tahun" class="px-3 py-2 rounded-lg text-sm font-mono border"
                    style="background:var(--c-surface);border-color:var(--c-border);color:var(--c-text);min-width:100px">
                    @foreach ($tahunOptions as $t)
                        <option value="{{ $t }}">{{ $t }}</option>
                    @endforeach
                </select>
                <div wire:loading class="text-xs font-mono" style="color:var(--c-text-dim)">
                    <svg class="animate-spin inline w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M21 12a9 9 0 00-9-9" opacity=".4" />
                        <path d="M21 12a9 9 0 11-18 0" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Summary Stats --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3 mb-8">
            @foreach ([['label' => 'Total Biaya', 'value' => 'Rp ' . number_format($stats['total_biaya_tahun'], 0, ',', '.'), 'color' => 'var(--c-accent)', 'dim' => 'var(--c-accent-dim)'], ['label' => 'Total Kasus', 'value' => $stats['total_kasus'] . ' kasus', 'color' => 'var(--c-text)', 'dim' => 'var(--c-surface-2)'], ['label' => 'Rata Durasi', 'value' => $stats['rata_durasi'] . ' hari', 'color' => 'var(--c-orange)', 'dim' => 'var(--c-orange-dim)'], ['label' => 'Recurring Rate', 'value' => $stats['recurring_rate'] . '%', 'color' => 'var(--c-red)', 'dim' => 'var(--c-red-dim)'], ['label' => 'Perlu Diganti', 'value' => $stats['laptop_perlu_ganti'] . ' unit', 'color' => 'var(--c-red)', 'dim' => 'var(--c-red-dim)'], ['label' => 'Perlu Evaluasi', 'value' => $stats['laptop_evaluasi'] . ' unit', 'color' => 'var(--c-orange)', 'dim' => 'var(--c-orange-dim)']] as $s)
                <div class="rounded-xl border p-4" style="background:var(--c-surface);border-color:var(--c-border)">
                    <p class="font-mono text-xs mb-2 leading-snug" style="color:var(--c-text-dim)">{{ $s['label'] }}
                    </p>
                    <p class="font-mono text-base font-bold leading-tight" style="color:{{ $s['color'] }}">
                        {{ $s['value'] }}</p>
                </div>
            @endforeach
        </div>

        {{-- Tabs --}}
        <div class="flex gap-1 mb-6 p-1 rounded-xl border w-fit"
            style="background:var(--c-surface);border-color:var(--c-border)">
            @foreach ([['key' => 'komponen', 'label' => 'Komponen Rusak'], ['key' => 'teknisi', 'label' => 'Ranking Teknisi'], ['key' => 'lifecycle', 'label' => 'Lifecycle Laptop'], ['key' => 'cost', 'label' => 'Cost Analysis']] as $tab)
                <button wire:click="$set('activeTab','{{ $tab['key'] }}')"
                    class="px-4 py-2 rounded-lg text-xs font-mono font-semibold transition-all"
                    style="{{ $activeTab === $tab['key']
                        ? 'background:var(--c-accent-dim);color:var(--c-accent);'
                        : 'color:var(--c-text-dim);' }}">
                    {{ $tab['label'] }}
                </button>
            @endforeach
        </div>

        {{-- ══ TAB: KOMPONEN RUSAK ══ --}}
        @if ($activeTab === 'komponen')
            <div class="rounded-xl border overflow-hidden" style="border-color:var(--c-border)">
                <div class="px-6 py-4 border-b flex items-center justify-between"
                    style="background:var(--c-surface);border-color:var(--c-border)">
                    <div>
                        <p class="font-mono text-sm font-bold" style="color:var(--c-text)">Komponen Paling Sering Rusak
                        </p>
                        <p class="text-xs mt-0.5" style="color:var(--c-text-dim)">Top 10 komponen berdasarkan frekuensi
                            kerusakan tahun {{ $tahun }}</p>
                    </div>
                </div>

                {{-- Bar chart visual --}}
                @php $maxTotal = $komponenRusak->max('total') ?: 1; @endphp
                <div class="p-6 space-y-4" style="background:var(--c-surface)">
                    @forelse($komponenRusak as $i => $k)
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <div class="flex items-center gap-2">
                                    <span class="font-mono text-xs w-5 text-right"
                                        style="color:var(--c-text-muted)">{{ $i + 1 }}</span>
                                    <span class="text-sm font-medium"
                                        style="color:var(--c-text)">{{ $k->komponen_rusak }}</span>
                                    <span class="text-xs px-2 py-0.5 rounded font-mono"
                                        style="background:{{ $k->kategori_rusak === 'Hardware' ? 'var(--c-accent-dim)' : ($k->kategori_rusak === 'Software' ? 'var(--c-green-dim)' : 'var(--c-orange-dim)') }};
                                         color:{{ $k->kategori_rusak === 'Hardware' ? 'var(--c-accent)' : ($k->kategori_rusak === 'Software' ? 'var(--c-green)' : 'var(--c-orange)') }}">
                                        {{ $k->kategori_rusak }}
                                    </span>
                                    @if ($k->recurring > 0)
                                        <span class="text-xs px-2 py-0.5 rounded font-mono"
                                            style="background:var(--c-red-dim);color:var(--c-red)">
                                            {{ $k->recurring }}x berulang
                                        </span>
                                    @endif
                                </div>
                                <div class="flex items-center gap-4 text-xs font-mono">
                                    <span
                                        style="color:var(--c-text-dim)">{{ number_format($k->total_biaya, 0, ',', '.') }}
                                        IDR</span>
                                    <span style="color:var(--c-text-dim)">~{{ round($k->rata_durasi, 1) }} hari</span>
                                    <span class="font-bold" style="color:var(--c-text)">{{ $k->total }}x</span>
                                </div>
                            </div>
                            <div class="h-2 rounded-full overflow-hidden" style="background:var(--c-border)">
                                <div class="h-2 rounded-full transition-all"
                                    style="width:{{ round(($k->total / $maxTotal) * 100) }}%;
                                    background:{{ $i === 0 ? 'var(--c-red)' : ($i <= 2 ? 'var(--c-orange)' : 'var(--c-accent)') }}">
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-center py-8" style="color:var(--c-text-muted)">Belum ada data perbaikan
                            untuk tahun {{ $tahun }}.</p>
                    @endforelse
                </div>

                {{-- Rekomendasi --}}
                @if ($komponenRusak->isNotEmpty())
                    <div class="px-6 py-4 border-t" style="background:var(--c-surface-2);border-color:var(--c-border)">
                        <p class="font-mono text-xs uppercase tracking-widest mb-3" style="color:var(--c-text-dim)">
                            Rekomendasi Strategis</p>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                            @php
                                $top1 = $komponenRusak->first();
                                $highRecurring = $komponenRusak->where('recurring', '>', 2)->first();
                                $mostExpensive = $komponenRusak->sortByDesc('total_biaya')->first();
                            @endphp
                            @if ($top1)
                                <div class="rounded-lg p-3 border"
                                    style="background:var(--c-red-dim);border-color:var(--c-red)">
                                    <p class="font-mono text-xs font-bold mb-1" style="color:var(--c-red)">⚠ Frekuensi
                                        Tertinggi</p>
                                    <p class="text-xs" style="color:var(--c-text-dim)">
                                        <strong style="color:var(--c-text)">{{ $top1->komponen_rusak }}</strong> rusak
                                        {{ $top1->total }}x.
                                        Pertimbangkan stok spare part atau maintenance preventif rutin.
                                    </p>
                                </div>
                            @endif
                            @if ($highRecurring)
                                <div class="rounded-lg p-3 border"
                                    style="background:var(--c-orange-dim);border-color:var(--c-orange)">
                                    <p class="font-mono text-xs font-bold mb-1" style="color:var(--c-orange)">🔄
                                        Recurring Issue</p>
                                    <p class="text-xs" style="color:var(--c-text-dim)">
                                        <strong
                                            style="color:var(--c-text)">{{ $highRecurring->komponen_rusak }}</strong>
                                        berulang {{ $highRecurring->recurring }}x.
                                        Indikasi root cause belum terselesaikan, perlu audit mendalam.
                                    </p>
                                </div>
                            @endif
                            @if ($mostExpensive)
                                <div class="rounded-lg p-3 border"
                                    style="background:var(--c-accent-dim);border-color:var(--c-accent)">
                                    <p class="font-mono text-xs font-bold mb-1" style="color:var(--c-accent)">💰 Biaya
                                        Tertinggi</p>
                                    <p class="text-xs" style="color:var(--c-text-dim)">
                                        <strong
                                            style="color:var(--c-text)">{{ $mostExpensive->komponen_rusak }}</strong>
                                        menyerap
                                        Rp {{ number_format($mostExpensive->total_biaya, 0, ',', '.') }}.
                                        Evaluasi kontrak vendor atau penggantian massal.
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        @endif

        {{-- ══ TAB: RANKING TEKNISI ══ --}}
        @if ($activeTab === 'teknisi')
            <div class="rounded-xl border overflow-hidden" style="border-color:var(--c-border)">
                <div class="px-6 py-4 border-b" style="background:var(--c-surface);border-color:var(--c-border)">
                    <p class="font-mono text-sm font-bold" style="color:var(--c-text)">Ranking Performa Teknisi</p>
                    <p class="text-xs mt-0.5" style="color:var(--c-text-dim)">Skor = 40% kecepatan + 60% kualitas
                        (recurring rate). Tahun {{ $tahun }}</p>
                </div>
                <div style="background:var(--c-surface)">
                    @forelse($rankingTeknisi as $i => $t)
                        @php
                            $medal = match ($i) {
                                0 => '🥇',
                                1 => '🥈',
                                2 => '🥉',
                                default => '#' . ($i + 1),
                            };
                            $skorColor =
                                $t->skor >= 80
                                    ? 'var(--c-green)'
                                    : ($t->skor >= 60
                                        ? 'var(--c-orange)'
                                        : 'var(--c-red)');
                            $skorBg =
                                $t->skor >= 80
                                    ? 'var(--c-green-dim)'
                                    : ($t->skor >= 60
                                        ? 'var(--c-orange-dim)'
                                        : 'var(--c-red-dim)');
                        @endphp
                        <div class="flex items-center gap-4 px-6 py-4 border-b transition-colors"
                            style="border-color:var(--c-border)"
                            onmouseover="this.style.background='var(--c-surface-2)'"
                            onmouseout="this.style.background='transparent'">

                            {{-- Rank --}}
                            <div class="w-8 text-center font-mono text-sm flex-shrink-0">
                                @if ($i < 3)
                                    <span>{{ $medal }}</span>
                                @else
                                    <span style="color:var(--c-text-muted)">#{{ $i + 1 }}</span>
                                @endif
                            </div>

                            {{-- Avatar + Name --}}
                            <div class="flex items-center gap-3 flex-1 min-w-0">
                                <div class="w-9 h-9 rounded-lg flex items-center justify-center text-xs font-bold font-mono flex-shrink-0"
                                    style="background:var(--c-accent-dim);color:var(--c-accent)">
                                    {{ strtoupper(substr($t->nama_lengkap, 0, 2)) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold truncate" style="color:var(--c-text)">
                                        {{ $t->nama_lengkap }}</p>
                                    <p class="text-xs font-mono mt-0.5" style="color:var(--c-text-dim)">
                                        {{ $t->kasus_sulit }} kasus sulit</p>
                                </div>
                            </div>

                            {{-- Stats --}}
                            <div class="hidden md:grid grid-cols-3 gap-6 text-center">
                                <div>
                                    <p class="font-mono text-base font-bold" style="color:var(--c-text)">
                                        {{ $t->total_perbaikan }}</p>
                                    <p class="font-mono text-xs mt-0.5" style="color:var(--c-text-dim)">Perbaikan</p>
                                </div>
                                <div>
                                    <p class="font-mono text-base font-bold" style="color:var(--c-text)">
                                        {{ round($t->rata_durasi, 1) }}</p>
                                    <p class="font-mono text-xs mt-0.5" style="color:var(--c-text-dim)">Rata Hari</p>
                                </div>
                                <div>
                                    <p class="font-mono text-base font-bold" style="color:var(--c-red)">
                                        {{ $t->total_recurring }}</p>
                                    <p class="font-mono text-xs mt-0.5" style="color:var(--c-text-dim)">Recurring</p>
                                </div>
                            </div>

                            {{-- Skor --}}
                            <div class="flex-shrink-0 text-right">
                                <div class="inline-flex flex-col items-center px-4 py-2 rounded-xl"
                                    style="background:{{ $skorBg }}">
                                    <span class="font-mono text-xl font-bold"
                                        style="color:{{ $skorColor }}">{{ $t->skor }}</span>
                                    <span class="font-mono text-xs" style="color:{{ $skorColor }}">skor</span>
                                </div>
                            </div>

                            {{-- Progress bar skor --}}
                        </div>
                    @empty
                        <p class="text-sm text-center py-8" style="color:var(--c-text-muted)">Belum ada data teknisi
                            untuk tahun {{ $tahun }}.</p>
                    @endforelse
                </div>

                {{-- Legend --}}
                <div class="px-6 py-3 border-t flex items-center gap-6"
                    style="background:var(--c-surface-2);border-color:var(--c-border)">
                    <span class="font-mono text-xs" style="color:var(--c-text-muted)">Skala skor:</span>
                    <span class="font-mono text-xs px-2 py-0.5 rounded"
                        style="background:var(--c-green-dim);color:var(--c-green)">80–100 Baik</span>
                    <span class="font-mono text-xs px-2 py-0.5 rounded"
                        style="background:var(--c-orange-dim);color:var(--c-orange)">60–79 Cukup</span>
                    <span class="font-mono text-xs px-2 py-0.5 rounded"
                        style="background:var(--c-red-dim);color:var(--c-red)">&lt;60 Perlu Perhatian</span>
                </div>
            </div>
        @endif

        {{-- ══ TAB: LIFECYCLE LAPTOP ══ --}}
        @if ($activeTab === 'lifecycle')
            <div class="rounded-xl border overflow-hidden" style="border-color:var(--c-border)">
                <div class="px-6 py-4 border-b" style="background:var(--c-surface);border-color:var(--c-border)">
                    <p class="font-mono text-sm font-bold" style="color:var(--c-text)">Lifecycle Analysis — Ganti vs
                        Pertahankan</p>
                    <p class="text-xs mt-0.5" style="color:var(--c-text-dim)">Rekomendasi berdasarkan usia, biaya
                        perbaikan kumulatif, dan nilai aset</p>
                </div>
                <table class="w-full text-sm" style="background:var(--c-surface)">
                    <thead>
                        <tr style="background:var(--c-surface-2);border-bottom:1px solid var(--c-border)">
                            @foreach (['Kode Aset', 'Merek / Model', 'Usia', 'Nilai Aset', 'Biaya Perbaikan', 'Rasio', 'Kerusakan', 'Rekomendasi'] as $h)
                                <th class="text-left px-4 py-3 font-mono text-xs tracking-wider uppercase"
                                    style="color:var(--c-text-dim)">{{ $h }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lifecycleLaptop as $l)
                            @php
                                $rc = match ($l->rekomendasi_color) {
                                    'red' => ['bg' => 'var(--c-red-dim)', 'color' => 'var(--c-red)'],
                                    'orange' => ['bg' => 'var(--c-orange-dim)', 'color' => 'var(--c-orange)'],
                                    default => ['bg' => 'var(--c-green-dim)', 'color' => 'var(--c-green)'],
                                };
                            @endphp
                            <tr class="border-t transition-colors" style="border-color:var(--c-border)"
                                onmouseover="this.style.background='var(--c-surface-2)'"
                                onmouseout="this.style.background='transparent'">
                                <td class="px-4 py-3">
                                    <span class="font-mono text-xs px-2 py-1 rounded"
                                        style="background:var(--c-accent-dim);color:var(--c-accent)">
                                        {{ $l->kode_aset }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <p class="font-medium text-sm" style="color:var(--c-text)">
                                        {{ $l->merek->nama_merek ?? '—' }}</p>
                                    <p class="text-xs mt-0.5" style="color:var(--c-text-dim)">{{ $l->tipe_model }}
                                    </p>
                                </td>
                                <td class="px-4 py-3 font-mono text-sm"
                                    style="color:{{ (int) $l->usia_tahun >= ($l->merek->rata_usia_optimal ?? 5) ? 'var(--c-red)' : 'var(--c-text)' }}">
                                    {{ $l->usia_tahun }} thn
                                </td>
                                <td class="px-4 py-3 font-mono text-xs" style="color:var(--c-text-dim)">
                                    {{ $l->nilai_aset ? 'Rp ' . number_format($l->nilai_aset, 0, ',', '.') : '—' }}
                                </td>
                                <td class="px-4 py-3 font-mono text-xs" style="color:var(--c-text)">
                                    Rp {{ number_format($l->total_biaya_perbaikan, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <div class="w-16 h-1.5 rounded-full overflow-hidden"
                                            style="background:var(--c-border)">
                                            <div class="h-1.5 rounded-full"
                                                style="width:{{ min($l->rasio_biaya, 100) }}%;background:{{ $l->rasio_biaya > 50 ? 'var(--c-red)' : ($l->rasio_biaya > 30 ? 'var(--c-orange)' : 'var(--c-green)') }}">
                                            </div>
                                        </div>
                                        <span class="font-mono text-xs"
                                            style="color:var(--c-text-dim)">{{ $l->rasio_biaya }}%</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 font-mono text-sm text-center" style="color:var(--c-text)">
                                    {{ $l->laporan_kerusakan_count }}x
                                </td>
                                <td class="px-4 py-3">
                                    <span class="text-xs font-mono font-semibold px-3 py-1 rounded-full"
                                        style="background:{{ $rc['bg'] }};color:{{ $rc['color'] }}">
                                        {{ $l->rekomendasi }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-12 text-center text-sm"
                                    style="color:var(--c-text-muted)">Belum ada data laptop.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Legend lifecycle --}}
                <div class="px-6 py-3 border-t flex flex-wrap items-center gap-6"
                    style="background:var(--c-surface-2);border-color:var(--c-border)">
                    <span class="font-mono text-xs" style="color:var(--c-text-muted)">Logika rekomendasi:</span>
                    <span class="text-xs" style="color:var(--c-green)">✓ <strong>Pertahankan</strong> — usia &lt;
                        optimal &amp; biaya &lt;30% nilai aset</span>
                    <span class="text-xs" style="color:var(--c-orange)">⚠ <strong>Evaluasi</strong> — mendekati batas
                        usia atau biaya 30–50%</span>
                    <span class="text-xs" style="color:var(--c-red)">✕ <strong>Ganti</strong> — melewati usia optimal
                        &amp; biaya &gt;50% nilai aset</span>
                </div>
            </div>
        @endif

        {{-- ══ TAB: COST ANALYSIS ══ --}}
        @if ($activeTab === 'cost')
            <div class="space-y-6">

                {{-- Chart biaya per bulan --}}
                <div class="rounded-xl border overflow-hidden" style="border-color:var(--c-border)">
                    <div class="px-6 py-4 border-b" style="background:var(--c-surface);border-color:var(--c-border)">
                        <p class="font-mono text-sm font-bold" style="color:var(--c-text)">Biaya Perbaikan per Bulan —
                            {{ $tahun }}</p>
                        <p class="text-xs mt-0.5" style="color:var(--c-text-dim)">Total pengeluaran maintenance
                            bulanan</p>
                    </div>
                    <div class="p-6" style="background:var(--c-surface)">
                        @php $maxBiaya = $chartData->max('total_biaya') ?: 1; @endphp
                        <div class="flex items-end gap-2 h-48">
                            @foreach ($chartData as $d)
                                @php
                                    $pct = $maxBiaya > 0 ? round(($d['total_biaya'] / $maxBiaya) * 100) : 0;
                                    $barColor =
                                        $d['total_biaya'] === $chartData->max('total_biaya')
                                            ? 'var(--c-red)'
                                            : ($d['total_biaya'] > $chartData->avg('total_biaya') * 1.2
                                                ? 'var(--c-orange)'
                                                : 'var(--c-accent)');
                                @endphp
                                <div class="flex-1 flex flex-col items-center gap-1 group" x-data>
                                    {{-- Tooltip on hover --}}
                                    <div class="text-center mb-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <p class="font-mono text-xs" style="color:var(--c-text)">Rp
                                            {{ number_format($d['total_biaya'], 0, ',', '.') }}</p>
                                        <p class="font-mono text-xs" style="color:var(--c-text-dim)">
                                            {{ $d['total_kasus'] }} kasus</p>
                                    </div>
                                    <div class="w-full rounded-t-md transition-all"
                                        style="height:{{ max($pct, $d['total_biaya'] > 0 ? 4 : 0) }}%;
                                        background:{{ $barColor }};
                                        opacity:0.85;
                                        min-height:{{ $d['total_biaya'] > 0 ? '4px' : '0' }}">
                                    </div>
                                    <span class="font-mono text-xs mt-1"
                                        style="color:var(--c-text-dim)">{{ $d['bulan'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Detail table --}}
                <div class="rounded-xl border overflow-hidden" style="border-color:var(--c-border)">
                    <div class="px-6 py-4 border-b" style="background:var(--c-surface);border-color:var(--c-border)">
                        <p class="font-mono text-sm font-bold" style="color:var(--c-text)">Detail Biaya per Bulan</p>
                    </div>
                    <table class="w-full text-sm" style="background:var(--c-surface)">
                        <thead>
                            <tr style="background:var(--c-surface-2);border-bottom:1px solid var(--c-border)">
                                <th class="text-left px-6 py-3 font-mono text-xs tracking-wider uppercase"
                                    style="color:var(--c-text-dim)">Bulan</th>
                                <th class="text-left px-6 py-3 font-mono text-xs tracking-wider uppercase"
                                    style="color:var(--c-text-dim)">Total Kasus</th>
                                <th class="text-left px-6 py-3 font-mono text-xs tracking-wider uppercase"
                                    style="color:var(--c-text-dim)">Total Biaya</th>
                                <th class="text-left px-6 py-3 font-mono text-xs tracking-wider uppercase"
                                    style="color:var(--c-text-dim)">Rata / Kasus</th>
                                <th class="text-left px-6 py-3 font-mono text-xs tracking-wider uppercase"
                                    style="color:var(--c-text-dim)">Proporsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $totalAll = $chartData->sum('total_biaya') ?: 1; @endphp
                            @foreach ($chartData as $d)
                                <tr class="border-t transition-colors" style="border-color:var(--c-border)"
                                    onmouseover="this.style.background='var(--c-surface-2)'"
                                    onmouseout="this.style.background='transparent'">
                                    <td class="px-6 py-3 font-mono text-sm" style="color:var(--c-text)">
                                        {{ $d['bulan'] }}</td>
                                    <td class="px-6 py-3 font-mono text-sm" style="color:var(--c-text)">
                                        {{ $d['total_kasus'] }}</td>
                                    <td class="px-6 py-3 font-mono text-sm font-semibold"
                                        style="color:{{ $d['total_biaya'] > 0 ? 'var(--c-text)' : 'var(--c-text-muted)' }}">
                                        {{ $d['total_biaya'] > 0 ? 'Rp ' . number_format($d['total_biaya'], 0, ',', '.') : '—' }}
                                    </td>
                                    <td class="px-6 py-3 font-mono text-xs" style="color:var(--c-text-dim)">
                                        {{ $d['total_kasus'] > 0 ? 'Rp ' . number_format($d['total_biaya'] / $d['total_kasus'], 0, ',', '.') : '—' }}
                                    </td>
                                    <td class="px-6 py-3">
                                        @php $pct = round(($d['total_biaya'] / $totalAll) * 100, 1); @endphp
                                        <div class="flex items-center gap-2">
                                            <div class="w-20 h-1.5 rounded-full overflow-hidden"
                                                style="background:var(--c-border)">
                                                <div class="h-1.5 rounded-full"
                                                    style="width:{{ $pct }}%;background:var(--c-accent)">
                                                </div>
                                            </div>
                                            <span class="font-mono text-xs"
                                                style="color:var(--c-text-dim)">{{ $pct }}%</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            {{-- Total row --}}
                            <tr class="border-t"
                                style="border-color:var(--c-border-bright);background:var(--c-surface-2)">
                                <td class="px-6 py-3 font-mono text-xs font-bold" style="color:var(--c-text)">TOTAL
                                    {{ $tahun }}</td>
                                <td class="px-6 py-3 font-mono text-sm font-bold" style="color:var(--c-text)">
                                    {{ $chartData->sum('total_kasus') }}</td>
                                <td class="px-6 py-3 font-mono text-sm font-bold" style="color:var(--c-accent)">Rp
                                    {{ number_format($chartData->sum('total_biaya'), 0, ',', '.') }}</td>
                                <td class="px-6 py-3 font-mono text-xs" style="color:var(--c-text-dim)">
                                    {{ $chartData->sum('total_kasus') > 0
                                        ? 'Rp ' . number_format($chartData->sum('total_biaya') / $chartData->sum('total_kasus'), 0, ',', '.')
                                        : '—' }}
                                </td>
                                <td class="px-6 py-3 font-mono text-xs font-bold" style="color:var(--c-text)">100%
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

    </div>
</div>
