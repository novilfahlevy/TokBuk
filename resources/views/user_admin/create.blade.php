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
                                                    Nama
                                                    <input type="text" class="form-control" required name="name" value="{{ old('name') }}" >
                                                    <br/>
                                                    Username
                                                    <input type="text" class="form-control @error('username') is-invalid @enderror" required name="username" value="{{ old('username') }}">
                                                    @error('username')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                    @enderror
                                                    <br/>

                                                    Posisi
                                                    <select name="posisi" class="form-control">
                                                        <option value=''>--- Pilih Posisi ---</option>
                                                        <option value="Admin">Admin</option>
                                                        <option value="Operator">Operator</option>
                                                        <option value="Kasir">Kasir</option>
                                                    </select>
                                                    <br/>

                                                    E-Mail
                                                    <input type="email" class="form-control @error('email') is-invalid @enderror" required name="email" value="{{ old('email') }}">
                                                    @error('email')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                    @enderror
                                                    <br/>
                                                    Telepon
                                                    <input type="number" class="form-control" required name="telepon" value="{{ old('telepon') }}">
                                                </div>
                                                
                                               
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    Password
                                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                                        @error('password')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                        <br/>

                                                    Konfirmasi Password
                                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                                    <br/>

                                                    Alamat
                                                    <textarea type="text" class="form-control" required name="alamat" value="{{ old('alamat') }}" style="height:215px"></textarea>
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
