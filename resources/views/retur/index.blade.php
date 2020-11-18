@extends('layouts.partials.app')
@section('title')
Retur
@endsection

@section('content')
<div class="main-wrapper main-wrapper-1">
    <div class="main-content" style="min-height: 116px;">
        <section class="section">
            <div class="section-header">
                <h1>Retur</h1>
            </div>
            <div class="section-body">
                <div class="content-body table">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            @include('layouts.flash-alert')
                            <div class="card">
                                <div class="card-header">
                                    <h4>Daftar Retur</h4>
                                    <div class="card-header-action">
                                        <div class="col-md-3 col-sm-3 col-xs-4 text-right d-flex align-items-center">
                                            <a href="{{ route('retur.create') }}" class="btn btn-sm btn-primary" data-tooltip="tooltip" title="Buat Retur">
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
                                                    <th scope="col">No</th>
                                                    <th>Kode</th>
                                                    <th>Tanggal</th>
                                                    <th>Nominal Pembayaran</th>
                                                    <th>Jumlah Buku</th>
                                                    <th>Total Harga</th>
                                                    <th scope="col"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($transaksi as $t)
                                                
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
