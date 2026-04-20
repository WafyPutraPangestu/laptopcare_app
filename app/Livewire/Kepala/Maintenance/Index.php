<?php

namespace App\Livewire\Kepala\Maintenance;

use App\Models\JadwalMaintenance;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Jadwal Maintenance')]
class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public string $filterStatus = '';
    public string $filterTipe = '';
    public string $sortBy = 'tgl_jadwal_maintenance';
    public string $sortDir = 'desc';
    public bool $confirmingDelete = false;
    public ?int $deleteId = null;

    protected $queryString = [
        'search'       => ['except' => ''],
        'filterStatus' => ['except' => ''],
        'filterTipe'   => ['except' => ''],
        'sortBy'       => ['except' => 'tgl_jadwal_maintenance'],
        'sortDir'      => ['except' => 'desc'],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingFilterStatus(): void
    {
        $this->resetPage();
    }

    public function updatingFilterTipe(): void
    {
        $this->resetPage();
    }

    public function sortBy(string $column): void
    {
        if ($this->sortBy === $column) {
            $this->sortDir = $this->sortDir === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy  = $column;
            $this->sortDir = 'asc';
        }
    }

    public function resetFilter(): void
    {
        $this->reset(['search', 'filterStatus', 'filterTipe']);
        $this->resetPage();
    }

    public function confirmDelete(int $id): void
    {
        $this->deleteId        = $id;
        $this->confirmingDelete = true;
    }

    public function deleteJadwal(): void
    {
        if ($this->deleteId) {
            JadwalMaintenance::findOrFail($this->deleteId)->delete();
            session()->flash('success', 'Jadwal maintenance berhasil dihapus.');
        }

        $this->confirmingDelete = false;
        $this->deleteId         = null;
    }

    public function render()
    {
        $jadwals = JadwalMaintenance::with(['laptop', 'teknisi'])
            ->when($this->search, function ($q) {
                $q->whereHas('laptop', fn($l) => $l->where('kode_aset', 'like', "%{$this->search}%")
                    ->orWhere('tipe_model', 'like', "%{$this->search}%"))
                    ->orWhereHas('teknisi', fn($t) => $t->where('nama_lengkap', 'like', "%{$this->search}%"));
            })
            ->when($this->filterStatus, fn($q) => $q->where('status', $this->filterStatus))
            ->when($this->filterTipe,   fn($q) => $q->where('tipe_maintenance', $this->filterTipe))
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate(10);

        return view('livewire.kepala.maintenance.index', compact('jadwals'));
    }
}
