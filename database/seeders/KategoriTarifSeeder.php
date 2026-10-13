<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriTarif;

class KategoriTarifSeeder extends Seeder
{
    public function run(): void
    {
        KategoriTarif::updateOrCreate(
            ['nama_kategori' => 'Rumah Tangga'],
            [
                'tarif_per_kubik' => 3000,
                'biaya_pemeliharaan' => 10000,
            ]
        );

        KategoriTarif::updateOrCreate(
            ['nama_kategori' => 'Ruko / Usaha'],
            [
                'tarif_per_kubik' => 5000,
                'biaya_pemeliharaan' => 20000,
            ]
        );

        KategoriTarif::updateOrCreate(
            ['nama_kategori' => 'kost'],
            [
                'tarif_per_kubik' => 2000,
                'biaya_pemeliharaan' => 6000,
            ]
        );

        KategoriTarif::updateOrCreate(
            ['nama_kategori' => 'sekolah'],
            [
                'tarif_per_kubik' => 1000,
                'biaya_pemeliharaan' => 4000,
            ]
        );
    }
}