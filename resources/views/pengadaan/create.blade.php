@extends('layouts.partials.app')

@section('title')
Tambah Pengadaan
@endsection

@section('content')
<div class="main-wrapper main-wrapper-1">
  <div class="main-content" style="min-height: 116px;">
    <section class="section">
      <div class="section-header">
        <h1>Tambah Pengadaan</h1>
      </div>
      <div class="section-body">
        @include('layouts.flash-alert')
        <div class="card">
          <div class="card-header">
            <h4>Form Tambah Pengadaan</h4>
            <div class="card-header-form">
              <a href="{{ route('pengadaan') }}" class="btn btn-primary" data-tooltip="tooltip" title="Kembali">
                <i class="fas fa-chevron-left"></i>
              </a>
            </div>
          </div>
          <div class="card-body">
            <form action="{{ route('pengadaan.store') }}" method="POST" id="pengadaan" enctype="multipart/form-data">
              @csrf
              <input type="hidden" id="hasilRespon" name="bukuYangDibeli" hidden>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="hargaBeli">Nominal Pembayaran</label>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="basic-addon1">Rp</span>
                        </div>
                        <input type="number" class="form-control" id="hargaBeli" name="hargaBeli" value="0">
                        @error('hargaBeli')
                          <span class="invalid-feedback d-block" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="idDistributor">Distributor</label>
                      <select required name="idDistributor" class="form-control" value="{{ old('idDistributor') }}" data-live-search="true" required>
                        <option value='' disabled selected>- Pilih -</option>
                        @foreach($distributor as $pem)
                          <option value="{{ $pem['id'] }}"> {{$pem->nama}} </option>
                        @endforeach
                      </select>
                      @error('idDistributor')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="tanggal">Tanggal</label>
                      <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ date('Y-m-d') }}" required>
                    </div>
                  </div>
                  <div class="col-md-6">
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
                  </div>
                  <div class="col-12">
                    <div class="form-group mb-0">
                      <label for="keterangan">Keterangan</label>
                      <textarea type="text" class="form-control" name="keterangan" value="{{ old('keterangan') }}" style="height:80px;"></textarea>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="d-flex justify-content-between align-items-center">
                  <label for="buku" class="mb-2">Buku yang ingin dibeli</label>
                  <h6 class="mb-0 mr-2">Total <span id="totalSemuaHarga">0</span></h6>
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
                        <th scope="col">No</th>
                        <th scope="col">Status</th>
                        <th scope="col">Buku</th>
                        <th scope="col">Jumlah</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Sub Total</th>
                        <th scope="col"></th>
                      </tr>
                    </thead>
                    <tbody id="bukuContainer"></tbody>
                  </table>
                  <button type="button" class="btn btn-success" id="tambahBuku">Tambah Buku</button>
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
  <script src="{{ asset('js/pengadaan/create.js') }}"></script>
@endpush

@push('css')
  <link rel="stylesheet" href="{{ asset('css/transaksi/custom.css') }}">
@endpush