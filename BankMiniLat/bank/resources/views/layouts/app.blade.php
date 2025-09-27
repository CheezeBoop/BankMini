<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bank Mini</title>
    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container">
    <a class="navbar-brand" href="{{ url('/') }}">Bank Mini</a>
    <div>
      @auth
        <span class="text-white me-3">Hi, {{ Auth::user()->name }}</span>
        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
          @csrf
          <button class="btn btn-sm btn-danger">Logout</button>
        </form>
      @endauth
      @guest
        <a href="{{ route('login') }}" class="btn btn-sm btn-primary">Login</a>
      @endguest
    </div>
  </div>
</nav>

<div class="container">
    @yield('content')
</div>

{{-- Bootstrap JS + Popper (Wajib untuk Modal, Dropdown, dsb) --}}
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

</body>
</html>
