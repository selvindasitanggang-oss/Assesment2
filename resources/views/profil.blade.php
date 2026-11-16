@extends('layouts.app')
@section('title', 'Profil')

@section('content')
<h1 class="h3 mb-3">Profil</h1>
<div class="card" style="max-width: 36rem;">
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-4">Nama</dt><dd class="col-8">{{ $user->name }}</dd>
            <dt class="col-4">Email</dt><dd class="col-8">{{ $user->email }}</dd>
            <dt class="col-4">Role</dt><dd class="col-8"><span class="badge text-bg-primary">{{ $user->role }}</span></dd>
        </dl>
    </div>
</div>
@endsection
