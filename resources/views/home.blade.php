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
                      <h4>Transaksi Bulan Ini</h4>
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
                    <h4>Pendapatan dan Pengeluaran Per Hari Bulan Ini (<span id="bulan"></span>)</h4>
                  </div>
                  <div class="card-body">
                    <h5 class="mb-0 text-center py-5 my-5" id="loading">Sedang memuat data...</h5>
                    <canvas id="transaksi" width="400" height="200"></canvas>
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw==" crossorigin="anonymous"></script>
  <script src="{{ asset('js/dasbor/index.js') }}"></script>
@endpush

@push('css')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css" integrity="sha512-/zs32ZEJh+/EO2N1b0PEdoA10JkdC3zJ8L5FTiQu82LR9S/rOQNfQN7U59U9BC12swNeRAz3HSzIL2vpp4fv3w==" crossorigin="anonymous" />
@endpush