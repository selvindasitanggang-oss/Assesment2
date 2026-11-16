<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\Laporan\Database\Seeders\LaporanDatabaseSeeder;
use Modules\TitikDrainase\Database\Seeders\TitikDrainaseDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = new User(['name' => 'Admin SmartDrain', 'email' => 'admin@smartdrain.test']);
        $warga = new User(['name' => 'Warga Contoh', 'email' => 'warga@smartdrain.test']);

        $this->upsert($admin, 'Admin#12345', User::ROLE_ADMIN);
        $this->upsert($warga, 'Warga#12345', User::ROLE_WARGA);

        $this->call([
            TitikDrainaseDatabaseSeeder::class,
            LaporanDatabaseSeeder::class,
        ]);
    }

    private function upsert(User $data, string $plainPassword, string $role): void
    {
        $user = User::firstOrNew(['email' => $data->email]);
        $user->name = $data->name;
        $user->password = Hash::make($plainPassword); // tersimpan sebagai hash
        $user->role = $role;
        $user->save();
    }
}
