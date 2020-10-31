@extends('layouts.partials.app')

@section('title')
    Ubah Penerbit
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
                        </div>
                        <div class="card-body">
                            <form action="{{ route('penerbit.update', ['id' => $penerbit->id]) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate="" >
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            Nama
                                            <input type="text" class="form-control" required id="nama" name="nama" value="{{ $penerbit->nama }}">
                                            @error('nama')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <br/>
                                            Email
                                            <input type="email" class="form-control" id="email" name="email" value="{{ $penerbit->email }}">
                                            <br/>

                                            Telepon
                                            <input type="number" class="form-control" id="telepon" name="telepon" value="{{ $penerbit->telepon }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            Alamat
                                            <textarea type="text" class="form-control" required name="alamat"  style="height:215px">{{$penerbit->alamat}}</textarea>
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
