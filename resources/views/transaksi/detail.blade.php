@extends('layouts.partials.app')

@section('title')
Detail Transaksi
@endsection

@section('content')
<div class="main-wrapper main-wrapper-1">
  <div class="main-content" style="min-height: 116px;">
    <section class="section">
      <div class="section-header">
        <h1>Detail Transaksi</h1>
      </div>
      <div class="section-body">
        @include('layouts.flash-alert')
        <div class="card">
          <div class="card-header">
            <h4>Data Transaksi</h4>
            <div class="card-header-form">
              <a href="{{ route('transaksi') }}" class="btn btn-primary">
                <i class="fas fa-chevron-left"></i>
              </a>
            </div>
          </div>
          <div class="card-body">
            <div class="form-group">
              <div class="row">
                <div class="col-lg-2">
                  <h6 class="mb-1">Kode</h6>
                  <p>{{ $transaksi->kode }}</p>
                </div>
                <div class="col-lg-2">
                  <h6 class="mb-1">Tanggal Transaksi</h6>
                  <p>{{ $transaksi->created_at }}</p>
                </div>
                <div class="col-lg-2">
                  <h6 class="mb-1">Ditangani Oleh</h6>
                  <p>{{ $transaksi->user()->withTrashed()->first()->name }}</p>
                </div>
                <div class="col-lg-2">
                  <h6 class="mb-1">Uang Pembeli</h6>
                  <p>Rp {{ number_format($transaksi->uang_pembeli) }}</p>
                </div>
                <div class="col-lg-2">
                  <h6 class="mb-1">Total Harga</h6>
                  <p>Rp {{ number_format($transaksi->total_harga) }}</p>
                </div>
                <div class="col-lg-2">
                  <h6 class="mb-1">Kembalian</h6>
                  <p>Rp {{ number_format($transaksi->uang_pembeli - $transaksi->total_harga) }}</p>
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <table class="display table table-striped table-bordered" style="width:100%; text-align:center;">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Judul</th>
                    <th scope="col">Jumlah</th>
                    <th scope="col">Harga Per Buku</th>
                    <th scope="col">Total Harga</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($transaksi->detail as $t)
                    <tr>
                      <th>{{ $loop->index + 1 }}</th>
                      <th>{{ $t->buku()->withTrashed()->first()->judul }}</th>
                      <th>{{ $t->jumlah }}</th>
                      <th>Rp {{ number_format($t->harga) }}</th>
                      <th>Rp {{ number_format($t->jumlah * $t->harga) }}</th>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>
@endsection