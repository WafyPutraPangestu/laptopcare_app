<div class="min-h-screen flex items-center justify-center p-6"
    style="background:#0a0c10; position:relative; overflow:hidden;">
    {{-- Grid background --}}
    <div
        style="position:absolute;inset:0;background-image:linear-gradient(rgba(79,142,247,0.04) 1px,transparent 1px),linear-gradient(90deg,rgba(79,142,247,0.04) 1px,transparent 1px);background-size:36px 36px;pointer-events:none;">
    </div>

    {{-- Glow --}}
    <div
        style="position:absolute;top:-80px;left:-80px;width:340px;height:340px;background:radial-gradient(ellipse,rgba(79,142,247,0.13) 0%,transparent 65%);pointer-events:none;">
    </div>

    <div class="w-full relative" style="max-width:420px;z-index:1;">
        {{-- Card --}}
        <div style="background:#111318;border:1px solid #1e2330;border-radius:20px;padding:2.5rem 2.25rem 2rem;">

            {{-- Brand --}}
            <div class="flex items-center justify-center gap-3 mb-8">
                <div
                    style="width:44px;height:44px;background:linear-gradient(135deg,#4f8ef7 0%,#a78bfa 100%);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:22px;">
                    💻</div>
                <div style="line-height:1;">
                    <div
                        style="font-family:'Space Mono',monospace;font-size:20px;font-weight:700;color:#e2e6f0;letter-spacing:-0.02em;">
                        LAPCARE</div>
                    <div
                        style="font-family:'Space Mono',monospace;font-size:9px;color:#3d4460;letter-spacing:0.12em;text-transform:uppercase;margin-top:3px;">
                        Angkasa Pura</div>
                </div>
            </div>

            {{-- Divider --}}
            <div style="height:1px;background:#1e2330;margin-bottom:1.75rem;"></div>

            {{-- Heading --}}
            <h2
                style="font-family:'Space Mono',monospace;font-size:18px;font-weight:700;color:#e2e6f0;text-align:center;margin-bottom:6px;letter-spacing:-0.02em;">
                Selamat Datang Kembali</h2>
            <p style="font-size:13px;color:#6b7490;text-align:center;margin-bottom:2rem;line-height:1.55;">Masuk untuk
                mengelola perawatan laptop</p>

            {{-- Form --}}
            <form wire:submit="login" class="space-y-5">
                {{-- Username --}}
                <div>
                    <label
                        style="display:block;font-family:'Space Mono',monospace;font-size:11px;letter-spacing:0.06em;text-transform:uppercase;color:#6b7490;margin-bottom:8px;">Username</label>
                    <input type="text" wire:model.live="username"
                        style="width:100%;background:#0d1018;border:1px solid #1e2330;border-radius:10px;padding:13px 16px;font-size:14px;color:#e2e6f0;outline:none;box-sizing:border-box;transition:border-color 0.2s,box-shadow 0.2s;"
                        placeholder="Masukkan username Anda"
                        onfocus="this.style.borderColor='#4f8ef7';this.style.boxShadow='0 0 0 3px rgba(79,142,247,0.12)'"
                        onblur="this.style.borderColor='#1e2330';this.style.boxShadow='none'">
                    @error('username')
                        <p class="mt-2 text-sm" style="color:#f7564f;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label
                        style="display:block;font-family:'Space Mono',monospace;font-size:11px;letter-spacing:0.06em;text-transform:uppercase;color:#6b7490;margin-bottom:8px;">Password</label>
                    <input type="password" wire:model.live="password"
                        style="width:100%;background:#0d1018;border:1px solid #1e2330;border-radius:10px;padding:13px 16px;font-size:14px;color:#e2e6f0;outline:none;box-sizing:border-box;transition:border-color 0.2s,box-shadow 0.2s;"
                        placeholder="••••••••"
                        onfocus="this.style.borderColor='#4f8ef7';this.style.boxShadow='0 0 0 3px rgba(79,142,247,0.12)'"
                        onblur="this.style.borderColor='#1e2330';this.style.boxShadow='none'">
                    @error('password')
                        <p class="mt-2 text-sm" style="color:#f7564f;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit --}}
                <button type="submit"
                    style="width:100%;margin-top:0.25rem;padding:14px;background:#4f8ef7;border:none;border-radius:10px;color:#fff;font-family:'Space Mono',monospace;font-size:13px;font-weight:700;letter-spacing:0.03em;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;transition:background 0.2s,transform 0.15s,box-shadow 0.2s;"
                    onmouseover="this.style.background='#6ba3f9';this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 24px rgba(79,142,247,0.3)'"
                    onmouseout="this.style.background='#4f8ef7';this.style.transform='none';this.style.boxShadow='none'">
                    <span>Masuk ke Sistem</span>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </button>
            </form>

            {{-- Footer --}}
            <p style="font-size:12px;text-align:center;margin-top:1.5rem;line-height:1.6;color:#3d4460;">
                Belum punya akun? <span style="color:#6b7490;">Hubungi Kepala IT</span>
            </p>
        </div>

        {{-- Copyright --}}
        <p
            style="font-family:'Space Mono',monospace;font-size:10px;color:#1e2330;text-align:center;margin-top:1.75rem;letter-spacing:0.03em;">
            © 2026 Sistem Manajemen Perawatan Laptop • Angkasa Pura
        </p>
    </div>
</div>
