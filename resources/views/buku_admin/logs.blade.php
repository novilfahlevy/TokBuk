@extends('layouts.partials.app')
@section('title')
Riwayat Penambahan dan Pembelian Buku
@endsection

@section('content')
<div class="main-wrapper main-wrapper-1">
    <div class="main-content" style="min-height: 116px;">
        <section class="section">
          <div class="section-header">
                <h1>Riwayat Penambahan dan Pembelian Buku</h1>
          </div>
          <div class="section-body">
            <div class="content-body table">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Data Riwayat Pembelian Buku</h4>
                                <div class="card-header-action">
                                <div class="col-md-3 col-sm-3 col-xs-4 text-right d-flex align-items-center">
                                <a class="btn btn-sm btn-primary mr-2" href="{{route('buku')}}" title="Kembali"><i class="fas fa-chevron-left"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <div class="table-responsive">
                                <table id="table-index" class="display table-striped table-bordered" style="width:100%; text-align:center;">
                                    <thead style="">
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Judul Buku</th>
                                            <th>Ditangani Oleh</th>
                                            <th>Harga Jual / Buku</th>
                                            <th>Harga Beli</th>
                                            <th>Jumlah</th>
                                            <th>Total Harga</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      @foreach ($logs as $b)
                                      <tr>
                                      <td>{{$loop->index+1}}</td>
                                      <td>{{$b->created_at}}</td>
                                      <td>{{$b->buku()->withTrashed()->first()->judul}}</td>
                                      <td>{{$b->user()->withTrashed()->first()->name}}</td>
                                      <td>Rp. {{$b->harga_jual}},00</td>
                                      <td>Rp. {{$b->harga_beli}},00</td>
                                      <td>{{$b->jumlah}}</td>
                                      <td>Rp. {{$b->harga_jual * $b->jumlah}},00</td>
                                      <td>
                                        <div class="badge badge-{{ $b->status === 'Baru' ? 'success' : 'primary' }}">
                                          {{$b->status}}
                                        </div>
                                      </td>
                              </tr>
                                  @endforeach
                                    </tbody>
                                </table> <br>
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