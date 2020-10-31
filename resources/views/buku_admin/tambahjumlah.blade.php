@extends('layouts.partials.app')

@section('title')
    Tambah Jumlah Buku
@endsection

@section('content')
    <div class="main-wrapper main-wrapper-1">
        <div class="main-content" style="min-height: 116px;">
            <section class="section">
                <div class="section-header">
                    <h1>Tambah Jumlah Buku</h1>
                </div>
                <div class="section-body">
                    <h6>Bila ada tanda <span class="text-danger">*</span> Input tidak boleh dikosongkan.</h6>
                    <br>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="card border-dark mb-3" style="max-width: 50rem; height:430px">
                                <div class="card-header"><h4>Sampul Buku</h4></div>
                                    <div class="card-body text-dark">
                                        <img src="{{ asset('images/buku/'.$buku->sampul) }}" alt="" style="width:100%; height:100%;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="card">
                                    <div class="card-header"><h4>Tambah Jumlah Buku</h4></div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <h6>ISBN</h6>
                                                    {{$buku->isbn}}
                                                </div>
                                                <div class="col-md-4">
                                                    <h6>Judul</h6>
                                                    {{$buku->judul}}
                                                </div>
                                                <div class="col-md-4">
                                                    <h6>Jumlah Awal</h6>
                                                    {{$buku->jumlah}} Buku
                                                </div>
                                            </div>
                                            <br/><br/>
                                            <form action="{{ route('buku.tambahstore') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate="" >
                                            {{ csrf_field() }}
                                            <div class="row">
                                                <div class="col-md-6">
                                                    Harga Beli*
                                                    <input type="number" class="form-control" required name="harga_beli" value="{{ old('harga_beli') }}" >
                                                </div>
                                                <div class="col-md-6">
                                                    Harga Jual*
                                                    <input type="number" class="form-control" required name="harga_jual" value="{{ old('harga_jual') }}" >
                                                </div>
                                            </div>
                                            <br/>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    Jumlah*
                                                    <input type="number" class="form-control" required name="jumlah" value="{{ old('jumlah') }}" >
                                                </div>
                                            </div>
                                            <br/>
                                            <button class="btn btn-primary" type="submit">Tambah Jumlah</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>   
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection