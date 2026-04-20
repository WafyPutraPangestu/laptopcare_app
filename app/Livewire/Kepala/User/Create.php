<?php

namespace App\Livewire\Kepala\User;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Title;

#[Title('Buat User Baru')]
class Create extends Component
{
    public string $nama_lengkap = '';
    public string $username = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $role = 'User';
    public string $unit_kerja = '';
    public bool $is_active = true;
    public bool $showPassword = false;

    protected function rules(): array
    {
        return [
            'nama_lengkap' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'nullable|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => ['required', Rule::in(['User', 'Teknisi', 'Kepala_IT'])],
            'unit_kerja' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ];
    }

    protected array $messages = [
        'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
        'username.required' => 'Username wajib diisi.',
        'username.unique' => 'Username sudah digunakan.',
        'email.unique' => 'Email sudah digunakan.',
        'password.required' => 'Password wajib diisi.',
        'password.min' => 'Password minimal 8 karakter.',
        'password.confirmed' => 'Konfirmasi password tidak cocok.',
    ];

    public function toggleShowPassword(): void
    {
        $this->showPassword = !$this->showPassword;
    }

    public function save(): void
    {
        $this->validate();

        User::create([
            'nama_lengkap' => $this->nama_lengkap,
            'username' => $this->username,
            'email' => $this->email ?: null,
            'password' => Hash::make($this->password),
            'role' => $this->role,
            'unit_kerja' => $this->unit_kerja ?: null,
            'is_active' => $this->is_active,
        ]);

        session()->flash('success', "User {$this->nama_lengkap} berhasil dibuat.");
        $this->redirect(route('kepala.user.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.kepala.user.create');
    }
}
