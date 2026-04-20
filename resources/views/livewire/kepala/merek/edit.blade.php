<div class="home-section-inner py-8" style="max-width: 760px;">

    {{-- Header --}}
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('kepala.merek.index') }}" wire:navigate
            class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0 transition-colors"
            style="background: var(--c-surface-2); color: var(--c-text-dim); border: 1px solid var(--c-border);"
            onmouseover="this.style.borderColor='var(--c-border-bright)'; this.style.color='var(--c-text)'"
            onmouseout="this.style.borderColor='var(--c-border)'; this.style.color='var(--c-text-dim)'">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 12H5M12 19l-7-7 7-7" />
            </svg>
        </a>
        <div>
            <p class="home-section-label">Master Data / Merek</p>
            <h1 class="home-section-title mb-0">Edit Merek</h1>
        </div>
        {{-- Badge info --}}
        <div class="ml-auto flex items-center gap-2 px-3 py-1.5 rounded-lg"
            style="background: var(--c-surface-2); border: 1px solid var(--c-border);">
            <div class="w-7 h-7 rounded flex items-center justify-center"
                style="background: var(--c-accent-dim); color: var(--c-accent); font-family: var(--font-mono); font-size: 0.5625rem; font-weight: 700;">
                {{ strtoupper(substr($merek->nama_merek, 0, 2)) }}
            </div>
            <span class="text-xs font-medium" style="color: var(--c-text-dim);">
                {{ $merek->laptops()->count() }} laptop terdaftar
            </span>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="card" style="padding: 2rem;">
        <form wire:submit="update" class="flex flex-col gap-6">

            {{-- Nama Merek --}}
            <div class="flex flex-col gap-1.5">
                <label class="text-sm font-medium" style="color: var(--c-text);">
                    Nama Merek <span style="color: var(--c-red);">*</span>
                </label>
                <input type="text" wire:model="nama_merek" placeholder="Contoh: Dell, HP, Lenovo, ASUS..."
                    class="{{ $errors->has('nama_merek') ? 'border-red-500' : '' }}">
                @error('nama_merek')
                    <p class="text-xs flex items-center gap-1" style="color: var(--c-red);">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" y1="8" x2="12" y2="12" />
                            <line x1="12" y1="16" x2="12.01" y2="16" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Row: Tahun Rilis & Rata Usia --}}
            <div class="grid grid-cols-2 gap-5">
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-medium" style="color: var(--c-text);">Tahun Rilis</label>
                    <input type="number" wire:model="tahun_rilis" placeholder="{{ date('Y') }}" min="1990"
                        max="{{ date('Y') }}">
                    @error('tahun_rilis')
                        <p class="text-xs" style="color: var(--c-red);">{{ $message }}</p>
                    @enderror
                    <p class="text-xs" style="color: var(--c-text-muted);">Opsional — tahun pertama rilis seri ini</p>
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-medium" style="color: var(--c-text);">
                        Rata Usia Optimal <span style="color: var(--c-red);">*</span>
                        <span class="font-normal text-xs ml-1" style="color: var(--c-text-muted)">(tahun)</span>
                    </label>
                    <input type="number" wire:model="rata_usia_optimal" min="1" max="20" placeholder="5">
                    @error('rata_usia_optimal')
                        <p class="text-xs" style="color: var(--c-red);">{{ $message }}</p>
                    @enderror
                    <p class="text-xs" style="color: var(--c-text-muted);">Digunakan untuk analisis lifecycle laptop</p>
                </div>
            </div>

            {{-- Spesifikasi --}}
            <div class="flex flex-col gap-1.5">
                <label class="text-sm font-medium" style="color: var(--c-text);">Spesifikasi Umum</label>
                <textarea wire:model="spesifikasi" rows="4" placeholder="Deskripsi spesifikasi umum merek ini..."
                    style="resize: vertical;"></textarea>
                @error('spesifikasi')
                    <p class="text-xs" style="color: var(--c-red);">{{ $message }}</p>
                @enderror
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3 pt-2" style="border-top: 1px solid var(--c-border);">
                <button type="submit" class="home-btn home-btn--primary flex items-center gap-2">
                    <span wire:loading.remove wire:target="update" class="flex items-center gap-2">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                            <polyline points="17 21 17 13 7 13 7 21" />
                            <polyline points="7 3 7 8 15 8" />
                        </svg>
                        Perbarui Merek
                    </span>
                    <span wire:loading wire:target="update" class="flex items-center gap-2">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" style="animation: spin 1s linear infinite;">
                            <path d="M21 12a9 9 0 1 1-6.219-8.56" />
                        </svg>
                        Memperbarui...
                    </span>
                </button>
                <a href="{{ route('kepala.merek.index') }}" wire:navigate class="home-btn home-btn--secondary">
                    Batal
                </a>
            </div>

        </form>
    </div>

    {{-- Meta info --}}
    <div class="mt-4 px-4 py-3 rounded-lg flex items-center gap-2"
        style="background: var(--c-surface-2); border: 1px solid var(--c-border);">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="2" style="color: var(--c-text-muted); flex-shrink: 0;">
            <circle cx="12" cy="12" r="10" />
            <line x1="12" y1="16" x2="12" y2="12" />
            <line x1="12" y1="8" x2="12.01" y2="8" />
        </svg>
        <span class="text-xs" style="color: var(--c-text-muted);">
            Dibuat {{ $merek->created_at->diffForHumans() }} &middot; Terakhir diperbarui
            {{ $merek->updated_at->diffForHumans() }}
        </span>
    </div>

</div>
