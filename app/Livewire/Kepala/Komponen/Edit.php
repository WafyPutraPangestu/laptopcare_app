<?php

namespace App\Livewire\Kepala\Komponen;

use App\Models\Komponen;
use Livewire\Component;

class Edit extends Component
{
    public Komponen $komponen;

    public string $nama_komponen = '';
    public string $kategori = 'Hardware';
    public string $deskripsi = '';
    public bool $is_critical = false;

    public function mount(Komponen $komponen): void
    {
        $this->komponen      = $komponen;
        $this->nama_komponen = $komponen->nama_komponen;
        $this->kategori      = $komponen->kategori;
        $this->deskripsi     = $komponen->deskripsi ?? '';
        $this->is_critical   = $komponen->is_critical;
    }

    protected function rules(): array
    {
        return [
            'nama_komponen' => "required|string|max:100|unique:komponen,nama_komponen,{$this->komponen->id_komponen},id_komponen",
            'kategori'      => 'required|in:Hardware,Software,Jaringan,Lainnya',
            'deskripsi'     => 'nullable|string',
            'is_critical'   => 'boolean',
        ];
    }

    protected $messages = [
        'nama_komponen.required' => 'Nama komponen wajib diisi.',
        'nama_komponen.unique'   => 'Nama komponen sudah terdaftar.',
        'kategori.required'      => 'Kategori wajib diisi.',
        'kategori.in'            => 'Kategori tidak valid.',
    ];

    public function update(): void
    {
        $this->validate();

        $this->komponen->update([
            'nama_komponen' => $this->nama_komponen,
            'kategori'      => $this->kategori,
            'deskripsi'     => $this->deskripsi ?: null,
            'is_critical'   => $this->is_critical,
        ]);

        session()->flash('success', "Komponen \"{$this->nama_komponen}\" berhasil diperbarui.");
        $this->redirect(route('kepala.komponen.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.kepala.komponen.edit');
    }
}
