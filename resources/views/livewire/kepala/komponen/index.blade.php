<div class="home-section-inner py-8">

    {{-- Flash Messages --}}
    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            class="mb-6 flex items-center gap-3 px-4 py-3 rounded-lg border"
            style="background: var(--c-green-dim); border-color: var(--c-green); color: var(--c-green);">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                <polyline points="22 4 12 14.01 9 11.01" />
            </svg>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="mb-6 flex items-center gap-3 px-4 py-3 rounded-lg border"
            style="background: var(--c-red-dim); border-color: var(--c-red); color: var(--c-red);">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2">
                <circle cx="12" cy="12" r="10" />
                <line x1="15" y1="9" x2="9" y2="15" />
                <line x1="9" y1="9" x2="15" y2="15" />
            </svg>
            <span class="text-sm font-medium">{{ session('error') }}</span>
        </div>
    @endif

    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <p class="home-section-label">Master Data</p>
            <h1 class="home-section-title mb-1">Komponen Laptop</h1>
            <p class="text-sm" style="color: var(--c-text-dim);">Kelola data komponen yang digunakan dalam sistem</p>
        </div>
        <a href="{{ route('kepala.komponen.create') }}" wire:navigate
            class="home-btn home-btn--primary flex items-center gap-2">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2.5">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
            </svg>
            Tambah Komponen
        </a>
    </div>

    {{-- Search --}}
    <div class="mb-5">
        <div class="relative" style="max-width: 360px;">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" width="14" height="14"
                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                style="color: var(--c-text-muted);">
                <circle cx="11" cy="11" r="8" />
                <path d="m21 21-4.35-4.35" />
            </svg>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama komponen..."
                class="pl-9" style="max-width: 360px; background: var(--c-surface-2);">
        </div>
    </div>

    {{-- Table --}}
    <div class="card-transparent-border overflow-hidden" style="padding: 0;">
        <table class="w-full text-sm">
            <thead>
                <tr style="background: var(--c-surface-2); border-bottom: 1px solid var(--c-border);">
                    <th class="px-5 py-3 text-left font-medium" style="color: var(--c-text-dim);">
                        <button wire:click="sortBy('nama_komponen')"
                            class="flex items-center gap-1 hover:opacity-80 transition-opacity">
                            Nama Komponen
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2"
                                style="color: {{ $sortField === 'nama_komponen' ? 'var(--c-accent)' : 'var(--c-text-muted)' }}; transform: {{ $sortField === 'nama_komponen' && $sortDirection === 'desc' ? 'rotate(180deg)' : 'none' }}">
                                <path d="M12 5l7 7-7 7M5 12h14" transform="rotate(-90 12 12)" />
                            </svg>
                        </button>
                    </th>
                    <th class="px-5 py-3 text-left font-medium" style="color: var(--c-text-dim);">Kategori</th>
                    <th class="px-5 py-3 text-left font-medium" style="color: var(--c-text-dim);">Status Kritis</th>
                    <th class="px-5 py-3 text-left font-medium" style="color: var(--c-text-dim);">Deskripsi</th>
                    <th class="px-5 py-3 text-right font-medium" style="color: var(--c-text-dim);">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($komponens as $komponen)
                    <tr class="border-b transition-colors hover:bg-opacity-50" style="border-color: var(--c-border);"
                        x-data x-on:mouseenter="$el.style.background='var(--c-surface-2)'"
                        x-on:mouseleave="$el.style.background='transparent'">
                        <td class="px-5 py-4">
                            <span class="font-semibold" style="color: var(--c-text);">{{ $komponen->nama_komponen }}</span>
                        </td>
                        <td class="px-5 py-4">
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-medium"
                                style="background: var(--c-accent-dim); color: var(--c-accent); font-family: var(--font-mono);">
                                {{ $komponen->kategori }}
                            </span>
                        </td>
                        <td class="px-5 py-4">
                            @if($komponen->is_critical)
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-medium"
                                    style="background: var(--c-red-dim); color: var(--c-red);">
                                    Ya
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-medium"
                                    style="background: var(--c-surface-3); color: var(--c-text-dim);">
                                    Tidak
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-4 max-w-xs">
                            <span class="text-xs line-clamp-2" style="color: var(--c-text-dim);">
                                {{ $komponen->deskripsi ?? '—' }}
                            </span>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('kepala.komponen.edit', $komponen->id_komponen) }}" wire:navigate
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md text-xs font-medium transition-colors"
                                    style="background: var(--c-surface-3); color: var(--c-text-dim); border: 1px solid var(--c-border);"
                                    onmouseover="this.style.borderColor='var(--c-border-bright)'; this.style.color='var(--c-text)'"
                                    onmouseout="this.style.borderColor='var(--c-border)'; this.style.color='var(--c-text-dim)'">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                    </svg>
                                    Edit
                                </a>
                                <button wire:click="confirmDelete({{ $komponen->id_komponen }})"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md text-xs font-medium transition-colors"
                                    style="background: var(--c-red-dim); color: var(--c-red); border: 1px solid transparent;"
                                    onmouseover="this.style.borderColor='var(--c-red)'"
                                    onmouseout="this.style.borderColor='transparent'">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <polyline points="3 6 5 6 21 6" />
                                        <path d="M19 6l-1 14H6L5 6" />
                                        <path d="M10 11v6M14 11v6" />
                                        <path d="M9 6V4h6v2" />
                                    </svg>
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-5 py-16 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-12 h-12 rounded-xl flex items-center justify-center"
                                    style="background: var(--c-surface-2); color: var(--c-text-muted);">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="1.5">
                                        <circle cx="11" cy="11" r="8" />
                                        <path d="m21 21-4.35-4.35" />
                                    </svg>
                                </div>
                                <p class="font-medium" style="color: var(--c-text-dim);">
                                    {{ $search ? 'Tidak ada komponen yang cocok' : 'Belum ada data komponen' }}
                                </p>
                                @if (!$search)
                                    <a href="{{ route('kepala.komponen.create') }}" wire:navigate
                                        class="home-btn home-btn--primary text-sm">
                                        Tambah Komponen Pertama
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if ($komponens->hasPages())
            <div class="px-5 py-4 border-t" style="border-color: var(--c-border); background: var(--c-surface-2);">
                {{ $komponens->links() }}
            </div>
        @endif
    </div>

    {{-- Delete Confirm Modal --}}
    @if ($deletingId)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4"
            style="background: rgba(0,0,0,0.6); backdrop-filter: blur(4px);">
            <div class="card w-full max-w-sm" style="padding: 2rem; animation: fadeInUp 0.2s ease both;">
                <div class="flex items-center gap-3 mb-4">
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
                        <h3 class="font-semibold" style="color: var(--c-text);">Hapus Komponen</h3>
                        <p class="text-xs mt-0.5" style="color: var(--c-text-dim);">Tindakan ini tidak dapat dibatalkan</p>
                    </div>
                </div>
                <p class="text-sm mb-6" style="color: var(--c-text-dim);">
                    Apakah Anda yakin ingin menghapus komponen ini? Pastikan tidak ada riwayat perbaikan yang menggunakan komponen ini.
                </p>
                <div class="flex items-center gap-3 justify-end">
                    <button wire:click="cancelDelete"
                        class="px-4 py-2 rounded-lg text-sm font-medium transition-colors"
                        style="background: var(--c-surface-3); color: var(--c-text-dim); border: 1px solid var(--c-border);">
                        Batal
                    </button>
                    <button wire:click="delete" class="px-4 py-2 rounded-lg text-sm font-medium transition-colors"
                        style="background: var(--c-red-dim); color: var(--c-red); border: 1px solid var(--c-red);">
                        <span wire:loading.remove wire:target="delete">Ya, Hapus</span>
                        <span wire:loading wire:target="delete">Menghapus...</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>
