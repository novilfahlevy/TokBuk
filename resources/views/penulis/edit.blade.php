@extends('layouts.partials.app')

@section('title')
Ubah Nama Penulis
@endsection

@section('content')
<div class="main-wrapper main-wrapper-1">
  <div class="main-content" style="min-height: 116px;">
    <section class="section">
      <div class="section-header">
        <h1>Ubah Nama Penulis</h1>
      </div>
      <div class="section-body">
        <div class="card">
          <div class="card-header">
            <h4>Form Ubah Nama Penulis</h4>
          </div>
          <div class="card-body">
            <h6>Bila ada tanda <span class="text-danger">*</span> Input tidak boleh dikosongkan.</h6>
            <br><br>
            <form action="{{ route('penulis.update', ['id' => $penulis->id]) }}" method="POST"
              enctype="multipart/form-data" >
              {{ csrf_field() }}
              {{ method_field('PUT') }}
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <p>Nama Penulis*</p>
                    <input type="text" class="form-control" required name="nama" value="{{$penulis->nama}}">
                  </div>
                </div>
              </div>
              <button class="btn btn-primary" type="submit">Ubah</button>
            </form>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>
@endsection