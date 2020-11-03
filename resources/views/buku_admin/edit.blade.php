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
                                                <div class="card border-dark mb-3" style="max-width: 50rem; height:500px">
                                                    <div class="card-header"><h4>Sampul Buku</h4></div>
                                                    <div class="card-body text-dark">
                                                        <img src="{{ asset('images/buku/'.$buku->sampul) }}" id="showgambar" style="width:100%;height:315px;" /><br/><br/>
                                                        <small>Sampul Buku (abaikan jika tidak ingin mengubah)</small>
                                                        <input type="file" id="inputgambar" name="sampul" class="form-control validate" value="{{$buku->sampul}}"/>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h4>Data Buku</h4>
                                                        <div class="card-header-form">
                                                            <a href="{{ route('buku') }}" class="btn btn-primary" title="Kembali">
                                                              <i class="fas fa-chevron-left"></i>
                                                            </a>
                                                          </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                ISBN
                                                                <input type="number" class="form-control" required name="isbn" value="{{ $buku->isbn }}" >
                                                                <br/>
    
                                                                Judul Buku
                                                                <input type="text" class="form-control" required name="judul" value="{{ $buku->judul }}" >
                                                                <br/>
    
                                                                Kategori
                                                                <select name="id_kategori" class="form-control" value="{{ old('id_kategori') }}" data-live-search="true"> 
                                                                    <option value=''>- Pilih -</option>
                                                                    @foreach($kategori as $jen)
                                                                        <option value="{{ $jen['id'] }}" {{$jen->id == $buku->id_kategori ?  'selected' : ''}}> {{$jen->nama}} </option>
                                                                    @endforeach
                                                                </select>
                                                                <br/>
    
                                                                Penulis
                                                                <select name="id_penulis" class="form-control" value="{{ old('id_penulis') }}"data-live-search="true">
                                                                    <option value='' >- Pilih -</option>
                                                                    @foreach($penulis as $pel)
                                                                        <option value="{{ $pel['id'] }}" {{$pel->id == $buku->id_penulis ?  'selected' : ''}}> {{$pel->nama}} </option>
                                                                    @endforeach
                                                                </select>
                                                                <br/>

                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    Penerbit
                                                                    <select name="id_penerbit" class="form-control" value="{{ old('id_penerbit') }}" data-live-search="true">
                                                                        <option value=''>- Pilih -</option>
                                                                        @foreach($penerbit as $per)     
                                                                            <option value="{{ $per['id'] }}" {{$per->id == $buku->id_penerbit ?  'selected' : ''}}> {{$per->nama}} </option>
                                                                        @endforeach
                                                                    </select>
                                                                    <br/>
                                                                    {{-- Pemasok
                                                                    <select name="id_pemasok" class="form-control" value="{{ old('id_pemasok') }}" data-live-search="true">
                                                                        <option value=''>- Pilih -</option>
                                                                        @foreach($Pemasok as $sup)     
                                                                            <option value="{{ $sup['id'] }}" {{$sup->id == $buku->id_pemasok ?  'selected' : ''}}> {{$sup->nama}} </option>
                                                                        @endforeach
                                                                    </select>
                                                                    <br/> --}}
                                                                    
                                                                    Tahun Terbit
                                                                    <input type="number" class="form-control" name="tahun_terbit" value="{{ $buku->tahun_terbit }}" >
                                                                    <br/>
    
                                                                    Lokasi
                                                                    <select name="id_lokasi" class="form-control" value="{{ old('id_lokasi') }}" data-live-search="true">
                                                                        <option value=''>- Pilih -</option>
                                                                        @foreach($lokasi as $lok)     
                                                                            <option value="{{ $lok['id'] }}" {{$lok->id == $buku->id_lokasi ?  'selected' : ''}}> {{$lok->nama}} </option>
                                                                        @endforeach
                                                                    </select>
                                                                    <br/>
    
                                                                    Harga
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text" id="basic-addon1">Rp</span>
                                                                        </div>
                                                                    <input type="number" class="form-control" name="harga" value="{{ $buku->harga }}" >
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button class="btn btn-primary" type="submit" >Simpan Perubahan</button>
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
