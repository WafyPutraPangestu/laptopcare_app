<?php

namespace App\Livewire\Teknisi\Tiket;

use App\Models\LaporanKerusakan;
use App\Models\RiwayatPerbaikan;
use App\Models\Komponen;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;

#[Title('Tiket Masuk — Teknisi')]
class Index extends Component
{
    use WithPagination;

    // Filter & Search
    public string $search = '';
    public string $filterStatus = '';
    public string $filterPrioritas = '';

    // State Modal
    public bool $showModal = false;
    public ?int $activeLaporanId = null;

    // Form Fields
    public string $komponen_rusak = '';
    public ?int $id_komponen = null;
    public string $kategori_rusak = 'Hardware';
    public string $tingkat_kesulitan = 'Sedang';
    public string $tindakan_penyelesaian = '';
    public string $rekomendasi_perawatan = '';
    public ?float $biaya_perbaikan = null;
    public bool $apakah_terjadi_ulang = false;
    public string $spare_part_digunakan = '';
    public string $tgl_selesai = '';

    // Data tiket yang sedang diproses (untuk ditampilkan di modal)
    public array $activeTiket = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'filterStatus' => ['except' => ''],
        'filterPrioritas' => ['except' => ''],
    ];

    protected function rules(): array
    {
        return [
            'komponen_rusak'        => 'required|string|max:100',
            'id_komponen'           => 'nullable|exists:komponen,id_komponen',
            'kategori_rusak'        => 'required|in:Hardware,Software,Jaringan,Lainnya',
            'tingkat_kesulitan'     => 'required|in:Mudah,Sedang,Sulit',
            'tindakan_penyelesaian' => 'required|string',
            'rekomendasi_perawatan' => 'nullable|string',
            'biaya_perbaikan'       => 'nullable|numeric|min:0',
            'apakah_terjadi_ulang'  => 'boolean',
            'spare_part_digunakan'  => 'nullable|string|max:255',
            'tgl_selesai'           => 'required|date',
        ];
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingFilterStatus(): void
    {
        $this->resetPage();
    }

    public function updatingFilterPrioritas(): void
    {
        $this->resetPage();
    }

    /**
     * Buka modal dan load data tiket yang dipilih.
     */
    public function prosesTicket(int $id): void
    {
        $laporan = LaporanKerusakan::with(['laptop.merek', 'user'])->findOrFail($id);

        $this->activeLaporanId = $id;
        $this->activeTiket = [
            'id_laporan'       => $laporan->id_laporan,
            'kode_aset'        => $laporan->laptop->kode_aset,
            'merek'            => $laporan->laptop->merek->nama_merek,
            'tipe_model'       => $laporan->laptop->tipe_model,
            'nama_user'        => $laporan->user->nama_lengkap,
            'unit_kerja'       => $laporan->user->unit_kerja ?? '-',
            'keluhan_user'     => $laporan->keluhan_user,
            'prioritas'        => $laporan->prioritas,
            'tgl_lapor'        => $laporan->tgl_lapor->format('d M Y H:i'),
            'status_tiket'     => $laporan->status_tiket,
        ];

        // Reset form
        $this->reset([
            'komponen_rusak',
            'id_komponen',
            'kategori_rusak',
            'tingkat_kesulitan',
            'tindakan_penyelesaian',
            'rekomendasi_perawatan',
            'biaya_perbaikan',
            'apakah_terjadi_ulang',
            'spare_part_digunakan',
            'tgl_selesai',
        ]);
        $this->tgl_selesai = now()->format('Y-m-d');

        $this->showModal = true;
    }

    /**
     * Submit form perbaikan.
     */
    public function simpanPerbaikan(): void
    {
        $this->validate();

        $laporan = LaporanKerusakan::findOrFail($this->activeLaporanId);

        // Buat record riwayat perbaikan
        $tglMulai = $laporan->tgl_dikerjakan_teknisi ?? now();
        $tglSelesai = \Carbon\Carbon::parse($this->tgl_selesai);
        $durasi = (int) $tglMulai->diffInDays($tglSelesai);

        RiwayatPerbaikan::create([
            'id_laporan'            => $this->activeLaporanId,
            'id_teknisi'            => Auth::id(),
            'id_komponen'           => $this->id_komponen ?: null,
            'tgl_mulai_perbaikan'   => $tglMulai,
            'tgl_selesai'           => $tglSelesai,
            'durasi_perbaikan_hari' => $durasi,
            'kategori_rusak'        => $this->kategori_rusak,
            'komponen_rusak'        => $this->komponen_rusak,
            'tingkat_kesulitan'     => $this->tingkat_kesulitan,
            'tindakan_penyelesaian' => $this->tindakan_penyelesaian,
            'rekomendasi_perawatan' => $this->rekomendasi_perawatan ?: null,
            'biaya_perbaikan'       => $this->biaya_perbaikan,
            'apakah_terjadi_ulang'  => $this->apakah_terjadi_ulang,
            'spare_part_digunakan'  => $this->spare_part_digunakan ?: null,
        ]);

        // Update laporan kerusakan
        $laporan->update([
            'status_tiket'          => 'Selesai',
            'tgl_selesai_tiket'     => $tglSelesai,
        ]);

        // Update laptop status & maintenance date
        $laporan->laptop->update([
            'status_kondisi'        => 'Baik',
            'tgl_last_maintenance'  => $tglSelesai,
            'total_kerusakan_count' => $laporan->laptop->total_kerusakan_count + 1,
        ]);

        // Update frekuensi komponen jika dipilih
        if ($this->id_komponen) {
            $komponen = Komponen::find($this->id_komponen);
            $komponen?->increment('frekuensi_kerusakan');
        }

        $this->showModal = false;
        $this->activeLaporanId = null;
        $this->activeTiket = [];

        session()->flash('success', 'Tiket berhasil diselesaikan!');
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->activeLaporanId = null;
        $this->activeTiket = [];
    }

    public function render()
    {
        $tikets = LaporanKerusakan::with(['laptop.merek', 'user'])
            ->when($this->search, function ($q) {
                $q->where(function ($q2) {
                    $q2->whereHas('laptop', fn($q3) => $q3->where('kode_aset', 'like', "%{$this->search}%"))
                        ->orWhereHas('user', fn($q3) => $q3->where('nama_lengkap', 'like', "%{$this->search}%"))
                        ->orWhere('keluhan_user', 'like', "%{$this->search}%");
                });
            })
            ->when($this->filterStatus, fn($q) => $q->where('status_tiket', $this->filterStatus))
            ->when($this->filterPrioritas, fn($q) => $q->where('prioritas', $this->filterPrioritas))
            ->orderByRaw("FIELD(prioritas, 'Tinggi', 'Sedang', 'Rendah')")
            ->orderBy('tgl_lapor', 'asc')
            ->paginate(10);

        $komponen = Komponen::orderBy('nama_komponen')->get();

        $stats = [
            'menunggu'  => LaporanKerusakan::where('status_tiket', 'Menunggu')->count(),
            'diproses'  => LaporanKerusakan::where('status_tiket', 'Diproses')->count(),
            'selesai'   => LaporanKerusakan::where('status_tiket', 'Selesai')->count(),
            'urgent'    => LaporanKerusakan::where('prioritas', 'Tinggi')->whereIn('status_tiket', ['Menunggu', 'Diproses'])->count(),
        ];

        return view('livewire.teknisi.tiket.index', compact('tikets', 'komponen', 'stats'));
    }
}
