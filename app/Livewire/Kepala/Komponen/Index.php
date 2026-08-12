<?php

namespace App\Livewire\Kepala\Komponen;

use App\Models\Komponen;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public string $sortField = 'nama_komponen';
    public string $sortDirection = 'asc';
    public ?int $deletingId = null;

    protected $queryString = ['search'];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function confirmDelete(int $id): void
    {
        $this->deletingId = $id;
    }

    public function cancelDelete(): void
    {
        $this->deletingId = null;
    }

    public function delete(): void
    {
        $komponen = Komponen::findOrFail($this->deletingId);

        if ($komponen->riwayatPerbaikan()->count() > 0) {
            session()->flash('error', 'Komponen tidak dapat dihapus karena masih memiliki riwayat perbaikan.');
            $this->deletingId = null;
            return;
        }

        $komponen->delete();
        session()->flash('success', 'Komponen berhasil dihapus.');
        $this->deletingId = null;
    }

    public function render()
    {
        $komponens = Komponen::query()
            ->withCount('riwayatPerbaikan')
            ->when($this->search, fn($q) => $q->where('nama_komponen', 'like', "%{$this->search}%"))
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.kepala.komponen.index', compact('komponens'));
    }
}
