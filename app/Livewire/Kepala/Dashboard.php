<?php

namespace App\Livewire\Kepala;

use Livewire\Component;
use App\Models\Laptop;
use App\Models\LaporanKerusakan;
use App\Models\JadwalMaintenance;
use App\Models\RiwayatPerbaikan;

class Dashboard extends Component
{
    public function render()
    {
        $stats = [
            'total_laptop'      => Laptop::count(),
            'laptop_baik'       => Laptop::where('status_kondisi', 'Baik')->count(),
            'laptop_rusak'      => Laptop::where('status_kondisi', 'Rusak')->count(),
            'laptop_perbaikan'  => Laptop::where('status_kondisi', 'Dalam Perbaikan')->count(),
            'tiket_menunggu'    => LaporanKerusakan::where('status_tiket', 'Menunggu')->count(),
            'tiket_diproses'    => LaporanKerusakan::where('status_tiket', 'Diproses')->count(),
            'tiket_selesai_bulan' => LaporanKerusakan::where('status_tiket', 'Selesai')
                ->whereMonth('tgl_selesai_tiket', now()->month)
                ->whereYear('tgl_selesai_tiket', now()->year)
                ->count(),
            'jadwal_upcoming'   => JadwalMaintenance::where('status', 'Dijadwalkan')
                ->where('tgl_jadwal_maintenance', '>=', now())
                ->count(),
        ];

        // Kerusakan per bulan tahun ini
        $chartData = collect(range(1, 12))->map(
            fn($m) =>
            RiwayatPerbaikan::whereYear('tgl_selesai', now()->year)
                ->whereMonth('tgl_selesai', $m)
                ->count()
        )->values()->toArray();

        // 5 laporan terbaru
        $laporanTerbaru = LaporanKerusakan::with(['user', 'laptop.merek'])
            ->latest('tgl_lapor')
            ->limit(5)
            ->get();

        // Jadwal maintenance upcoming
        $jadwalUpcoming = JadwalMaintenance::with(['laptop', 'teknisi'])
            ->where('status', 'Dijadwalkan')
            ->where('tgl_jadwal_maintenance', '>=', now())
            ->orderBy('tgl_jadwal_maintenance')
            ->limit(4)
            ->get();

        return view('livewire.kepala.dashboard', compact(
            'stats',
            'chartData',
            'laporanTerbaru',
            'jadwalUpcoming'
        ));
    }
}
