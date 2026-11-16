<!DOCTYPE html>
<html lang="id" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SmartDrain') - SmartDrain</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        // Bonus dark mode: terapkan tema tersimpan sebelum render
        try {
            var t = localStorage.getItem('theme');
            if (t) document.documentElement.setAttribute('data-bs-theme', t);
        } catch (e) {}
    </script>
</head>
<body class="d-flex flex-column min-vh-100">

    {{-- Header / navigasi --}}
    @auth
        @include('partials.navbar')
    @else
        <nav class="navbar bg-primary navbar-dark">
            <div class="container"><span class="navbar-brand mb-0 h1">SmartDrain</span></div>
        </nav>
    @endauth

    {{-- Area konten --}}
    <main class="container py-4 flex-grow-1">
        @include('partials.flash')
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        // Nonaktifkan tombol submit pada form biasa agar tidak terkirim dua kali
        $(document).on('submit', 'form', function () {
            $(this).find('[data-loading-on-submit]').prop('disabled', true).text('Memproses...');
        });
        $('#theme-toggle').on('click', function () {
            var el = document.documentElement;
            var next = el.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';
            el.setAttribute('data-bs-theme', next);
            try { localStorage.setItem('theme', next); } catch (e) {}
        });
    </script>
    @stack('scripts')
</body>
</html>
