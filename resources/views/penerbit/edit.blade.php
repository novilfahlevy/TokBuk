@extends('layouts.partials.app')

@section('title')
Edit Penerbit
@endsection

@section('content')
<div class="main-wrapper main-wrapper-1">
  <div class="main-content" style="min-height: 116px;">
    <section class="section">
      <div class="section-header">
        <h1>Edit Penerbit</h1>
      </div>
      <div class="section-body">
        <div class="card">
          <div class="card-header">
            <h4>Form Edit Penerbit</h4>
            <div class="card-header-form">
              <a href="{{ route('penerbit') }}" class="btn btn-primary" data-tooltip="tooltip" title="Kembali">
                <i class="fas fa-chevron-left"></i>
              </a>
            </div>
          </div>
          <div class="card-body">
            <form action="{{ route('penerbit.update', ['id' => $penerbit->id]) }}" method="POST"
              enctype="multipart/form-data" >
              {{ csrf_field() }}
              {{ method_field('PUT') }}
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control" required id="nama" name="nama"
                      value="{{ $penerbit->nama }}">
                    @error('nama')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <br />
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $penerbit->email }}">
                    <br />

                    <label for="telepon">Telepon</label>
                    <input type="number" class="form-control" id="telepon" name="telepon"
                      value="{{ $penerbit->telepon }}" min="0">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea type="text" class="form-control" name="alamat"
                      style="height:215px">{{$penerbit->alamat}}</textarea>
                  </div>
                </div>
              </div>

              <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
            </form>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>
@endsection