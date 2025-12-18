@extends('layouts.app')

@section('content')

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-10">
      <div class="card">
        <div class="card-header">Admin Dashboard</div>
        <div class="card-body">
          <h4>Selamat datang, {{ auth()->user()->name }}</h4>
          <p>Ini adalah dashboard admin sederhana. Tambahkan konten sesuai kebutuhan.</p>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
