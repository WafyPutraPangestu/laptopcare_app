<?php

namespace App\Livewire\User\Lapor;

use App\Models\Laptop;
use App\Models\LaporanKerusakan;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Buat Laporan Kerusakan')]

class Create extends Component
{
    public string $id_laptop    = '';
    public string $keluhan_user = '';
    public string $prioritas    = 'Sedang';
    public string $area_kerja_user       = '';
    public string $dampak_produktivitas  = '';

    public function rules(): array
    {
        return [
            'id_laptop'             => 'required|exists:laptops,id_laptop',
            'keluhan_user'          => 'required|string|min:10|max:2000',
            'prioritas'             => 'required|in:Rendah,Sedang,Tinggi',
            'area_kerja_user'       => 'nullable|string|max:100',
            'dampak_produktivitas'  => 'nullable|string|max:500',
        ];
    }

    protected array $messages = [
        'id_laptop.required'    => 'Pilih laptop yang bermasalah.',
        'id_laptop.exists'      => 'Laptop tidak valid.',
        'keluhan_user.required' => 'Deskripsi keluhan wajib diisi.',
        'keluhan_user.min'      => 'Keluhan minimal 10 karakter.',
    ];

    public function save(): void
    {
        $this->validate();

        LaporanKerusakan::create([
            'id_laptop'            => $this->id_laptop,
            'id_user'              => Auth::id(),
            'keluhan_user'         => $this->keluhan_user,
            'prioritas'            => $this->prioritas,
            'area_kerja_user'      => $this->area_kerja_user ?: null,
            'dampak_produktivitas' => $this->dampak_produktivitas ?: null,
            'status_tiket'         => 'Menunggu',
        ]);

        // Naikkan counter kerusakan di laptop
        Laptop::where('id_laptop', $this->id_laptop)
            ->increment('total_kerusakan_count');

        session()->flash('success', 'Laporan kerusakan berhasil dikirim. Tim IT akan segera menghubungi Anda.');
        $this->redirect(route('user.lapor.index'), navigate: true);
    }

    public function render()
    {
        // Hanya laptop milik user yang login
        $laptops = Laptop::with('merek')
            ->where('id_user', Auth::id())
            ->where('status_kondisi', '!=', 'Dalam Perbaikan')
            ->orderBy('kode_aset')
            ->get();

        return view('livewire.user.lapor.create', compact('laptops'));
    }
}
