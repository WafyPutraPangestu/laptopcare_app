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
            <p class="home-section-label" style="margin-bottom: 0.25rem;">Ticketing</p>
            <h1 class="font-mono text-2xl font-bold" style="color: var(--c-text); letter-spacing: -0.02em;">Buat Laporan
                Kerusakan</h1>
        </div>
    </div>

    <div class="max-w-2xl">
        <div class="card">

            {{-- Info banner --}}
            <div class="flex items-start gap-3 p-4 mb-6 rounded-lg"
                style="background: var(--c-accent-dim); border: 1px solid rgba(79,142,247,0.25);">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" style="color: var(--c-accent); flex-shrink: 0; margin-top: 1px;">
                    <circle cx="12" cy="12" r="10" />
                    <line x1="12" y1="8" x2="12" y2="12" />
                    <line x1="12" y1="16" x2="12.01" y2="16" />
                </svg>
                <p class="text-xs leading-relaxed" style="color: var(--c-accent);">
                    Deskripsikan keluhan dengan detail agar teknisi dapat menangani lebih cepat.
                    Laporan akan diproses dalam waktu kerja (Senin–Jumat, 08.00–17.00).
                </p>
            </div>

            {{-- Laptop --}}
            <div class="mb-6">
                <p class="font-mono text-xs font-semibold tracking-widest uppercase mb-4"
                    style="color: var(--c-accent); border-bottom: 1px solid var(--c-border); padding-bottom: 0.75rem;">
                    Laptop yang Bermasalah
                </p>
                <div>
                    <label class="block text-xs font-semibold mb-1.5 font-mono" style="color: var(--c-text-dim);">
                        Pilih Laptop <span style="color: var(--c-red);">*</span>
                    </label>
                    <select wire:model.live="id_laptop">
                        <option value="">-- Pilih laptop Anda --</option>
                        @forelse ($laptops as $laptop)
                            <option value="{{ $laptop->id_laptop }}">
                                {{ $laptop->kode_aset }} — {{ $laptop->merek->nama_merek ?? '' }}
                                {{ $laptop->tipe_model }}
                                @if ($laptop->status_kondisi !== 'Baik')
                                    ({{ $laptop->status_kondisi }})
                                @endif
                            </option>
                        @empty
                        @endforelse
                    </select>
                    @error('id_laptop')
                        <p class="text-xs mt-1.5" style="color: var(--c-red);">{{ $message }}</p>
                    @enderror
                    @if ($laptops->isEmpty())
                        <p class="text-xs mt-1.5" style="color: var(--c-orange);">
                            Tidak ada laptop yang terdaftar atas nama Anda. Hubungi admin IT.
                        </p>
                    @endif
                </div>
            </div>

            {{-- Detail Keluhan --}}
            <div class="mb-6">
                <p class="font-mono text-xs font-semibold tracking-widest uppercase mb-4"
                    style="color: var(--c-accent); border-bottom: 1px solid var(--c-border); padding-bottom: 0.75rem;">
                    Detail Keluhan
                </p>
                <div class="flex flex-col gap-4">
                    {{-- Keluhan --}}
                    <div>
                        <label class="block text-xs font-semibold mb-1.5 font-mono" style="color: var(--c-text-dim);">
                            Deskripsi Keluhan <span style="color: var(--c-red);">*</span>
                        </label>
                        <textarea wire:model="keluhan_user" rows="5"
                            placeholder="Contoh: Laptop tidak bisa menyala sejak pagi. Saat tombol power ditekan, lampu indikator menyala sebentar lalu mati kembali..."
                            style="resize: vertical;"></textarea>
                        <div class="flex justify-between mt-1.5">
                            @error('keluhan_user')
                                <p class="text-xs" style="color: var(--c-red);">{{ $message }}</p>
                            @else
                                <p class="text-xs" style="color: var(--c-text-muted);">Minimal 10 karakter. Semakin detail
                                    semakin baik.</p>
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
                            <div class="flex gap-2" x-data>
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
                        <textarea wire:model="dampak_produktivitas" rows="2"
                            placeholder="Contoh: Tidak bisa mengakses sistem kepegawaian untuk input data absensi..." style="resize: none;"></textarea>
                        @error('dampak_produktivitas')
                            <p class="text-xs mt-1.5" style="color: var(--c-red);">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('user.lapor.index') }}" wire:navigate class="button-v2 variant-outline">Batal</a>
                <button wire:click="save" wire:loading.attr="disabled" class="button-v2 is-icon ">
                    <span wire:loading.remove wire:target="save">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5">
                            <line x1="22" y1="2" x2="11" y2="13" />
                            <polygon points="22 2 15 22 11 13 2 9 22 2" />
                        </svg>
                    </span>
                    <span wire:loading wire:target="save">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" style="animation: spin 0.8s linear infinite;">
                            <path d="M21 12a9 9 0 1 1-6.219-8.56" />
                        </svg>
                    </span>
                    Kirim Laporan
                </button>
            </div>

        </div>
    </div>

</div>
