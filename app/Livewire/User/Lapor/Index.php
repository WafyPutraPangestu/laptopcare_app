<?php

namespace App\Livewire\User\Lapor;

use App\Models\LaporanKerusakan;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Laporan Saya')]
class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public string $filterStatus = '';
    public string $filterPrioritas = '';
    public string $sortBy = 'tgl_lapor';
    public string $sortDir = 'desc';

    public ?int $confirmCancelId = null;

    protected $queryString = [
        'search'          => ['except' => ''],
        'filterStatus'    => ['except' => ''],
        'filterPrioritas' => ['except' => ''],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function sort(string $column): void
    {
        $this->sortBy  = ($this->sortBy === $column) ? $this->sortBy  : $column;
        $this->sortDir = ($this->sortBy === $column && $this->sortDir === 'asc') ? 'desc' : 'asc';
        $this->sortBy  = $column;
    }

    public function confirmCancel(int $id): void
    {
        $laporan = LaporanKerusakan::where('id_laporan', $id)
            ->where('id_user', Auth::id())
            ->first();

        if ($laporan && $laporan->status_tiket === 'Menunggu') {
            $this->confirmCancelId = $id;
        }
    }

    public function cancelLaporan(): void
    {
        $laporan = LaporanKerusakan::where('id_laporan', $this->confirmCancelId)
            ->where('id_user', Auth::id())
            ->where('status_tiket', 'Menunggu')
            ->first();

        if ($laporan) {
            $laporan->delete();
            session()->flash('success', 'Laporan berhasil dibatalkan.');
        }

        $this->confirmCancelId = null;
    }

    public function render()
    {
        $laporan = LaporanKerusakan::with(['laptop.merek'])
            ->where('id_user', Auth::id())
            ->when($this->search, fn($q) => $q->where(function ($q) {
                $q->where('keluhan_user', 'like', "%{$this->search}%")
                    ->orWhereHas(
                        'laptop',
                        fn($q) => $q
                            ->where('kode_aset', 'like', "%{$this->search}%")
                            ->orWhere('tipe_model', 'like', "%{$this->search}%")
                    );
            }))
            ->when($this->filterStatus, fn($q) => $q->where('status_tiket', $this->filterStatus))
            ->when($this->filterPrioritas, fn($q) => $q->where('prioritas', $this->filterPrioritas))
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate(8);

        $stats = [
            'total'    => LaporanKerusakan::where('id_user', Auth::id())->count(),
            'menunggu' => LaporanKerusakan::where('id_user', Auth::id())->where('status_tiket', 'Menunggu')->count(),
            'diproses' => LaporanKerusakan::where('id_user', Auth::id())->where('status_tiket', 'Diproses')->count(),
            'selesai'  => LaporanKerusakan::where('id_user', Auth::id())->where('status_tiket', 'Selesai')->count(),
        ];

        return view('livewire.user.lapor.index', compact('laporan', 'stats'));
    }
}
