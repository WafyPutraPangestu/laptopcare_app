<nav class="ap-navbar" role="navigation" aria-label="Main navigation">
    <div class="ap-navbar__inner">

        {{-- Logo / Brand --}}
        <a href="/" wire:navigate class="ap-navbar__brand" wire:navigate>
            <div class="ap-navbar__logo-mark">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <rect x="1" y="1" width="8" height="8" rx="1" fill="currentColor" opacity="0.9" />
                    <rect x="11" y="1" width="8" height="8" rx="1" fill="currentColor"
                        opacity="0.4" />
                    <rect x="1" y="11" width="8" height="8" rx="1" fill="currentColor"
                        opacity="0.4" />
                    <rect x="11" y="11" width="8" height="8" rx="1" fill="currentColor"
                        opacity="0.9" />
                </svg>
            </div>
            <div class="ap-navbar__brand-text">
                <span class="ap-navbar__brand-name">LaptopCare</span>
                <span class="ap-navbar__brand-sub">Angkasa Pura</span>
            </div>
        </a>

        {{-- Center Nav Links --}}
        <div class="ap-navbar__links">
            @auth
                @if (auth()->user()->role === 'Kepala_IT')
                    <a href="{{ route('kepala.dashboard') }}"
                        class="ap-nav-link {{ request()->routeIs('kepala.dashboard') ? 'is-active' : '' }}" wire:navigate>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <rect x="3" y="3" width="7" height="7" />
                            <rect x="14" y="3" width="7" height="7" />
                            <rect x="3" y="14" width="7" height="7" />
                            <rect x="14" y="14" width="7" height="7" />
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('kepala.user.index') }}"
                        class="ap-nav-link {{ request()->routeIs('kepala.user.*') ? 'is-active' : '' }}" wire:navigate>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75" />
                        </svg>
                        Users
                    </a>
                    <a href="{{ route('kepala.merek.index') }}"
                        class="ap-nav-link {{ request()->routeIs('kepala.merek.*') ? 'is-active' : '' }}" wire:navigate>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z" />
                            <line x1="7" y1="7" x2="7.01" y2="7" />
                        </svg>
                        Merek
                    </a>
                    <a href="{{ route('kepala.komponen.index') }}"
                        class="ap-nav-link {{ request()->routeIs('kepala.komponen.*') ? 'is-active' : '' }}" wire:navigate>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <rect x="2" y="2" width="20" height="8" rx="2" ry="2" />
                            <rect x="2" y="14" width="20" height="8" rx="2" ry="2" />
                            <line x1="6" y1="6" x2="6.01" y2="6" />
                            <line x1="6" y1="18" x2="6.01" y2="18" />
                        </svg>
                        Komponen
                    </a>
                    <a href="{{ route('kepala.laptop.index') }}"
                        class="ap-nav-link {{ request()->routeIs('kepala.laptop.index*') ? 'is-active' : '' }}"
                        wire:navigate>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <rect x="2" y="3" width="20" height="14" rx="2" />
                            <path d="M8 21h8M12 17v4" />
                        </svg>
                        Aset Laptop
                    </a>
                    <a href="{{ route('kepala.laporan') }}"
                        class="ap-nav-link {{ request()->routeIs('kepala.laporan*') ? 'is-active' : '' }}" wire:navigate>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <polyline points="14 2 14 8 20 8" />
                            <line x1="16" y1="13" x2="8" y2="13" />
                            <line x1="16" y1="17" x2="8" y2="17" />
                            <polyline points="10 9 9 9 8 9" />
                        </svg>
                        Laporan
                    </a>
                    <a href="{{ route('kepala.maintenance.index') }}"
                        class="ap-nav-link {{ request()->routeIs('kepala.maintenance.index*') ? 'is-active' : '' }}"
                        wire:navigate>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path
                                d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z" />
                        </svg>
                        Maintenance
                    </a>
                @elseif(auth()->user()->role === 'Teknisi')
                    <a href="{{ route('teknisi.tiket.index') }}"
                        class="ap-nav-link {{ request()->routeIs('teknisi.tiket.index*') ? 'is-active' : '' }}"
                        wire:navigate>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <polyline points="14 2 14 8 20 8" />
                        </svg>
                        Tiket Masuk
                    </a>
                    <a href="{{ route('teknisi.jadwal.index') }}"
                        class="ap-nav-link {{ request()->routeIs('teknisi.jadwal.index*') ? 'is-active' : '' }}"
                        wire:navigate>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                            <line x1="16" y1="2" x2="16" y2="6" />
                            <line x1="8" y1="2" x2="8" y2="6" />
                            <line x1="3" y1="10" x2="21" y2="10" />
                        </svg>
                        Jadwal Saya
                    </a>
                @else
                    {{-- User biasa --}}
                    <a href="{{ route('user.dashboard') }}"
                        class="ap-nav-link {{ request()->routeIs('kepala.dashboard') ? 'is-active' : '' }}" wire:navigate>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <rect x="3" y="3" width="7" height="7" />
                            <rect x="14" y="3" width="7" height="7" />
                            <rect x="3" y="14" width="7" height="7" />
                            <rect x="14" y="14" width="7" height="7" />
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('user.lapor.create') }}"
                        class="ap-nav-link {{ request()->routeIs('user.lapor.create') ? 'is-active' : '' }}"
                        wire:navigate>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" y1="8" x2="12" y2="16" />
                            <line x1="8" y1="12" x2="16" y2="12" />
                        </svg>
                        Lapor Kerusakan
                    </a>
                    <a href="{{ route('user.lapor.index') }}"
                        class="ap-nav-link {{ request()->routeIs('user.lapor.index') ? 'is-active' : '' }}" wire:navigate>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <polyline points="14 2 14 8 20 8" />
                        </svg>
                        Laporan Saya
                    </a>
                @endif
            @endauth
        </div>

        {{-- Right Side --}}
        <div class="ap-navbar__right">
            @auth
                {{-- Status badge --}}
                <div class="ap-status-pill">
                    <span class="ap-status-dot"></span>
                    <span>{{ auth()->user()->role === 'Kepala_IT' ? 'Admin' : auth()->user()->role }}</span>
                </div>

                {{-- User dropdown --}}
                <div class="ap-user-menu" x-data="{ open: false }" @click.outside="open = false">
                    <button class="ap-user-btn" @click="open = !open" :aria-expanded="open">
                        <div class="ap-user-avatar">
                            {{ strtoupper(substr(auth()->user()->nama_lengkap ?? auth()->user()->username, 0, 1)) }}
                        </div>
                        <div class="ap-user-info">
                            <span
                                class="ap-user-name">{{ auth()->user()->nama_lengkap ?? auth()->user()->username }}</span>
                            <span class="ap-user-unit">{{ auth()->user()->unit_kerja ?? '—' }}</span>
                        </div>
                        <svg class="ap-user-chevron" :class="{ 'rotated': open }" width="12" height="12"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <polyline points="6 9 12 15 18 9" />
                        </svg>
                    </button>

                    <div class="ap-dropdown" x-show="open" x-transition:enter="ap-dropdown-enter"
                        x-transition:enter-start="ap-dropdown-enter-start" x-transition:enter-end="ap-dropdown-enter-end"
                        x-transition:leave="ap-dropdown-leave" x-transition:leave-start="ap-dropdown-leave-end"
                        x-transition:leave-end="ap-dropdown-leave-start" style="display:none;">
                        <div class="ap-dropdown__header">
                            <p class="ap-dropdown__name">{{ auth()->user()->nama_lengkap ?? auth()->user()->username }}
                            </p>
                            <p class="ap-dropdown__email">{{ auth()->user()->email ?? 'Tidak ada email' }}</p>
                        </div>
                        <div class="ap-dropdown__items">
                            <a href="#" class="ap-dropdown__item" wire:navigate>
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                    <circle cx="12" cy="7" r="4" />
                                </svg>
                                Profil Saya
                            </a>
                        </div>
                        <div class="ap-dropdown__divider"></div>
                        <form wire:submit.prevent="logout">

                            <button type="submit" class="ap-dropdown__item ap-dropdown__item--danger">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                    <polyline points="16 17 21 12 16 7" />
                                    <line x1="21" y1="12" x2="9" y2="12" />
                                </svg>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" wire:navigate class="ap-btn-login">
                    Masuk
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5">
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                        <polyline points="10 17 15 12 10 7" />
                        <line x1="15" y1="12" x2="3" y2="12" />
                    </svg>
                </a>
            @endauth

            {{-- Mobile toggle --}}
            <button class="ap-mobile-toggle" x-data @click="$dispatch('toggle-mobile-nav')" aria-label="Toggle menu">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>

    {{-- Mobile Nav --}}
    <div class="ap-mobile-nav" x-data="{ open: false }" @toggle-mobile-nav.window="open = !open"
        :class="{ 'is-open': open }">
        @auth
            <a href="#" class="ap-mobile-link">Dashboard</a>
            <a href="#" class="ap-mobile-link">Aset Laptop</a>
            <a href="#" class="ap-mobile-link">Laporan</a>
            <a href="#" class="ap-mobile-link">Maintenance</a>
        @endauth
    </div>
</nav>
