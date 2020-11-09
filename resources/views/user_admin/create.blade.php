@extends('layouts.partials.app')

@section('title')
    Tambah Pengguna
@endsection

@section('content')
    <div class="main-wrapper main-wrapper-1">
        <div class="main-content" style="min-height: 116px;">
            <section class="section">
                <div class="section-header">
                    <h1>Tambah Pengguna</h1>
                </div>
                <div class="section-body">
                    @include('layouts.flash-alert')
                    <div class="card">
                        <div class="card-header">
                            <h4>Form Tambah Pengguna</h4>
                            <div class="card-header-form">
                                <a href="{{ route('user') }}" class="btn btn-primary" title="Kembali">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            </div>
                        </div>
                                <div class="card-body">
                                    <form action="{{route('user.store')}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate="" >
                                        {{ csrf_field() }}
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="name">Nama</label>
                                                    <input type="text" class="form-control" required id="name" name="name" value="{{ old('name') }}">
                                                    @error('name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="username">Username</label>
                                                    <input type="text" class="form-control @error('username') is-invalid @enderror" required name="username" id="username" value="{{ old('username') }}">
                                                    @error('username')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="telepon">Telepon</label>
                                                    <input type="number" class="form-control @error('telepon') is-invalid @enderror" required name="telepon" value="{{ old('telepon') }}">
                                                    @error('telepon')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="email">Email</label>
                                                    <input type="email" class="form-control @error('email') is-invalid @enderror" required name="email" value="{{ old('email') }}">
                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="password">Password</label>
                                                    <input type="password" class="form-control @error('password') is-invalid @enderror" required name="password" value="{{ old('password') }}">
                                                    @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="password_confirmation">Konfirmasi Password</label>
                                                    <input type="password" class="form-control" required name="password_confirmation" value="{{ old('password_confirmation') }}">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="posisi">Posisi</label>
                                                    <select name="posisi" class="form-control">
                                                        @if ( auth()->user()->posisi === 'Admin' ) 
                                                            <option value="Admin">Admin</option> 
                                                        @endif
                                                        <option value="Operator">Operator</option>
                                                        <option value="Kasir">Kasir</option>
                                                    </select>
                                                    @error('posisi')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="alamat">Alamat</label>
                                                    <textarea type="text" class="form-control" required id="alamat" name="alamat" value="{{ old('alamat') }}" style="height:180px"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <button class="btn btn-primary" type="submit">Simpan</button>
                                    </form>
                                </div>

                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
