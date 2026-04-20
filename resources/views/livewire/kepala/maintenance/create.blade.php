<div>
    <div style="padding:2rem;max-width:800px;margin:0 auto">

        {{-- Header --}}
        <div style="margin-bottom:2rem">
            <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:0.75rem">
                <a href="{{ route('kepala.maintenance.index') }}"
                    style="display:inline-flex;align-items:center;justify-content:center;width:30px;height:30px;border-radius:var(--radius-sm);background:var(--c-surface-2);color:var(--c-text-dim);text-decoration:none;border:1px solid var(--c-border);transition:all 0.15s"
                    onmouseover="this.style.borderColor='var(--c-border-bright)';this.style.color='var(--c-text)'"
                    onmouseout="this.style.borderColor='var(--c-border)';this.style.color='var(--c-text-dim)'">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5">
                        <path d="m15 18-6-6 6-6" />
                    </svg>
                </a>
                <span
                    style="font-family:var(--font-mono);font-size:0.6875rem;letter-spacing:0.1em;text-transform:uppercase;color:var(--c-text-muted)">Kembali
                    ke Daftar</span>
            </div>
            <h1
                style="font-family:var(--font-mono);font-size:1.5rem;font-weight:700;color:var(--c-text);letter-spacing:-0.02em;margin:0 0 0.375rem">
                Buat Jadwal Maintenance
            </h1>
            <p style="font-size:0.875rem;color:var(--c-text-dim);margin:0">Isi formulir untuk menjadwalkan maintenance
                laptop.</p>
        </div>

        {{-- Flash message --}}
        @if (session('success'))
            <div
                style="display:flex;align-items:center;gap:0.75rem;padding:0.875rem 1rem;border-radius:var(--radius-md);background:var(--c-green-dim);border:1px solid rgba(45,212,160,0.3);color:var(--c-green);font-size:0.875rem;margin-bottom:1.5rem">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                    <path d="M22 4 12 14.01l-3-3" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- Form Card --}}
        <div
            style="background:var(--c-surface);border:1px solid var(--c-border);border-radius:var(--radius-xl);overflow:hidden">

            {{-- Section: Info Utama --}}
            <div style="padding:1.5rem 1.75rem;border-bottom:1px solid var(--c-border)">
                <div style="display:flex;align-items:center;gap:0.625rem;margin-bottom:1.25rem">
                    <div
                        style="width:28px;height:28px;border-radius:var(--radius-sm);background:var(--c-accent-dim);color:var(--c-accent);display:flex;align-items:center;justify-content:center">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                            <line x1="16" y1="2" x2="16" y2="6" />
                            <line x1="8" y1="2" x2="8" y2="6" />
                            <line x1="3" y1="10" x2="21" y2="10" />
                        </svg>
                    </div>
                    <span
                        style="font-family:var(--font-mono);font-size:0.75rem;font-weight:700;color:var(--c-text);letter-spacing:0.02em">Informasi
                        Utama</span>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
                    {{-- Laptop --}}
                    <div style="grid-column:span 2">
                        <label
                            style="display:block;font-size:0.75rem;font-weight:600;color:var(--c-text-dim);margin-bottom:0.375rem">
                            Laptop <span style="color:var(--c-red)">*</span>
                        </label>
                        <select wire:model.live="id_laptop"
                            style="background:var(--c-surface-2);border:1px solid {{ $errors->has('id_laptop') ? 'var(--c-red)' : 'var(--c-border)' }};border-radius:var(--radius-md);color:var(--c-text);font-size:0.875rem;padding:0.625rem 2rem 0.625rem 0.875rem;width:100%;cursor:pointer">
                            <option value="">— Pilih Laptop —</option>
                            @foreach ($laptops as $laptop)
                                <option value="{{ $laptop->id_laptop }}">{{ $laptop->kode_aset }} —
                                    {{ $laptop->tipe_model }}</option>
                            @endforeach
                        </select>
                        @error('id_laptop')
                            <p style="font-size:0.6875rem;color:var(--c-red);margin-top:4px">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Teknisi --}}
                    <div>
                        <label
                            style="display:block;font-size:0.75rem;font-weight:600;color:var(--c-text-dim);margin-bottom:0.375rem">Teknisi</label>
                        <select wire:model="id_teknisi"
                            style="background:var(--c-surface-2);border:1px solid var(--c-border);border-radius:var(--radius-md);color:var(--c-text);font-size:0.875rem;padding:0.625rem 2rem 0.625rem 0.875rem;width:100%;cursor:pointer">
                            <option value="">— Pilih Teknisi —</option>
                            @foreach ($teknisis as $t)
                                <option value="{{ $t->id_user }}">{{ $t->nama_lengkap }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Tipe --}}
                    <div>
                        <label
                            style="display:block;font-size:0.75rem;font-weight:600;color:var(--c-text-dim);margin-bottom:0.375rem">
                            Tipe Maintenance <span style="color:var(--c-red)">*</span>
                        </label>
                        <select wire:model="tipe_maintenance"
                            style="background:var(--c-surface-2);border:1px solid {{ $errors->has('tipe_maintenance') ? 'var(--c-red)' : 'var(--c-border)' }};border-radius:var(--radius-md);color:var(--c-text);font-size:0.875rem;padding:0.625rem 2rem 0.625rem 0.875rem;width:100%;cursor:pointer">
                            <option value="Rutin">Rutin</option>
                            <option value="Darurat">Darurat</option>
                            <option value="Preventif">Preventif</option>
                        </select>
                        @error('tipe_maintenance')
                            <p style="font-size:0.6875rem;color:var(--c-red);margin-top:4px">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tanggal jadwal --}}
                    <div>
                        <label
                            style="display:block;font-size:0.75rem;font-weight:600;color:var(--c-text-dim);margin-bottom:0.375rem">
                            Tanggal Jadwal <span style="color:var(--c-red)">*</span>
                        </label>
                        <input type="datetime-local" wire:model="tgl_jadwal_maintenance"
                            style="background:var(--c-surface-2);border:1px solid {{ $errors->has('tgl_jadwal_maintenance') ? 'var(--c-red)' : 'var(--c-border)' }};border-radius:var(--radius-md);color:var(--c-text);font-size:0.875rem;padding:0.625rem 0.875rem;width:100%">
                        @error('tgl_jadwal_maintenance')
                            <p style="font-size:0.6875rem;color:var(--c-red);margin-top:4px">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tanggal selesai --}}
                    <div>
                        <label
                            style="display:block;font-size:0.75rem;font-weight:600;color:var(--c-text-dim);margin-bottom:0.375rem">Tanggal
                            Selesai</label>
                        <input type="datetime-local" wire:model="tgl_selesai_maintenance"
                            style="background:var(--c-surface-2);border:1px solid var(--c-border);border-radius:var(--radius-md);color:var(--c-text);font-size:0.875rem;padding:0.625rem 0.875rem;width:100%">
                    </div>
                </div>
            </div>

            {{-- Section: Detail --}}
            <div style="padding:1.5rem 1.75rem;border-bottom:1px solid var(--c-border)">
                <div style="display:flex;align-items:center;gap:0.625rem;margin-bottom:1.25rem">
                    <div
                        style="width:28px;height:28px;border-radius:var(--radius-sm);background:rgba(167,139,250,0.12);color:var(--c-purple);display:flex;align-items:center;justify-content:center">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <polyline points="14 2 14 8 20 8" />
                        </svg>
                    </div>
                    <span
                        style="font-family:var(--font-mono);font-size:0.75rem;font-weight:700;color:var(--c-text);letter-spacing:0.02em">Detail
                        Pekerjaan</span>
                </div>

                <div style="display:flex;flex-direction:column;gap:1rem">
                    <div>
                        <label
                            style="display:block;font-size:0.75rem;font-weight:600;color:var(--c-text-dim);margin-bottom:0.375rem">Deskripsi
                            Maintenance</label>
                        <textarea wire:model="deskripsi_maintenance" rows="3" placeholder="Jelaskan rencana pekerjaan maintenance..."
                            style="background:var(--c-surface-2);border:1px solid var(--c-border);border-radius:var(--radius-md);color:var(--c-text);font-size:0.875rem;padding:0.625rem 0.875rem;width:100%;resize:vertical;font-family:var(--font-body)"></textarea>
                    </div>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
                        <div>
                            <label
                                style="display:block;font-size:0.75rem;font-weight:600;color:var(--c-text-dim);margin-bottom:0.375rem">Durasi
                                (hari)</label>
                            <input type="number" wire:model="durasi_hari" min="1" placeholder="0"
                                style="background:var(--c-surface-2);border:1px solid var(--c-border);border-radius:var(--radius-md);color:var(--c-text);font-size:0.875rem;padding:0.625rem 0.875rem;width:100%">
                        </div>
                        <div>
                            <label
                                style="display:block;font-size:0.75rem;font-weight:600;color:var(--c-text-dim);margin-bottom:0.375rem">Estimasi
                                Biaya (Rp)</label>
                            <input type="number" wire:model="biaya_maintenance" min="0" step="1000"
                                placeholder="0"
                                style="background:var(--c-surface-2);border:1px solid var(--c-border);border-radius:var(--radius-md);color:var(--c-text);font-size:0.875rem;padding:0.625rem 0.875rem;width:100%">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div
                style="padding:1.25rem 1.75rem;background:var(--c-surface-2);display:flex;align-items:center;justify-content:flex-end;gap:0.75rem">
                <a href="{{ route('kepala.maintenance.index') }}"
                    style="padding:0.65rem 1.25rem;border-radius:var(--radius-md);background:var(--c-surface-3);color:var(--c-text-dim);border:1px solid var(--c-border);font-size:0.875rem;text-decoration:none;transition:all 0.15s"
                    onmouseover="this.style.borderColor='var(--c-border-bright)'"
                    onmouseout="this.style.borderColor='var(--c-border)'">
                    Batal
                </a>
                <button wire:click="save" wire:loading.attr="disabled"
                    style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.65rem 1.5rem;border-radius:var(--radius-md);background:var(--c-accent);color:#fff;border:none;font-size:0.875rem;font-weight:600;cursor:pointer;transition:all 0.2s;box-shadow:0 0 20px rgba(79,142,247,0.3)"
                    onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform=''">
                    <span wire:loading.remove wire:target="save">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" style="margin-right:4px">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                            <polyline points="17 21 17 13 7 13 7 21" />
                            <polyline points="7 3 7 8 15 8" />
                        </svg>
                        Simpan Jadwal
                    </span>
                    <span wire:loading wire:target="save" style="display:none;align-items:center;gap:0.5rem">
                        <span
                            style="width:14px;height:14px;border:2px solid rgba(255,255,255,0.4);border-top-color:#fff;border-radius:50%;animation:spin 0.7s linear infinite;display:inline-block"></span>
                        Menyimpan...
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>
