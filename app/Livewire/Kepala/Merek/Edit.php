<?php

namespace App\Livewire\Kepala\Merek;

use App\Models\MerekLaptop;
use Livewire\Component;

class Edit extends Component
{
    public MerekLaptop $merek;

    public string $nama_merek = '';
    public string $tahun_rilis = '';
    public int $rata_usia_optimal = 5;
    public string $spesifikasi = '';

    public function mount(MerekLaptop $merek): void
    {
        $this->merek           = $merek;
        $this->nama_merek      = $merek->nama_merek;
        $this->tahun_rilis     = $merek->tahun_rilis ?? '';
        $this->rata_usia_optimal = $merek->rata_usia_optimal;
        $this->spesifikasi     = $merek->spesifikasi ?? '';
    }

    protected function rules(): array
    {
        return [
            'nama_merek'        => "required|string|max:100|unique:merek_laptop,nama_merek,{$this->merek->id_merek},id_merek",
            'tahun_rilis'       => 'nullable|digits:4|integer|min:1990|max:' . date('Y'),
            'rata_usia_optimal' => 'required|integer|min:1|max:20',
            'spesifikasi'       => 'nullable|string',
        ];
    }

    protected $messages = [
        'nama_merek.required' => 'Nama merek wajib diisi.',
        'nama_merek.unique'   => 'Nama merek sudah terdaftar.',
        'tahun_rilis.digits'  => 'Tahun rilis harus 4 digit.',
        'rata_usia_optimal.required' => 'Rata usia optimal wajib diisi.',
    ];

    public function update(): void
    {
        $this->validate();

        $this->merek->update([
            'nama_merek'        => $this->nama_merek,
            'tahun_rilis'       => $this->tahun_rilis ?: null,
            'rata_usia_optimal' => $this->rata_usia_optimal,
            'spesifikasi'       => $this->spesifikasi ?: null,
        ]);

        session()->flash('success', "Merek \"{$this->nama_merek}\" berhasil diperbarui.");
        $this->redirect(route('kepala.merek.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.kepala.merek.edit');
    }
}
