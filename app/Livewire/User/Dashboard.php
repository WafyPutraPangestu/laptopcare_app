<?php

namespace App\Livewire\User;

use App\Models\JadwalMaintenance;
use App\Models\LaporanKerusakan;
use App\Models\Laptop;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Dashboard')]
class Dashboard extends Component
{
    public function render()
    {
        $userId = Auth::id();

        // ── Laptop milik user ──────────────────────────────────────────
        $laptops = Laptop::with(['merek', 'laporanKerusakan', 'jadwalMaintenance'])
            ->where('id_user', $userId)
            ->get();

        $totalLaptop   = $laptops->count();
        $laptopBaik    = $laptops->where('status_kondisi', 'Baik')->count();
        $laptopRusak   = $laptops->where('status_kondisi', 'Rusak')->count();
        $laptopDiperbaiki = $laptops->where('status_kondisi', 'Dalam Perbaikan')->count();

        // ── Tiket laporan user ─────────────────────────────────────────
        $tiketTotal    = LaporanKerusakan::where('id_user', $userId)->count();
        $tiketMenunggu = LaporanKerusakan::where('id_user', $userId)->where('status_tiket', 'Menunggu')->count();
        $tiketDiproses = LaporanKerusakan::where('id_user', $userId)->where('status_tiket', 'Diproses')->count();
        $tiketSelesai  = LaporanKerusakan::where('id_user', $userId)->where('status_tiket', 'Selesai')->count();

        // ── 3 Laporan terbaru ──────────────────────────────────────────
        $laporanTerbaru = LaporanKerusakan::with('laptop.merek')
            ->where('id_user', $userId)
            ->latest('tgl_lapor')
            ->limit(3)
            ->get();

        // ── Jadwal maintenance mendatang ───────────────────────────────
        $maintenanceMendatang = JadwalMaintenance::with('laptop.merek')
            ->whereHas('laptop', fn($q) => $q->where('id_user', $userId))
            ->where('status', 'Dijadwalkan')
            ->where('tgl_jadwal_maintenance', '>=', now())
            ->orderBy('tgl_jadwal_maintenance')
            ->limit(3)
            ->get();

        // ── Laptop dengan kerusakan terbanyak ─────────────────────────
        $laptopRawan = $laptops->sortByDesc('total_kerusakan_count')->first();

        // ── Usia laptop (tahun) ────────────────────────────────────────
        $laptopDetail = $laptops->map(function ($laptop) {
            $usiaTahun   = now()->diffInYears($laptop->tgl_pengadaan);
            $usiaBulan   = now()->diffInMonths($laptop->tgl_pengadaan);
            $usiaPersen  = $laptop->merek?->rata_usia_optimal
                ? min(100, round(($usiaTahun / $laptop->merek->rata_usia_optimal) * 100))
                : null;

            return [
                'laptop'       => $laptop,
                'usia_tahun'   => $usiaTahun,
                'usia_bulan'   => $usiaBulan,
                'usia_persen'  => $usiaPersen,
                'kondisi_usia' => match (true) {
                    $usiaPersen === null       => 'unknown',
                    $usiaPersen >= 90          => 'kritis',
                    $usiaPersen >= 70          => 'perlu_perhatian',
                    default                    => 'baik',
                },
            ];
        });

        return view('livewire.user.dashboard', compact(
            'laptops',
            'totalLaptop',
            'laptopBaik',
            'laptopRusak',
            'laptopDiperbaiki',
            'tiketTotal',
            'tiketMenunggu',
            'tiketDiproses',
            'tiketSelesai',
            'laporanTerbaru',
            'maintenanceMendatang',
            'laptopRawan',
            'laptopDetail',
        ));
    }
}
