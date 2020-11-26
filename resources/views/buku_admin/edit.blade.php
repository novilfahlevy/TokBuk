@extends('layouts.partials.app')

@section('title')
    Edit Buku
@endsection

@section('content')
    <div class="main-wrapper main-wrapper-1">
        <div class="main-content" style="min-height: 116px;">
            <section class="section">
                <div class="section-header">
                    <h1>Edit Buku</h1>
                    
                </div>
                <div class="section-body">
                                    <form action="{{ route('buku.update', ['id' => $buku->id]) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate="" >
                                        {{ csrf_field() }}
                                        {{ method_field('PUT') }}
                                          <div class="row">
                                            <div class="col-sm-4">
                                              <img src="{{ asset('images/buku/'.$buku->sampul) }}" id="showgambar" style="width:100%;height:350px;" class="img-thumbnail mb-3" />
                                              {{-- <label for="inputGambar">Sampul Buku (abaikan jika tidak ingin mengubah)</label> --}}
                                              <input type="file" id="inputgambar" name="sampul" class="validate d-none" />
                                              <label class="btn btn-success w-100" for="inputgambar">
                                                Ganti Sampul
                                              </label>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h4>Form Edit Buku</h4>
                                                        <div class="card-header-form">
                                                            <a href="{{ route('buku') }}" class="btn btn-primary" data-tooltip="tooltip" title="Kembali">
                                                              <i class="fas fa-chevron-left"></i>
                                                            </a>
                                                          </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-12 col-md-6">
                                                                <div class="form-group">
                                                                    <label for="isbn">ISBN</label>
                                                                    <input type="text" class="form-control" required name="isbn" value="{{ $buku->isbn }}" >
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-6">
                                                                <div class="form-group">
                                                                    <label for="judul">Judul Buku</label>
                                                                    <input type="text" class="form-control" required name="judul" value="{{ $buku->judul }}" >
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-6">
                                                                <div class="form-group">
                                                                    <label for="id_kategpri">Kategori</label>
                                                                    <select name="id_kategori" id="id_kategpri" class="form-control" value="{{ old('id_kategori') }}" data-live-search="true"> 
                                                                        <option value=''>- Pilih -</option>
                                                                        @foreach($kategori as $jen)
                                                                            <option value="{{ $jen['id'] }}" {{$jen->id == $buku->id_kategori ?  'selected' : ''}}> {{$jen->nama}} </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-6">
                                                                <div class="form-group">
                                                                    <label for="id_penulis">Penulis</label>
                                                                    <select name="id_penulis" id="id_penulis" class="form-control" value="{{ old('id_penulis') }}"data-live-search="true">
                                                                        <option value='' >- Pilih -</option>
                                                                        @foreach($penulis as $pel)
                                                                            <option value="{{ $pel['id'] }}" {{$pel->id == $buku->id_penulis ?  'selected' : ''}}> {{$pel->nama}} </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-6">
                                                                <div class="form-group">
                                                                    <label for="id_penerbit">Penerbit</label>
                                                                    <select name="id_penerbit" class="form-control" value="{{ old('id_penerbit') }}" data-live-search="true">
                                                                        <option value=''>- Pilih -</option>
                                                                        @foreach($penerbit as $per)     
                                                                            <option value="{{ $per['id'] }}" {{$per->id == $buku->id_penerbit ?  'selected' : ''}}> {{$per->nama}} </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-6">
                                                                <div class="form-group">
                                                                    <label for="tahun_terbit">Tahun Terbit</label>
                                                                    <input type="number" class="form-control" id="tahun_terbit" name="tahun_terbit" value="{{ $buku->tahun_terbit }}" >
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-6">
                                                                <div class="form-group">
                                                                    <label for="id_lokasi">Lokasi</label>
                                                                    <select name="id_lokasi" id="id_lokasi" class="form-control" value="{{ old('id_lokasi') }}" data-live-search="true">
                                                                        <option value=''>- Pilih -</option>
                                                                        @foreach($lokasi as $lok)     
                                                                            <option value="{{ $lok['id'] }}" {{$lok->id == $buku->id_lokasi ?  'selected' : ''}}> {{$lok->nama}} </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-6">
                                                                <div class="form-group">
                                                                    <label for="harga">Harga</label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text" id="basic-addon1">Rp</span>
                                                                        </div>
                                                                    <input type="number" class="form-control" id="harga" name="harga" value="{{ $buku->harga }}" >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="diskon">Diskon</label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text" id="basic-addon1">%</span>
                                                                        </div>
                                                                    <input type="number" class="form-control" id="diskon" name="diskon" value="{{ $buku->diskon }}" >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <button class="btn btn-primary" type="submit" >Simpan Perubahan</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                
                        
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

@section('js')
<script type="text/javascript">

      function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#showgambar').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#inputgambar").change(function () {
        readURL(this);
    });

</script>

@stop
