@extends('layouts.partials.app')

@section('title')
    Detail Buku
@endsection
@section('content')
    <div class="main-wrapper main-wrapper-1">
        <div class="main-content" style="min-height: 116px;">
            <section class="section">
                <div class="section-header">
                    <h1>Detail Buku</h1>
                </div>
                <div class="section-body">
                    <div class="row justify-content-center">
                        <div class="col-12">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="card border-dark mb-3" style="max-width: 50rem; height:450px">
                                                <div class="card-header"><h4>Foto Cover Depan</h4></div>
                                                <div class="card-body text-dark">
                                                    <td><img src="{{ asset('images/buku/'.$buku->sampul) }}" alt="" style="width:100%; height:100%;"></td>
                                                </div>
                                              </div>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="card">
                                                <div class="card-header"><h4>Detail Buku</h4></div>
                                                <div class="card-body">
                                                    <div class="row mb-4">
                                                        <div class="col-lg-4 col-5">Judul</div>
                                                        <div class="col-1 text-right">:</div>
                                                        <div class="col-lg-6 col-5">{{strtoupper($buku->judul)}}</div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <div class="col-lg-4 col-5">ISBN</div>
                                                        <div class="col-1 text-right">:</div>
                                                        <div class="col-lg-6 col-5">{{strtoupper($buku->isbn)}}</div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <div class="col-lg-4 col-5">Kategori</div>
                                                        <div class="col-1 text-right">:</div>
                                                        <div class="col-lg-6 col-5">{{strtoupper($buku->kategori ? $buku->kategori->nama : '')}}</div>
                                                    </div>
                                                    
                                                    <div class="row mb-4">
                                                        <div class="col-lg-4 col-5">Penulis</div>
                                                        <div class="col-1 text-right">:</div>
                                                        <div class="col-lg-6 col-5">{{strtoupper($buku->penulis ? $buku->penulis->nama : '')}}</div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <div class="col-lg-4 col-5">Penerbit</div>
                                                        <div class="col-1 text-right">:</div>
                                                        <div class="col-lg-6 col-5">{{strtoupper($buku->penerbit ? $buku->penerbit->nama : '')}}</div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <div class="col-lg-4 col-5">Tahun Terbit</div>
                                                        <div class="col-1 text-right">:</div>
                                                        <div class="col-lg-6 col-5">{{$buku->tahun_terbit}}</div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <div class="col-lg-4 col-5">Pemasok</div>
                                                        <div class="col-1 text-right">:</div>
                                                        <div class="col-lg-6 col-5">{{strtoupper($buku->pemasok ? $buku->pemasok->nama : '')}}</div>
                                                    </div>
                                                    
                                                    <div class="row mb-4">
                                                        <div class="col-lg-4 col-5">Harga (Per buku)</div>
                                                        <div class="col-1 text-right">:</div>
                                                        <div class="col-lg-6 col-5">Rp. {{number_format($buku->harga)}}</div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <div class="col-lg-4 col-5">Jumlah Stok Buku Saat ini</div>
                                                        <div class="col-1 text-right">:</div>
                                                        <div class="col-lg-6 col-5">{{$buku->jumlah}} BUKU</div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <div class="col-lg-4 col-5">Lokasi Buku</div>
                                                        <div class="col-1 text-right">:</div>
                                                        <div class="col-lg-6 col-5">{{strtoupper($buku->lokasi ? $buku->lokasi->nama : '')}}</div>
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