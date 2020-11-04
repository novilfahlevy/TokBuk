@extends('layouts.partials.app')

@section('title')
Detail Pembelian Buku
@endsection

@section('content')
<div class="main-wrapper main-wrapper-1">
  <div class="main-content" style="min-height: 116px;">
    <section class="section">
      <div class="section-header">
        <h1>Detail Pembelian Buku</h1>
      </div>
      <div class="section-body">
        @include('layouts.flash-alert')
        <div class="card">
          <div class="card-header">
            <h4>Data Pembelian Buku</h4>
            <div class="card-header-form">
              <div class="dropdown">
                <button class="btn btn-success mr-2 dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-file-invoice"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                  <h6 class="dropdown-header pl-3 pt-1 pb-0">Faktur</h6>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="{{ asset('images/faktur/' . $pembelian->faktur) }}" target="_blank">Lihat</a>
                  <a class="dropdown-item" href="{{ route('pembelian-buku.faktur', $pembelian->id) }}">Download</a>
                </div>
              </div>
              <a href="{{ route('pembelian-buku') }}" class="btn btn-primary">
                <i class="fas fa-chevron-left"></i>
              </a>
            </div>
          </div>
          <div class="card-body">
            <div class="form-group">
              <div class="row">
                <div class="col-lg-2">
                  <h6 class="mb-1">Kode</h6>
                  <p>{{ $pembelian->kode }}</p>
                </div>
                <div class="col-lg-2">
                  <h6 class="mb-1">Tanggal</h6>
                  <p>{{ $pembelian->created_at }}</p>
                </div>
                <div class="col-lg-2">
                  <h6 class="mb-1">Ditangani</h6>
                  <p>{{ $pembelian->user->name }}</p>
                </div>
                <div class="col-lg-2">
                  <h6 class="mb-1">Bayar</h6>
                  <p>Rp {{ number_format($pembelian->bayar) }}</p>
                </div>
                <div class="col-lg-2">
                  <h6 class="mb-1">Total Harga</h6>
                  <p>Rp {{ number_format($pembelian->total_harga) }}</p>
                </div>
                <div class="col-lg-2">
                  <h6 class="mb-1">Kembalian</h6>
                  <p>Rp {{ number_format($pembelian->bayar - $pembelian->total_harga) }}</p>
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <table class="display table table-striped table-bordered" style="width:100%; text-align:center;">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Judul</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Jumlah</th>
                    <th scope="col">Total Harga</th>
                    <th scope="col">Status</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($pembelian->detail as $p)
                    <tr>
                      <td>{{ $loop->index + 1 }}</td>
                      <td>{{ $p->buku()->withTrashed()->first()->judul }}</td>
                      <td>Rp {{ number_format($p->harga) }}</td>
                      <td>{{ $p->jumlah }}</td>
                      <td>Rp {{ number_format($p->harga * $p->jumlah) }}</td>
                      <td>
                        <div class="badge badge-{{ $p->status === 'Baru' ? 'success' : 'primary' }}">
                          {{$p->status}}
                        </div>
                      </td>
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