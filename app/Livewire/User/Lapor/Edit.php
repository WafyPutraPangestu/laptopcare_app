<?php

namespace App\Livewire\User\Lapor;

use App\Models\LaporanKerusakan;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Edit Laporan')]
class Edit extends Component
{
    public LaporanKerusakan $laporan;

    public string $keluhan_user         = '';
    public string $prioritas            = 'Sedang';
    public string $area_kerja_user      = '';
    public string $dampak_produktivitas = '';

    public function mount(LaporanKerusakan $laporan): void
    {
        // Pastikan laporan milik user yang login & masih bisa diedit
        abort_if(
            $laporan->id_user !== Auth::id() || $laporan->status_tiket !== 'Menunggu',
            403,
            'Laporan tidak dapat diedit.'
        );

        $this->laporan              = $laporan;
        $this->keluhan_user         = $laporan->keluhan_user;
        $this->prioritas            = $laporan->prioritas;
        $this->area_kerja_user      = $laporan->area_kerja_user ?? '';
        $this->dampak_produktivitas = $laporan->dampak_produktivitas ?? '';
    }

    public function rules(): array
    {
        return [
            'keluhan_user'         => 'required|string|min:10|max:2000',
            'prioritas'            => 'required|in:Rendah,Sedang,Tinggi',
            'area_kerja_user'      => 'nullable|string|max:100',
            'dampak_produktivitas' => 'nullable|string|max:500',
        ];
    }

    protected array $messages = [
        'keluhan_user.required' => 'Deskripsi keluhan wajib diisi.',
        'keluhan_user.min'      => 'Keluhan minimal 10 karakter.',
    ];

    public function save(): void
    {
        // Double-check status masih Menunggu sebelum simpan
        abort_if($this->laporan->fresh()->status_tiket !== 'Menunggu', 403);

        $this->validate();

        $this->laporan->update([
            'keluhan_user'         => $this->keluhan_user,
            'prioritas'            => $this->prioritas,
            'area_kerja_user'      => $this->area_kerja_user ?: null,
            'dampak_produktivitas' => $this->dampak_produktivitas ?: null,
        ]);

        session()->flash('success', 'Laporan berhasil diperbarui.');
        $this->redirect(route('user.lapor.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.user.lapor.edit');
    }
}
