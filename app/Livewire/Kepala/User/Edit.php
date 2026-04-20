<?php

namespace App\Livewire\Kepala\User;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Title;

#[Title('Edit User')]
class Edit extends Component
{
    public User $user;

    public string $nama_lengkap = '';
    public string $username = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $role = 'User';
    public string $unit_kerja = '';
    public bool $is_active = true;
    public bool $showPassword = false;
    public bool $changePassword = false;

    public function mount(User $user): void
    {
        $this->user = $user;
        $this->nama_lengkap = $user->nama_lengkap;
        $this->username = $user->username;
        $this->email = $user->email ?? '';
        $this->role = $user->role;
        $this->unit_kerja = $user->unit_kerja ?? '';
        $this->is_active = $user->is_active;
    }

    protected function rules(): array
    {
        $rules = [
            'nama_lengkap' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('users', 'username')->ignore($this->user->id_user, 'id_user')],
            'email' => ['nullable', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->user->id_user, 'id_user')],
            'role' => ['required', Rule::in(['User', 'Teknisi', 'Kepala_IT'])],
            'unit_kerja' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ];

        if ($this->changePassword) {
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        return $rules;
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

        $data = [
            'nama_lengkap' => $this->nama_lengkap,
            'username' => $this->username,
            'email' => $this->email ?: null,
            'role' => $this->role,
            'unit_kerja' => $this->unit_kerja ?: null,
            'is_active' => $this->is_active,
        ];

        if ($this->changePassword && $this->password) {
            $data['password'] = Hash::make($this->password);
        }

        $this->user->update($data);

        session()->flash('success', "User {$this->nama_lengkap} berhasil diperbarui.");
        $this->redirect(route('kepala.user.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.kepala.user.edit');
    }
}
