<?php

namespace Modules\TitikDrainase\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\TitikDrainase\Models\TitikDrainase;

class TitikDrainaseDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['Saluran Jl. Merdeka', 'Banjar', 'Saluran utama sepanjang Jl. Merdeka, sering tersumbat sampah.', 120],
            ['Saluran Pasar Banjar', 'Banjar', 'Dekat area pasar, rawan meluap saat hujan deras.', 90],
            ['Saluran Pataruman', 'Pataruman', 'Saluran sekunder permukiman padat.', 75],
            ['Saluran Langensari Timur', 'Langensari', 'Saluran tersier tepi jalan raya.', 60],
            ['Saluran Purwaharja Barat', 'Purwaharja', 'Saluran dekat sekolah dasar.', 85],
            ['Saluran Terminal', 'Banjar', null, null],
        ];

        foreach ($data as [$nama, $kec, $desk, $dalam]) {
            TitikDrainase::updateOrCreate(
                ['nama_titik' => $nama],
                ['kecamatan' => $kec, 'deskripsi' => $desk, 'kedalaman_cm' => $dalam]
            );
        }
    }
}
