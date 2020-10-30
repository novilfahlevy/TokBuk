@extends('layouts.partials.app')
@section('title')
Lokasi Buku
@endsection

@section('content')
<div class="main-wrapper main-wrapper-1">
    <div class="main-content" style="min-height: 116px;">
        <section class="section">
          <div class="section-header">
                <h1>Lokasi Buku</h1>
          </div>
          <div class="section-body">
            <div class="content-body table">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        @if ( $alert = Session::get('alert') )
                            <div class="alert alert-{{ $alert['type'] }} alert-dismissible fade show">
                                {{ $alert['message'] }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <div class="card">
                            <div class="card-header">
                                <h4>Daftar Lokasi Buku</h4>
                                <div class="card-header-action">
                                <div class="col-md-3 col-sm-3 col-xs-4 text-right">
                                <button class="btn btn-sm btn-primary" title="Tambah Data" data-toggle="modal" data-target="#createLokasiModal">
                                    <i class="fas fa-plus"></i>
                                </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <div class="table-responsive">
                                <table id="table-index" class="display table table-striped table-bordered" style="width:100%; text-align:center;">
                                    <thead style="">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Nama</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      @foreach ($lokasi as $l)
                                      <tr>
                                      <td scope="row">{{$loop->index+1}}</td>
                                      <td>{{$l->nama}}</td>
                                  <td>
                                      <div class="btn-group">
                                        @php 
                                            $dataLokasi = base64_encode(json_encode([
                                                'id' => $l->id,
                                                'nama' => $l->nama
                                            ]));
                                        @endphp
                                        <button type="button" class="btn btn-sm btn-info text-white edit-lokasi" data-lokasi="{{ $dataLokasi }}" data-toggle="modal" data-target="#editLokasiModal">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                    </div>
                                    <div class="btn-group">
                                        <form method="post" class="delete_form " action="{{route('lokasi.destroy',$l['id'])}}">
                                            @method('DELETE')
                                            @csrf
                                            <button  class="btn btn-sm btn-danger" id="btn-delete"  ><i class="fa fa-trash"></i></button>
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

  <div class="modal" tabindex="-1" role="dialog" id="createLokasiModal">
    <form action="{{ route('lokasi.store') }}" method="POST">
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
                    <label for="lokasi">Nama Lokasi</label>
                    <input type="text" class="form-control" id="lokasi" name="lokasi">
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary">Simpan</button>
              </div>
            </div>
        </div>
    </form>
  </div>

  <div class="modal" tabindex="-1" role="dialog" id="editLokasiModal">
    <form action="{{ route('lokasi.update', 'id') }}" method="POST">
        @csrf @method('PUT')
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
                    <label for="lokasi">Nama Lokasi</label>
                    <input type="text" class="form-control" id="lokasi" name="lokasi">
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary">Simpan</button>
              </div>
            </div>
        </div>
    </form>
  </div>
@endsection

@push('js')
    <script>
        $('button.edit-lokasi').click(function() {
            const dataLokasi = $(this).data('lokasi');
            const { id, nama } = JSON.parse(atob(dataLokasi));
            $('#editLokasiModal input#lokasi').val(nama);
            $('#editLokasiModal form').attr('action', `${BASEURL}/lokasi/${id}/update`);
        });
    </script>
@endpush