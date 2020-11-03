@extends('layouts.partials.app')
@section('title')
Pengaturan
@endsection

@section('content')
<div class="main-wrapper main-wrapper-1">
  <div class="main-content" style="min-height: 116px;">
    <section class="section">
      <div class="section-header">
        <h1>Pengaturan</h1>
      </div>
      <div class="section-body">
        @include('layouts.flash-alert')
        <div class="content-body">
          <div class="card">
            <div class="card-header">
              <h4>Form Pengaturan</h4>
            </div>
            <div class="card-body">
              <form action="{{ route('pengaturan.update') }}" method="POST">
                @csrf @method('PUT')
                <div class="form-group">
                  <label for="nama_toko">Nama Toko</label>
                  <input type="text" class="form-control" id="nama_toko" name="nama_toko" value="{{ $pengaturan->nama_toko }}">
                  @error('nama_toko')
                    <span class="invalid-feedback d-block" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" class="form-control" id="email" name="email" value="{{ $pengaturan->email }}">
                  @error('email')
                    <span class="invalid-feedback d-block" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="telepon">Telepon</label>
                  <input type="number" class="form-control" id="telepon" name="telepon" value="{{ $pengaturan->telepon }}">
                  @error('telepon')
                    <span class="invalid-feedback d-block" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="alamat">Alamat</label>
                  <textarea class="form-control" id="alamat" name="alamat" style="height:150px">{{ $pengaturan->alamat }}</textarea>
                  @error('alamat')
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
      </div>
    </section>
  </div>
</div>
@endsection