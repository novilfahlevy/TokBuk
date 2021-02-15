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
                  @if ( $pengadaan->faktur )
                    <a href="{{ $pengadaan->retur ? route('retur.detail', $pengadaan->retur->id) : route('retur.create', $pengadaan->id) }}"
                      class="btn btn-danger mr-2" data-tooltip="tooltip"
                      title="{{ !$pengadaan->retur ? 'Ajukan ' : '' }}Retur">
                      <i class="fas fa-exchange-alt"></i>
                    </a>
                  @endif
                  <div class="dropdown">
                    <button class="btn btn-success mr-2 dropdown-toggle" type="button" id="dropdownMenuButton"
                      data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-file-invoice"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                      <h6 class="dropdown-header pl-3 pt-1 pb-0">Laporan</h6>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="{{ route('pengadaan.laporan', $pengadaan->id) }}">Unduh</a>
                      <a class="dropdown-item" href="{{ route('pengadaan.cetak', $pengadaan->id) }}" target="_blank">Cetak</a>
                      @if ( $pengadaan->faktur )
                        <div class="my-3"></div>
                        <h6 class="dropdown-header pl-3 pt-1 pb-0">Faktur</h6>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ asset('images/faktur/' . $pengadaan->faktur) }}"
                          target="_blank">Lihat</a>
                        <a class="dropdown-item" href="{{ route('pengadaan.faktur', $pengadaan->id) }}">Unduh</a>
                      @endif
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
                    <p>{{ $pengadaan->kode }}</p>
                  </div>
                  <div class="col-lg-2">
                    <h6 class="mb-1">Tanggal</h6>
                    <p>{{ $pengadaan->tanggal }}</p>
                  </div>
                  <div class="col-lg-2">
                    <h6 class="mb-1">Ditangani</h6>
                    <p>{{ $pengadaan->user ? $pengadaan->user->name : '-' }}</p>
                  </div>
                  <div class="col-lg-2">
                    <h6 class="mb-1">Nominal Pembayaran</h6>
                    <p>Rp {{ number_format($pengadaan->bayar, 2, ',', '.') }}</p>
                  </div>
                  <div class="col-lg-2">
                    <h6 class="mb-1">Total Harga</h6>
                    <p>Rp {{ number_format($pengadaan->total_harga, 2, ',', '.') }}</p>
                  </div>
                  <div class="col-lg-2">
                    <h6 class="mb-1">Kembalian</h6>
                    <p>Rp {{ number_format($pengadaan->bayar - $pengadaan->total_harga, 2, ',', '.') }}</p>
                  </div>
                  <div class="col-lg-2">
                    <h6 class="mb-1">Distributor</h6>
                    <p>{{ $pengadaan->distributor->nama ?? '-' }}</p>
                  </div>
                  <div class="col-lg-2">
                    <h6 class="mb-1">Keterangan</h6>
                    <p>{{ $pengadaan->keterangan ?? '-' }}</p>
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
                      @foreach ($pengadaan->detail as $p)
                      <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $p->buku ? $p->buku->judul : '-' }}</td>
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
          @if ( !$pengadaan->faktur )
            <div class="col-8">
              <form action="{{ route('pengadaan.unggah-faktur', ['id' => $pengadaan->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card">
                  <div class="card-header">
                    <h4>Unggah Faktur</h4>
                  </div>
                  <div class="card-body">
                    <img src="" class="w-100 img-thumbnail mb-3" style="display: none;" id="gambar">
                    <input type="file" id="faktur" name="faktur" hidden>
                    <div class="row">
                      <div class="col-6">
                        <label for="faktur" class="btn btn-success mb-0 w-100" id="pilihGambar">Pilih Gambar</label>
                      </div>
                      <div class="col-6">
                        <button type="submit" class="btn btn-primary w-100" id="unggahGambar" disabled>Unggah</button>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          @endif
        </div>
      </div>
    </section>
  </div>
</div>
@endsection

@push('js')
<script>
  $('input#faktur').change(function() {
    if (this.files && this.files[0]) {
      const reader = new FileReader();
      reader.onload = function (e) {
        $('#gambar').attr('src', e.target.result);
        $('#gambar').show();
        $('#unggahGambar').attr('disabled', false);
      }
      reader.readAsDataURL(this.files[0]);
    }
  });
</script>
@endpush