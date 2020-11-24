@extends('layouts.partials.app')

@section('title')
Detail Retur
@endsection

@section('content')
<div class="main-wrapper main-wrapper-1">
  <div class="main-content" style="min-height: 116px;">
    <section class="section">
      <div class="section-header">
        <h1>Detail Retur</h1>
      </div>
      <div class="section-body">
        @include('layouts.flash-alert')
        <div class="card">
          <div class="card-header">
            <h4>Data Retur</h4>
            <div class="card-header-form">
              <a href="{{ route('pengadaan.detail', $retur->pengadaan->id) }}" class="btn btn-warning mr-2" data-tooltip="tooltip" title="Pengadaan">
                <i class="fas fa-truck-loading"></i>
              </a>
              <div class="dropdown">
                <button class="btn btn-success mr-2 dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-file-invoice"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                  <h6 class="dropdown-header pl-3 pt-1 pb-0">Faktur</h6>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="{{ route('retur.faktur', $retur->id) }}">Unduh</a>
                  <a class="dropdown-item" href="{{ route('retur.cetak', $retur->id) }}" target="_blank">Cetak</a>
                </div>
              </div>
              <a href="{{ route('retur') }}" class="btn btn-primary" data-tooltip="tooltip" title="Kembali">
                <i class="fas fa-chevron-left"></i>
              </a>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-lg-2">
                <h6 class="mb-1">Kode</h6>
                <p>{{ $retur->kode }}</p>
              </div>
              <div class="col-lg-2">
                <h6 class="mb-1">Tanggal</h6>
                <p>{{ $retur->tanggal }}</p>
              </div>
              <div class="col-lg-2">
                <h6 class="mb-1">Ditangani</h6>
                <p>{{ $retur->user ? $retur->user->name : '-' }}</p>
              </div>
              <div class="col-lg-2">
                <h6 class="mb-1">Dana Pengembalian</h6>
                <p>Rp {{ number_format($retur->total_dana_pengembalian, 2, ',', '.') }}</p>
              </div>
            </div>
            <hr class="mt-0 mb-3">
            <h6>Buku yang dikembalikan</h6>
            <div class="table-responsive">
              <table class="display table table-striped table-bordered" style="width:100%; text-align:center;">
                <thead>
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">Judul</th>
                    <th scope="col">Keterangan</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Jumlah</th>
                    <th scope="col">Sub Total</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($retur->detail as $r)
                    <tr>
                      <th>{{ $loop->index + 1 }}</th>
                      <th>{{ $r->pengadaan->buku->judul }}</th>
                      <th>{{ $r->keterangan }}</th>
                      <th>Rp {{ number_format($r->dana_pengembalian, 2, ',', '.') }}</th>
                      <th>{{ $r->jumlah }}</th>
                      <th>Rp {{ number_format($r->dana_pengembalian * $r->jumlah, 2, ',', '.') }}</th>
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