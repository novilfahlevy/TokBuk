@extends('layouts.partials.app')
@section('title')
  Dasbor
@endsection
@section('content')
  <div class="main-wrapper main-wrapper-1">
    <div class="main-content" style="min-height: 116px;">
        <section class="section">
          <div class="section-header">
            <h1>Dasbor</h1>
          </div>
          <div class="section-body">
            <div class="row">
              <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                  <div class="card-icon bg-primary">
                    <i class="far fa-user"></i>
                  </div>
                  <div class="card-wrap">
                    <div class="card-header">
                      <h4>Total Pengguna</h4>
                    </div>
                    <div class="card-body">
                      {{ number_format($pengguna) }}
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                  <div class="card-icon bg-danger">
                    <i class="fas fa-book"></i>
                  </div>
                  <div class="card-wrap">
                    <div class="card-header">
                      <h4>Total Judul Buku</h4>
                    </div>
                    <div class="card-body">
                      {{ number_format($judulBuku) }}
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                  <div class="card-icon bg-warning">
                    <i class="fas fa-book-open"></i>
                  </div>
                  <div class="card-wrap">
                    <div class="card-header">
                      <h4>Total Buku</h4>
                    </div>
                    <div class="card-body" id="jumlahBuku">
                      {{ number_format($buku) }}
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                  <div class="card-icon bg-success">
                    <i class="fas fa-money-bill"></i>
                  </div>
                  <div class="card-wrap">
                    <div class="card-header">
                      <h4>Transaksi Hari Ini</h4>
                    </div>
                    <div class="card-body" id="jumlahTransaksi">
                      {{ number_format($transaksi) }}
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Laporan Transaksi</h4>
                  </div>
                  <div class="card-body">
                    <h5 class="mb-3" id="waktuLaporanPenjualan">{{ $penjualan->bulan }} {{ $penjualan->tahun }}</h5>
                    <div class="table-responsive">
                      <table class="table table-striped">
                        <tr>
                          <td width="30%">
                            Total Transaksi
                          </td>
                          <td id="totalTransaksi">
                            {{ $penjualan->totalTransaksi }}
                          </td>
                        </tr>
                        <tr>
                          <td>
                            Buku Terjual
                          </td>
                          <td id="bukuTerjual">
                            {{ $penjualan->bukuTerjual }}
                          </td>
                        </tr>
                        <tr>
                          <td>
                            Total Pendapatan
                          </td>
                          <td id="totalPendapatan">
                            Rp {{ number_format($penjualan->pendapatan, 2, ',', '.') }}
                          </td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Laporan Pembelian Buku</h4>
                  </div>
                  <div class="card-body">
                    <h5 class="mb-3" id="waktuLaporanPendapatan">{{ $pembelian->bulan }} {{ $pembelian->tahun }}</h5>
                    <div class="table-responsive">
                      <table class="table table-striped">
                        <tr>
                          <td width="30%">
                            Total Pembelian
                          </td>
                          <td id="totalPembelian">
                            {{ $pembelian->totalPembelian }}
                          </td>
                        </tr>
                        <tr>
                          <td>
                            Buku Dibeli
                          </td>
                          <td id="bukuTerbeli">
                            {{ $pembelian->bukuTerbeli }}
                          </td>
                        </tr>
                        <tr>
                          <td>
                            Total Pengeluaran
                          </td>
                          <td id="totalPengeluaran">
                            Rp {{ number_format($pembelian->pengeluaran, 2, ',', '.') }}
                          </td>
                        </tr>
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

@push('js')
  <script src="{{ asset('js/dasbor/index.js') }}"></script>
@endpush