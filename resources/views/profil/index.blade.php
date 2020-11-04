@extends('layouts.partials.app')
@section('title')
Profil
@endsection

@section('content')
<div class="main-wrapper main-wrapper-1">
  <div class="main-content" style="min-height: 116px;">
    <section class="section">
      <div class="section-header">
        <h1>Profil Saya</h1>
      </div>
      <div class="section-body">
        <div class="content-body table">
          <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
              {{-- @if ( ($message = Session::get('message')) && ($type = Session::get('type')) )
                <div class="alert alert-{{ $type }} alert-dismissible fade show">
                  {{ $message }}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
             @endif --}}
             @include('layouts.flash-alert')
            <div class="row">
              <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h4>Form Profil</h4>
              </div>
              <div class="card-body p-3">
                <div class="row">
                  <div class="col-12">
                    <form action="{{ route('profil.update') }}" method="POST">
                      @csrf @method('PUT')
                        <div class="form-group">
                          <label for="name">Nama</label>
                          <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
                          @error('name')
                            <span class="invalid-feedback d-block" role="alert">
                              <strong>{{ $message }}</strong>
                            </span>
                          @enderror
                        </div>
                        <div class="form-group">
                          <label for="username">Username</label>
                          <input type="text" class="form-control" id="username" name="username" placeholder="{{ $user->username }}">
                          @error('username')
                            <span class="invalid-feedback d-block" role="alert">
                              <strong>{{ $message }}</strong>
                            </span>
                          @enderror
                        </div>
                        <div class="form-group">
                          <label for="alamat">Alamat</label>
                          <input type="text" class="form-control" id="alamat" name="alamat" value="{{ $user->alamat }}">
                          @error('alamat')
                            <span class="invalid-feedback d-block" role="alert">
                              <strong>{{ $message }}</strong>
                            </span>
                          @enderror
                        </div>
                        <div class="form-group">
                          <label for="email">Email</label>
                          <input type="email" class="form-control" id="email" name="email" placeholder="{{ $user->email }}">
                          @error('email')
                            <span class="invalid-feedback d-block" role="alert">
                              <strong>{{ $message }}</strong>
                            </span>
                          @enderror
                        </div>
                        <div class="form-group">
                          <label for="telepon">Telepon</label>
                          <input type="number" class="form-control" id="telepon" name="telepon" value="{{ $user->telepon }}">
                          @error('telepon')
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
            </div>
            
             
            
             <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                  <h4>Form Ganti Password</h4>
                </div>
                <div class="card-body p-3">
                  <div class="row">
                    <div class="col-12">
                      <form action="{{ route('profil.password') }}" method="POST">
                        @csrf @method('PUT')
                        <div class="form-group">
                          <label for="passwordLama">Password Lama</label>
                          <input type="password" class="form-control" id="passwordLama" name="passwordLama">
                          @error('passwordLama')
                            <span class="invalid-feedback d-block" role="alert">
                              <strong>{{ $message }}</strong>
                            </span>
                          @enderror
                        </div>
                        <div class="form-group">
                          <label for="password">Password Baru</label>
                          <input type="password" class="form-control" id="password" name="password">
                          @error('password')
                            <span class="invalid-feedback d-block" role="alert">
                              <strong>{{ $message }}</strong>
                            </span>
                          @enderror
                        </div>
                        <div class="form-group">
                          <label for="password_confirmation">Konfirmasi Password Baru</label>
                          <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                        </div>
                        <button type="submit" class="btn btn-primary">Ganti Password</button>
                      </form>
                    </div>
                  </div>
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