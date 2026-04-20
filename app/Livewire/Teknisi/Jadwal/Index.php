<?php

namespace App\Livewire\Teknisi\Jadwal;

use App\Models\JadwalMaintenance;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

// #[Layout('layouts.app.blade.php')]
#[Title('Jadwal Maintenance — Teknisi')]
class Index extends Component
{
    use WithPagination;

    public string $activeTab = 'Dijadwalkan';
    public string $search = '';
    public string $filterTipe = '';
    public ?int $selectedJadwalId = null;
    public bool $showDetailModal = false;

    // Form update status
    public string $statusBaru = '';
    public string $catatanTeknisi = '';
    public string $hasilMaintenance = '';

    protected $queryString = [
        'activeTab' => ['except' => 'Dijadwalkan'],
        'search' => ['except' => ''],
        'filterTipe' => ['except' => ''],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingFilterTipe(): void
    {
        $this->resetPage();
    }

    public function setTab(string $tab): void
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }

    public function openDetail(int $id): void
    {
        $this->selectedJadwalId = $id;
        $jadwal = JadwalMaintenance::find($id);
        if ($jadwal) {
            $this->catatanTeknisi = $jadwal->catatan_teknisi ?? '';
            $this->hasilMaintenance = $jadwal->hasil_maintenance ?? '';
            $this->statusBaru = $jadwal->status;
        }
        $this->showDetailModal = true;
    }

    public function closeModal(): void
    {
        $this->showDetailModal = false;
        $this->selectedJadwalId = null;
        $this->resetForm();
    }

    public function updateStatus(): void
    {
        $this->validate([
            'statusBaru' => 'required|in:Dijadwalkan,Selesai,Dibatalkan',
            'catatanTeknisi' => 'nullable|string|max:1000',
            'hasilMaintenance' => 'nullable|string|max:1000',
        ]);

        $jadwal = JadwalMaintenance::findOrFail($this->selectedJadwalId);

        $data = [
            'status' => $this->statusBaru,
            'catatan_teknisi' => $this->catatanTeknisi,
            'hasil_maintenance' => $this->hasilMaintenance,
        ];

        if ($this->statusBaru === 'Selesai' && !$jadwal->tgl_selesai_maintenance) {
            $data['tgl_selesai_maintenance'] = now();
            if ($jadwal->tgl_jadwal_maintenance) {
                $data['durasi_hari'] = now()->diffInDays($jadwal->tgl_jadwal_maintenance);
            }
        }

        $jadwal->update($data);

        // Update last maintenance date on laptop if completed
        if ($this->statusBaru === 'Selesai') {
            $jadwal->laptop()->update(['tgl_last_maintenance' => now()]);
        }

        $this->closeModal();
        session()->flash('success', 'Status jadwal berhasil diperbarui.');
    }

    private function resetForm(): void
    {
        $this->statusBaru = '';
        $this->catatanTeknisi = '';
        $this->hasilMaintenance = '';
    }

    public function getSelectedJadwalProperty()
    {
        if (!$this->selectedJadwalId) return null;
        return JadwalMaintenance::with(['laptop.merek', 'laptop.user'])->find($this->selectedJadwalId);
    }

    public function getCountsProperty(): array
    {
        $teknisiId = Auth::id();
        return [
            'Dijadwalkan' => JadwalMaintenance::where('id_teknisi', $teknisiId)->where('status', 'Dijadwalkan')->count(),
            'Selesai'     => JadwalMaintenance::where('id_teknisi', $teknisiId)->where('status', 'Selesai')->count(),
            'Dibatalkan'  => JadwalMaintenance::where('id_teknisi', $teknisiId)->where('status', 'Dibatalkan')->count(),
        ];
    }

    public function render()
    {
        $teknisiId = Auth::id();

        $jadwals = JadwalMaintenance::with(['laptop.merek', 'laptop.user'])
            ->where('id_teknisi', $teknisiId)
            ->where('status', $this->activeTab)
            ->when($this->filterTipe, fn($q) => $q->where('tipe_maintenance', $this->filterTipe))
            ->when($this->search, function ($q) {
                $q->whereHas('laptop', function ($lq) {
                    $lq->where('kode_aset', 'like', "%{$this->search}%")
                        ->orWhere('tipe_model', 'like', "%{$this->search}%")
                        ->orWhereHas('merek', fn($mq) => $mq->where('nama_merek', 'like', "%{$this->search}%"));
                })->orWhere('deskripsi_maintenance', 'like', "%{$this->search}%");
            })
            ->orderBy('tgl_jadwal_maintenance', $this->activeTab === 'Dijadwalkan' ? 'asc' : 'desc')
            ->paginate(10);

        return view('livewire.teknisi.jadwal.index', [
            'jadwals' => $jadwals,
            'counts'  => $this->counts,
        ]);
    }
}
