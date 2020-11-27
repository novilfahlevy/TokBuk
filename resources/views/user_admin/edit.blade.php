@extends('layouts.partials.app')

@section('title')
    Edit Pengguna
@endsection

@section('content')
    <div class="main-wrapper main-wrapper-1">
        <div class="main-content" style="min-height: 116px;">
            <section class="section">
                <div class="section-header">
                    <h1>Edit Pengguna</h1>
                </div>
                <div class="section-body">
                    <div class="card">
                        <div class="card-header">
                            <h4>Form Edit Pengguna</h4>
                            <div class="card-header-form">
                                <a href="{{ route('user') }}" class="btn btn-primary" data-tooltip="tooltip" title="Kembali">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('user.update', ['id' => $user->id]) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate="" >
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Nama</label>
                                            <input type="text" class="form-control" required id="name" name="name" value="{{ old('name', $user->name) }}">
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
                                            <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" id="username" value="{{ old('username') }}" placeholder="{{ $user->username }}">
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
                                            <input type="number" class="form-control @error('telepon') is-invalid @enderror" required name="telepon" value="{{ old('telepon', $user->telepon) }}" min="0">
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
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="{{ $user->email }}">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="posisi">Posisi</label>
                                            <select name="posisi" class="form-control">
                                                @php $posisi = auth()->user()->posisi; @endphp
                                                @if ( $posisi === 'Admin' || $posisi === 'Owner' ) 
                                                    <option value="Admin" {{ $user->posisi === 'Admin' ? 'selected' : '' }}>Admin</option>
                                                @endif
                                                <option value="Operator" {{ $user->posisi === 'Operator' ? 'selected' : '' }}>Operator</option>
                                                <option value="Kasir" {{ $user->posisi === 'Kasir' ? 'selected' : '' }}>Kasir</option>
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
                                            <textarea type="text" class="form-control" required name="alamat" style="height:180px">{{ old('alamat', $user->alamat) }}</textarea>
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
