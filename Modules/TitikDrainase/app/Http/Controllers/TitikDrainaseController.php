<?php

namespace Modules\TitikDrainase\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\TitikDrainase\Http\Requests\TitikDrainaseRequest;
use Modules\TitikDrainase\Models\TitikDrainase;

class TitikDrainaseController extends Controller
{
    // Daftar + pencarian (semua role yang login). Bonus: pagination 10 data/halaman.
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));

        $items = TitikDrainase::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($w) use ($q) {
                    $w->where('nama_titik', 'like', "%{$q}%")
                      ->orWhere('kecamatan', 'like', "%{$q}%");
                });
            })
            ->orderBy('nama_titik')
            ->paginate(10)
            ->withQueryString();

        return view('titikdrainase::index', compact('items', 'q'));
    }

    public function create()
    {
        return view('titikdrainase::form', ['item' => null]);
    }

    public function store(TitikDrainaseRequest $request): RedirectResponse
    {
        TitikDrainase::create($request->validated());

        return redirect()->route('titik-drainase.index')
            ->with('success', 'Titik drainase berhasil ditambahkan.');
    }

    public function edit(TitikDrainase $titikDrainase)
    {
        return view('titikdrainase::form', ['item' => $titikDrainase]);
    }

    public function update(TitikDrainaseRequest $request, TitikDrainase $titikDrainase): RedirectResponse
    {
        $titikDrainase->update($request->validated());

        return redirect()->route('titik-drainase.index')
            ->with('success', 'Titik drainase berhasil diperbarui.');
    }

    public function destroy(TitikDrainase $titikDrainase): RedirectResponse
    {
        // Tolak penghapusan bila sudah dirujuk laporan.
        if ($titikDrainase->laporans()->exists()) {
            return redirect()->route('titik-drainase.index')
                ->with('error', "Titik drainase \"{$titikDrainase->nama_titik}\" tidak dapat dihapus karena sudah memiliki laporan terkait.");
        }

        $titikDrainase->delete();

        return redirect()->route('titik-drainase.index')
            ->with('success', 'Titik drainase berhasil dihapus.');
    }
}
