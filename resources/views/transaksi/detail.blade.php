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
              @if ( session()->has('message') )
              <a href="{{ route('transaksi.create') }}" class="btn btn-warning mr-2" data-tooltip="tooltip"
                title="Buat Transaksi Lagi" id="buatTransaksiLagi" autofocus>
                <i class="fas fa-plus"></i>
              </a>
              @endif
              <div class="dropdown">
                <button class="btn btn-success mr-2 dropdown-toggle" type="button" id="dropdownMenuButton"
                  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-file-invoice"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                  <h6 class="dropdown-header pl-3 pt-1 pb-0">Nota</h6>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="{{ route('transaksi.nota', $transaksi->id) }}">Unduh</a>
                  <a class="dropdown-item" href="{{ route('transaksi.cetak', $transaksi->id) }}"
                    target="_blank">Cetak</a>
                </div>
              </div>
              <a href="{{ route('transaksi') }}" class="btn btn-primary" data-tooltip="tooltip" title="Kembali">
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
                <p>{{ $transaksi->user ? $transaksi->user->name : '-' }}</p>
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
                    <th>{{ $t->buku ? $t->buku->judul : '-' }}</th>
                    <th>Rp {{ number_format($t->harga, 2, ',', '.') }}</th>
                    <th>{{ $t->jumlah }}</th>
                    <th>{{ $t->diskon ? $t->diskon . '%' : '-' }}</th>
                    <th>Rp
                      {{ number_format($t->jumlah * ($t->diskon ? $t->harga - (($t->harga / 100) * $t->diskon) : $t->harga), 2, ',', '.') }}
                    </th>
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