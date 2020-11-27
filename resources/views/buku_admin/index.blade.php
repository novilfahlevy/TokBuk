@extends('layouts.partials.app')
@section('title')
Buku
@endsection

@section('content')
<div class="main-wrapper main-wrapper-1">
    <div class="main-content" style="min-height: 116px;">
        <section class="section">
          <div class="section-header">
                <h1>Buku</h1>
          </div>
          <div class="section-body">
            <div class="content-body table">
                @include('layouts.flash-alert')
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Daftar Buku</h4>
                                <div class="card-header-action">
                                <div class="col-md-3 col-sm-3 col-xs-4 text-right d-flex align-items-center">
                                <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#filterModal" data-tooltip="tooltip" title="Filter"><i class="fas fa-filter"></i></button>
                                {{-- <a class="btn btn-sm btn-primary" href="{{route('buku.create')}}" data-tooltip="tooltip" title="Tambah"><i class="fas fa-plus"></i></a> --}}
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <div class="table-responsive">
                                <table id="table-index" class="display table-striped table-bordered" style="width:100%; text-align:center;">
                                    <thead style="">
                                        <tr>
                                            <th>No</th>
                                            <th>ISBN</th>
                                            <th>Judul Buku</th>
                                            <th>Kategori</th>
                                            <th>Jumlah</th>
                                            <th>Harga</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      @foreach ($buku as $b)
                                      <tr>
                                      <td>{{$loop->index+1}}</td>
                                      <td>{{$b->isbn}}</td>
                                      <td>{{$b->judul}}</td>
                                      <td>{{$b->kategori ? $b->kategori->nama : '-'}}</td>
                                      <td>{{$b->jumlah}}</td>
                                      <td>Rp. {{number_format($b->harga, 2, ',', '.')}}</td>
                                  <td>
                                    <div class="btn-group">
                                        <a href="{{ route( 'buku.detail' ,['id' => $b->id]) }}" class="btn btn-sm btn-primary text-white" data-tooltip="tooltip" title="Detail"><i class="fa fa-info px-1"></i></i></a>
                                    </div>
                                    <div class="btn-group">
                                        <a type="submit" class="btn btn-sm btn-info text-white" href="{{ route('buku.edit',  ['id' => $b["id"]]) }}" data-tooltip="tooltip" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                    </div>
                                    <div class="btn-group">
                                        <form method="post" class="delete_form " data-tooltip="tooltip" title="Hapus" action="{{route('buku.destroy',$b['id'])}}">
                                            @method('DELETE')
                                            @csrf
                                            <button  class="btn btn-sm btn-danger btn-delete" ><i class="fa fa-trash"></i></button>
                                        </form>
                                    </div>
                                    {{-- <div class="btn-group">
                                        <a href="{{ route( 'buku.tambah' ,['id' => $b->id]) }}" class="btn btn-sm btn-success text-white" title="Tambah Jumlah Buku"><i class="fas fa-plus"></i></i></a>
                                    </div> --}}
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

  <div class="modal fade" tabindex="-1" role="dialog" id="filterModal">
    <form action="{{ route('buku') }}" method="GET">
        {{-- @csrf --}}
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Filter</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pb-2">
                <div class="row">
                    @php
                        $kategoriId = session()->pull('kategori');
                        $penulisId = session()->pull('penulis');
                        $penerbitId = session()->pull('penerbit');
                        $distributorId = session()->pull('distributor');
                        $lokasiId = session()->pull('lokasi');
                    @endphp
                    <div class="col-6">
                        <div class="form-group mb-3 d-flex flex-column">
                            <label for="kategori">Kategori</label>
                            <select name="kategori" id="kategori" class="form-control">
                                <option value="" selected>Semua</option>
                                @foreach ($kategori as $k)
                                    <option value="{{ $k->id }}" {{ $kategoriId == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group mb-3 d-flex flex-column">
                            <label for="penerbit">Penerbit</label>
                            <select name="penerbit" id="penerbit" class="form-control">
                                <option value="" selected>Semua</option>
                                @foreach ($penerbit as $p)
                                    <option value="{{ $p->id }}" {{ $penerbitId == $p->id ? 'selected' : '' }}>{{ $p->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group mb-3 d-flex flex-column">
                            <label for="penulis">Penulis</label>
                            <select name="penulis" id="penulis" class="form-control">
                                <option value="" selected>Semua</option>
                                @foreach ($penulis as $p)
                                    <option value="{{ $p->id }}" {{ $penulisId == $p->id ? 'selected' : '' }}>{{ $p->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group mb-3 d-flex flex-column">
                            <label for="lokasi">Lokasi</label>
                            <select name="lokasi" id="lokasi" class="form-control">
                                <option value="" selected>Semua</option>
                                @foreach ($lokasi as $l)
                                    <option value="{{ $l->id }}" {{ $lokasiId == $l->id ? 'selected' : '' }}>{{ $l->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group mb-3">
                            <label for="tahunTerbitDari">Tahun terbit dari</label>
                            <input type="number" id="tahunTerbitDari" name="tahunTerbitDari" class="form-control" pattern="/0-9/" value="{{ session()->pull('tahunTerbitDari') }}">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group mb-3">
                            <label for="tahunTerbitSampai">Tahun terbit sampai</label>
                            <input type="number" id="tahunTerbitSampai" name="tahunTerbitSampai" class="form-control" pattern="/0-9/" value="{{ session()->pull('tahunTerbitSampai') }}">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group mb-2">
                            <label for="tahunTerbitDari">Jumlah dari</label>
                            <input type="number" id="jumlahDari" name="jumlahDari" class="form-control" pattern="/0-9/" value="{{ session()->pull('jumlahDari') }}">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group mb-2">
                            <label for="jumlahSampai">Jumlah sampai</label>
                            <input type="number" id="jumlahSampai" name="jumlahSampai" class="form-control" pattern="/0-9/" value="{{ session()->pull('jumlahSampai') }}">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group mt-2 mb-0">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="diskon" id="diskon" {{ session()->pull('diskon') ? 'checked' : '' }}>
                                <label class="custom-control-label" for="diskon" style="user-select: none">Diskon</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-between pt-3">
                <a href="{{ route('buku') }}" class="btn btn-info">Clear</a>
                <div>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                  <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
            </div>
        </div>
    </form>
</div>
@endsection