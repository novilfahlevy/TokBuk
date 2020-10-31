@extends('layouts.partials.app')

@section('title')
Tambah Transaksi
@endsection

@section('content')
<div class="main-wrapper main-wrapper-1">
  <div class="main-content" style="min-height: 116px;">
    <section class="section">
      <div class="section-header">
        <h1>Tambah Transaksi</h1>
      </div>
      <div class="section-body">
        @include('layouts.flash-alert')
        <div class="card">
          <div class="card-header">
            <h4>Form Tambah Transaksi</h4>
            <div class="card-header-form">
              <a href="{{ route('transaksi') }}" class="btn btn-primary">
                <i class="fas fa-chevron-left"></i>
              </a>
            </div>
          </div>
          <div class="card-body">
            <form action="{{ route('transaksi.store') }}" method="POST" id="formTransaksi">
              @csrf
              <input type="hidden" id="hasilRespon" name="transaksi" hidden>
              <div class="form-group">
                <label for="uangPembeli">Uang pembeli</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Rp</span>
                  </div>
                  <input type="number" class="form-control" id="uangPembeli" name="uangPembeli" value="0">
                  @error('uangPembeli')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>
              <div class="form-group">
                <div class="d-flex justify-content-between align-items-center">
                  <label for="buku" class="mb-2">Buku yang ingin dibeli</label>
                  <h6 class="mb-0 mr-2">Total Rp <span id="totalSemuaHarga">0</span></h6>
                </div>
                @error('bukuDibeli')
                  <span class="invalid-feedback d-block my-2" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
                @enderror
                <div class="table-responsive">
                  <table class="display table table-striped table-bordered" style="width:100%; text-align:center;">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Judul</th>
                        <th scope="col">Jumlah</th>
                        <th scope="col">Harga Per Buku</th>
                        <th scope="col">Total Harga</th>
                        <th scope="col"></th>
                      </tr>
                    </thead>
                    <tbody id="bukuContainer">
                      
                    </tbody>
                  </table>
                  <button type="button" class="btn btn-primary w-100" id="tambahBuku">Tambah Buku</button>
                </div>
              </div>
              <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>
@endsection

@push('js')
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
  <script src="{{ asset('js/transaksi/create.js') }}"></script>
@endpush

@push('css')
  <link rel="stylesheet" href="{{ asset('css/transaksi/custom.css') }}">
@endpush