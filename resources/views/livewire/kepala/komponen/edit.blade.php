<div class="home-section-inner py-8" style="max-width: 760px;">

    {{-- Header --}}
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('kepala.komponen.index') }}" wire:navigate
            class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0 transition-colors"
            style="background: var(--c-surface-2); color: var(--c-text-dim); border: 1px solid var(--c-border);"
            onmouseover="this.style.borderColor='var(--c-border-bright)'; this.style.color='var(--c-text)'"
            onmouseout="this.style.borderColor='var(--c-border)'; this.style.color='var(--c-text-dim)'">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 12H5M12 19l-7-7 7-7" />
            </svg>
        </a>
        <div>
            <p class="home-section-label">Master Data / Komponen</p>
            <h1 class="home-section-title mb-0">Edit Komponen</h1>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="card" style="padding: 2rem;">
        <form wire:submit="update" class="flex flex-col gap-6">

            {{-- Nama Komponen --}}
            <div class="flex flex-col gap-1.5">
                <label class="text-sm font-medium" style="color: var(--c-text);">
                    Nama Komponen <span style="color: var(--c-red);">*</span>
                </label>
                <input type="text" wire:model="nama_komponen" placeholder="Contoh: Motherboard, RAM, dll..."
                    class="{{ $errors->has('nama_komponen') ? 'border-red-500' : '' }}">
                @error('nama_komponen')
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

            {{-- Row: Kategori & Is Critical --}}
            <div class="grid grid-cols-2 gap-5">
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-medium" style="color: var(--c-text);">
                        Kategori <span style="color: var(--c-red);">*</span>
                    </label>
                    <select wire:model="kategori" class="{{ $errors->has('kategori') ? 'border-red-500' : '' }}">
                        <option value="Hardware">Hardware</option>
                        <option value="Software">Software</option>
                        <option value="Jaringan">Jaringan</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                    @error('kategori')
                        <p class="text-xs" style="color: var(--c-red);">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-medium" style="color: var(--c-text);">Status Kritis</label>
                    <div class="flex items-center gap-2 mt-2">
                        <input type="checkbox" wire:model="is_critical" id="is_critical" class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <label for="is_critical" class="text-sm" style="color: var(--c-text-dim);">Komponen Kritis</label>
                    </div>
                    <p class="text-xs mt-1" style="color: var(--c-text-muted);">Tandai jika kerusakan pada komponen ini sangat berisiko</p>
                </div>
            </div>

            {{-- Deskripsi --}}
            <div class="flex flex-col gap-1.5">
                <label class="text-sm font-medium" style="color: var(--c-text);">Deskripsi</label>
                <textarea wire:model="deskripsi" rows="4"
                    placeholder="Deskripsi atau catatan tentang komponen ini..."
                    style="resize: vertical;"></textarea>
                @error('deskripsi')
                    <p class="text-xs" style="color: var(--c-red);">{{ $message }}</p>
                @enderror
                <p class="text-xs" style="color: var(--c-text-muted);">Opsional — catatan detail komponen
                </p>
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
                        Perbarui Komponen
                    </span>
                    <span wire:loading wire:target="update" class="flex items-center gap-2">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" style="animation: spin 1s linear infinite;">
                            <path d="M21 12a9 9 0 1 1-6.219-8.56" />
                        </svg>
                        Menyimpan...
                    </span>
                </button>
                <a href="{{ route('kepala.komponen.index') }}" wire:navigate class="home-btn home-btn--secondary">
                    Batal
                </a>
            </div>

        </form>
    </div>

</div>
