<div class="home-section-inner py-8">

    {{-- Header --}}
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('user.lapor.index') }}" wire:navigate
            class="flex items-center justify-center w-9 h-9 rounded-lg transition-all"
            style="background: var(--c-surface-2); border: 1px solid var(--c-border); color: var(--c-text-dim);" x-data
            x-on:mouseenter="$el.style.borderColor='var(--c-border-bright)'; $el.style.color='var(--c-text)'"
            x-on:mouseleave="$el.style.borderColor='var(--c-border)'; $el.style.color='var(--c-text-dim)'">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="15 18 9 12 15 6" />
            </svg>
        </a>
        <div>
            <p class="home-section-label" style="margin-bottom: 0.25rem;">
                Tiket #{{ str_pad($laporan->id_laporan, 4, '0', STR_PAD_LEFT) }}
            </p>
            <h1 class="font-mono text-2xl font-bold" style="color: var(--c-text); letter-spacing: -0.02em;">Edit Laporan
            </h1>
        </div>
    </div>

    <div class="max-w-2xl">

        {{-- Info: hanya bisa edit saat Menunggu --}}
        <div class="flex items-start gap-3 p-4 mb-5 rounded-lg"
            style="background: var(--c-orange-dim); border: 1px solid rgba(247,166,79,0.3);">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                style="color: var(--c-orange); flex-shrink: 0; margin-top: 1px;">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                <line x1="12" y1="9" x2="12" y2="13" />
                <line x1="12" y1="17" x2="12.01" y2="17" />
            </svg>
            <p class="text-xs leading-relaxed" style="color: var(--c-orange);">
                Laporan hanya dapat diedit selama masih berstatus <strong>Menunggu</strong>.
                Setelah diproses oleh teknisi, laporan tidak bisa diubah.
            </p>
        </div>

        <div class="card">

            {{-- Laptop info (read-only) --}}
            <div class="mb-6">
                <p class="font-mono text-xs font-semibold tracking-widest uppercase mb-4"
                    style="color: var(--c-accent); border-bottom: 1px solid var(--c-border); padding-bottom: 0.75rem;">
                    Laptop
                </p>
                <div class="flex items-center gap-3 px-4 py-3 rounded-lg"
                    style="background: var(--c-surface-3); border: 1px solid var(--c-border);">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0"
                        style="background: var(--c-surface-2); color: var(--c-text-dim);">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <rect x="2" y="3" width="20" height="14" rx="2" />
                            <path d="M8 21h8M12 17v4" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium" style="color: var(--c-text);">
                            {{ $laporan->laptop->kode_aset }} — {{ $laporan->laptop->merek->nama_merek ?? '' }}
                            {{ $laporan->laptop->tipe_model }}
                        </p>
                        <p class="text-xs mt-0.5" style="color: var(--c-text-muted);">Tidak dapat diubah setelah laporan
                            dibuat.</p>
                    </div>
                </div>
            </div>

            {{-- Detail Keluhan --}}
            <div class="mb-6">
                <p class="font-mono text-xs font-semibold tracking-widest uppercase mb-4"
                    style="color: var(--c-accent); border-bottom: 1px solid var(--c-border); padding-bottom: 0.75rem;">
                    Detail Keluhan
                </p>
                <div class="flex flex-col gap-4">
                    <div>
                        <label class="block text-xs font-semibold mb-1.5 font-mono" style="color: var(--c-text-dim);">
                            Deskripsi Keluhan <span style="color: var(--c-red);">*</span>
                        </label>
                        <textarea wire:model="keluhan_user" rows="5" style="resize: vertical;"></textarea>
                        <div class="flex justify-between mt-1.5">
                            @error('keluhan_user')
                                <p class="text-xs" style="color: var(--c-red);">{{ $message }}</p>
                            @else
                                <span></span>
                            @enderror
                            <p class="text-xs ml-auto" style="color: var(--c-text-muted);">
                                {{ strlen($keluhan_user) }}/2000</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Prioritas --}}
                        <div>
                            <label class="block text-xs font-semibold mb-1.5 font-mono"
                                style="color: var(--c-text-dim);">
                                Prioritas <span style="color: var(--c-red);">*</span>
                            </label>
                            <div class="flex gap-2">
                                @foreach (['Rendah' => ['var(--c-text-muted)', 'var(--c-surface-3)'], 'Sedang' => ['var(--c-orange)', 'var(--c-orange-dim)'], 'Tinggi' => ['var(--c-red)', 'var(--c-red-dim)']] as $p => [$clr, $bg])
                                    <label
                                        class="flex-1 flex items-center justify-center gap-1.5 py-2 px-3 rounded-lg cursor-pointer text-xs font-medium font-mono transition-all"
                                        style="{{ $prioritas === $p ? "background: {$bg}; color: {$clr}; border: 1px solid {$clr};" : 'background: var(--c-surface-3); color: var(--c-text-muted); border: 1px solid var(--c-border);' }}">
                                        <input type="radio" wire:model.live="prioritas" value="{{ $p }}"
                                            class="sr-only">
                                        {{ $p }}
                                    </label>
                                @endforeach
                            </div>
                            @error('prioritas')
                                <p class="text-xs mt-1.5" style="color: var(--c-red);">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Area Kerja --}}
                        <div>
                            <label class="block text-xs font-semibold mb-1.5 font-mono"
                                style="color: var(--c-text-dim);">Lokasi / Area Kerja</label>
                            <input type="text" wire:model="area_kerja_user" placeholder="Contoh: Lantai 3, Ruang IT">
                            @error('area_kerja_user')
                                <p class="text-xs mt-1.5" style="color: var(--c-red);">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Dampak --}}
                    <div>
                        <label class="block text-xs font-semibold mb-1.5 font-mono" style="color: var(--c-text-dim);">
                            Dampak terhadap Produktivitas
                            <span class="font-normal" style="color: var(--c-text-muted);">(opsional)</span>
                        </label>
                        <textarea wire:model="dampak_produktivitas" rows="2" style="resize: none;"></textarea>
                        @error('dampak_produktivitas')
                            <p class="text-xs mt-1.5" style="color: var(--c-red);">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Meta --}}
            <div class="flex gap-6 pb-5 mb-5" style="border-bottom: 1px solid var(--c-border);">
                <div>
                    <p class="text-xs font-mono mb-0.5" style="color: var(--c-text-muted);">Dilaporkan</p>
                    <p class="text-xs" style="color: var(--c-text-dim);">
                        {{ $laporan->tgl_lapor->format('d M Y, H:i') }}</p>
                </div>
                <div>
                    <p class="text-xs font-mono mb-0.5" style="color: var(--c-text-muted);">Status</p>
                    <span class="text-xs font-mono font-semibold px-2 py-0.5 rounded-full"
                        style="background: var(--c-orange-dim); color: var(--c-orange);">
                        {{ $laporan->status_tiket }}
                    </span>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('user.lapor.index') }}" wire:navigate class="button-v2 variant-outline">Batal</a>
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
