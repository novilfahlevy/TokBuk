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
                    <h4>Pendapatan Tahun {{ date('Y') }}</h4>
                  </div>
                  <div class="card-body">
                    <canvas id="transaksiPerbulan"></canvas>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Buku Yang Sudah Mencapai Batasan Stok</h4>
                  </div>
                  <div class="card-body p-3">
                    <p>* Batasan stok {{ $batasanStok }}</p>
                    <div class="table-responsive">
                      <table class="display table table-striped table-bordered" style="width:100%; text-align:center;">
                        <thead style="">
                          <tr>
                            <th scope="col">No</th>
                            <th>ISBN</th>
                            <th>Judul</th>
                            <th>Stok</th>
                            <th>Tanggal Pembelian Terakhir</th>
                          </tr>
                        </thead>
                        <tbody>
                          @forelse ($bukuMencapaiStok as $buku)
                            <tr>
                              <td scope="row">{{ $loop->index + 1 }}</td>
                              <td>{{ $buku->isbn }}</td>
                              <td>{{ $buku->judul }}</td>
                              <td>{{ $buku->jumlah }}</td>
                              <td>{{ $buku->tanggal }}</td>
                            </tr>
                          @empty
                            <tr class="odd"><td valign="top" colspan="5" class="dataTables_empty">No data available in table</td></tr>
                          @endforelse
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

@push('js')
  <script src="{{ asset('js/dasbor/index.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
  <script>
    var ctx = document.getElementById('transaksiPerbulan').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
          datasets: [{
            label: 'Pendapatan',
            backgroundColor: 'rgba(71, 195, 99, 0.8)',
            borderColor: '#47c363',
            data: JSON.parse('{!! json_encode($hasil) !!}')
          }],
        },
        options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true,
                callback: function(value) {
                  return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(value);
                }
              }
            }]
          },
          tooltips: {
            callbacks: {
              label: function(tooltipItems, data) {
                return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(tooltipItems.yLabel);
              }
            }
          }
        }
    });
  </script>
@endpush