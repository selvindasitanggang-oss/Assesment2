@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<h1 class="h3 mb-3">Dashboard Warga</h1>

<div class="card text-bg-primary mb-4" style="max-width: 22rem;">
    <div class="card-body">
        <div class="small">Jumlah Laporan Saya</div>
        <div class="display-5 fw-bold">{{ $laporans->count() }}</div>
    </div>
</div>

<div class="card">
    <div class="card-header">Laporan yang Pernah Saya Kirim</div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th>Tanggal</th><th>Titik Drainase</th><th>Tinggi Air</th><th>Status</th><th>Deskripsi</th></tr>
            </thead>
            <tbody>
                @forelse ($laporans as $l)
                    <tr>
                        <td class="text-nowrap">{{ $l->created_at->format('d M Y H:i') }}</td>
                        <td>{{ $l->titikDrainase?->nama_titik }}</td>
                        <td>{{ $l->tinggi_air_cm }} cm</td>
                        <td>
                            <span class="badge text-bg-{{ ['Normal'=>'success','Tersumbat'=>'warning','Meluap'=>'danger'][$l->status_kondisi] ?? 'secondary' }}">{{ $l->status_kondisi }}</span>
                        </td>
                        <td>{{ $l->deskripsi }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">Anda belum mengirim laporan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
