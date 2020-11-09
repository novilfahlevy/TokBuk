@extends('layouts.partials.app')
@section('title')
Penulis
@endsection

@section('content')
<div class="main-wrapper main-wrapper-1">
    <div class="main-content" style="min-height: 116px;">
        <section class="section">
          <div class="section-header">
                <h1>Penulis</h1>
          </div>
        </section>
          <div class="section-body">
            <div class="content-body table">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        @include('layouts.flash-alert')
                        <div class="card">
                            <div class="card-header">
                                <h4>Daftar Penulis</h4>
                                <div class="card-header-action">
                                <div class="col-md-3 col-sm-3 col-xs-4 text-right">
                                    <a class="btn btn-sm btn-primary text-white" data-target=".bs-example-modal-lg-" data-toggle="modal" title="Tambah Data"><i class="fas fa-plus"></i></a>
                                </div>
                            </div>
                        </div>

                        {{-- modal tambah --}}
                        <div class="modal fade bs-example-modal-lg-" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form action="{{ route('penulis.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate="" >
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Tambah Penulis</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body pb-2">
                                        {{ csrf_field() }}
                                            <div class="form-group mb-0">
                                                <label for="recipient-name" class="col-form-label">Nama Penulis</label>
                                                <input type="text" class="form-control" required id="recipient-name" name="nama" value="{{ old('nama') }}" >
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                            <button class="btn btn-primary" type="submit">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <div class="table-responsive">
                                <table id="table-index" class="display table-striped table-bordered" style="width:100%; text-align:center;">
                                    <thead style="">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Penulis</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($penulis as $p)
                                        <tr>
                                            <td>{{$loop->index+1}}</td>
                                            <td>{{$p->nama}}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a type="submit" class="btn btn-sm btn-info text-white" data-toggle="modal" data-target=".bs-example-modal-lg-{{$p->id}}" title="Edit Data"><i class="fas fa-pencil-alt"></i></a>
                                                </div>
                                                <div class="btn-group">
                                                    <form method="post" class="delete_form " action="{{route('penulis.destroy',$p['id'])}}">
                                                    @method('DELETE')
                                                    @csrf
                                                        <button  class="btn btn-sm btn-danger" id="btn-delete"  title="Hapus data"><i class="fa fa-trash"></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                            
                                            {{-- modal edit --}}
                                            <div class="modal fade bs-example-modal-lg-{{$p->id}}" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Edit Penulis</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('penulis.update', ['id' => $p->id]) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate="" >
                                                        <div class="modal-body pb-2">
                                                            {{ csrf_field() }}
                                                            {{ method_field('PUT') }}
                                                                <div class="form-group mb-0">
                                                                    <label for="recipient-name" class="col-form-label">Nama Penulis</label>
                                                                    <input type="text" class="form-control" required id="recipient-name" name="nama" value="{{$p->nama}}" >
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                                <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
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
    </div>
  </div>
@endsection

