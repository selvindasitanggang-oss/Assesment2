<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Laporan\Models\Laporan;
use Modules\TitikDrainase\Models\TitikDrainase;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->isAdmin()) {
            $stats = [
                'titik' => TitikDrainase::count(),
                'laporan' => Laporan::count(),
                'meluap' => Laporan::where('status_kondisi', 'Meluap')->count(),
            ];
            $perStatus = Laporan::selectRaw('status_kondisi, COUNT(*) as total')
                ->groupBy('status_kondisi')->pluck('total', 'status_kondisi');

            return view('dashboard.admin', compact('stats', 'perStatus'));
        }

        $laporans = Laporan::with('titikDrainase:id,nama_titik,kecamatan')
            ->where('user_id', $user->id)
            ->latest()->get();

        return view('dashboard.warga', compact('laporans'));
    }
}
