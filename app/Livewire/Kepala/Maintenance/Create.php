<?php

namespace App\Livewire\Kepala\Maintenance;

use App\Models\JadwalMaintenance;
use App\Models\Laptop;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Buat Jadwal Maintenance')]
class Create extends Component
{
    public ?int $id_laptop = null;
    public ?int $id_teknisi = null;
    public string $tipe_maintenance = 'Rutin';
    public string $tgl_jadwal_maintenance = '';
    public string $tgl_selesai_maintenance = '';
    public string $deskripsi_maintenance = '';
    public ?int $durasi_hari = null;
    public ?float $biaya_maintenance = null;

    protected function rules(): array
    {
        return [
            'id_laptop'              => 'required|exists:laptops,id_laptop',
            'id_teknisi'             => 'nullable|exists:users,id_user',
            'tipe_maintenance'       => 'required|in:Rutin,Darurat,Preventif',
            'tgl_jadwal_maintenance' => 'required|date',
            'tgl_selesai_maintenance' => 'nullable|date|after_or_equal:tgl_jadwal_maintenance',
            'deskripsi_maintenance'  => 'nullable|string|max:2000',
            'durasi_hari'            => 'nullable|integer|min:1',
            'biaya_maintenance'      => 'nullable|numeric|min:0',
        ];
    }

    protected array $messages = [
        'id_laptop.required'              => 'Pilih laptop terlebih dahulu.',
        'tgl_jadwal_maintenance.required' => 'Tanggal jadwal wajib diisi.',
        'tgl_selesai_maintenance.after_or_equal' => 'Tanggal selesai harus setelah tanggal mulai.',
    ];

    public function save(): void
    {
        $this->validate();

        JadwalMaintenance::create([
            'id_laptop'               => $this->id_laptop,
            'id_teknisi'              => $this->id_teknisi ?: null,
            'tipe_maintenance'        => $this->tipe_maintenance,
            'tgl_jadwal_maintenance'  => $this->tgl_jadwal_maintenance,
            'tgl_selesai_maintenance' => $this->tgl_selesai_maintenance ?: null,
            'deskripsi_maintenance'   => $this->deskripsi_maintenance,
            'durasi_hari'             => $this->durasi_hari,
            'biaya_maintenance'       => $this->biaya_maintenance,
            'status'                  => 'Dijadwalkan',
        ]);

        session()->flash('success', 'Jadwal maintenance berhasil dibuat.');
        $this->redirect(route('kepala.maintenance.index'), navigate: true);
    }

    public function render()
    {
        $laptops  = Laptop::orderBy('kode_aset')->get(['id_laptop', 'kode_aset', 'tipe_model']);
        $teknisis = User::where('role', 'Teknisi')->orderBy('nama_lengkap')->get(['id_user', 'nama_lengkap']);

        return view('livewire.kepala.maintenance.create', compact('laptops', 'teknisis'));
    }
}
