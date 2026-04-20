    <div class="home-page">

        {{-- Hero Section --}}
        <section class="home-hero">
            <div class="home-hero__bg">
                <div class="home-hero__glow-1"></div>
                <div class="home-hero__glow-2"></div>
                <div class="home-hero__grid"></div>
            </div>

            <div class="home-hero__inner">
                <div class="home-hero__label">
                    <span class="home-hero__dot"></span>
                    <span>Sistem Manajemen Perawatan Aset</span>
                </div>

                <h1 class="home-hero__title">
                    Monitor & Kelola<br>
                    <span class="home-hero__title-accent">Aset Laptop</span><br>
                    Lebih Efisien
                </h1>

                <p class="home-hero__desc">
                    Platform terpadu untuk digitalisasi pemeliharaan laptop Angkasa Pura —
                    dari pelaporan kerusakan, riwayat perbaikan, hingga analitik preventif berbasis data.
                </p>

                <div class="home-hero__actions">
                    @auth
                        @if (auth()->user()->role === 'User')
                            <a href="#" class="home-btn home-btn--primary" wire:navigate>
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <circle cx="12" cy="12" r="10" />
                                    <line x1="12" y1="8" x2="12" y2="16" />
                                    <line x1="8" y1="12" x2="16" y2="12" />
                                </svg>
                                Lapor Kerusakan Sekarang
                            </a>
                            <a href="#" class="home-btn home-btn--secondary" wire:navigate>
                                Lihat Laporan Saya
                            </a>
                        @elseif(auth()->user()->role === 'Teknisi')
                            <a href="#" class="home-btn home-btn--primary" wire:navigate>
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                    <polyline points="14 2 14 8 20 8" />
                                </svg>
                                Lihat Tiket Masuk
                            </a>
                        @else
                            <a href="#" class="home-btn home-btn--primary" wire:navigate>
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <rect x="3" y="3" width="7" height="7" />
                                    <rect x="14" y="3" width="7" height="7" />
                                    <rect x="3" y="14" width="7" height="7" />
                                    <rect x="14" y="14" width="7" height="7" />
                                </svg>
                                Buka Dashboard Admin
                            </a>
                            <a href="#" class="home-btn home-btn--secondary" wire:navigate>
                                Lihat Analitik
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" wire:navigate class="home-btn home-btn--primary">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                                <polyline points="10 17 15 12 10 7" />
                                <line x1="15" y1="12" x2="3" y2="12" />
                            </svg>
                            Masuk ke Sistem
                        </a>
                    @endauth
                </div>
            </div>

            {{-- Floating stat cards --}}
            <div class="home-hero__float-cards">
                <div class="home-float-card home-float-card--1">
                    <div class="home-float-card__icon" style="color: var(--c-green)">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <polyline points="20 6 9 17 4 12" />
                        </svg>
                    </div>
                    <div>
                        <div class="home-float-card__value">98%</div>
                        <div class="home-float-card__label">Tiket Terselesaikan</div>
                    </div>
                </div>
                <div class="home-float-card home-float-card--2">
                    <div class="home-float-card__icon" style="color: var(--c-accent)">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <circle cx="12" cy="12" r="10" />
                            <polyline points="12 6 12 12 16 14" />
                        </svg>
                    </div>
                    <div>
                        <div class="home-float-card__value">2.4 hr</div>
                        <div class="home-float-card__label">Rata-rata Respons</div>
                    </div>
                </div>
                <div class="home-float-card home-float-card--3">
                    <div class="home-float-card__icon" style="color: var(--c-purple)">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <rect x="2" y="3" width="20" height="14" rx="2" />
                            <path d="M8 21h8M12 17v4" />
                        </svg>
                    </div>
                    <div>
                        <div class="home-float-card__value">200+</div>
                        <div class="home-float-card__label">Aset Terdaftar</div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Feature Grid --}}
        <section class="home-features">
            <div class="home-section-inner">
                <div class="home-section-label">Fitur Unggulan</div>
                <h2 class="home-section-title">Satu Platform, Semua Kebutuhan</h2>
                <p class="home-section-desc">Dari laporan kerusakan harian hingga analitik strategis tahunan, semua
                    terintegrasi dalam satu sistem yang mudah digunakan.</p>

                <div class="home-features__grid">

                    <div class="home-feat-card home-feat-card--wide">
                        <div class="home-feat-card__icon home-feat-card__icon--blue">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1.5">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                <polyline points="14 2 14 8 20 8" />
                                <line x1="16" y1="13" x2="8" y2="13" />
                                <line x1="16" y1="17" x2="8" y2="17" />
                            </svg>
                        </div>
                        <h3 class="home-feat-card__title">Ticketing Real-time</h3>
                        <p class="home-feat-card__desc">Karyawan lapor kerusakan secara online. Teknisi ternotifikasi
                            langsung. Status tiket update otomatis — dari "Menunggu" hingga "Selesai".</p>
                        <div class="home-feat-card__tags">
                            <span>Live Update</span><span>Prioritas Otomatis</span><span>Notifikasi</span>
                        </div>
                    </div>

                    <div class="home-feat-card">
                        <div class="home-feat-card__icon home-feat-card__icon--green">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1.5">
                                <line x1="18" y1="20" x2="18" y2="10" />
                                <line x1="12" y1="20" x2="12" y2="4" />
                                <line x1="6" y1="20" x2="6" y2="14" />
                                <line x1="2" y1="20" x2="22" y2="20" />
                            </svg>
                        </div>
                        <h3 class="home-feat-card__title">Analitik Pola Kerusakan</h3>
                        <p class="home-feat-card__desc">Identifikasi komponen mana yang paling sering rusak dan buat
                            keputusan berbasis data.</p>
                        <div class="home-feat-card__tags">
                            <span>Dashboard</span><span>Insight AI</span>
                        </div>
                    </div>

                    <div class="home-feat-card">
                        <div class="home-feat-card__icon home-feat-card__icon--orange">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1.5">
                                <path
                                    d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z" />
                            </svg>
                        </div>
                        <h3 class="home-feat-card__title">Maintenance Preventif</h3>
                        <p class="home-feat-card__desc">Jadwalkan perawatan sebelum kerusakan terjadi. Kurangi downtime
                            dan biaya perbaikan mendadak.</p>
                        <div class="home-feat-card__tags">
                            <span>Scheduling</span><span>Reminder</span>
                        </div>
                    </div>

                    <div class="home-feat-card">
                        <div class="home-feat-card__icon home-feat-card__icon--purple">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1.5">
                                <rect x="2" y="3" width="20" height="14" rx="2" />
                                <path d="M8 21h8M12 17v4" />
                            </svg>
                        </div>
                        <h3 class="home-feat-card__title">Manajemen Aset Laptop</h3>
                        <p class="home-feat-card__desc">Database lengkap semua laptop beserta riwayat, kondisi, nilai
                            aset, dan masa optimal penggunaan.</p>
                        <div class="home-feat-card__tags">
                            <span>Inventaris</span><span>Lifecycle</span>
                        </div>
                    </div>

                    <div class="home-feat-card">
                        <div class="home-feat-card__icon home-feat-card__icon--red">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1.5">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                <circle cx="9" cy="7" r="4" />
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                            </svg>
                        </div>
                        <h3 class="home-feat-card__title">Sistem Berbasis Role</h3>
                        <p class="home-feat-card__desc">Akses terpisah untuk Karyawan, Teknisi, dan Kepala IT. Setiap
                            peran melihat fitur yang relevan saja.</p>
                        <div class="home-feat-card__tags">
                            <span>RBAC</span><span>Secure</span>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        {{-- Role CTA Section --}}
        <section class="home-roles">
            <div class="home-section-inner">
                <div class="home-section-label">Akses Sesuai Peran</div>
                <h2 class="home-section-title">Untuk Siapa Sistem Ini?</h2>

                <div class="home-roles__grid">
                    <div class="home-role-card">
                        <div class="home-role-card__num">01</div>
                        <h3 class="home-role-card__title">Karyawan</h3>
                        <p class="home-role-card__desc">Laporkan kerusakan laptop secara online. Pantau status
                            perbaikan tanpa harus menelepon IT.</p>
                        <ul class="home-role-card__list">
                            <li>Buat laporan kerusakan</li>
                            <li>Pantau status tiket real-time</li>
                            <li>Riwayat laporan pribadi</li>
                        </ul>
                    </div>

                    <div class="home-role-card home-role-card--highlight">
                        <div class="home-role-card__num">02</div>
                        <h3 class="home-role-card__title">Teknisi</h3>
                        <p class="home-role-card__desc">Kelola semua tiket perbaikan. Catat tindakan, biaya, dan spare
                            part yang digunakan.</p>
                        <ul class="home-role-card__list">
                            <li>Terima & proses tiket</li>
                            <li>Catat riwayat perbaikan</li>
                            <li>Kelola jadwal maintenance</li>
                        </ul>
                    </div>

                    <div class="home-role-card">
                        <div class="home-role-card__num">03</div>
                        <h3 class="home-role-card__title">Kepala IT</h3>
                        <p class="home-role-card__desc">Akses penuh ke seluruh data, analitik, dan laporan strategis
                            untuk pengambilan keputusan.</p>
                        <ul class="home-role-card__list">
                            <li>Dashboard & analitik lengkap</li>
                            <li>Manajemen semua aset</li>
                            <li>Laporan bulanan & tahunan</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        {{-- Footer --}}
        <footer class="home-footer">
            <div class="home-section-inner">
                <div class="home-footer__inner">
                    <div class="ap-navbar__brand" style="pointer-events:none">
                        <div class="ap-navbar__logo-mark">
                            <svg width="18" height="18" viewBox="0 0 20 20" fill="none">
                                <rect x="1" y="1" width="8" height="8" rx="1" fill="currentColor"
                                    opacity="0.9" />
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
                    </div>
                    <p class="home-footer__copy">© {{ date('Y') }} Angkasa Pura. Sistem Manajemen Aset Laptop.</p>
                </div>
            </div>
        </footer>

    </div>
