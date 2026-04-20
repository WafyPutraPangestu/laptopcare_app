<div>
    {{-- Flash Message --}}
    @if ($flashMessage)
        <div x-data="{ show: true }" x-init="setTimeout(() => { show = false;
            $wire.clearFlash(); }, 4000)" x-show="show" x-transition
            class="fixed top-[70px] right-4 z-50 flex items-center gap-3 px-4 py-3 rounded-lg border text-sm font-mono"
            style="background: {{ $flashType === 'success' ? 'var(--c-green-dim)' : 'var(--c-red-dim)' }}; border-color: {{ $flashType === 'success' ? 'var(--c-green)' : 'var(--c-red)' }}; color: {{ $flashType === 'success' ? 'var(--c-green)' : 'var(--c-red)' }};">
            <span>{{ $flashType === 'success' ? '✓' : '✕' }}</span>
            <span>{{ $flashMessage }}</span>
            <button wire:click="clearFlash" class="ml-2 opacity-60 hover:opacity-100">✕</button>
        </div>
    @endif

    {{-- Session Flash --}}
    @if (session('flash_message'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" x-transition
            class="fixed top-[70px] right-4 z-50 flex items-center gap-3 px-4 py-3 rounded-lg border text-sm font-mono"
            style="background: {{ session('flash_type') === 'success' ? 'var(--c-green-dim)' : 'var(--c-red-dim)' }}; border-color: {{ session('flash_type') === 'success' ? 'var(--c-green)' : 'var(--c-red)' }}; color: {{ session('flash_type') === 'success' ? 'var(--c-green)' : 'var(--c-red)' }};">
            <span>{{ session('flash_type') === 'success' ? '✓' : '✕' }}</span>
            <span>{{ session('flash_message') }}</span>
        </div>
    @endif

    <div class="max-w-[1400px] mx-auto px-6 py-8">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-8">
            <div>
                <p class="font-mono text-xs tracking-widest uppercase mb-2" style="color: var(--c-accent);">Manajemen
                    Aset</p>
                <h1 class="font-mono text-2xl font-bold tracking-tight" style="color: var(--c-text);">Laptop Inventory
                </h1>
            </div>
            <a href="{{ route('kepala.laptop.create') }}" wire:navigate
                class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold transition-all"
                style="background: var(--c-accent); color: #fff; box-shadow: 0 0 20px rgba(79,142,247,0.25);"
                onmouseover="this.style.background='#6ba3f9';this.style.transform='translateY(-1px)'"
                onmouseout="this.style.background='var(--c-accent)';this.style.transform='translateY(0)'">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2.5">
                    <path d="M12 5v14M5 12h14" />
                </svg>
                Tambah Laptop
            </a>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-4 gap-4 mb-8">
            @foreach ([['label' => 'Total Laptop', 'value' => $stats['total'], 'color' => 'var(--c-accent)', 'dim' => 'var(--c-accent-dim)'], ['label' => 'Kondisi Baik', 'value' => $stats['baik'], 'color' => 'var(--c-green)', 'dim' => 'var(--c-green-dim)'], ['label' => 'Rusak', 'value' => $stats['rusak'], 'color' => 'var(--c-red)', 'dim' => 'var(--c-red-dim)'], ['label' => 'Dalam Perbaikan', 'value' => $stats['perbaikan'], 'color' => 'var(--c-orange)', 'dim' => 'var(--c-orange-dim)']] as $stat)
                <div class="rounded-xl p-4 border" style="background: var(--c-surface); border-color: var(--c-border);">
                    <p class="text-xs font-mono mb-2" style="color: var(--c-text-dim);">{{ $stat['label'] }}</p>
                    <p class="font-mono text-2xl font-bold" style="color: {{ $stat['color'] }};">{{ $stat['value'] }}
                    </p>
                    <div class="h-1 rounded-full mt-3" style="background: {{ $stat['dim'] }};">
                        <div class="h-1 rounded-full"
                            style="background: {{ $stat['color'] }}; width: {{ $stats['total'] > 0 ? round(($stat['value'] / $stats['total']) * 100) : 0 }}%;">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Filters --}}
        <div class="flex items-center gap-3 mb-6 flex-wrap">
            {{-- Search --}}
            <div class="relative flex-1 min-w-[220px]">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 opacity-40" width="14" height="14"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8" />
                    <path d="M21 21l-4.35-4.35" />
                </svg>
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari kode, model, user..."
                    class="w-full pl-9 pr-4 py-2 rounded-lg text-sm border font-mono"
                    style="background: var(--c-surface); border-color: var(--c-border); color: var(--c-text);">
            </div>

            {{-- Status Filter --}}
            <select wire:model.live="filterStatus" class="px-3 py-2 rounded-lg text-sm border font-mono"
                style="background: var(--c-surface); border-color: var(--c-border); color: var(--c-text);">
                <option value="">Semua Status</option>
                <option value="Baik">Baik</option>
                <option value="Rusak">Rusak</option>
                <option value="Dalam Perbaikan">Dalam Perbaikan</option>
            </select>

            {{-- Merek Filter --}}
            <select wire:model.live="filterMerek" class="px-3 py-2 rounded-lg text-sm border font-mono"
                style="background: var(--c-surface); border-color: var(--c-border); color: var(--c-text);">
                <option value="">Semua Merek</option>
                @foreach ($mereks as $m)
                    <option value="{{ $m->id_merek }}">{{ $m->nama_merek }}</option>
                @endforeach
            </select>

            {{-- Loading indicator --}}
            <div wire:loading class="text-xs font-mono" style="color: var(--c-text-dim);">
                <svg class="animate-spin inline w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" opacity=".3" />
                    <path d="M21 12a9 9 0 00-9-9" />
                </svg>
                Memuat...
            </div>
        </div>

        {{-- Table --}}
        <div class="rounded-xl border overflow-hidden" style="border-color: var(--c-border);">
            <table class="w-full text-sm">
                <thead>
                    <tr style="background: var(--c-surface-2); border-bottom: 1px solid var(--c-border);">
                        @foreach ([['kode_aset', 'Kode Aset'], ['tipe_model', 'Model'], ['status_kondisi', 'Status'], ['tgl_pengadaan', 'Tgl Pengadaan']] as [$col, $label])
                            <th class="text-left px-4 py-3">
                                <button wire:click="sortBy('{{ $col }}')"
                                    class="flex items-center gap-1 font-mono text-xs tracking-wider uppercase transition-colors"
                                    style="color: {{ $sortBy === $col ? 'var(--c-accent)' : 'var(--c-text-dim)' }};">
                                    {{ $label }}
                                    @if ($sortBy === $col)
                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2.5">
                                            @if ($sortDir === 'asc')
                                                <path d="M18 15l-6-6-6 6" />
                                            @else
                                                <path d="M6 9l6 6 6-6" />
                                            @endif
                                        </svg>
                                    @endif
                                </button>
                            </th>
                        @endforeach
                        <th class="text-left px-4 py-3 font-mono text-xs tracking-wider uppercase"
                            style="color: var(--c-text-dim);">User</th>
                        <th class="text-left px-4 py-3 font-mono text-xs tracking-wider uppercase"
                            style="color: var(--c-text-dim);">Merek</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laptops as $laptop)
                        <tr class="border-t transition-colors" style="border-color: var(--c-border);"
                            onmouseover="this.style.background='var(--c-surface)'"
                            onmouseout="this.style.background='transparent'">
                            <td class="px-4 py-3">
                                <span class="font-mono text-xs px-2 py-1 rounded"
                                    style="background: var(--c-accent-dim); color: var(--c-accent);">
                                    {{ $laptop->kode_aset }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <p class="font-medium text-sm" style="color: var(--c-text);">
                                    {{ $laptop->tipe_model }}</p>
                                @if ($laptop->nomor_seri)
                                    <p class="font-mono text-xs mt-0.5" style="color: var(--c-text-dim);">
                                        {{ $laptop->nomor_seri }}</p>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @php
                                    $statusMap = [
                                        'Baik' => ['bg' => 'var(--c-green-dim)', 'color' => 'var(--c-green)'],
                                        'Rusak' => ['bg' => 'var(--c-red-dim)', 'color' => 'var(--c-red)'],
                                        'Dalam Perbaikan' => [
                                            'bg' => 'var(--c-orange-dim)',
                                            'color' => 'var(--c-orange)',
                                        ],
                                    ];
                                    $s = $statusMap[$laptop->status_kondisi] ?? [
                                        'bg' => 'var(--c-surface)',
                                        'color' => 'var(--c-text-dim)',
                                    ];
                                @endphp
                                <span class="text-xs font-mono px-2 py-1 rounded-full"
                                    style="background: {{ $s['bg'] }}; color: {{ $s['color'] }};">
                                    {{ $laptop->status_kondisi }}
                                </span>
                            </td>
                            <td class="px-4 py-3 font-mono text-xs" style="color: var(--c-text-dim);">
                                {{ $laptop->tgl_pengadaan->format('d M Y') }}
                            </td>
                            <td class="px-4 py-3">
                                @if ($laptop->user)
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-md flex items-center justify-center text-xs font-bold font-mono"
                                            style="background: var(--c-accent-dim); color: var(--c-accent);">
                                            {{ strtoupper(substr($laptop->user->nama_lengkap, 0, 2)) }}
                                        </div>
                                        <span class="text-xs"
                                            style="color: var(--c-text);">{{ $laptop->user->nama_lengkap }}</span>
                                    </div>
                                @else
                                    <span class="text-xs" style="color: var(--c-text-muted);">— Tidak ada</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-xs font-mono" style="color: var(--c-text-dim);">
                                {{ $laptop->merek->nama_merek ?? '—' }}
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2 justify-end">
                                    <a href="{{ route('kepala.laptop.edit', $laptop->id_laptop) }}" wire:navigate
                                        class="px-3 py-1.5 rounded-lg text-xs font-mono border transition-colors"
                                        style="background: var(--c-surface-2); border-color: var(--c-border-bright); color: var(--c-text-dim);"
                                        onmouseover="this.style.color='var(--c-text)'"
                                        onmouseout="this.style.color='var(--c-text-dim)'">
                                        Edit
                                    </a>
                                    <button
                                        wire:click="confirmDelete({{ $laptop->id_laptop }}, '{{ $laptop->kode_aset }}')"
                                        class="px-3 py-1.5 rounded-lg text-xs font-mono border transition-colors"
                                        style="background: var(--c-red-dim); border-color: var(--c-red); color: var(--c-red);">
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-16 text-center">
                                <p class="font-mono text-sm" style="color: var(--c-text-muted);">Tidak ada data laptop
                                    ditemukan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $laptops->links() }}
        </div>
    </div>

    {{-- Delete Confirm Modal --}}
    @if ($confirmDeleteId)
        <div class="fixed inset-0 z-50 flex items-center justify-center" style="background: rgba(0,0,0,0.6);">
            <div class="rounded-xl border p-6 w-full max-w-sm mx-4"
                style="background: var(--c-surface-2); border-color: var(--c-border-bright);">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center"
                        style="background: var(--c-red-dim);">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--c-red)"
                            stroke-width="2">
                            <path
                                d="M12 9v4M12 17h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-mono font-bold text-sm" style="color: var(--c-text);">Hapus Laptop</p>
                        <p class="text-xs mt-0.5" style="color: var(--c-text-dim);">Tindakan ini tidak dapat
                            dibatalkan</p>
                    </div>
                </div>
                <p class="text-sm mb-6" style="color: var(--c-text-dim);">
                    Yakin ingin menghapus laptop
                    <span class="font-mono px-1.5 py-0.5 rounded text-xs"
                        style="background: var(--c-red-dim); color: var(--c-red);">{{ $confirmDeleteKode }}</span>?
                </p>
                <div class="flex gap-3">
                    <button wire:click="cancelDelete"
                        class="flex-1 py-2 rounded-lg text-sm font-mono border transition-colors"
                        style="background: var(--c-surface); border-color: var(--c-border); color: var(--c-text-dim);">
                        Batal
                    </button>
                    <button wire:click="deleteLaptop"
                        class="flex-1 py-2 rounded-lg text-sm font-mono font-semibold transition-colors"
                        style="background: var(--c-red); color: #fff;">
                        Ya, Hapus
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
