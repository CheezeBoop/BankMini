@extends('layouts.app')
@section('content')
<div class="container">
  <h3>Admin Dashboard</h3>
  <p>Halo, {{ Auth::user()->name }}!</p>

  <h5>Daftar Teller</h5>
  <ul>
    @foreach($tellers as $t)
      <li>{{ $t->name }} ({{ $t->email }})
        <form action="{{ route('admin.teller.delete',$t->id) }}" method="POST" style="display:inline;">
          @csrf
          @method('DELETE')
          <button class="btn btn-sm btn-danger">Hapus</button>
        </form>
      </li>
    @endforeach
  </ul>

  <a href="{{ route('admin.teller.create') }}" class="btn btn-primary mt-3">+ Buat Teller Baru</a>
</div>
@endsection
