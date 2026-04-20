<div class="home-section-inner py-8">

    {{-- Header --}}
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('kepala.user.index') }}" wire:navigate
            class="flex items-center justify-center w-9 h-9 rounded-lg transition-all"
            style="background: var(--c-surface-2); border: 1px solid var(--c-border); color: var(--c-text-dim);" x-data
            x-on:mouseenter="$el.style.borderColor='var(--c-border-bright)'; $el.style.color='var(--c-text)'"
            x-on:mouseleave="$el.style.borderColor='var(--c-border)'; $el.style.color='var(--c-text-dim)'">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="15 18 9 12 15 6" />
            </svg>
        </a>
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg flex items-center justify-center font-mono text-sm font-bold"
                style="background: var(--c-accent-dim); color: var(--c-accent); border: 1px solid rgba(79,142,247,0.2);">
                {{ strtoupper(substr($user->nama_lengkap, 0, 2)) }}
            </div>
            <div>
                <p class="home-section-label" style="margin-bottom: 0.25rem;">Edit User</p>
                <h1 class="font-mono text-2xl font-bold" style="color: var(--c-text); letter-spacing: -0.02em;">
                    {{ $user->nama_lengkap }}
                </h1>
            </div>
        </div>
    </div>

    <div class="max-w-2xl">
        <div class="card">

            {{-- Section: Info Pribadi --}}
            <div class="mb-7">
                <p class="font-mono text-xs font-semibold tracking-widest uppercase mb-4"
                    style="color: var(--c-accent); border-bottom: 1px solid var(--c-border); padding-bottom: 0.75rem;">
                    Informasi Pribadi
                </p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold mb-1.5 font-mono" style="color: var(--c-text-dim);">
                            Nama Lengkap <span style="color: var(--c-red);">*</span>
                        </label>
                        <input type="text" wire:model="nama_lengkap" placeholder="Masukkan nama lengkap">
                        @error('nama_lengkap')
                            <p class="text-xs mt-1.5" style="color: var(--c-red);">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold mb-1.5 font-mono" style="color: var(--c-text-dim);">
                            Username <span style="color: var(--c-red);">*</span>
                        </label>
                        <input type="text" wire:model="username" placeholder="username">
                        @error('username')
                            <p class="text-xs mt-1.5" style="color: var(--c-red);">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold mb-1.5 font-mono"
                            style="color: var(--c-text-dim);">Email</label>
                        <input type="email" wire:model="email" placeholder="email@domain.com">
                        @error('email')
                            <p class="text-xs mt-1.5" style="color: var(--c-red);">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold mb-1.5 font-mono"
                            style="color: var(--c-text-dim);">Unit Kerja</label>
                        <input type="text" wire:model="unit_kerja" placeholder="Contoh: IT, Finance, Operasional...">
                        @error('unit_kerja')
                            <p class="text-xs mt-1.5" style="color: var(--c-red);">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Section: Akses & Role --}}
            <div class="mb-7">
                <p class="font-mono text-xs font-semibold tracking-widest uppercase mb-4"
                    style="color: var(--c-accent); border-bottom: 1px solid var(--c-border); padding-bottom: 0.75rem;">
                    Akses & Role
                </p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold mb-1.5 font-mono" style="color: var(--c-text-dim);">
                            Role <span style="color: var(--c-red);">*</span>
                        </label>
                        <select wire:model="role" @if ($user->id_user === auth()->id()) disabled @endif>
                            <option value="User">User (Karyawan)</option>
                            <option value="Teknisi">Teknisi</option>
                            <option value="Kepala_IT">Kepala IT</option>
                        </select>
                        @if ($user->id_user === auth()->id())
                            <p class="text-xs mt-1.5" style="color: var(--c-text-muted);">Tidak dapat mengubah role
                                sendiri.</p>
                        @endif
                        @error('role')
                            <p class="text-xs mt-1.5" style="color: var(--c-red);">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col justify-end pb-0.5">
                        <label class="block text-xs font-semibold mb-1.5 font-mono"
                            style="color: var(--c-text-dim);">Status Akun</label>
                        <label class="flex items-center gap-3 cursor-pointer select-none" x-data="{ checked: @entangle('is_active') }">
                            <div class="relative">
                                <input type="checkbox" wire:model="is_active" class="sr-only"
                                    @if ($user->id_user === auth()->id()) disabled @endif>
                                <div class="w-10 h-6 rounded-full transition-colors duration-200"
                                    :style="checked ? 'background: var(--c-green);' :
                                        'background: var(--c-surface-3); border: 1px solid var(--c-border);'">
                                </div>
                                <div class="absolute top-1 left-1 w-4 h-4 rounded-full transition-transform duration-200"
                                    style="background: white;"
                                    :style="checked ? 'transform: translateX(16px)' : 'transform: translateX(0)'">
                                </div>
                            </div>
                            <span class="text-sm font-medium" style="color: var(--c-text-dim);"
                                x-text="checked ? 'Aktif' : 'Non-Aktif'"></span>
                        </label>
                    </div>
                </div>
            </div>

            {{-- Section: Password --}}
            <div class="mb-7" x-data="{ change: @entangle('changePassword') }">
                <div class="flex items-center justify-between mb-4"
                    style="border-bottom: 1px solid var(--c-border); padding-bottom: 0.75rem;">
                    <p class="font-mono text-xs font-semibold tracking-widest uppercase"
                        style="color: var(--c-accent);">
                        Password
                    </p>
                    <label class="flex items-center gap-2 cursor-pointer select-none">
                        <input type="checkbox" wire:model.live="changePassword" class="sr-only">
                        <div class="relative">
                            <div class="w-8 h-5 rounded-full transition-colors duration-200"
                                :style="change ? 'background: var(--c-accent);' :
                                    'background: var(--c-surface-3); border: 1px solid var(--c-border);'">
                            </div>
                            <div class="absolute top-0.5 left-0.5 w-4 h-4 rounded-full transition-transform duration-200"
                                style="background: white;"
                                :style="change ? 'transform: translateX(12px)' : 'transform: translateX(0)'">
                            </div>
                        </div>
                        <span class="text-xs font-medium" style="color: var(--c-text-dim);">Ganti Password</span>
                    </label>
                </div>

                <div x-show="change" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold mb-1.5 font-mono"
                                style="color: var(--c-text-dim);">
                                Password Baru <span style="color: var(--c-red);">*</span>
                            </label>
                            <div class="relative" x-data="{ show: false }">
                                <input x-bind:type="show ? 'text' : 'password'" wire:model="password"
                                    placeholder="Min. 8 karakter" style="padding-right: 2.75rem;">
                                <button type="button" x-on:click="show = !show"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 transition-colors"
                                    style="color: var(--c-text-muted);"
                                    x-on:mouseenter="$el.style.color='var(--c-text-dim)'"
                                    x-on:mouseleave="$el.style.color='var(--c-text-muted)'">
                                    <svg x-show="!show" width="15" height="15" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                    <svg x-show="show" width="15" height="15" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2">
                                        <path
                                            d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94" />
                                        <path
                                            d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19" />
                                        <line x1="1" y1="1" x2="23" y2="23" />
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <p class="text-xs mt-1.5" style="color: var(--c-red);">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold mb-1.5 font-mono"
                                style="color: var(--c-text-dim);">
                                Konfirmasi Password <span style="color: var(--c-red);">*</span>
                            </label>
                            <div class="relative" x-data="{ show: false }">
                                <input x-bind:type="show ? 'text' : 'password'" wire:model="password_confirmation"
                                    placeholder="Ulangi password baru" style="padding-right: 2.75rem;">
                                <button type="button" x-on:click="show = !show"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 transition-colors"
                                    style="color: var(--c-text-muted);"
                                    x-on:mouseenter="$el.style.color='var(--c-text-dim)'"
                                    x-on:mouseleave="$el.style.color='var(--c-text-muted)'">
                                    <svg x-show="!show" width="15" height="15" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                    <svg x-show="show" width="15" height="15" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2">
                                        <path
                                            d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94" />
                                        <path
                                            d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19" />
                                        <line x1="1" y1="1" x2="23" y2="23" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div x-show="!change" class="flex items-center gap-2 px-3 py-2.5 rounded-lg"
                    style="background: var(--c-surface-3); border: 1px solid var(--c-border);">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" style="color: var(--c-text-muted); flex-shrink: 0;">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                    </svg>
                    <span class="text-xs" style="color: var(--c-text-muted);">Password tidak akan diubah.</span>
                </div>
            </div>

            {{-- Meta info --}}
            <div class="flex gap-6 mb-6 pb-6" style="border-bottom: 1px solid var(--c-border);">
                <div>
                    <p class="text-xs font-mono mb-1" style="color: var(--c-text-muted);">Dibuat</p>
                    <p class="text-xs" style="color: var(--c-text-dim);">{{ $user->created_at->format('d M Y, H:i') }}
                    </p>
                </div>
                <div>
                    <p class="text-xs font-mono mb-1" style="color: var(--c-text-muted);">Diperbarui</p>
                    <p class="text-xs" style="color: var(--c-text-dim);">
                        {{ $user->updated_at->format('d M Y, H:i') }}</p>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('kepala.user.index') }}" wire:navigate class="button-v2 variant-outline">
                    Batal
                </a>
                <button wire:click="save" wire:loading.attr="disabled" class="button-v2 is-icon">
                    <span wire:loading.remove wire:target="save">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                            <polyline points="17 21 17 13 7 13 7 21" />
                            <polyline points="7 3 7 8 15 8" />
                        </svg>
                    </span>
                    <span wire:loading wire:target="save">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" style="animation: spin 0.8s linear infinite;">
                            <path d="M21 12a9 9 0 1 1-6.219-8.56" />
                        </svg>
                    </span>
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </div>

</div>
