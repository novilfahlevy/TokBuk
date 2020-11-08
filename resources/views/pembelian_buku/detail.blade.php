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
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h4>Data Pembelian Buku</h4>
                <div class="card-header-form">
                  @if ( $pembelian->tanggal_terima )
                    <a href="{{ route('pembelian-buku.laporan', $pembelian->id) }}" class="btn btn-success mr-2" title="Download Laporan">
                      <i class="fas fa-file-download"></i>
                    </a>
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
                  @endif
                  <a href="{{ route('pembelian-buku') }}" class="btn btn-primary">
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
                    <h6 class="mb-1">Tanggal Pesan</h6>
                    <p>{{ $pembelian->tanggal_pesan }}</p>
                  </div>
                  <div class="col-lg-2">
                    <h6 class="mb-1">Tanggal Terima</h6>
                    <p>{!! $pembelian->tanggal_terima ?? '<span class="text-warning">Belum Diterima</span>' !!}</p>
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
                        <th scope="col">Status</th>
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
          @if ( !$pembelian->tanggal_terima )
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h4>Form Terima Pembelian Buku</h4>
                </div>
                <div class="card-body">
                  <form action="{{ route('pembelian-buku.terima', ['id' => $pembelian->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="form-group">
                      <div class="form-group">
                        <label for="tanggal_terima">Tanggal Terima</label>
                        <input type="date" class="form-control" id="tanggal_terima" name="tanggal_terima" value="{{ date('Y-m-d') }}" required>
                      </div>
                      @error('tanggal_terima')
                        <span class="invalid-feedback d-block" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                    <div class="form-group">
                      <label for="faktur">Faktur</label>
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" name="faktur" id="faktur" required>
                        <label class="custom-file-label" for="faktur">Masukan faktur</label>
                      </div>
                      @error('faktur')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                  </form>
                </div>
              </div>
            </div>
          @endif
        </div>
      </div>
    </section>
  </div>
</div>
@endsection