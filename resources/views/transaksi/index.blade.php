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
                                            <a href="{{ route('transaksi.export') }}" class="btn btn-sm btn-success mr-3" title="Export Data">
                                                <i class="fas fa-file-export"></i>
                                            </a>
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
@endsection
