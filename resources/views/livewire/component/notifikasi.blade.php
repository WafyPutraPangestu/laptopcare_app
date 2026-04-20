<div x-data="notifManager()" x-on:notify.window="addFromEvent($event.detail)" class="notif-portal" role="region"
    aria-label="Notifikasi" aria-live="polite">
    {{-- Toast Stack --}}
    <div class="notif-stack">
        @foreach ($notifications as $notif)
            <div wire:key="{{ $notif['id'] }}" x-data="notifItem('{{ $notif['id'] }}', {{ $notif['duration'] }})" x-init="init()" x-show="visible"
                x-transition:enter="notif-enter" x-transition:enter-start="notif-enter-start"
                x-transition:enter-end="notif-enter-end" x-transition:leave="notif-leave"
                x-transition:leave-start="notif-leave-start" x-transition:leave-end="notif-leave-end"
                class="notif-toast notif-toast--{{ $notif['type'] }}"
                role="{{ $notif['type'] === 'confirm' ? 'alertdialog' : 'alert' }}">
                {{-- Progress bar (non-confirm only) --}}
                @if ($notif['type'] !== 'confirm')
                    <div class="notif-progress" x-bind:style="`animation-duration: {{ $notif['duration'] }}ms`"></div>
                @endif

                {{-- Icon --}}
                <div class="notif-icon-wrap">
                    @if ($notif['type'] === 'success')
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12" />
                        </svg>
                    @elseif ($notif['type'] === 'error')
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="15" y1="9" x2="9" y2="15" />
                            <line x1="9" y1="9" x2="15" y2="15" />
                        </svg>
                    @elseif ($notif['type'] === 'warning')
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                            <line x1="12" y1="9" x2="12" y2="13" />
                            <line x1="12" y1="17" x2="12.01" y2="17" />
                        </svg>
                    @elseif ($notif['type'] === 'info')
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" y1="8" x2="12" y2="12" />
                            <line x1="12" y1="16" x2="12.01" y2="16" />
                        </svg>
                    @elseif ($notif['type'] === 'confirm')
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" y1="8" x2="12" y2="12" />
                            <line x1="12" y1="16" x2="12.01" y2="16" />
                        </svg>
                    @endif
                </div>

                {{-- Body --}}
                <div class="notif-body">
                    @if ($notif['title'])
                        <p class="notif-title">{{ $notif['title'] }}</p>
                    @endif
                    <p class="notif-message">{{ $notif['message'] }}</p>

                    {{-- Confirm Actions --}}
                    @if ($notif['type'] === 'confirm')
                        <div class="notif-actions">
                            <button wire:click="handleConfirm('{{ $notif['id'] }}')"
                                class="notif-btn notif-btn--confirm">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12" />
                                </svg>
                                Ya, Lanjutkan
                            </button>
                            <button wire:click="dismiss('{{ $notif['id'] }}')" class="notif-btn notif-btn--cancel">
                                Batal
                            </button>
                        </div>
                    @endif
                </div>

                {{-- Dismiss button (non-confirm) --}}
                @if ($notif['type'] !== 'confirm')
                    <button wire:click="dismiss('{{ $notif['id'] }}')" class="notif-close"
                        aria-label="Tutup notifikasi" x-on:click="visible = false">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18" />
                            <line x1="6" y1="6" x2="18" y2="18" />
                        </svg>
                    </button>
                @endif
            </div>
        @endforeach
    </div>
</div>

{{-- ─────────────────── STYLES ─────────────────── --}}
<style>
    .notif-portal {
        position: fixed;
        top: 1.25rem;
        right: 1.25rem;
        z-index: 9999;
        pointer-events: none;
    }

    .notif-stack {
        display: flex;
        flex-direction: column;
        gap: 0.625rem;
        align-items: flex-end;
        width: 360px;
        max-width: calc(100vw - 2.5rem);
    }

    /* ── Toast Base ── */
    .notif-toast {
        position: relative;
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        width: 100%;
        padding: 0.875rem 1rem 0.875rem 0.875rem;
        border-radius: 10px;
        border: 1px solid transparent;
        background: var(--c-surface-2, #181b22);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.45), 0 2px 8px rgba(0, 0, 0, 0.3);
        pointer-events: all;
        overflow: hidden;
        cursor: default;
    }

    /* ── Type Variants ── */
    .notif-toast--success {
        border-color: rgba(45, 212, 160, 0.25);
        background: linear-gradient(135deg, rgba(13, 51, 40, 0.9) 0%, var(--c-surface-2, #181b22) 60%);
    }

    .notif-toast--success .notif-icon-wrap {
        color: var(--c-green, #2dd4a0);
        background: var(--c-green-dim, #0d3328);
    }

    .notif-toast--success .notif-progress {
        background: var(--c-green, #2dd4a0);
    }

    .notif-toast--error {
        border-color: rgba(247, 86, 79, 0.25);
        background: linear-gradient(135deg, rgba(61, 16, 13, 0.9) 0%, var(--c-surface-2, #181b22) 60%);
    }

    .notif-toast--error .notif-icon-wrap {
        color: var(--c-red, #f7564f);
        background: var(--c-red-dim, #3d100d);
    }

    .notif-toast--error .notif-progress {
        background: var(--c-red, #f7564f);
    }

    .notif-toast--warning {
        border-color: rgba(247, 166, 79, 0.25);
        background: linear-gradient(135deg, rgba(61, 40, 13, 0.9) 0%, var(--c-surface-2, #181b22) 60%);
    }

    .notif-toast--warning .notif-icon-wrap {
        color: var(--c-orange, #f7a64f);
        background: var(--c-orange-dim, #3d280d);
    }

    .notif-toast--warning .notif-progress {
        background: var(--c-orange, #f7a64f);
    }

    .notif-toast--info {
        border-color: rgba(79, 142, 247, 0.25);
        background: linear-gradient(135deg, rgba(26, 45, 82, 0.9) 0%, var(--c-surface-2, #181b22) 60%);
    }

    .notif-toast--info .notif-icon-wrap {
        color: var(--c-accent, #4f8ef7);
        background: var(--c-accent-dim, #1a2d52);
    }

    .notif-toast--info .notif-progress {
        background: var(--c-accent, #4f8ef7);
    }

    .notif-toast--confirm {
        border-color: rgba(167, 139, 250, 0.3);
        background: linear-gradient(135deg, rgba(30, 20, 60, 0.95) 0%, var(--c-surface-2, #181b22) 60%);
    }

    .notif-toast--confirm .notif-icon-wrap {
        color: var(--c-purple, #a78bfa);
        background: rgba(167, 139, 250, 0.12);
    }

    /* ── Progress bar ── */
    .notif-progress {
        position: absolute;
        bottom: 0;
        left: 0;
        height: 2px;
        width: 100%;
        transform-origin: left;
        animation: notifShrink linear forwards;
        opacity: 0.7;
    }

    @keyframes notifShrink {
        from {
            transform: scaleX(1);
        }

        to {
            transform: scaleX(0);
        }
    }

    /* ── Icon ── */
    .notif-icon-wrap {
        flex-shrink: 0;
        width: 34px;
        height: 34px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 1px;
    }

    /* ── Body ── */
    .notif-body {
        flex: 1;
        min-width: 0;
    }

    .notif-title {
        font-family: var(--font-mono, 'Space Mono', monospace);
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--c-text, #e2e6f0);
        margin-bottom: 0.25rem;
        letter-spacing: -0.01em;
    }

    .notif-message {
        font-size: 0.8125rem;
        color: var(--c-text-dim, #6b7490);
        line-height: 1.55;
    }

    /* ── Confirm Actions ── */
    .notif-actions {
        display: flex;
        gap: 0.5rem;
        margin-top: 0.875rem;
    }

    .notif-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.375rem 0.875rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        font-family: var(--font-mono, 'Space Mono', monospace);
        cursor: pointer;
        border: 1px solid transparent;
        transition: all 0.15s;
        letter-spacing: 0.01em;
    }

    .notif-btn--confirm {
        background: rgba(167, 139, 250, 0.2);
        border-color: rgba(167, 139, 250, 0.4);
        color: var(--c-purple, #a78bfa);
    }

    .notif-btn--confirm:hover {
        background: rgba(167, 139, 250, 0.35);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(167, 139, 250, 0.2);
    }

    .notif-btn--cancel {
        background: var(--c-surface, #111318);
        border-color: var(--c-border-bright, #2a3048);
        color: var(--c-text-dim, #6b7490);
    }

    .notif-btn--cancel:hover {
        background: var(--c-surface-2, #181b22);
        color: var(--c-text, #e2e6f0);
    }

    /* ── Close btn ── */
    .notif-close {
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 22px;
        height: 22px;
        border-radius: 4px;
        border: none;
        background: transparent;
        color: var(--c-text-muted, #3d4460);
        cursor: pointer;
        transition: color 0.15s, background 0.15s;
        margin-top: 1px;
        padding: 0;
    }

    .notif-close:hover {
        color: var(--c-text, #e2e6f0);
        background: rgba(255, 255, 255, 0.06);
    }

    /* ── Alpine transitions ── */
    .notif-enter {
        transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .notif-enter-start {
        opacity: 0;
        transform: translateX(24px) scale(0.95);
    }

    .notif-enter-end {
        opacity: 1;
        transform: translateX(0) scale(1);
    }

    .notif-leave {
        transition: all 0.25s ease;
    }

    .notif-leave-start {
        opacity: 1;
        transform: translateX(0) scale(1);
    }

    .notif-leave-end {
        opacity: 0;
        transform: translateX(24px) scale(0.95);
    }

    /* ── Mobile ── */
    @media (max-width: 480px) {
        .notif-portal {
            top: auto;
            bottom: 1rem;
            right: 0.75rem;
            left: 0.75rem;
        }

        .notif-stack {
            width: 100%;
        }
    }
</style>

{{-- ─────────────────── ALPINE JS ─────────────────── --}}
<script>
    function notifManager() {
        return {
            addFromEvent(detail) {
                // Bridge: JS → Livewire
                // Usage: window.dispatchEvent(new CustomEvent('notify', { detail: { type, message, title } }))
            }
        }
    }

    function notifItem(id, duration) {
        return {
            visible: true,
            timer: null,
            init() {
                if (duration > 0) {
                    this.timer = setTimeout(() => {
                        this.visible = false;
                        // small delay then tell livewire
                        setTimeout(() => {
                            @this.dismiss(id);
                        }, 300);
                    }, duration);
                }
            },
            destroy() {
                if (this.timer) clearTimeout(this.timer);
            }
        }
    }

    /**
     * ──────────────────────────────────────────────────────
     *  GLOBAL HELPER — pakai dari mana saja di JS/Alpine
     * ──────────────────────────────────────────────────────
     *
     *  $notify.success('Data berhasil disimpan')
     *  $notify.error('Gagal menghapus data')
     *  $notify.warning('Stok hampir habis')
     *  $notify.info('Sesi akan berakhir dalam 5 menit')
     *  $notify.confirm('Yakin ingin menghapus laptop ini?', 'deleteLaptop', { id: 5 })
     */
    window.$notify = {
        _dispatch(type, message, title = '', duration = 4000, confirmAction = null, confirmParams = null) {
            Livewire.dispatch('notify', {
                type,
                message,
                title,
                duration,
                confirmAction,
                confirmParams
            });
        },
        success(message, title = '') {
            this._dispatch('success', message, title, 4000);
        },
        error(message, title = '') {
            this._dispatch('error', message, title, 6000);
        },
        warning(message, title = '') {
            this._dispatch('warning', message, title, 5000);
        },
        info(message, title = '') {
            this._dispatch('info', message, title, 4000);
        },
        confirm(message, action = '', params = {}, title = 'Konfirmasi') {
            this._dispatch('confirm', message, title, 0, action, JSON.stringify(params));
        },
    };
</script>
