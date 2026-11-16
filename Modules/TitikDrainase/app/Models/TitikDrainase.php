<?php

namespace Modules\TitikDrainase\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Laporan\Models\Laporan;

class TitikDrainase extends Model
{
    protected $table = 'titik_drainases';

    protected $fillable = ['nama_titik', 'kecamatan', 'deskripsi', 'kedalaman_cm'];

    public function laporans(): HasMany
    {
        return $this->hasMany(Laporan::class, 'titik_drainase_id');
    }
}
