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
                                          <img src="{{ asset('images/buku/'.$buku->sampul) }}" alt="" style="width:100%; height:400px; background-size: cover" class="img-thumbnail">
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4>Data Buku</h4>
                                                    <div class="card-header-form">
                                                        <a href="{{ route('buku') }}" class="btn btn-primary" data-tooltip="tooltip" title="Kembali">
                                                          <i class="fas fa-chevron-left"></i>
                                                        </a>
                                                      </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row mb-4">
                                                        <div class="col-lg-4 col-5 font-weight-bold">Judul</div>
                                                        <div class="col-1 text-right">:</div>
                                                        <div class="col-lg-6 col-5">{{$buku->judul}}</div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <div class="col-lg-4 col-5 font-weight-bold">ISBN</div>
                                                        <div class="col-1 text-right">:</div>
                                                        <div class="col-lg-6 col-5">{{$buku->isbn}}</div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <div class="col-lg-4 col-5 font-weight-bold">Kategori</div>
                                                        <div class="col-1 text-right">:</div>
                                                        <div class="col-lg-6 col-5">{{$buku->kategori ? $buku->kategori->nama : '-'}}</div>
                                                    </div>
                                                    
                                                    <div class="row mb-4">
                                                        <div class="col-lg-4 col-5 font-weight-bold">Penulis</div>
                                                        <div class="col-1 text-right">:</div>
                                                        <div class="col-lg-6 col-5">{{$buku->penulis ? $buku->penulis->nama : '-'}}</div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <div class="col-lg-4 col-5 font-weight-bold">Penerbit</div>
                                                        <div class="col-1 text-right">:</div>
                                                        <div class="col-lg-6 col-5">{{$buku->penerbit ? $buku->penerbit->nama : '-'}}</div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <div class="col-lg-4 col-5 font-weight-bold">Tahun Terbit</div>
                                                        <div class="col-1 text-right">:</div>
                                                        <div class="col-lg-6 col-5">{{$buku->tahun_terbit ?? '-'}}</div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <div class="col-lg-4 col-5 font-weight-bold">Harga</div>
                                                        <div class="col-1 text-right">:</div>
                                                        <div class="col-lg-6 col-5">Rp. {{number_format($buku->harga, 2, ',', '.')}}</div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <div class="col-lg-4 col-5 font-weight-bold">Diskon</div>
                                                        <div class="col-1 text-right">:</div>
                                                        @if ( $buku->diskon )
                                                            <div class="col-lg-6 col-5">
                                                                {{ $buku->diskon }}% (Rp {{ number_format($buku->harga - (($buku->harga / 100) * $buku->diskon), 2, ',', '.') }})
                                                            </div>    
                                                        @else
                                                            <div class="col-lg-6 col-5">-</div>    
                                                        @endif
                                                    </div>
                                                    <div class="row mb-4">
                                                        <div class="col-lg-4 col-5 font-weight-bold">Jumlah</div>
                                                        <div class="col-1 text-right">:</div>
                                                        <div class="col-lg-6 col-5">{{$buku->jumlah}} Buku</div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <div class="col-lg-4 col-5 font-weight-bold">Tempat / Lokasi</div>
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