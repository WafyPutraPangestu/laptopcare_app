<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <button class="button-v2">
        Klik Saya
    </button>

    <button class="button-v2 variant-outline">
        Outline Button
    </button>

    <button class="button-v2 size-lg is-block">
        Daftar Sekarang
    </button>

    <button class="button-secondary">
        Batal
    </button>

    <div class="card">
        <h2 class="text-primary font-bold">Judul Card</h2>
        <p class="text-secondary">Ini adalah isi konten card dengan warna teks sekunder.</p>
    </div>

    <div class="card-dark">
        <p>Card ini punya background biru gelap dan teks terang.</p>
    </div>

    <div class="bg-secondary p-6">
        <h1 class="text-primary">Gunakan class .text-primary</h1>
        <p class="text-success">Operasi Berhasil (Warna Hijau)</p>
        <p class="text-error">Terjadi Kesalahan (Warna Merah)</p>
    </div>

    <div class="card shadow-blue-glow">
        Konten dengan efek cahaya biru (glow).
    </div>

    <div class="flex flex-col gap-4">
        <label class="text-primary">Nama Lengkap</label>
        <input type="text" placeholder="Masukkan nama...">

        <select>
            <option>Pilihan 1</option>
            <option>Pilihan 2</option>
        </select>
    </div>
</body>

</html>
