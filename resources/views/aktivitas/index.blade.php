@extends('layouts.partials.app')
@section('title')
Riwayat Aktivitas
@endsection

@section('content')
<div class="main-wrapper main-wrapper-1">
    <div class="main-content" style="min-height: 116px;">
        <section class="section">
            <div class="section-header">
                <h1>Riwayat Aktivitas</h1>
            </div>
            <div class="section-body">
                <div class="content-body table">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            @include('layouts.flash-alert')
                            <div class="card">
                                <div class="card-header">
                                    <h4>Daftar Riwayat Aktivitas</h4>
                                </div>
                                <div class="card-body p-3">
                                    <p>* Riwayat aktivitas yang ditampilkan hanya saat 3 bulan terakhir, aktivitas yang sudah lewat 3 bulan akan otomatis terhapus.</p>
                                    <div class="table-responsive">
                                        <table id="table-index" class="display table table-striped table-bordered"
                                            style="width:100%; text-align:center;">
                                            <thead style="">
                                                <tr>
                                                    <th scope="col">No</th>
                                                    <th>Pengguna</th>
                                                    <th>Aktivitas</th>
                                                    <th>Waktu</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($riwayat as $aktivitas)
                                                  <tr>
                                                    <td>{{ $loop->index + 1 }}</td>
                                                    <td>{{ $aktivitas->user ? $aktivitas->user->name : '-' }}</td>
                                                    <td align="left">{{ $aktivitas->aktivitas }}.</td>
                                                    <td>{{ $aktivitas->created_at }}</td>
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
