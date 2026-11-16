<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">SmartDrain</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Buka menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                       href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('titik-drainase.*') ? 'active' : '' }}"
                       href="{{ route('titik-drainase.index') }}">Titik Drainase</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}"
                       href="{{ route('laporan.index') }}">{{ auth()->user()->isAdmin() ? 'Semua Laporan' : 'Laporan Saya' }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('profil') ? 'active' : '' }}"
                       href="{{ route('profil') }}">Profil</a>
                </li>
            </ul>

            <div class="d-flex align-items-center gap-2">
                <span class="navbar-text text-white small">
                    {{ auth()->user()->name }}
                    <span class="badge text-bg-light">{{ auth()->user()->role }}</span>
                </span>
                <button type="button" id="theme-toggle" class="btn btn-sm btn-outline-light">Tema</button>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-light">Logout</button>
                </form>
            </div>
        </div>
    </div>
</nav>
