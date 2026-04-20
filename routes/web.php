<?php

use App\Livewire\Home;
use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\Login;
use App\Livewire\Kepala\Dashboard as KepalaDashboard;
use App\Livewire\Kepala\Laporan;
use App\Livewire\Kepala\Maintenance\Create as MaintenanceCreate;
use App\Livewire\Kepala\Maintenance\Edit as MaintenanceEdit;
use App\Livewire\Kepala\Maintenance\Index as MaintenanceIndex;
use App\Livewire\Kepala\User\Create as UserCreate;
use App\Livewire\Kepala\User\Edit as UserEdit;
use App\Livewire\Kepala\User\Index as UserIndex;
use App\Livewire\Teknisi\Dashboard as TeknisiDashboard;
use App\Livewire\User\Dashboard;
use App\Livewire\User\Lapor\Create as LaporCreate;
use App\Livewire\User\Lapor\Edit as LaporEdit;
use App\Livewire\User\Lapor\Index as LaporIndex;

Route::get('/', Home::class);

// Auth Routes
// Route::get('/login', Login::class)->name('login');
Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
});

Route::middleware(['user'])->group(function () {
    Route::get('user/dashboard', Dashboard::class)->name('user.dashboard');
    Route::get('/laporan',                LaporIndex::class)->name('user.lapor.index');
    Route::get('/laporan/buat',           LaporCreate::class)->name('user.lapor.create');
    Route::get('/laporan/{laporan}/edit', LaporEdit::class)->name('user.lapor.edit');
});

Route::middleware(['teknisi'])->group(function () {
    Route::get('/teknisi/dashboard', TeknisiDashboard::class)->name('teknisi.dashboard');
    Route::get('/teknisi/tiket', \App\Livewire\Teknisi\Tiket\Index::class)->name('teknisi.tiket.index');
    Route::get('/teknisi/jadwal', \App\Livewire\Teknisi\Jadwal\Index::class)->name('teknisi.jadwal.index');
});
Route::middleware(['kepala_it'])->group(function () {
    Route::get('/kepala/dashboard', KepalaDashboard::class)->name('kepala.dashboard');
    Route::prefix('kepala/laptop')->name('kepala.laptop.')->group(function () {
        Route::get('/',           \App\Livewire\Kepala\Laptop\Index::class)->name('index');
        Route::get('/create',     \App\Livewire\Kepala\Laptop\Create::class)->name('create');
        Route::get('/{laptop}/edit', \App\Livewire\Kepala\Laptop\Edit::class)->name('edit');
    });
    Route::get('/kepala/laporan', Laporan::class)->name('kepala.laporan');
    Route::get('/kepala/maintenance', MaintenanceIndex::class)->name('kepala.maintenance.index');
    Route::get('/kepala/maintenance/create', MaintenanceCreate::class)->name('kepala.maintenance.create');
    Route::get('/kepala/maintenance/{id}/edit', MaintenanceEdit::class)->name('kepala.maintenance.edit');
    Route::get('/kepala/merek', \App\Livewire\Kepala\Merek\Index::class)->name('kepala.merek.index');
    Route::get('/kepala/merek/create', \App\Livewire\Kepala\Merek\Create::class)->name('kepala.merek.create');
    Route::get('/kepala/merek/{merek}/edit', \App\Livewire\Kepala\Merek\Edit::class)->name('kepala.merek.edit');
    Route::get('/kepala/user', UserIndex::class)->name('kepala.user.index');
    Route::get('/kepala/user/create', UserCreate::class)->name('kepala.user.create');
    Route::get('/kepala/user/{user}/edit', UserEdit::class)->name('kepala.user.edit');
});
