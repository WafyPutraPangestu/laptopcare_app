<?php

namespace App\Livewire\Kepala;

use App\Models\Laptop;
use App\Models\LaporanKerusakan;
use App\Models\RiwayatPerbaikan;
use App\Models\Komponen;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;

#[Title('Laporan & Analitik')]
class Laporan extends Component
{
    public string $tahun;
    public string $activeTab = 'komponen';

    public function mount(): void
    {
        $this->tahun = (string) now()->year;
    }

    public function render()
    {
        $tahun = (int) $this->tahun;

        // ── 1. KOMPONEN SERING RUSAK ─────────────────────────────
        $komponenRusak = RiwayatPerbaikan::query()
            ->whereYear('tgl_selesai', $tahun)
            ->select(
                'komponen_rusak',
                'kategori_rusak',
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(biaya_perbaikan) as total_biaya'),
                DB::raw('AVG(durasi_perbaikan_hari) as rata_durasi'),
                DB::raw('SUM(CASE WHEN apakah_terjadi_ulang = 1 THEN 1 ELSE 0 END) as recurring')
            )
            ->groupBy('komponen_rusak', 'kategori_rusak')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        // ── 2. RANKING TEKNISI ───────────────────────────────────
        $rankingTeknisi = RiwayatPerbaikan::query()
            ->whereYear('tgl_selesai', $tahun)
            ->join('users', 'users.id_user', '=', 'riwayat_perbaikan.id_teknisi')
            ->select(
                'users.nama_lengkap',
                'users.id_user',
                DB::raw('COUNT(*) as total_perbaikan'),
                DB::raw('AVG(durasi_perbaikan_hari) as rata_durasi'),
                DB::raw('SUM(CASE WHEN apakah_terjadi_ulang = 1 THEN 1 ELSE 0 END) as total_recurring'),
                DB::raw('SUM(biaya_perbaikan) as total_biaya_ditangani'),
                DB::raw('SUM(CASE WHEN tingkat_kesulitan = "Sulit" THEN 1 ELSE 0 END) as kasus_sulit')
            )
            ->groupBy('users.id_user', 'users.nama_lengkap')
            ->orderByDesc('total_perbaikan')
            ->get()
            ->map(function ($t) {
                // Skor kualitas: makin cepat + makin sedikit recurring = skor tinggi
                $skorKecepatan = $t->rata_durasi > 0
                    ? max(0, 100 - ($t->rata_durasi * 8))
                    : 100;
                $skorKualitas = $t->total_perbaikan > 0
                    ? max(0, 100 - (($t->total_recurring / $t->total_perbaikan) * 100))
                    : 100;
                $t->skor = round(($skorKecepatan * 0.4) + ($skorKualitas * 0.6));
                return $t;
            })
            ->sortByDesc('skor')
            ->values();

        // ── 3. LIFECYCLE LAPTOP (ganti vs pertahankan) ──────────
        $lifecycleLaptop = Laptop::query()
            ->with('merek')
            ->withCount('laporanKerusakan')
            ->select(
                'laptops.*',
                DB::raw('TIMESTAMPDIFF(YEAR, tgl_pengadaan, CURDATE()) as usia_tahun'),
                DB::raw('(SELECT COALESCE(SUM(rp.biaya_perbaikan),0)
                          FROM riwayat_perbaikan rp
                          JOIN laporan_kerusakan lk ON lk.id_laporan = rp.id_laporan
                          WHERE lk.id_laptop = laptops.id_laptop) as total_biaya_perbaikan')
            )
            ->orderByDesc(DB::raw('total_biaya_perbaikan'))
            ->limit(15)
            ->get()
            ->map(function ($l) {
                $usiaTahun      = (int) $l->usia_tahun;
                $rataUsiaOptimal = $l->merek->rata_usia_optimal ?? 5;
                $nilaiAset      = (float) ($l->nilai_aset ?? 0);
                $biayaPerbaikan = (float) $l->total_biaya_perbaikan;

                // Rekomendasi sederhana
                if ($usiaTahun >= $rataUsiaOptimal && $biayaPerbaikan > ($nilaiAset * 0.5)) {
                    $l->rekomendasi = 'Ganti';
                    $l->rekomendasi_color = 'red';
                } elseif ($usiaTahun >= ($rataUsiaOptimal - 1) || $biayaPerbaikan > ($nilaiAset * 0.3)) {
                    $l->rekomendasi = 'Evaluasi';
                    $l->rekomendasi_color = 'orange';
                } else {
                    $l->rekomendasi = 'Pertahankan';
                    $l->rekomendasi_color = 'green';
                }

                $l->rasio_biaya = $nilaiAset > 0
                    ? round(($biayaPerbaikan / $nilaiAset) * 100, 1)
                    : 0;

                return $l;
            });

        // ── 4. COST ANALYSIS ────────────────────────────────────
        $costPerBulan = RiwayatPerbaikan::query()
            ->whereYear('tgl_selesai', $tahun)
            ->select(
                DB::raw('MONTH(tgl_selesai) as bulan'),
                DB::raw('SUM(biaya_perbaikan) as total_biaya'),
                DB::raw('COUNT(*) as total_kasus')
            )
            ->groupBy(DB::raw('MONTH(tgl_selesai)'))
            ->orderBy('bulan')
            ->get()
            ->keyBy('bulan');

        // Lengkapi 12 bulan
        $bulanLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'];
        $chartData = collect(range(1, 12))->map(fn($b) => [
            'bulan'       => $bulanLabels[$b - 1],
            'total_biaya' => (float) ($costPerBulan[$b]->total_biaya ?? 0),
            'total_kasus' => (int)   ($costPerBulan[$b]->total_kasus ?? 0),
        ]);

        // ── 5. SUMMARY STATS ────────────────────────────────────
        $stats = [
            'total_biaya_tahun'   => RiwayatPerbaikan::whereYear('tgl_selesai', $tahun)->sum('biaya_perbaikan'),
            'total_kasus'         => RiwayatPerbaikan::whereYear('tgl_selesai', $tahun)->count(),
            'rata_durasi'         => round((float) RiwayatPerbaikan::whereYear('tgl_selesai', $tahun)->avg('durasi_perbaikan_hari'), 1),
            'recurring_rate'      => RiwayatPerbaikan::whereYear('tgl_selesai', $tahun)->count() > 0
                ? round(
                    RiwayatPerbaikan::whereYear('tgl_selesai', $tahun)->where('apakah_terjadi_ulang', true)->count()
                        / RiwayatPerbaikan::whereYear('tgl_selesai', $tahun)->count() * 100,
                    1
                )
                : 0,
            'laptop_perlu_ganti'  => $lifecycleLaptop->where('rekomendasi', 'Ganti')->count(),
            'laptop_evaluasi'     => $lifecycleLaptop->where('rekomendasi', 'Evaluasi')->count(),
        ];

        $tahunOptions = range(now()->year, now()->year - 4);

        return view('livewire.kepala.laporan', compact(
            'komponenRusak',
            'rankingTeknisi',
            'lifecycleLaptop',
            'chartData',
            'stats',
            'tahunOptions',
        ));
    }
}
