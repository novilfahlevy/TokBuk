@extends('layouts.partials.app')

@section('title')
Detail Pengadaan
@endsection

@section('content')
<div class="main-wrapper main-wrapper-1">
  <div class="main-content" style="min-height: 116px;">
    <section class="section">
      <div class="section-header">
        <h1>Detail Pengadaan</h1>
      </div>
      <div class="section-body">
        @include('layouts.flash-alert')
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h4>Data Pengadaan</h4>
                <div class="card-header-form">
                  <a href="{{ $pembelian->retur ? route('retur.detail', $pembelian->retur->id) : route('retur.create', $pembelian->id) }}" class="btn btn-danger mr-2" data-tooltip="tooltip" title="{{ !$pembelian->retur ?? 'Ajukan' }} Retur">
                    <i class="fas fa-exchange-alt"></i>
                  </a>
                  <div class="dropdown">
                    <button class="btn btn-success mr-2 dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-file-invoice"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                      <h6 class="dropdown-header pl-3 pt-1 pb-0">Laporan</h6>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="{{ route('pengadaan.laporan', $pembelian->id) }}">Unduh</a>
                      <a class="dropdown-item" href="{{ route('pengadaan.cetak', $pembelian->id) }}" target="_blank">Cetak</a>
                      <div class="my-3"></div>
                      <h6 class="dropdown-header pl-3 pt-1 pb-0">Faktur</h6>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="{{ asset('images/faktur/' . $pembelian->faktur) }}" target="_blank">Lihat</a>
                      <a class="dropdown-item" href="{{ route('pengadaan.faktur', $pembelian->id) }}">Unduh</a>
                    </div>
                  </div>
                  <a href="{{ route('pengadaan') }}" class="btn btn-primary" data-tooltip="tooltip" title="Kembali">
                    <i class="fas fa-chevron-left"></i>
                  </a>
                </div>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-2">
                    <h6 class="mb-1">Kode</h6>
                    <p>{{ $pembelian->kode }}</p>
                  </div>
                  <div class="col-lg-2">
                    <h6 class="mb-1">Tanggal</h6>
                    <p>{{ $pembelian->tanggal }}</p>
                  </div>
                  <div class="col-lg-2">
                    <h6 class="mb-1">Ditangani</h6>
                    <p>{{ $pembelian->user->name }}</p>
                  </div>
                  <div class="col-lg-2">
                    <h6 class="mb-1">Nominal Pembayaran</h6>
                    <p>Rp {{ number_format($pembelian->bayar, 2, ',', '.') }}</p>
                  </div>
                  <div class="col-lg-2">
                    <h6 class="mb-1">Total Harga</h6>
                    <p>Rp {{ number_format($pembelian->total_harga, 2, ',', '.') }}</p>
                  </div>
                  <div class="col-lg-2">
                    <h6 class="mb-1">Kembalian</h6>
                    <p>Rp {{ number_format($pembelian->bayar - $pembelian->total_harga, 2, ',', '.') }}</p>
                  </div>
                  <div class="col-lg-2">
                    <h6 class="mb-1">Distributor</h6>
                    <p>{{ $pembelian->distributor->nama ?? '-' }}</p>
                  </div>
                  <div class="col-lg-2">
                    <h6 class="mb-1">Keterangan</h6>
                    <p>{{ $pembelian->keterangan ?? '-' }}</p>
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
                        <th scope="col">Sub Total</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($pembelian->detail as $p)
                        <tr>
                          <td>{{ $loop->index + 1 }}</td>
                          <td>{{ $p->buku()->withTrashed()->first()->judul }}</td>
                          <td>Rp {{ number_format($p->harga, 2, ',', '.') }}</td>
                          <td>{{ $p->jumlah }}</td>
                          <td>Rp {{ number_format($p->harga * $p->jumlah, 2, ',', '.') }}</td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>
@endsection