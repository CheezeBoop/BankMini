<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bank Mini</title>

    {{-- Responsive --}}
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    @stack('styles')
    @livewireStyles
</head>
<body>
@php
  $user = Auth::user();
@endphp

{{-- 
  Navbar hanya untuk:
  - Guest (belum login), atau
  - User login yang BUKAN nasabah (admin / teller)
--}}
@if(!$user || ($user && !$user->isNasabah()))
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container">
    <a class="navbar-brand" href="{{ url('/') }}">Bank Mini</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
      aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav me-auto">
        @auth
          @if($user->isAdmin())
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Admin</a></li>
          @endif
          @if($user->isTeller())
            <li class="nav-item"><a class="nav-link" href="{{ route('teller.dashboard') }}">Teller</a></li>
          @endif
          {{-- Tidak menampilkan item "Nasabah" di navbar --}}
        @endauth
      </ul>

      <div class="d-flex align-items-center gap-2">
        @auth
          <span class="text-white small">Hi, {{ $user->name }}</span>
          <form method="POST" action="{{ route('logout') }}" class="m-0">
            @csrf
            <button class="btn btn-sm btn-danger">Logout</button>
          </form>
        @endauth

        @guest
          <a href="{{ route('login') }}" class="btn btn-sm btn-primary">Login</a>
        @endguest
      </div>
    </div>
  </div>
</nav>
@endif

{{-- 
  Konten utama:
  - Untuk nasabah, biarkan child view atur layout (punya sidebar sendiri), jadi pakai container-fluid kosong
  - Untuk selain nasabah/guest, tetap gunakan .container standar
--}}
@if($user && $user->isNasabah())
  <div class="container-fluid p-0">
    @yield('content')
  </div>
@else
  <div class="container">
    @yield('content')
  </div>
@endif

{{-- Bootstrap JS + Popper --}}
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

@stack('scripts')
@livewireScripts
</body>
</html>
