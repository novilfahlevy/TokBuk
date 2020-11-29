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
                          <th>Jumlah Buku</th>
                          <th>Dana Pengembalian</th>
                          <th>Distributor</th>
                          <th scope="col"></th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($returs as $retur)
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $retur->kode }}</td>
                        <td>{{ $retur->tanggal }}</td>
                        <td>{{ $retur->jumlah }}</td>
                        <td>Rp {{ number_format($retur->total_dana_pengembalian, 2, ',', '.') }}</td>
                        <td>{{ $retur->pengadaan->distributor ? $retur->pengadaan->distributor->nama : '-' }}</td>
                        <td>
                          <div class="btn-group">
                            <a href="{{ route('retur.detail', $retur->id) }}" class="btn btn-sm btn-primary text-white"
                              data-tooltip="tooltip" title="Detail">
                              <i class="fas fa-info px-1"></i>
                            </a>
                          </div>
                          <div class="btn-group">
                            <form method="post" class="delete_form" data-tooltip="tooltip" title="Hapus"
                              action="{{route('retur.destroy',$retur->id)}}">
                              @method('DELETE')
                              @csrf
                              <button class="btn btn-sm btn-danger btn-delete"><i class="fa fa-trash"></i></button>
                            </form>
                          </div>
                        </td>
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