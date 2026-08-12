<?php

namespace App\Livewire\Kepala\Komponen;

use App\Models\Komponen;
use Livewire\Component;

class Create extends Component
{
    public string $nama_komponen = '';
    public string $kategori = 'Hardware';
    public int $frekuensi_kerusakan = 0;
    public string $deskripsi = '';
    public bool $is_critical = false;

    protected function rules(): array
    {
        return [
            'nama_komponen' => 'required|string|max:100|unique:komponen,nama_komponen',
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

    public function save(): void
    {
        $this->validate();

        Komponen::create([
            'nama_komponen'       => $this->nama_komponen,
            'kategori'            => $this->kategori,
            'frekuensi_kerusakan' => 0, // initial is always 0
            'deskripsi'           => $this->deskripsi ?: null,
            'is_critical'         => $this->is_critical,
        ]);

        session()->flash('success', "Komponen \"{$this->nama_komponen}\" berhasil ditambahkan.");
        $this->redirect(route('kepala.komponen.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.kepala.komponen.create');
    }
}
