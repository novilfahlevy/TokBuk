@extends('layouts.partials.app')
@section('title')
Pengadaan
@endsection

@section('content')
<div class="main-wrapper main-wrapper-1">
  <div class="main-content" style="min-height: 116px;">
    <section class="section">
      <div class="section-header">
        <h1>Pengadaan</h1>
      </div>
      <div class="section-body">
        <div class="content-body table">
          <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
              @include('layouts.flash-alert')
              <div class="card">
                <div class="card-header">
                  <h4>Daftar Pengadaan</h4>
                  <div class="card-header-action">
                    <div class="col-md-3 col-sm-3 col-xs-4 text-right d-flex align-items-center">
                      <button type="button" class="btn btn-sm btn-success mr-2" data-toggle="modal"
                        data-target="#exportModal" data-tooltip="tooltip" title="Export XLSX">
                        <i class="fas fa-file-export"></i>
                      </button>
                      <button type="button" class="btn btn-sm btn-warning mr-2" data-toggle="modal"
                        data-target="#filterModal" data-tooltip="tooltip" title="Filter">
                        <i class="fas fa-filter"></i>
                      </button>
                      <a href="{{ route('pengadaan.create') }}" class="btn btn-sm btn-primary" data-tooltip="tooltip"
                        title="Buat Pengadaan">
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
                          <th>Harga</th>
                          <th>Faktur</th>
                          <th scope="col"></th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($pengadaan as $p)
                        <tr>
                          <td scope="row">{{ $loop->index + 1 }}</td>
                          <td>{{ $p->kode }}</td>
                          <td>{{ $p->tanggal }}</td>
                          <td>Rp {{ number_format($p->bayar, 2, ',', '.') }}</td>
                          <td>{{ $p->jumlah_buku }}</td>
                          <td>Rp {{ number_format($p->total_harga, 2, ',', '.') }}</td>
                          <td>
                            <div class="badge badge-{{ $p->faktur ? 'success' : 'warning' }} w-100">
                              {{ $p->faktur ? 'Sudah diunggah' : 'Belum diunggah' }}
                            </div>
                          </td>
                          <td>
                            <div class="btn-group">
                              <a href="{{ route('pengadaan.detail', $p->id) }}"
                                class="btn btn-sm btn-primary text-white" data-tooltip="tooltip" title="Detail">
                                <i class="fas fa-info px-1"></i>
                              </a>
                            </div>
                            <div class="btn-group">
                              <form method="post" class="delete_form " data-tooltip="tooltip" title="Hapus"
                                action="{{route('pengadaan.destroy',$p->id)}}">
                                @method('DELETE')
                                @csrf
                                <button class="btn btn-sm btn-danger btn-delete"><i class="fa fa-trash"></i></button>
                              </form>
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

@php $distributorId = session()->pull('distributor') @endphp

<div class="modal fade" tabindex="-1" role="dialog" id="exportModal">
  <form action="{{ route('pengadaan.export') }}" method="POST">
    @csrf
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Export XLXS</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pb-2">
          <div class="form-group mb-0">
            <div class="row">
              <div class="col-12">
                <div class="form-group mb-3 d-flex flex-column">
                  <label for="distributorExport">Distributor</label>
                  <select name="distributor" id="distributorExport" class="form-control">
                    <option value="" selected>Semua</option>
                    @foreach ($distributor as $p)
                    <option value="{{ $p->id }}" {{ $distributorId == $p->id ? 'selected' : '' }}>{{ $p->nama }}
                    </option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group mb-0">
                  <label for="mulai">Dari tanggal</label>
                  <input type="date" class="form-control" id="mulai" name="mulai">
                </div>
              </div>
              <div class="col-6">
                <div class="form-group mb-0">
                  <label for="sampai">Sampai tanggal</label>
                  <input type="date" class="form-control" id="sampai" name="sampai">
                </div>
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

<div class="modal fade" tabindex="-1" role="dialog" id="filterModal">
  <form action="{{ route('pengadaan') }}" method="GET">
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
          <div class="form-group mb-0">
            <div class="row">
              <div class="col-12">
                <div class="form-group mb-3 d-flex flex-column">
                  <label for="distributor">Distributor</label>
                  <select name="distributor" id="distributor" class="form-control">
                    <option value="" selected>Semua</option>
                    @foreach ($distributor as $p)
                    <option value="{{ $p->id }}" {{ $distributorId == $p->id ? 'selected' : '' }}>{{ $p->nama }}
                    </option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group mb-3">
                  <label for="mulai">Dari tanggal</label>
                  <input type="date" class="form-control" id="mulai" name="mulai"
                    value="{{ session()->pull('mulai') }}">
                </div>
              </div>
              <div class="col-6">
                <div class="form-group mb-3">
                  <label for="sampai">Sampai tanggal</label>
                  <input type="date" class="form-control" id="sampai" name="sampai"
                    value="{{ session()->pull('sampai') }}">
                </div>
              </div>
              <div class="col-12">
                <div class="form-group mb-3 d-flex flex-column">
                  <label for="faktur">Faktur</label>
                  <select name="faktur" id="faktur" class="form-control">
                    <option value="Sudah Diunggah" selected>Sudah Diunggah</option>
                    <option value="Belum Diunggah">Belum Diunggah</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer d-flex justify-content-between pt-3">
          <a href="{{ route('pengadaan') }}" class="btn btn-info">Bersihkan</a>
          <div>
            <button type="button" class="btn btn-secondary mr-1" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Filter</button>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
@endsection