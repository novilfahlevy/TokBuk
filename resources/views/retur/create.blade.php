@extends('layouts.partials.app')

@section('title')
Tambah Retur
@endsection

@section('content')
<span class="d-none" id="idPengadaan">{{ $pengadaan->id }}</span>
<div class="main-wrapper main-wrapper-1">
  <div class="main-content" style="min-height: 116px;">
    <section class="section">
      <div class="section-header">
        <h1>Pengajuan Retur</h1>
      </div>
      <div class="section-body">
        @include('layouts.flash-alert')
        <div class="card">
          <div class="card-header">
            <h4>Form Pengajuan Retur</h4>
            <div class="card-header-form">
              <a href="{{ route('pengadaan.detail', $pengadaan->id) }}" class="btn btn-primary" data-tooltip="tooltip"
                title="Kembali">
                <i class="fas fa-chevron-left"></i>
              </a>
            </div>
          </div>
          <div class="card-body">
            <form action="{{ route('retur.store', ['id' => $pengadaan->id]) }}" method="POST" id="formRetur">
              @csrf
              <input type="hidden" id="hasilRespon" name="retur" hidden>
              <div class="row">
                <div class="col-lg-2">
                  <h6 class="mb-1">Kode Pengadaan</h6>
                  <p>{{ $pengadaan->kode }}</p>
                </div>
                <div class="col-lg-2">
                  <h6 class="mb-1">Tanggal Pengadaan</h6>
                  <p>{{ $pengadaan->tanggal }}</p>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ date('Y-m-d') }}"
                      required>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="d-flex justify-content-between align-items-center">
                  <label for="buku" class="mb-2">Buku yang ingin dikembalikan</label>
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
                        <th scope="col">Judul</th>
                        <th scope="col">Jumlah</th>
                        <th scope="col">Keterangan</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Sub Total</th>
                        <th scope="col"></th>
                      </tr>
                    </thead>
                    <tbody id="bukuContainer">

                    </tbody>
                  </table>
                </div>
                <button type="button" class="btn btn-success mt-2" data-toggle="modal" data-target="#tambahBukuBaruModal">Tambah Buku</button>
              </div>
              <p>* Pastikan buku yang ingin diretur masih dalam keadaan sama seperti saat baru dibeli melalui pengadaan.
              </p>
              <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="tambahBukuBaruModal">
  <form action="" method="GET" id="formTambahBukuBaru">
    {{-- @csrf --}}
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Buku Baru</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pb-2">
          <div class="row">
            <div class="col-12">
              <div class="alert alert-danger" style="display: none;" id="error"></div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label for="isbn">ISBN</label>
                <input type="text" class="form-control" id="isbn" name="isbn" placeholder="Contoh: 978-601-8520-93-1">
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label for="judul">Judul</label>
                <input type="text" class="form-control" id="judul" name="judul" disabled>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label for="keterangan">Keterangan</label>
                <textarea class="form-control" id="keterangan" name="keterangan" style="height: 100px"></textarea>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label for="jumlah">Jumlah</label>
                <input type="number" class="form-control" id="jumlah" name="jumlah" min="1" value="1">
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label for="harga">Harga</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon2">Rp</span>
                  </div>
                  <input type="number" class="form-control" id="harga" name="harga" min="0" value="0">
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label for="subTotal">Sub Total</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon2">Rp</span>
                  </div>
                  <input type="text" class="form-control" id="subTotal" name="subTotal" value="0" disabled>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary mr-1" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success">Tambah</button>
        </div>
      </div>
    </div>
  </form>
</div>
@endsection

@push('js')
<script src="{{ asset('js/retur/create.js') }}"></script>
@endpush

@push('css')
<link rel="stylesheet" href="{{ asset('css/transaksi/custom.css') }}">
@endpush