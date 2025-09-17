@extends('layouts.app')
@section('content')
<div class="container">
  <h3>Dashboard Nasabah</h3>
  <p>Halo, {{ Auth::user()->name }}!</p>

  @if(Auth::user()->isNasabah() && Auth::user()->nasabah && Auth::user()->nasabah->rekening)
    <p>No Rekening: {{ Auth::user()->nasabah->rekening->no_rekening }}</p>
    <p>Saldo: Rp {{ number_format(Auth::user()->nasabah->rekening->saldo) }}</p>

    <h5>Request Setor</h5>
    <form method="POST" action="{{ route('deposit.request') }}">
      @csrf
      <input type="hidden" name="rekening_id" value="{{ Auth::user()->nasabah->rekening->id }}">
      <input type="number" name="nominal" placeholder="Nominal" class="form-control mb-2" required>
      <button class="btn btn-success">Setor</button>
    </form>

    <h5 class="mt-4">Request Tarik</h5>
    <form method="POST" action="{{ route('withdraw.request') }}">
      @csrf
      <input type="hidden" name="rekening_id" value="{{ Auth::user()->nasabah->rekening->id }}">
      <input type="number" name="nominal" placeholder="Nominal" class="form-control mb-2" required>
      <button class="btn btn-warning">Tarik</button>
    </form>
  @else
    <p>Anda belum memiliki rekening.</p>
  @endif
</div>
@endsection
