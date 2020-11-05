@extends('layouts.partials.app')
@section('title')
Laporan
@endsection

@section('content')
<div class="main-wrapper main-wrapper-1">
  <div class="main-content" style="min-height: 116px;">
    <section class="section">
      <div class="section-header">
        <h1>Laporan</h1>
      </div>
      <div class="section-body">
        <div class="content-body table">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h4>Laporan Transaksi</h4>
                  <div class="card-header-form">
                  <a href="{{route('laporan.penjualan')}}" class="btn btn-success mr-2" title="Download Laporan Transaksi">
                      <i class="fas fa-file-download"></i>
                    </a>
                  </div>
                </div>
                <div class="card-body">
                  <h5 class="mb-3" id="waktuLaporanPenjualan"></h5>
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <tr>
                        <td width="30%">
                          Total Transaksi
                        </td>
                        <td id="totalTransaksi">
                          0
                        </td>
                      </tr>
                      <tr>
                        <td>
                          Buku Terjual
                        </td>
                        <td id="bukuTerjual">
                          0
                        </td>
                      </tr>
                      <tr>
                        <td>
                          Total Pendapatan
                        </td>
                        <td id="totalPendapatan">
                          Rp 0
                        </td>
                      </tr>
                    </table>
                  </div>
                </div>
                <div class="card-footer pt-0">
                  <div class="input-group">
                    <input type="month" class="form-control" id="pendapatan" value="{{ date('Y-m') }}">
                    <div class="input-group-append">
                      <button type="button" class="btn btn-primary" id="submitPendapatan">Submit</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h4>Laporan Pembelian Buku</h4>
                  <div class="card-header-form">
                    <a href="" class="btn btn-success mr-2" title="Download Laporan Pembelian">
                      <i class="fas fa-file-download"></i>
                    </a>
                  </div>
                </div>
                <div class="card-body">
                  <h5 class="mb-3" id="waktuLaporanPendapatan"></h5>
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <tr>
                        <td width="30%">
                          Total Pembelian
                        </td>
                        <td id="totalPembelian">
                          0
                        </td>
                      </tr>
                      <tr>
                        <td>
                          Buku Dibeli
                        </td>
                        <td id="bukuTerbeli">
                          0
                        </td>
                      </tr>
                      <tr>
                        <td>
                          Total Pengeluaran
                        </td>
                        <td id="totalPengeluaran">
                          Rp 0
                        </td>
                      </tr>
                    </table>
                  </div>
                </div>
                <div class="card-footer pt-0">
                  <div class="input-group">
                    <input type="month" class="form-control" id="pengeluaran" value="{{ date('Y-m') }}">
                    <div class="input-group-append">
                      <button type="button" class="btn btn-primary" id="submitPengeluaran">Submit</button>
                    </div>
                  </div>
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
  <script src="{{ asset('js/laporan/index.js') }}"></script>
@endpush