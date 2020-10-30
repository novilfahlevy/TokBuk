@extends('layouts.partials.app')

@section('title')
    Detail Penerbit
@endsection
@section('content')
    <div class="main-wrapper main-wrapper-1">
        <div class="main-content" style="min-height: 116px;">
            <section class="section">
                <div class="section-header">
                    <h1>Detail Penerbit</h1>
                </div>
                <div class="section-body">
                    <div class="row justify-content-center">
                        <div class="col-12">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="card">
                                                <div class="card-header"><h4>Detail Penerbit</h4></div>
                                                <div class="card-body">
                                                    <div class="row mb-4">
                                                        <div class="col-lg-4 col-5">Nama</div>
                                                        <div class="col-1 text-right">:</div>
                                                        <div class="col-lg-6 col-5">{{strtoupper($penerbit->nama)}}</div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <div class="col-lg-4 col-5">Alamat</div>
                                                        <div class="col-1 text-right">:</div>
                                                        <div class="col-lg-6 col-5">{{strtoupper(!!$penerbit->alamat ? $penerbit->alamat : '-')}}</div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <div class="col-lg-4 col-5">Email</div>
                                                        <div class="col-1 text-right">:</div>
                                                        <div class="col-lg-6 col-5">{{strtoupper(!!$penerbit->email ? $penerbit->email : '-')}}</div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <div class="col-lg-4 col-5">Telepon</div>
                                                        <div class="col-1 text-right">:</div>
                                                        <div class="col-lg-6 col-5">{{strtoupper($penerbit->telepon ? $penerbit->telepon : '-')}}</div>
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