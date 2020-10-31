@extends('layouts.partials.app')
@section('title')
Transaksi Penjualan
@endsection

@section('content')
<div class="main-wrapper main-wrapper-1">
    <div class="main-content" style="min-height: 116px;">
        <section class="section">
            <div class="section-header">
                <h1>Transaksi Penjualan</h1>
            </div>
            <div class="section-body">
                <div class="content-body table">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            @include('layouts.flash-alert')
                            <div class="card">
                                <div class="card-header">
                                    <h4>Daftar Transaksi Penjualan</h4>
                                    <div class="card-header-action">
                                        <div class="col-md-3 col-sm-3 col-xs-4 text-right d-flex align-items-center">
                                            <button type="button" class="btn btn-sm btn-success mr-3" data-toggle="modal" data-target="#exportModal" title="Export Data">
                                                <i class="fas fa-file-export"></i>
                                            </button>
                                            <a href="{{ route('transaksi.create') }}" class="btn btn-sm btn-primary" title="Tambah Data">
                                                <i class="fas fa-plus"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-3">
                                    <div class="table-responsive">
                                        <table id="table-index" class="display table table-striped table-bordered"
                                            style="width:100%; text-align:center;">
                                            <thead style="">
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Tanggal</th>
                                                    <th scope="col">Ditangani Oleh</th>
                                                    <th scope="col">Total Harga</th>
                                                    <th scope="col">Uang Pembeli</th>
                                                    <th scope="col"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($transaksi as $t)
                                                <tr>
                                                    <td scope="row">{{$loop->index+1}}</td>
                                                    <td>{{ $t->created_at }}</td>
                                                    <td>{{ $t->user()->withTrashed()->first()->name }}</td>
                                                    <td>Rp {{ number_format($t->total_harga) }}</td>
                                                    <td>Rp {{ number_format($t->uang_pembeli) }}</td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <form method="post" class="delete_form "
                                                            action="{{route('transaksi.destroy',$t->id)}}">
                                                            @method('DELETE')
                                                            @csrf
                                                            <button class="btn btn-sm btn-danger" id="btn-delete"><i
                                                                class="fa fa-trash"></i></button>
                                                            </form>
                                                        </div>
                                                        <div class="btn-group">
                                                            <a href="{{ route('transaksi.detail', $t->id) }}"
                                                                class="btn btn-sm btn-success text-white">
                                                                <i class="fas fa-file"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
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
    <form action="{{ route('transaksi.export') }}" method="POST">
        @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Tambah Lokasi</h5>
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
