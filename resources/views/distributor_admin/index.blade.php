@extends('layouts.partials.app')
@section('title')
Distributor
@endsection

@section('content')
<div class="main-wrapper main-wrapper-1">
    <div class="main-content" style="min-height: 116px;">
        <section class="section">
          <div class="section-header">
                <h1>Distributor</h1>
          </div>
        </section>
          <div class="section-body">
            <div class="content-body table">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        {{-- @if ( ($message = Session::get('message')) && ($type = Session::get('type')) )
                            <div class="alert alert-{{ $type }} alert-dismissible fade show">
                                {{ $message }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif --}}
                        @include('layouts.flash-alert')
                        <div class="card">
                            <div class="card-header">
                                <h4>Daftar Distributor</h4>
                                <div class="card-header-action">
                                <div class="col-md-3 col-sm-3 col-xs-4 text-right">
                                <a class="btn btn-sm btn-primary" href="{{route('distributor.create')}}" data-tooltip="tooltip" title="Tambah"><i class="fas fa-plus"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <div class="table-responsive">
                                <table id="table-index" class="display table-striped table-bordered" style="width:100%; text-align:center;">
                                    <thead style="">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      @foreach ($distributor as $s)
                                      <tr>
                                      <td>{{$loop->index+1}}</td>
                                      <td>{{$s->nama}}</td>
                                  <td>
                                    <a type="button" class="btn btn-sm btn-primary text-white" data-toggle="modal" data-target=".bs-example-modal-lg-{{$s->id}}" title="Detail Data"><i class="fa fa-info px-1"></i></a>
                                      <div class="btn-group">
                                        <a type="submit" class="btn btn-sm btn-info text-white" href="{{ route('distributor.edit',  ['id' => $s["id"]]) }}" title="Edit Data"><i class="fas fa-pencil-alt"></i></a>
                                    </div>
                                    <div class="btn-group">
                                        <form method="post" class="delete_form " action="{{route('distributor.destroy',$s['id'])}}">
                                            @method('DELETE')
                                            @csrf
                                            <button  class="btn btn-sm btn-danger btn-delete" title="Hapus Data"  ><i class="fa fa-trash"></i></button>
                                        </form>
                                    </div>
                                  </td>
                              </tr>
                              <div class="modal fade bs-example-modal-lg-{{$s->id}}" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h3 class="modal-title" id="exampleModalLabel">Detail Distributor</h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12" style="text-align: left;">
                                                <h6>Nama</h6>
                                                <label for="">{{$s->nama}}</label>
                                                <hr>
                                                <h6>Alamat</h6>
                                                <label for="">{{!!$s->alamat ? $s->alamat : '-'}}</label>
                                                <hr>
                                                <h6>E-Mail</h6>
                                                <label for="">{{!!$s->email ? $s->email : '-'}}</label>
                                                <hr>
                                                <h6>Telepon</h6>
                                                <label for="">{{!!$s->telepon ? $s->telepon : '-'}}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                                  @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- </section> --}}
    </div>
  </div>
@endsection
