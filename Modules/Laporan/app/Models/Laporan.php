<?php

namespace Modules\Laporan\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\TitikDrainase\Models\TitikDrainase;

class Laporan extends Model
{
    public const STATUS = ['Normal', 'Tersumbat', 'Meluap'];

    protected $table = 'laporans';

    // user_id sengaja tidak fillable: diisi dari akun aktif di controller.
    protected $fillable = ['titik_drainase_id', 'tinggi_air_cm', 'status_kondisi', 'deskripsi', 'foto_bukti'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function titikDrainase(): BelongsTo
    {
        return $this->belongsTo(TitikDrainase::class, 'titik_drainase_id');
    }
}
