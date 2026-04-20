<?php

namespace App\Livewire\Kepala\Laptop;

use App\Models\Laptop;
use App\Models\MerekLaptop;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Tambah Laptop')]
class Create extends Component
{
    // Form fields
    public string $kode_aset = '';
    public ?int $id_user = null;
    public int $id_merek;
    public string $tipe_model = '';
    public string $nomor_seri = '';
    public string $tgl_pengadaan = '';
    public string $status_kondisi = 'Baik';
    public string $nilai_aset = '';
    public string $catatan = '';

    protected function rules(): array
    {
        return [
            'kode_aset'      => 'required|string|max:50|unique:laptops,kode_aset',
            'id_user'        => 'nullable|exists:users,id_user',
            'id_merek'       => 'required|exists:merek_laptop,id_merek',
            'tipe_model'     => 'required|string|max:100',
            'nomor_seri'     => 'nullable|string|max:100',
            'tgl_pengadaan'  => 'required|date',
            'status_kondisi' => 'required|in:Baik,Rusak,Dalam Perbaikan',
            'nilai_aset'     => 'nullable|numeric|min:0',
            'catatan'        => 'nullable|string',
        ];
    }

    protected $messages = [
        'kode_aset.required'     => 'Kode aset wajib diisi.',
        'kode_aset.unique'       => 'Kode aset sudah digunakan.',
        'id_merek.required'      => 'Merek wajib dipilih.',
        'tipe_model.required'    => 'Tipe/model wajib diisi.',
        'tgl_pengadaan.required' => 'Tanggal pengadaan wajib diisi.',
        'tgl_pengadaan.date'     => 'Format tanggal tidak valid.',
        'nilai_aset.numeric'     => 'Nilai aset harus berupa angka.',
    ];

    public function mount(): void
    {
        $this->tgl_pengadaan = now()->format('Y-m-d');
        $firstMerek = MerekLaptop::first();
        $this->id_merek = $firstMerek?->id_merek ?? 0;
    }

    // Real-time validation
    public function updated(string $field): void
    {
        $this->validateOnly($field);
    }

    public function save(): void
    {
        $validated = $this->validate();

        if (empty($validated['nilai_aset'])) {
            $validated['nilai_aset'] = null;
        }

        $laptop = Laptop::create($validated);

        session()->flash('flash_message', "Laptop {$laptop->kode_aset} berhasil ditambahkan.");
        session()->flash('flash_type', 'success');

        $this->redirect(route('kepala.laptop.index'), navigate: true);
    }

    public function render()
    {
        $mereks = MerekLaptop::orderBy('nama_merek')->get();
        $users  = User::where('role', 'User')->orderBy('nama_lengkap')->get();

        return view('livewire.kepala.laptop.create', compact('mereks', 'users'));
    }
}
