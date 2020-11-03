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
              <a href="{{ route('pembelian-buku.faktur', $pembelian->id) }}" title="Cetak Faktur" class="btn btn-success mr-2">
                <i class="fas fa-file-invoice"></i>
              </a>
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
                  <h6 class="mb-1">Bayar</h6>
                  <p>Rp {{ number_format($pembelian->harga_beli) }}</p>
                </div>
                <div class="col-lg-2">
                  <h6 class="mb-1">Total Harga</h6>
                  <p>Rp {{ number_format($pembelian->total_harga_jual) }}</p>
                </div>
                <div class="col-lg-2">
                  <h6 class="mb-1">Kembalian</h6>
                  <p>Rp {{ number_format($pembelian->harga_beli - $pembelian->total_harga_jual) }}</p>
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
                      <td>Rp {{ number_format($p->harga_jual) }}</td>
                      <td>{{ $p->jumlah }}</td>
                      <td>Rp {{ number_format($p->harga_jual * $p->jumlah) }}</td>
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