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
              <a href="{{ route('transaksi.struk', $transaksi->id) }}" class="btn btn-success mr-2" title="Download Struk">
                <i class="fas fa-file-download"></i>
              </a>
              <a href="{{ route('transaksi') }}" class="btn btn-primary">
                <i class="fas fa-chevron-left"></i>
              </a>
            </div>
          </div>
          <div class="card-body">
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
                <h6 class="mb-1">Dilayani</h6>
                <p>{{ $transaksi->user->name }}</p>
              </div>
              <div class="col-lg-2">
                <h6 class="mb-1">Nominal Pembayaran</h6>
                <p>Rp {{ number_format($transaksi->bayar, 2, ',', '.') }}</p>
              </div>
              <div class="col-lg-2">
                <h6 class="mb-1">Total Harga</h6>
                <p>Rp {{ number_format($transaksi->total_harga, 2, ',', '.') }}</p>
              </div>
              <div class="col-lg-2">
                <h6 class="mb-1">Kembalian</h6>
                <p>Rp {{ number_format($transaksi->bayar - $transaksi->total_harga, 2, ',', '.') }}</p>
              </div>
              <div class="col-lg-2">
                <h6 class="mb-1">Keterangan</h6>
                <p>{{ $transaksi->keterangan ?? '-' }}</p>
              </div>
            </div>
            <hr class="mt-0 mb-3">
            <h6>Buku yang dibeli</h6>
            <div class="table-responsive">
              <table class="display table table-striped table-bordered" style="width:100%; text-align:center;">
                <thead>
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">Judul</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Jumlah</th>
                    <th scope="col">Diskon</th>
                    <th scope="col">Sub Total</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($transaksi->detail as $t)
                    <tr>
                      <th>{{ $loop->index + 1 }}</th>
                      <th>{{ $t->buku()->withTrashed()->first()->judul }}</th>
                      <th>Rp {{ number_format($t->harga, 2, ',', '.') }}</th>
                      <th>{{ $t->jumlah }}</th>
                      <th>{{ $t->diskon ? $t->diskon . '%' : '-' }}</th>
                      <th>Rp {{ number_format($t->jumlah * ($t->diskon ? $t->harga - (($t->harga / 100) * $t->diskon) : $t->harga), 2, ',', '.') }}</th>
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