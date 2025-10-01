@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row">
    {{-- Sidebar nasabah --}}
    <div class="col-12 col-md-3 col-lg-2 mb-3 mb-md-0">
      @include('nasabah.partials.sidebar')
    </div>

    {{-- Area konten kanan --}}
    <div class="col-12 col-md-9 col-lg-10">
      @yield('nasabah_content')
    </div>
  </div>
</div>
@endsection
