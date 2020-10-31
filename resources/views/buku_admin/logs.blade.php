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
                                <button type="button" class="btn btn-sm btn-success mr-3" data-toggle="modal" data-target="#exportModal" title="Export Data">
                                    <i class="fas fa-file-export"></i>
                                </button>
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
                                      <td>Rp {{number_format($b->harga_jual)}}</td>
                                      <td>Rp {{number_format($b->harga_beli)}}</td>
                                      <td>{{$b->jumlah}}</td>
                                      <td>Rp {{number_format($b->harga_jual * $b->jumlah)}}</td>
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

  <div class="modal" tabindex="-1" role="dialog" id="exportModal">
    <form action="{{ route('logbuku.export') }}" method="POST">
        @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Export Data Riwayat Pembelian Buku</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="form-group mb-0">
                    <div class="row">
                        <div class="col-6">
                            <label for="mulai">Dari tanggal</label>
                            <input type="date" class="form-control" id="mulai" name="mulai">
                        </div>
                        <div class="col-6">
                            <label for="sampai">Sampai tanggal</label>
                            <input type="date" class="form-control" id="sampai" name="sampai">
                        </div>
                    </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Export</button>
              </div>
            </div>
        </div>
    </form>
  </div>
@endsection