@extends('layouts.partials.app')
@section('title')
Penerbit
@endsection

@section('content')
<div class="main-wrapper main-wrapper-1">
  <div class="main-content" style="min-height: 116px;">
    <section class="section">
      <div class="section-header">
        <h1>Penerbit</h1>
      </div>
    </section>
    <div class="section-body">
      <div class="content-body table">
        <div class="row">
          <div class="col-12 col-md-12 col-lg-12">
            @include('layouts.flash-alert')
            <div class="card">
              <div class="card-header">
                <h4>Daftar Penerbit</h4>
                <div class="card-header-action">
                  <div class="col-md-3 col-sm-3 col-xs-4 text-right">
                    <a class="btn btn-sm btn-primary" href="{{route('penerbit.create')}} " data-tooltip="tooltip"
                      title="Tambah"><i class="fas fa-plus"></i></a>
                  </div>
                </div>
              </div>
              <div class="card-body p-3">
                <div class="table-responsive">
                  <table id="table-index" class="display table-striped table-bordered"
                    style="width:100%; text-align:center;">
                    <thead style="">
                      <tr>
                        <th>No</th>
                        <th>Nama Penerbit</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($penerbit as $p)
                      <tr>
                        <td>{{$loop->index+1}}</td>
                        <td>{{$p->nama}}</td>
                        <td>
                          <a type="button" class="btn btn-sm btn-primary text-white" data-toggle="modal"
                            data-target=".bs-example-modal-lg-{{$p->id}}" data-tooltip="tooltip" title="Detail"><i
                              class="fa fa-info px-1"></i></a>
                          <div class="btn-group">
                            <a type="submit" class="btn btn-sm btn-info text-white"
                              href="{{ route('penerbit.edit',  ['id' => $p["id"]]) }}" data-tooltip="tooltip"
                              title="Edit"><i class="fas fa-pencil-alt"></i></a>
                          </div>
                          <div class="btn-group">
                            <form method="post" class="delete_form " data-tooltip="tooltip" title="Hapus"
                              action="{{route('penerbit.destroy',$p['id'])}}">
                              @method('DELETE')
                              @csrf
                              <button class="btn btn-sm btn-danger btn-delete"><i class="fa fa-trash"></i></button>
                            </form>
                          </div>
                        </td>
                      </tr>

                      {{-- modal --}}
                      <div class="modal fade bs-example-modal-lg-{{$p->id}}" id="exampleModal" tabindex="-1"
                        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h3 class="modal-title" id="exampleModalLabel">Detail Penerbit</h3>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <div class="row">
                                <div class="col-md-12" style="text-align: left;">
                                  <h6>Nama</h6>
                                  <label for="">{{$p->nama}}</label>
                                  <hr>
                                  <h6>Alamat</h6>
                                  <label for="">{{!!$p->alamat ? $p->alamat : '-'}}</label>
                                  <hr>
                                  <h6>E-Mail</h6>
                                  <label for="">{{!!$p->email ? $p->email : '-'}}</label>
                                  <hr>
                                  <h6>Telepon</h6>
                                  <label for="">{{!!$p->telepon ? $p->telepon : '-'}}</label>
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