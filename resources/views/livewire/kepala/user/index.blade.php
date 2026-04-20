<div class="home-section-inner py-8">

    {{-- Flash Message --}}
    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            class="mb-6 flex items-center gap-3 px-4 py-3 rounded-lg border"
            style="background: var(--c-green-dim); border-color: rgba(45,212,160,0.3); color: var(--c-green);">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="20 6 9 13 4 8" />
                <polyline points="20 6 9 20 4 14" />
            </svg>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
    @endif

    {{-- Header --}}
    <div class="flex items-start justify-between mb-8 gap-4 flex-wrap">
        <div>
            <p class="home-section-label">Manajemen Akses</p>
            <h1 class="font-mono text-2xl font-bold" style="color: var(--c-text); letter-spacing: -0.02em;">
                Manajemen User
            </h1>
            <p class="text-sm mt-1" style="color: var(--c-text-dim);">Kelola akun pengguna, role, dan status akses
                sistem.</p>
        </div>
        <a href="{{ route('kepala.user.create') }}" wire:navigate class="button-v2 is-icon">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2.5">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
            </svg>
            Tambah User
        </a>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-8">
        <div class="card" style="padding: 1.25rem; animation-delay: 0s;">
            <p class="text-xs font-mono mb-1"
                style="color: var(--c-text-muted); letter-spacing: 0.06em; text-transform: uppercase;">Total User</p>
            <p class="text-2xl font-bold font-mono" style="color: var(--c-text);">{{ $stats['total'] }}</p>
        </div>
        <div class="card" style="padding: 1.25rem; animation-delay: 0.06s;">
            <p class="text-xs font-mono mb-1"
                style="color: var(--c-text-muted); letter-spacing: 0.06em; text-transform: uppercase;">Aktif</p>
            <p class="text-2xl font-bold font-mono" style="color: var(--c-green);">{{ $stats['active'] }}</p>
        </div>
        <div class="card" style="padding: 1.25rem; animation-delay: 0.12s;">
            <p class="text-xs font-mono mb-1"
                style="color: var(--c-text-muted); letter-spacing: 0.06em; text-transform: uppercase;">Teknisi</p>
            <p class="text-2xl font-bold font-mono" style="color: var(--c-accent);">{{ $stats['teknisi'] }}</p>
        </div>
        <div class="card" style="padding: 1.25rem; animation-delay: 0.18s;">
            <p class="text-xs font-mono mb-1"
                style="color: var(--c-text-muted); letter-spacing: 0.06em; text-transform: uppercase;">Kepala IT</p>
            <p class="text-2xl font-bold font-mono" style="color: var(--c-purple);">{{ $stats['kepala'] }}</p>
        </div>
    </div>

    {{-- Filter & Search --}}
    <div class="card mb-6" style="padding: 1.25rem;">
        <div class="flex flex-wrap gap-3 items-center">
            {{-- Search --}}
            <div class="relative flex-1 min-w-48">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" width="14" height="14"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    style="color: var(--c-text-muted);">
                    <circle cx="11" cy="11" r="8" />
                    <line x1="21" y1="21" x2="16.65" y2="16.65" />
                </svg>
                <input type="text" wire:model.live.debounce.300ms="search"
                    placeholder="Cari nama, username, email..."
                    style="padding-left: 2.25rem; background: var(--c-surface-2);">
            </div>

            {{-- Filter Role --}}
            <select wire:model.live="filterRole" style="width: auto; min-width: 140px; background: var(--c-surface-2);">
                <option value="">Semua Role</option>
                <option value="User">User</option>
                <option value="Teknisi">Teknisi</option>
                <option value="Kepala_IT">Kepala IT</option>
            </select>

            {{-- Filter Status --}}
            <select wire:model.live="filterStatus"
                style="width: auto; min-width: 140px; background: var(--c-surface-2);">
                <option value="">Semua Status</option>
                <option value="1">Aktif</option>
                <option value="0">Non-Aktif</option>
            </select>

            {{-- Clear --}}
            @if ($search || $filterRole || $filterStatus)
                <button wire:click="$set('search', ''); $set('filterRole', ''); $set('filterStatus', '')"
                    class="flex items-center gap-1.5 text-xs px-3 py-2 rounded-lg transition-colors"
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

    {{-- Table --}}
    <div class="card" style="padding: 0; overflow: hidden;">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr style="border-bottom: 1px solid var(--c-border); background: var(--c-surface-2);">
                        <th class="text-left px-5 py-3.5">
                            <button wire:click="sort('nama_lengkap')"
                                class="flex items-center gap-1.5 font-mono text-xs font-semibold tracking-wider uppercase transition-colors"
                                style="color: var(--c-text-muted);">
                                Nama
                                @if ($sortBy === 'nama_lengkap')
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2.5">
                                        @if ($sortDir === 'asc')
                                            <polyline points="18 15 12 9 6 15" />
                                        @else
                                            <polyline points="6 9 12 15 18 9" />
                                        @endif
                                    </svg>
                                @endif
                            </button>
                        </th>
                        <th class="text-left px-5 py-3.5">
                            <span class="font-mono text-xs font-semibold tracking-wider uppercase"
                                style="color: var(--c-text-muted);">Username</span>
                        </th>
                        <th class="text-left px-5 py-3.5 hidden md:table-cell">
                            <span class="font-mono text-xs font-semibold tracking-wider uppercase"
                                style="color: var(--c-text-muted);">Unit Kerja</span>
                        </th>
                        <th class="text-left px-5 py-3.5">
                            <span class="font-mono text-xs font-semibold tracking-wider uppercase"
                                style="color: var(--c-text-muted);">Role</span>
                        </th>
                        <th class="text-left px-5 py-3.5">
                            <span class="font-mono text-xs font-semibold tracking-wider uppercase"
                                style="color: var(--c-text-muted);">Status</span>
                        </th>
                        <th class="text-left px-5 py-3.5 hidden lg:table-cell">
                            <button wire:click="sort('created_at')"
                                class="flex items-center gap-1.5 font-mono text-xs font-semibold tracking-wider uppercase transition-colors"
                                style="color: var(--c-text-muted);">
                                Dibuat
                                @if ($sortBy === 'created_at')
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2.5">
                                        @if ($sortDir === 'asc')
                                            <polyline points="18 15 12 9 6 15" />
                                        @else
                                            <polyline points="6 9 12 15 18 9" />
                                        @endif
                                    </svg>
                                @endif
                            </button>
                        </th>
                        <th class="px-5 py-3.5"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr wire:key="user-{{ $user->id_user }}" class="transition-colors"
                            style="border-bottom: 1px solid var(--c-border);" x-data
                            x-on:mouseenter="$el.style.background='var(--c-surface-2)'"
                            x-on:mouseleave="$el.style.background=''">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    {{-- Avatar --}}
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center font-mono text-xs font-bold flex-shrink-0"
                                        style="background: var(--c-accent-dim); color: var(--c-accent); border: 1px solid rgba(79,142,247,0.2);">
                                        {{ strtoupper(substr($user->nama_lengkap, 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="font-medium text-sm" style="color: var(--c-text);">
                                            {{ $user->nama_lengkap }}</p>
                                        <p class="text-xs" style="color: var(--c-text-muted);">
                                            {{ $user->email ?? '—' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <span class="font-mono text-xs px-2 py-1 rounded"
                                    style="background: var(--c-surface-3); color: var(--c-text-dim);">{{ $user->username }}</span>
                            </td>
                            <td class="px-5 py-4 hidden md:table-cell">
                                <span class="text-sm"
                                    style="color: var(--c-text-dim);">{{ $user->unit_kerja ?? '—' }}</span>
                            </td>
                            <td class="px-5 py-4">
                                @php
                                    $roleConfig = match ($user->role) {
                                        'Kepala_IT' => [
                                            'label' => 'Kepala IT',
                                            'color' => 'var(--c-purple)',
                                            'bg' => 'rgba(167,139,250,0.12)',
                                        ],
                                        'Teknisi' => [
                                            'label' => 'Teknisi',
                                            'color' => 'var(--c-accent)',
                                            'bg' => 'var(--c-accent-dim)',
                                        ],
                                        default => [
                                            'label' => 'User',
                                            'color' => 'var(--c-text-dim)',
                                            'bg' => 'var(--c-surface-3)',
                                        ],
                                    };
                                @endphp
                                <span class="text-xs font-mono font-semibold px-2.5 py-1 rounded-full"
                                    style="background: {{ $roleConfig['bg'] }}; color: {{ $roleConfig['color'] }};">
                                    {{ $roleConfig['label'] }}
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                <button wire:click="toggleStatus({{ $user->id_user }})"
                                    @if ($user->id_user === auth()->id()) disabled @endif
                                    class="flex items-center gap-1.5 text-xs font-medium px-2.5 py-1 rounded-full transition-all"
                                    style="{{ $user->is_active ? 'background: var(--c-green-dim); color: var(--c-green);' : 'background: var(--c-surface-3); color: var(--c-text-muted);' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $user->is_active ? '' : 'opacity-40' }}"
                                        style="background: currentColor; {{ $user->is_active ? 'box-shadow: 0 0 5px currentColor;' : '' }}"></span>
                                    {{ $user->is_active ? 'Aktif' : 'Non-Aktif' }}
                                </button>
                            </td>
                            <td class="px-5 py-4 hidden lg:table-cell">
                                <span class="text-xs"
                                    style="color: var(--c-text-muted);">{{ $user->created_at->format('d M Y') }}</span>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-1.5 justify-end">
                                    <a href="{{ route('kepala.user.edit', $user->id_user) }}" wire:navigate
                                        class="flex items-center justify-center w-8 h-8 rounded-lg transition-all"
                                        style="color: var(--c-text-dim); background: var(--c-surface-3);"
                                        x-on:mouseenter="$el.style.background='var(--c-accent-dim)'; $el.style.color='var(--c-accent)'"
                                        x-on:mouseleave="$el.style.background='var(--c-surface-3)'; $el.style.color='var(--c-text-dim)'"
                                        title="Edit">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                        </svg>
                                    </a>
                                    @if ($user->id_user !== auth()->id())
                                        <button
                                            wire:click="confirmDelete({{ $user->id_user }}, '{{ $user->nama_lengkap }}')"
                                            class="flex items-center justify-center w-8 h-8 rounded-lg transition-all"
                                            style="color: var(--c-text-dim); background: var(--c-surface-3);"
                                            x-on:mouseenter="$el.style.background='var(--c-red-dim)'; $el.style.color='var(--c-red)'"
                                            x-on:mouseleave="$el.style.background='var(--c-surface-3)'; $el.style.color='var(--c-text-dim)'"
                                            title="Hapus">
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
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-16 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="1.5" style="color: var(--c-text-muted);">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                        <circle cx="9" cy="7" r="4" />
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75" />
                                    </svg>
                                    <p class="text-sm font-medium" style="color: var(--c-text-dim);">Tidak ada user
                                        ditemukan</p>
                                    <p class="text-xs" style="color: var(--c-text-muted);">Coba ubah filter atau kata
                                        kunci pencarian</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($users->hasPages())
            <div class="px-5 py-4" style="border-top: 1px solid var(--c-border);">
                {{ $users->links() }}
            </div>
        @endif
    </div>

    {{-- Delete Confirmation Modal --}}
    @if ($confirmDeleteId)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4" x-data
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100">
            {{-- Backdrop --}}
            <div class="absolute inset-0" style="background: rgba(0,0,0,0.7); backdrop-filter: blur(4px);"
                wire:click="cancelDelete"></div>

            {{-- Modal --}}
            <div class="relative w-full max-w-sm card-elevated rounded-xl p-6"
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
                        <h3 class="font-mono font-bold text-base mb-1" style="color: var(--c-text);">Hapus User</h3>
                        <p class="text-sm" style="color: var(--c-text-dim);">
                            Anda yakin ingin menghapus <span class="font-semibold"
                                style="color: var(--c-text);">{{ $confirmDeleteName }}</span>?
                            Tindakan ini tidak bisa dibatalkan.
                        </p>
                    </div>
                </div>
                <div class="flex gap-3 justify-end">
                    <button wire:click="cancelDelete" class="button-v2 variant-outline size-sm">
                        Batal
                    </button>
                    <button wire:click="deleteUser" class="button-v2 variant-danger size-sm">
                        Hapus
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>
