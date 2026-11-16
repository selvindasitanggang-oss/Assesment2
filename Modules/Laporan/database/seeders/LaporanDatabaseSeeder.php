<?php

namespace Modules\Laporan\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Modules\Laporan\Models\Laporan;
use Modules\TitikDrainase\Models\TitikDrainase;

class LaporanDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $warga = User::where('email', 'warga@smartdrain.test')->first();
        $titiks = TitikDrainase::orderBy('id')->take(3)->get();

        if (! $warga || $titiks->count() < 3 || Laporan::exists()) {
            return;
        }

        $contoh = [
            [0, 15, 'Normal', 'Air mengalir lancar.'],
            [1, 60, 'Meluap', 'Air meluap ke badan jalan setelah hujan.'],
            [2, 30, 'Tersumbat', 'Banyak sampah plastik menyumbat saluran.'],
        ];

        foreach ($contoh as [$i, $tinggi, $status, $desk]) {
            $laporan = new Laporan([
                'titik_drainase_id' => $titiks[$i]->id,
                'tinggi_air_cm' => $tinggi,
                'status_kondisi' => $status,
                'deskripsi' => $desk,
            ]);
            $laporan->user_id = $warga->id;
            $laporan->save();
        }
    }
}
