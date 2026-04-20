<div>
    <div class="max-w-[1400px] mx-auto px-6 py-8">

        {{-- Header --}}
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('kepala.laptop.index') }}" wire:navigate
                class="w-9 h-9 rounded-lg border flex items-center justify-center transition-colors"
                style="background: var(--c-surface); border-color: var(--c-border); color: var(--c-text-dim);"
                onmouseover="this.style.color='var(--c-text)'" onmouseout="this.style.color='var(--c-text-dim)'">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M19 12H5M12 5l-7 7 7 7" />
                </svg>
            </a>
            <div>
                <p class="font-mono text-xs tracking-widest uppercase mb-1" style="color: var(--c-accent);">Manajemen
                    Laptop</p>
                <h1 class="font-mono text-2xl font-bold tracking-tight" style="color: var(--c-text);">Tambah Laptop Baru
                </h1>
            </div>
        </div>

        <form wire:submit="save">
            <div class="grid grid-cols-3 gap-6">

                {{-- Form Card --}}
                <div class="col-span-2 space-y-6">

                    {{-- Identitas Laptop --}}
                    <div class="rounded-xl border p-6"
                        style="background: var(--c-surface); border-color: var(--c-border);">
                        <p class="font-mono text-xs tracking-widest uppercase mb-5" style="color: var(--c-text-dim);">
                            Identitas Aset</p>

                        <div class="grid grid-cols-2 gap-4">
                            {{-- Kode Aset --}}
                            <div class="col-span-2">
                                <label class="block text-xs font-mono mb-2" style="color: var(--c-text-dim);">Kode Aset
                                    <span style="color: var(--c-red);">*</span></label>
                                <input wire:model.blur="kode_aset" type="text" placeholder="AP-LT-2024-001"
                                    class="w-full px-3 py-2 rounded-lg text-sm font-mono border transition-colors"
                                    style="background: var(--c-surface-2); border-color: {{ $errors->has('kode_aset') ? 'var(--c-red)' : 'var(--c-border)' }}; color: var(--c-text);">
                                @error('kode_aset')
                                    <p class="text-xs mt-1.5 font-mono" style="color: var(--c-red);">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Merek --}}
                            <div>
                                <label class="block text-xs font-mono mb-2" style="color: var(--c-text-dim);">Merek
                                    <span style="color: var(--c-red);">*</span></label>
                                <select wire:model="id_merek"
                                    class="w-full px-3 py-2 rounded-lg text-sm font-mono border"
                                    style="background: var(--c-surface-2); border-color: {{ $errors->has('id_merek') ? 'var(--c-red)' : 'var(--c-border)' }}; color: var(--c-text);">
                                    @foreach ($mereks as $merek)
                                        <option value="{{ $merek->id_merek }}">{{ $merek->nama_merek }}</option>
                                    @endforeach
                                </select>
                                @error('id_merek')
                                    <p class="text-xs mt-1.5 font-mono" style="color: var(--c-red);">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Tipe Model --}}
                            <div>
                                <label class="block text-xs font-mono mb-2" style="color: var(--c-text-dim);">Tipe /
                                    Model <span style="color: var(--c-red);">*</span></label>
                                <input wire:model.blur="tipe_model" type="text"
                                    placeholder="ThinkPad X1 Carbon Gen 11"
                                    class="w-full px-3 py-2 rounded-lg text-sm border"
                                    style="background: var(--c-surface-2); border-color: {{ $errors->has('tipe_model') ? 'var(--c-red)' : 'var(--c-border)' }}; color: var(--c-text);">
                                @error('tipe_model')
                                    <p class="text-xs mt-1.5 font-mono" style="color: var(--c-red);">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Nomor Seri --}}
                            <div>
                                <label class="block text-xs font-mono mb-2" style="color: var(--c-text-dim);">Nomor
                                    Seri</label>
                                <input wire:model.blur="nomor_seri" type="text" placeholder="SN-XXXXXXXXX"
                                    class="w-full px-3 py-2 rounded-lg text-sm font-mono border"
                                    style="background: var(--c-surface-2); border-color: var(--c-border); color: var(--c-text);">
                            </div>

                            {{-- Tanggal Pengadaan --}}
                            <div>
                                <label class="block text-xs font-mono mb-2" style="color: var(--c-text-dim);">Tanggal
                                    Pengadaan <span style="color: var(--c-red);">*</span></label>
                                <input wire:model.blur="tgl_pengadaan" type="date"
                                    class="w-full px-3 py-2 rounded-lg text-sm font-mono border"
                                    style="background: var(--c-surface-2); border-color: {{ $errors->has('tgl_pengadaan') ? 'var(--c-red)' : 'var(--c-border)' }}; color: var(--c-text);">
                                @error('tgl_pengadaan')
                                    <p class="text-xs mt-1.5 font-mono" style="color: var(--c-red);">{{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Status & Nilai --}}
                    <div class="rounded-xl border p-6"
                        style="background: var(--c-surface); border-color: var(--c-border);">
                        <p class="font-mono text-xs tracking-widest uppercase mb-5" style="color: var(--c-text-dim);">
                            Kondisi & Nilai</p>
                        <div class="grid grid-cols-2 gap-4">

                            {{-- Status --}}
                            <div>
                                <label class="block text-xs font-mono mb-2" style="color: var(--c-text-dim);">Status
                                    Kondisi <span style="color: var(--c-red);">*</span></label>
                                <select wire:model="status_kondisi"
                                    class="w-full px-3 py-2 rounded-lg text-sm font-mono border"
                                    style="background: var(--c-surface-2); border-color: var(--c-border); color: var(--c-text);">
                                    <option value="Baik">Baik</option>
                                    <option value="Rusak">Rusak</option>
                                    <option value="Dalam Perbaikan">Dalam Perbaikan</option>
                                </select>
                            </div>

                            {{-- Nilai Aset --}}
                            <div>
                                <label class="block text-xs font-mono mb-2" style="color: var(--c-text-dim);">Nilai Aset
                                    (Rp)</label>
                                <input wire:model.blur="nilai_aset" type="number" placeholder="15000000"
                                    class="w-full px-3 py-2 rounded-lg text-sm font-mono border"
                                    style="background: var(--c-surface-2); border-color: {{ $errors->has('nilai_aset') ? 'var(--c-red)' : 'var(--c-border)' }}; color: var(--c-text);">
                                @error('nilai_aset')
                                    <p class="text-xs mt-1.5 font-mono" style="color: var(--c-red);">{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Catatan --}}
                            <div class="col-span-2">
                                <label class="block text-xs font-mono mb-2"
                                    style="color: var(--c-text-dim);">Catatan</label>
                                <textarea wire:model="catatan" rows="3" placeholder="Catatan tambahan..."
                                    class="w-full px-3 py-2 rounded-lg text-sm border resize-none"
                                    style="background: var(--c-surface-2); border-color: var(--c-border); color: var(--c-text);"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Sidebar --}}
                <div class="space-y-6">

                    {{-- Pengguna --}}
                    <div class="rounded-xl border p-6"
                        style="background: var(--c-surface); border-color: var(--c-border);">
                        <p class="font-mono text-xs tracking-widest uppercase mb-5" style="color: var(--c-text-dim);">
                            Pengguna Laptop</p>
                        <label class="block text-xs font-mono mb-2" style="color: var(--c-text-dim);">Assign ke
                            User</label>
                        <select wire:model="id_user" class="w-full px-3 py-2 rounded-lg text-sm font-mono border"
                            style="background: var(--c-surface-2); border-color: var(--c-border); color: var(--c-text);">
                            <option value="">— Tidak Diassign —</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id_user }}">{{ $user->nama_lengkap }}</option>
                            @endforeach
                        </select>
                        <p class="text-xs mt-2" style="color: var(--c-text-muted);">Kosongkan jika laptop belum
                            diassign ke karyawan.</p>
                    </div>

                    {{-- Summary --}}
                    <div class="rounded-xl border p-5"
                        style="background: var(--c-accent-dim); border-color: var(--c-accent);">
                        <p class="font-mono text-xs tracking-widest uppercase mb-4" style="color: var(--c-accent);">
                            Ringkasan</p>
                        <div class="space-y-2">
                            <div class="flex justify-between text-xs">
                                <span style="color: var(--c-text-dim);">Kode Aset</span>
                                <span class="font-mono" style="color: var(--c-text);">{{ $kode_aset ?: '—' }}</span>
                            </div>
                            <div class="flex justify-between text-xs">
                                <span style="color: var(--c-text-dim);">Status</span>
                                <span class="font-mono" style="color: var(--c-text);">{{ $status_kondisi }}</span>
                            </div>
                            <div class="flex justify-between text-xs">
                                <span style="color: var(--c-text-dim);">Tgl Pengadaan</span>
                                <span class="font-mono"
                                    style="color: var(--c-text);">{{ $tgl_pengadaan ?: '—' }}</span>
                            </div>
                        </div>
                        <div class="border-t mt-4 pt-4" style="border-color: rgba(79,142,247,0.3);">
                            <button type="submit"
                                class="w-full py-2.5  rounded-lg text-sm font-semibold font-mono transition-all"
                                style="background: var(--c-accent); color: #fff;" wire:loading.attr="disabled"
                                wire:loading.class="opacity-60">
                                <span wire:loading.remove>Simpan Laptop</span>
                                <span wire:loading class="flex items-center justify-center gap-2">
                                    <svg class="animate-spin w-4 h-4" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path d="M21 12a9 9 0 00-9-9" opacity=".5" />
                                        <path d="M21 12a9 9 0 11-18 0" />
                                    </svg>
                                    Menyimpan...
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
