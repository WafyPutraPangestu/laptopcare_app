<?php

namespace App\Livewire\Kepala\Maintenance;

use App\Models\JadwalMaintenance;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Edit Jadwal Maintenance')]

class Edit extends Component
{
    public JadwalMaintenance $jadwal;

    public ?int $id_teknisi = null;
    public string $tipe_maintenance = 'Rutin';
    public string $status = 'Dijadwalkan';
    public string $tgl_jadwal_maintenance = '';
    public string $tgl_selesai_maintenance = '';
    public string $deskripsi_maintenance = '';
    public string $catatan_teknisi = '';
    public string $hasil_maintenance = '';
    public ?int $durasi_hari = null;
    public ?float $biaya_maintenance = null;

    protected function rules(): array
    {
        return [
            'id_teknisi'             => 'nullable|exists:users,id_user',
            'tipe_maintenance'       => 'required|in:Rutin,Darurat,Preventif',
            'status'                 => 'required|in:Dijadwalkan,Selesai,Dibatalkan',
            'tgl_jadwal_maintenance' => 'required|date',
            'tgl_selesai_maintenance' => 'nullable|date|after_or_equal:tgl_jadwal_maintenance',
            'deskripsi_maintenance'  => 'nullable|string|max:2000',
            'catatan_teknisi'        => 'nullable|string|max:2000',
            'hasil_maintenance'      => 'nullable|string|max:2000',
            'durasi_hari'            => 'nullable|integer|min:1',
            'biaya_maintenance'      => 'nullable|numeric|min:0',
        ];
    }

    public function mount(int $id): void
    {
        $this->jadwal = JadwalMaintenance::with(['laptop', 'teknisi'])->findOrFail($id);

        $this->id_teknisi              = $this->jadwal->id_teknisi;
        $this->tipe_maintenance        = $this->jadwal->tipe_maintenance;
        $this->status                  = $this->jadwal->status;
        $this->tgl_jadwal_maintenance  = $this->jadwal->tgl_jadwal_maintenance->format('Y-m-d\TH:i');
        $this->tgl_selesai_maintenance = $this->jadwal->tgl_selesai_maintenance
            ? $this->jadwal->tgl_selesai_maintenance->format('Y-m-d\TH:i')
            : '';
        $this->deskripsi_maintenance   = $this->jadwal->deskripsi_maintenance ?? '';
        $this->catatan_teknisi         = $this->jadwal->catatan_teknisi ?? '';
        $this->hasil_maintenance       = $this->jadwal->hasil_maintenance ?? '';
        $this->durasi_hari             = $this->jadwal->durasi_hari;
        $this->biaya_maintenance       = $this->jadwal->biaya_maintenance;
    }

    public function update(): void
    {
        $this->validate();

        $this->jadwal->update([
            'id_teknisi'              => $this->id_teknisi ?: null,
            'tipe_maintenance'        => $this->tipe_maintenance,
            'status'                  => $this->status,
            'tgl_jadwal_maintenance'  => $this->tgl_jadwal_maintenance,
            'tgl_selesai_maintenance' => $this->tgl_selesai_maintenance ?: null,
            'deskripsi_maintenance'   => $this->deskripsi_maintenance,
            'catatan_teknisi'         => $this->catatan_teknisi,
            'hasil_maintenance'       => $this->hasil_maintenance,
            'durasi_hari'             => $this->durasi_hari,
            'biaya_maintenance'       => $this->biaya_maintenance,
        ]);

        session()->flash('success', 'Jadwal maintenance berhasil diperbarui.');
        $this->redirect(route('kepala.maintenance.index'), navigate: true);
    }

    public function render()
    {
        $teknisis = User::where('role', 'Teknisi')->orderBy('nama_lengkap')->get(['id_user', 'nama_lengkap']);

        return view('livewire.kepala.maintenance.edit', [
            'jadwal'   => $this->jadwal,
            'teknisis' => $teknisis,
        ]);
    }
}
