@extends('layouts.partials.app')

@section('title')
    Tambah Distributor
@endsection

@section('content')
    <div class="main-wrapper main-wrapper-1">
        <div class="main-content" style="min-height: 116px;">
            <section class="section">
                <div class="section-header">
                    <h1>Tambah Distributor</h1>
                </div>
                <div class="section-body">
                    <div class="card">
                        <div class="card-header">
                            <h4>Form Tambah Distributor</h4>
                            <div class="card-header-form">
                                <a href="{{ route('distributor') }}" class="btn btn-primary" data-tooltip="tooltip" title="Kembali">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            </div>
                        </div>
                                <div class="card-body">
                                    <form action="{{ route('distributor.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate="" >
                                        {{ csrf_field() }}
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="nama">Nama</label>
                                                    <input type="text" class="form-control" required id="nama" name="nama" value="{{ old('nama') }}" >
                                                </div>
                                                <div class="form-group">
                                                    <label for="email">Email</label>
                                                    <input type="email" class="form-control" required id="email" name="email" value="{{ old('email') }}" >
                                                </div>
                                                <div class="form-group">
                                                    <label for="telepon">Telepon</label>
                                                    <input type="number" class="form-control" required id="telepon" name="telepon" value="{{ old('telepon') }}" min="0">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="alamat">Alamat</label>
                                                    <textarea type="text" class="form-control" required id="alamat" name="alamat" value="{{ old('alamat') }}" style="height:215px"></textarea>
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
