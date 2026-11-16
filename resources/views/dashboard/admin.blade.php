@extends('layouts.app')
@section('title', 'Dashboard Admin')

@section('content')
<h1 class="h3 mb-3">Dashboard Admin</h1>

<div class="row g-3 mb-4">
    <div class="col-12 col-md-4">
        <div class="card text-bg-primary h-100"><div class="card-body">
            <div class="small">Jumlah Titik Drainase</div>
            <div class="display-5 fw-bold">{{ $stats['titik'] }}</div>
        </div></div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card text-bg-secondary h-100"><div class="card-body">
            <div class="small">Jumlah Seluruh Laporan</div>
            <div class="display-5 fw-bold">{{ $stats['laporan'] }}</div>
        </div></div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card text-bg-danger h-100"><div class="card-body">
            <div class="small">Laporan Status Meluap</div>
            <div class="display-5 fw-bold">{{ $stats['meluap'] }}</div>
        </div></div>
    </div>
</div>

<div class="card">
    <div class="card-header">Ringkasan Laporan per Status</div>
    <ul class="list-group list-group-flush">
        @foreach (\Modules\Laporan\Models\Laporan::STATUS as $s)
            <li class="list-group-item d-flex justify-content-between">
                <span>{{ $s }}</span>
                <span class="badge text-bg-dark">{{ $perStatus[$s] ?? 0 }}</span>
            </li>
        @endforeach
    </ul>
</div>
@endsection
