<?php

namespace App\Livewire\Kepala\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Manajemen User')]
class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public string $filterRole = '';
    public string $filterStatus = '';
    public string $sortBy = 'created_at';
    public string $sortDir = 'desc';

    public ?int $confirmDeleteId = null;
    public string $confirmDeleteName = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'filterRole' => ['except' => ''],
        'filterStatus' => ['except' => ''],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingFilterRole(): void
    {
        $this->resetPage();
    }

    public function updatingFilterStatus(): void
    {
        $this->resetPage();
    }

    public function sort(string $column): void
    {
        if ($this->sortBy === $column) {
            $this->sortDir = $this->sortDir === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDir = 'asc';
        }
    }

    public function confirmDelete(int $id, string $name): void
    {
        $this->confirmDeleteId = $id;
        $this->confirmDeleteName = $name;
    }

    public function cancelDelete(): void
    {
        $this->confirmDeleteId = null;
        $this->confirmDeleteName = '';
    }

    public function deleteUser(): void
    {
        $user = User::find($this->confirmDeleteId);

        if ($user && $user->id_user !== Auth::id()) {
            $user->delete();
            session()->flash('success', "User {$this->confirmDeleteName} berhasil dihapus.");
        }

        $this->cancelDelete();
    }

    public function toggleStatus(int $id): void
    {
        $user = User::find($id);
        if ($user && $user->id_user !== Auth::id()) {
            $user->update(['is_active' => !$user->is_active]);
        }
    }

    public function render()
    {
        $users = User::query()
            ->when($this->search, fn($q) => $q->where(function ($q) {
                $q->where('nama_lengkap', 'like', "%{$this->search}%")
                    ->orWhere('username', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%")
                    ->orWhere('unit_kerja', 'like', "%{$this->search}%");
            }))
            ->when($this->filterRole, fn($q) => $q->where('role', $this->filterRole))
            ->when($this->filterStatus !== '', fn($q) => $q->where('is_active', $this->filterStatus === '1'))
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate(10);

        $stats = [
            'total' => User::count(),
            'active' => User::where('is_active', true)->count(),
            'teknisi' => User::where('role', 'Teknisi')->count(),
            'kepala' => User::where('role', 'Kepala_IT')->count(),
        ];

        return view('livewire.kepala.user.index', compact('users', 'stats'));
    }
}
