@extends('layouts.partials.app')

@section('title')
    Edit Distributor
@endsection

@section('content')
    <div class="main-wrapper main-wrapper-1">
        <div class="main-content" style="min-height: 116px;">
            <section class="section">
                <div class="section-header">
                    <h1>Edit Distributor</h1>
                </div>
                <div class="section-body">
                    <div class="card">
                        <div class="card-header">
                            <h4>Form Edit Distributor</h4>
                            <div class="card-header-form">
                                <a href="{{ route('distributor') }}" class="btn btn-primary" data-tooltip="tooltip" title="Kembali">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('distributor.update', ['id' => $distributor->id]) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate="" >
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}
                                {{-- <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <p>Kategori*</p>
                                        <input type="text" class="form-control" required name="name" value="{{$kategori->name}}" >
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nama">Nama</label>
                                            <input type="text" class="form-control" required id="nama" name="nama" value="{{$distributor->nama}}">
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" id="email" required name="email" value="{{$distributor->email}}" >
                                        </div>
                                        <div class="form-group">
                                            <label for="telepon">Telepon</label>
                                            <input type="number" class="form-control" id="telepon" required name="telepon" value="{{$distributor->telepon}}" min="0">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="alamat">Alamat</label>
                                            <textarea type="text" class="form-control" id="alamat" required name="alamat"  style="height:215px">{{$distributor->alamat}}</textarea>
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
