<?php

namespace Modules\Laporan\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Modules\Laporan\Http\Requests\LaporanRequest;
use Modules\Laporan\Models\Laporan;
use Modules\TitikDrainase\Models\TitikDrainase;

class LaporanController extends Controller
{
   
    public function index()
    {
        $titiks = TitikDrainase::orderBy('nama_titik')->get(['id', 'nama_titik', 'kecamatan']);

        return view('laporan::index', compact('titiks'));
    }

   
    public function data(Request $request): JsonResponse
    {
        $user = $request->user();
        $status = $request->query('status');

        $rows = Laporan::with(['user:id,name', 'titikDrainase:id,nama_titik,kecamatan'])
            ->when(! $user->isAdmin(), fn ($q) => $q->where('user_id', $user->id))
            ->when(in_array($status, Laporan::STATUS, true), fn ($q) => $q->where('status_kondisi', $status))
            ->latest()
            ->get()
            ->map(fn (Laporan $l) => $this->transform($l, $request));

        return response()->json(['data' => $rows]);
    }

    
    public function show(Request $request, Laporan $laporan): JsonResponse
    {
        $this->authorizeOwnerOrAdmin($request, $laporan);
        $laporan->load(['user:id,name', 'titikDrainase:id,nama_titik,kecamatan']);

        return response()->json(['data' => $this->transform($laporan, $request)]);
    }

    public function store(LaporanRequest $request): JsonResponse
    {
        $data = $request->validated();
        unset($data['foto_bukti']);

        if ($request->hasFile('foto_bukti')) {
            // Disimpan di disk public; yang disimpan di DB hanya path relatif.
            $data['foto_bukti'] = $request->file('foto_bukti')->store('bukti', 'public');
        }

        $laporan = new Laporan($data);
        $laporan->user_id = $request->user()->id; // dari akun aktif, bukan dari input
        $laporan->save();

        return response()->json(['message' => 'Laporan berhasil ditambahkan.'], 201);
    }

    public function update(LaporanRequest $request, Laporan $laporan): JsonResponse
    {
        $this->authorizeOwnerOrAdmin($request, $laporan);

        $data = $request->validated();
        unset($data['foto_bukti']);

        // Foto baru mengganti yang lama; tanpa foto baru, foto lama dipertahankan.
        if ($request->hasFile('foto_bukti')) {
            if ($laporan->foto_bukti) {
                Storage::disk('public')->delete($laporan->foto_bukti);
            }
            $data['foto_bukti'] = $request->file('foto_bukti')->store('bukti', 'public');
        }

        $laporan->update($data);

        return response()->json(['message' => 'Laporan berhasil diperbarui.']);
    }

    
    public function destroy(Request $request, Laporan $laporan): JsonResponse
    {
        $this->authorizeOwnerOrAdmin($request, $laporan);

        if ($laporan->foto_bukti) {
            Storage::disk('public')->delete($laporan->foto_bukti);
        }
        $laporan->delete();

        return response()->json(['message' => 'Laporan berhasil dihapus.']);
    }

    private function authorizeOwnerOrAdmin(Request $request, Laporan $laporan): void
    {
        $user = $request->user();
        abort_unless($user->isAdmin() || $laporan->user_id === $user->id, 403, 'Anda tidak berhak mengakses laporan ini.');
    }

    private function transform(Laporan $l, Request $request): array
    {
        $user = $request->user();
        $isOwner = $l->user_id === $user->id;

        return [
            'id' => $l->id,
            'titik_drainase_id' => $l->titik_drainase_id,
            'titik' => $l->titikDrainase?->nama_titik,
            'kecamatan' => $l->titikDrainase?->kecamatan,
            'pelapor' => $l->user?->name,
            'tinggi_air_cm' => $l->tinggi_air_cm,
            'status_kondisi' => $l->status_kondisi,
            'deskripsi' => $l->deskripsi,
            'foto_url' => $l->foto_bukti ? asset('storage/'.$l->foto_bukti) : null,
            'tanggal' => $l->created_at?->format('d M Y H:i'),
            'can_edit' => $isOwner,
            'can_delete' => $isOwner || $user->isAdmin(),
            'show_url' => route('laporan.show', $l),
            'update_url' => route('laporan.update', $l),
            'delete_url' => $user->isAdmin()
                ? route('laporan.admin.destroy', $l)
                : route('laporan.destroy', $l),
        ];
    }
}
