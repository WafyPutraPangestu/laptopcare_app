<?php

namespace App\Livewire\Kepala\Laptop;

use App\Models\Laptop;
use App\Models\MerekLaptop;
use App\Models\User;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Manajemen Laptop')]
class Index extends Component
{
    use WithPagination;

    // Search & Filter
    public string $search = '';
    public string $filterStatus = '';
    public string $filterMerek = '';
    public string $sortBy = 'created_at';
    public string $sortDir = 'desc';

    // Delete confirmation
    public ?int $confirmDeleteId = null;
    public string $confirmDeleteKode = '';

    // Flash message
    public string $flashMessage = '';
    public string $flashType = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'filterStatus' => ['except' => ''],
        'filterMerek' => ['except' => ''],
        'sortBy' => ['except' => 'created_at'],
        'sortDir' => ['except' => 'desc'],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingFilterStatus(): void
    {
        $this->resetPage();
    }

    public function updatingFilterMerek(): void
    {
        $this->resetPage();
    }

    public function sortBy(string $column): void
    {
        if ($this->sortBy === $column) {
            $this->sortDir = $this->sortDir === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDir = 'asc';
        }
        $this->resetPage();
    }

    public function confirmDelete(int $id, string $kode): void
    {
        $this->confirmDeleteId = $id;
        $this->confirmDeleteKode = $kode;
    }

    public function cancelDelete(): void
    {
        $this->confirmDeleteId = null;
        $this->confirmDeleteKode = '';
    }

    public function deleteLaptop(): void
    {
        if (!$this->confirmDeleteId) return;

        $laptop = Laptop::find($this->confirmDeleteId);

        if ($laptop) {
            $kode = $laptop->kode_aset;
            $laptop->delete();
            $this->flashMessage = "Laptop {$kode} berhasil dihapus.";
            $this->flashType = 'success';
        } else {
            $this->flashMessage = 'Laptop tidak ditemukan.';
            $this->flashType = 'error';
        }

        $this->confirmDeleteId = null;
        $this->confirmDeleteKode = '';
        $this->resetPage();
    }

    public function clearFlash(): void
    {
        $this->flashMessage = '';
        $this->flashType = '';
    }

    public function render()
    {
        $laptops = Laptop::with(['user', 'merek'])
            ->when($this->search, function ($q) {
                $q->where(function ($inner) {
                    $inner->where('kode_aset', 'like', "%{$this->search}%")
                        ->orWhere('tipe_model', 'like', "%{$this->search}%")
                        ->orWhere('nomor_seri', 'like', "%{$this->search}%")
                        ->orWhereHas('user', fn($u) => $u->where('nama_lengkap', 'like', "%{$this->search}%"))
                        ->orWhereHas('merek', fn($m) => $m->where('nama_merek', 'like', "%{$this->search}%"));
                });
            })
            ->when($this->filterStatus, fn($q) => $q->where('status_kondisi', $this->filterStatus))
            ->when($this->filterMerek, fn($q) => $q->where('id_merek', $this->filterMerek))
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate(12);

        $mereks = MerekLaptop::orderBy('nama_merek')->get();

        $stats = [
            'total'      => Laptop::count(),
            'baik'       => Laptop::where('status_kondisi', 'Baik')->count(),
            'rusak'      => Laptop::where('status_kondisi', 'Rusak')->count(),
            'perbaikan'  => Laptop::where('status_kondisi', 'Dalam Perbaikan')->count(),
        ];

        return view('livewire.kepala.laptop.index', compact('laptops', 'mereks', 'stats'));
    }
}
