<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RingkasanAnalisisBulanan extends Model
{
    use HasFactory;

    protected $table = 'ringkasan_analisis_bulanan';
    protected $primaryKey = 'id_ringkasan';
    protected $fillable = [
        'bulan_tahun',
        'total_kerusakan',
        'komponen_terbanyak_rusak',
        'frekuensi_komponen',
        'durasi_rata_perbaikan',
        'tingkat_repeat_issue',
        'total_laptop_bermasalah',
        'total_tiket_terselesaikan',
        'rata_prioritas_urgent_count',
        'rekomendasi',
        'total_biaya_perbaikan',
        'insight_tambahan',
    ];

    protected $casts = [
        'bulan_tahun' => 'date',
        'durasi_rata_perbaikan' => 'float',
        'tingkat_repeat_issue' => 'float',
        'total_biaya_perbaikan' => 'integer',
    ];

    // Method: Generate ringkasan analisis untuk bulan tertentu
    public static function generateAnalisisBulan($bulan, $tahun)
    {
        // Cek apakah sudah ada ringkasan untuk bulan ini
        $bulanTahun = date("{$tahun}-{$bulan}-01");
        $existing = self::where('bulan_tahun', $bulanTahun)->first();

        if ($existing) {
            return $existing;
        }

        $startDate = "{$tahun}-{$bulan}-01";
        $endDate = date('Y-m-t', strtotime($startDate));

        // Ambil data dari RiwayatPerbaikan
        $perbaikan = RiwayatPerbaikan::whereBetween('tgl_selesai', [$startDate, $endDate])->get();

        if ($perbaikan->isEmpty()) {
            return null;
        }

        // Hitung metrik
        $totalKerusakan = $perbaikan->count();
        $komponenStats = $perbaikan->groupBy('komponen_rusak')
            ->map(function ($items) {
                return $items->count();
            })
            ->sort()
            ->reverse();

        $komponenTerbanyak = $komponenStats->keys()->first();
        $frekuensiKomponen = $komponenStats->values()->first();

        $rataRataDurasi = round($perbaikan->avg('durasi_perbaikan_hari'), 2);

        $totalRecurring = $perbaikan->where('apakah_terjadi_ulang', true)->count();
        $tingkatRepeat = $totalKerusakan > 0 ? round(($totalRecurring / $totalKerusakan) * 100, 2) : 0;

        $totalLaptopBermasalah = $perbaikan->pluck('id_laporan')
            ->unique()
            ->count();

        $totalTiketSelesai = LaporanKerusakan::whereBetween('tgl_selesai_tiket', [$startDate, $endDate])
            ->count();

        $totalBiayaPerbaikan = $perbaikan->sum('biaya_perbaikan');

        // Generate rekomendasi
        $rekomendasi = self::generateRekomendasi(
            $totalKerusakan,
            $tingkatRepeat,
            $rataRataDurasi,
            $komponenTerbanyak,
            $totalBiayaPerbaikan
        );

        // Buat ringkasan
        return self::create([
            'bulan_tahun' => $bulanTahun,
            'total_kerusakan' => $totalKerusakan,
            'komponen_terbanyak_rusak' => $komponenTerbanyak,
            'frekuensi_komponen' => $frekuensiKomponen,
            'durasi_rata_perbaikan' => $rataRataDurasi,
            'tingkat_repeat_issue' => $tingkatRepeat,
            'total_laptop_bermasalah' => $totalLaptopBermasalah,
            'total_tiket_terselesaikan' => $totalTiketSelesai,
            'total_biaya_perbaikan' => $totalBiayaPerbaikan,
            'rekomendasi' => $rekomendasi,
        ]);
    }

    // Method: Generate rekomendasi berdasarkan data
    private static function generateRekomendasi($totalKerusakan, $tingkatRepeat, $rataRataDurasi, $komponenTerbanyak, $totalBiaya)
    {
        $rekomendasi = [];

        // Jika kerusakan tinggi
        if ($totalKerusakan > 10) {
            $rekomendasi[] = "⚠️ Tingkat kerusakan tinggi ({$totalKerusakan} kasus). Perlukan evaluasi terhadap kualitas perangkat atau pelatihan penggunaan.";
        }

        // Jika recurring issue tinggi
        if ($tingkatRepeat > 30) {
            $rekomendasi[] = "🔄 Recurring issues mencapai {$tingkatRepeat}%. Komponen {$komponenTerbanyak} perlu dipertimbangkan untuk penggantian preventif.";
        }

        // Jika durasi perbaikan lama
        if ($rataRataDurasi > 7) {
            $rekomendasi[] = "⏱️ Rata-rata durasi perbaikan {$rataRataDurasi} hari. Pertimbangkan menyimpan spare parts untuk komponen kritikal atau melatih teknisi.";
        }

        // Jika biaya perbaikan tinggi
        if ($totalBiaya > 50000000) {
            $rekomendasi[] = "💰 Total biaya perbaikan Rp" . number_format($totalBiaya) . ". Evaluasi cost-benefit antara memperbaiki vs mengganti dengan unit baru.";
        }

        // Rekomendasi umum
        if (empty($rekomendasi)) {
            $rekomendasi[] = "✅ Kondisi perangkat dalam keadaan baik. Lanjutkan maintenance rutin.";
        }

        return implode("\n", $rekomendasi);
    }

    // Static Method: Ambil data untuk dashboard
    public static function dashboardData($tahun)
    {
        return self::whereYear('bulan_tahun', $tahun)
            ->orderBy('bulan_tahun')
            ->get();
    }

    // Static Method: Tren kerusakan tahunan
    public static function trenTahunan($tahun)
    {
        return self::whereYear('bulan_tahun', $tahun)
            ->select('bulan_tahun', 'total_kerusakan', 'durasi_rata_perbaikan', 'tingkat_repeat_issue', 'total_biaya_perbaikan')
            ->orderBy('bulan_tahun')
            ->get();
    }

    // Static Method: Perbandingan bulan
    public static function perbandinganBulan($bulan1, $tahun1, $bulan2, $tahun2)
    {
        $bulanTahun1 = date("{$tahun1}-{$bulan1}-01");
        $bulanTahun2 = date("{$tahun2}-{$bulan2}-01");

        $data1 = self::where('bulan_tahun', $bulanTahun1)->first();
        $data2 = self::where('bulan_tahun', $bulanTahun2)->first();

        return [
            'periode_1' => [
                'bulan_tahun' => $bulanTahun1,
                'data' => $data1,
            ],
            'periode_2' => [
                'bulan_tahun' => $bulanTahun2,
                'data' => $data2,
            ],
            'selisih_kerusakan' => $data1 && $data2 ? $data2->total_kerusakan - $data1->total_kerusakan : null,
            'selisih_durasi' => $data1 && $data2 ? round($data2->durasi_rata_perbaikan - $data1->durasi_rata_perbaikan, 2) : null,
            'selisih_biaya' => $data1 && $data2 ? $data2->total_biaya_perbaikan - $data1->total_biaya_perbaikan : null,
        ];
    }

    // Static Method: Komponen problem terbesar dalam tahun
    public static function komponenProblematikTahun($tahun)
    {
        return self::selectRaw('komponen_terbanyak_rusak, SUM(frekuensi_komponen) as total_frekuensi')
            ->whereYear('bulan_tahun', $tahun)
            ->groupBy('komponen_terbanyak_rusak')
            ->orderByDesc('total_frekuensi')
            ->limit(5)
            ->get();
    }

    // Static Method: Total biaya maintenance tahunan
    public static function totalBiayaTahunan($tahun)
    {
        return self::whereYear('bulan_tahun', $tahun)->sum('total_biaya_perbaikan');
    }

    // Static Method: Analisis ROI maintenance
    public static function analisisROI($tahun)
    {
        $data = self::whereYear('bulan_tahun', $tahun)->get();

        $totalBiaya = $data->sum('total_biaya_perbaikan');
        $totalKerusakan = $data->sum('total_kerusakan');
        $totalLaptop = Laptop::count();

        return [
            'tahun' => $tahun,
            'total_biaya_maintenance' => $totalBiaya,
            'total_kerusakan' => $totalKerusakan,
            'rata_biaya_per_kerusakan' => $totalKerusakan > 0 ? round($totalBiaya / $totalKerusakan, 2) : 0,
            'rata_biaya_per_laptop' => $totalLaptop > 0 ? round($totalBiaya / $totalLaptop, 2) : 0,
            'frekuensi_kerusakan_per_laptop' => round($totalKerusakan / $totalLaptop, 2),
        ];
    }

    // Static Method: Rekomendasi strategis tahunan
    public static function rekomendasiStrategis($tahun)
    {
        $data = self::whereYear('bulan_tahun', $tahun)->get();

        $rekomendasi = [];

        // Analisis komponen problem
        $komponenTop = self::komponenProblematikTahun($tahun)->first();
        if ($komponenTop) {
            $rekomendasi[] = "🎯 Fokus: Komponen '{$komponenTop->komponen_terbanyak_rusak}' adalah problem terbesar dengan {$komponenTop->total_frekuensi} kasus. Implementasikan maintenance preventif khusus.";
        }

        // Analisis biaya
        $totalBiaya = $data->sum('total_biaya_perbaikan');
        if ($totalBiaya > 500000000) {
            $rekomendasi[] = "💰 Budget: Total maintenance Rp" . number_format($totalBiaya) . " dalam setahun. Evaluasi kontrak dengan vendor atau upgrading equipment.";
        }

        // Analisis trend
        $trend = $data->sortBy('bulan_tahun')->values();
        if ($trend->count() > 6) {
            $bulanAwal = $trend->first()->total_kerusakan;
            $bulanAkhir = $trend->last()->total_kerusakan;
            if ($bulanAkhir > $bulanAwal) {
                $persentase = round((($bulanAkhir - $bulanAwal) / $bulanAwal) * 100, 2);
                $rekomendasi[] = "📈 Trend: Kerusakan meningkat {$persentase}% dari awal tahun. Perlukan tindakan pencegahan yang lebih agresif.";
            }
        }

        return $rekomendasi;
    }

    // Scope: Filter berdasarkan tahun
    public function scopeByYear($query, $tahun)
    {
        return $query->whereYear('bulan_tahun', $tahun);
    }

    // Scope: Filter berdasarkan bulan
    public function scopeByMonth($query, $bulan)
    {
        return $query->whereMonth('bulan_tahun', $bulan);
    }

    // Scope: Urutkan berdasarkan tanggal
    public function scopeOrderByDate($query)
    {
        return $query->orderBy('bulan_tahun', 'asc');
    }

    // Accessor: Format ringkasan untuk tampilan
    public function getRingkasanFormatAttribute()
    {
        return [
            'periode' => $this->bulan_tahun->format('F Y'),
            'kerusakan' => "{$this->total_kerusakan} kasus",
            'komponen_top' => $this->komponen_terbanyak_rusak,
            'durasi_rata' => "{$this->durasi_rata_perbaikan} hari",
            'recurring' => "{$this->tingkat_repeat_issue}%",
            'biaya' => "Rp" . number_format($this->total_biaya_perbaikan),
        ];
    }
}
