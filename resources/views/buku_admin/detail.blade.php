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
                    @include('layouts.flash-alert')
                    <div class="row justify-content-center">
                        <div class="col-12">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="card border-dark mb-3" style="max-width: 50rem; height:450px">
                                                <div class="card-header"><h4>Sampul Buku</h4></div>
                                                <div class="card-body text-dark">
                                                    <td><img src="{{ asset('images/buku/'.$buku->sampul) }}" alt="" style="width:100%; height:100%;" class="img-thumbnail"></td>
                                                </div>
                                              </div>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4>Data Buku</h4>
                                                    <div class="card-header-form">
                                                        <a href="{{ route('buku') }}" class="btn btn-primary" title="Kembali">
                                                          <i class="fas fa-chevron-left"></i>
                                                        </a>
                                                      </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row mb-4">
                                                        <div class="col-lg-4 col-5">Judul</div>
                                                        <div class="col-1 text-right">:</div>
                                                        <div class="col-lg-6 col-5">{{$buku->judul}}</div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <div class="col-lg-4 col-5">ISBN</div>
                                                        <div class="col-1 text-right">:</div>
                                                        <div class="col-lg-6 col-5">{{$buku->isbn}}</div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <div class="col-lg-4 col-5">Kategori</div>
                                                        <div class="col-1 text-right">:</div>
                                                        <div class="col-lg-6 col-5">{{$buku->kategori ? $buku->kategori->nama : '-'}}</div>
                                                    </div>
                                                    
                                                    <div class="row mb-4">
                                                        <div class="col-lg-4 col-5">Penulis</div>
                                                        <div class="col-1 text-right">:</div>
                                                        <div class="col-lg-6 col-5">{{$buku->penulis ? $buku->penulis->nama : '-'}}</div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <div class="col-lg-4 col-5">Penerbit</div>
                                                        <div class="col-1 text-right">:</div>
                                                        <div class="col-lg-6 col-5">{{$buku->penerbit ? $buku->penerbit->nama : '-'}}</div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <div class="col-lg-4 col-5">Tahun Terbit</div>
                                                        <div class="col-1 text-right">:</div>
                                                        <div class="col-lg-6 col-5">{{$buku->tahun_terbit ?? '-'}}</div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <div class="col-lg-4 col-5">Harga</div>
                                                        <div class="col-1 text-right">:</div>
                                                        <div class="col-lg-6 col-5">Rp. {{number_format($buku->harga, 2, ',', '.')}}</div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <div class="col-lg-4 col-5">Jumlah</div>
                                                        <div class="col-1 text-right">:</div>
                                                        <div class="col-lg-6 col-5">{{$buku->jumlah}} Buku</div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <div class="col-lg-4 col-5">Tempat / Lokasi</div>
                                                        <div class="col-1 text-right">:</div>
                                                        <div class="col-lg-6 col-5">{{$buku->lokasi ? $buku->lokasi->nama : '-'}}</div>
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