<?php

namespace App\Livewire\Kepala\Merek;

use App\Models\MerekLaptop;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public string $sortField = 'nama_merek';
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
        $merek = MerekLaptop::findOrFail($this->deletingId);

        if ($merek->laptops()->count() > 0) {
            session()->flash('error', 'Merek tidak dapat dihapus karena masih memiliki laptop terdaftar.');
            $this->deletingId = null;
            return;
        }

        $merek->delete();
        session()->flash('success', 'Merek berhasil dihapus.');
        $this->deletingId = null;
    }

    public function render()
    {
        $mereks = MerekLaptop::query()
            ->withCount('laptops')
            ->when($this->search, fn($q) => $q->where('nama_merek', 'like', "%{$this->search}%"))
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.kepala.merek.index', compact('mereks'));
    }
}
