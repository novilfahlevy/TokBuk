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
            <div class="col-12 col-md-6">
              <div class="card">
                <div class="card-header">
                  <h4>Laporan Transaksi</h4>
                  <div class="card-header-form">
                    <a href="{{ route('laporan.penjualan', ['dari' => date('Y-m') . '-01', 'sampai' => date('Y-m-') . $akhirBulan > 9 ? $akhirBulan : '0' . $akhirBulan]) }}" class="btn btn-success mr-2" data-tooltip="tooltip" title="Unduh Laporan" id="laporanTransaksi">
                      <i class="fas fa-file-download"></i>
                    </a>
                  </div>
                </div>
                <div class="card-body pb-0">
                  <h6 class="mb-3 text-center" id="waktuLaporanPenjualan"></h6>
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
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group mb-0">
                        <label for="awalTanggalPendapatan">Dari</label>
                        <input type="date" class="form-control" id="awalTanggalPendapatan" value="{{ date('Y-m') }}-01">
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group mb-0">
                        <label for="akhirTanggalPendapatan">Sampai</label>
                        <input type="date" class="form-control" id="akhirTanggalPendapatan" value="{{ date('Y-m') }}-{{ $akhirBulan > 9 ? $akhirBulan : '0' . $akhirBulan }}">
                      </div>
                    </div>
                    <div class="col-12">
                      <button type="button" class="btn btn-primary mt-3 w-100" id="submitPendapatan">Submit</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="card">
                <div class="card-header">
                  <h4>Laporan Pengadaan</h4>
                  <div class="card-header-form">
                    <a href="{{ route('laporan.pembelian', ['dari' => date('Y-m') . '-01', 'sampai' => date('Y-m-') . $akhirBulan > 9 ? $akhirBulan : '0' . $akhirBulan]) }}" class="btn btn-success mr-2" data-tooltip="tooltip" title="Unduh Laporan" id="laporanPembelian">
                      <i class="fas fa-file-download"></i>
                    </a>
                  </div>
                </div>
                <div class="card-body pb-0">
                  <h6 class="mb-3 text-center" id="waktuLaporanPendapatan"></h6>
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <tr>
                        <td width="30%">
                          Total Pengadaan
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
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group mb-0">
                        <label for="awalTanggalPengeluaran">Dari</label>
                        <input type="date" class="form-control" id="awalTanggalPengeluaran" value="{{ date('Y-m') }}-01">
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group mb-0">
                        <label for="akhirTanggalPengeluaran">Sampai</label>
                        <input type="date" class="form-control" id="akhirTanggalPengeluaran" value="{{ date('Y-m') }}-{{ $akhirBulan > 9 ? $akhirBulan : '0' . $akhirBulan }}">
                      </div>
                    </div>
                    <div class="col-12">
                      <button type="button" class="btn btn-primary mt-3 w-100" id="submitPengeluaran">Submit</button>
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