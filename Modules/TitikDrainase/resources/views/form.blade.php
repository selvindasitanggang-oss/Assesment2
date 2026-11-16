@extends('layouts.app')
@section('title', $item ? 'Edit Titik Drainase' : 'Tambah Titik Drainase')

@section('content')
<h1 class="h3 mb-3">{{ $item ? 'Edit Titik Drainase' : 'Tambah Titik Drainase' }}</h1>

<div class="card">
    <div class="card-body">
        <form method="POST"
              action="{{ $item ? route('titik-drainase.update', $item) : route('titik-drainase.store') }}"
              novalidate>
            @csrf
            @if ($item) @method('PUT') @endif

            <div class="mb-3">
                <label for="nama_titik" class="form-label">Nama Titik <span class="text-danger">*</span></label>
                <input type="text" id="nama_titik" name="nama_titik"
                       class="form-control @error('nama_titik') is-invalid @enderror"
                       value="{{ old('nama_titik', $item->nama_titik ?? '') }}">
                @error('nama_titik')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="kecamatan" class="form-label">Kecamatan <span class="text-danger">*</span></label>
                <input type="text" id="kecamatan" name="kecamatan"
                       class="form-control @error('kecamatan') is-invalid @enderror"
                       value="{{ old('kecamatan', $item->kecamatan ?? '') }}">
                @error('kecamatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="3"
                          class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi', $item->deskripsi ?? '') }}</textarea>
                @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="kedalaman_cm" class="form-label">Kedalaman (cm)</label>
                <input type="number" min="0" id="kedalaman_cm" name="kedalaman_cm"
                       class="form-control @error('kedalaman_cm') is-invalid @enderror"
                       value="{{ old('kedalaman_cm', $item->kedalaman_cm ?? '') }}">
                @error('kedalaman_cm')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <button type="submit" class="btn btn-primary" data-loading-on-submit>Simpan</button>
            <a href="{{ route('titik-drainase.index') }}" class="btn btn-outline-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
