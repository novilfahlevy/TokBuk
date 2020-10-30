@extends('layouts.partials.app')

@section('title')
    Tambah Buku
@endsection
@section('content')
    <div class="main-wrapper main-wrapper-1">
        <div class="main-content" style="min-height: 116px;">
            <section class="section">
                <div class="section-header">
                    <h1>Tambah Buku</h1>
                </div>
                <div class="section-body">
                    <h6>Bila ada tanda <span class="text-danger">*</span> Input tidak boleh dikosongkan.</h6>
                    <br>
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <form action="{{ route('buku.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate="" >
                                {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="card border-dark mb-3" style="max-width: 50rem; height:500px">
                                                <div class="card-header"><h4>Sampul Buku</h4></div>
                                                <div class="card-body text-dark">
                                                    <img src="http://placehold.it/" id="showgambar"alt="" style="width:100%; height:80%;"><br/><br/>
                                                    <small>Sampul Buku*</small>
                                                    <input type="file" class="form-control validate" id="inputgambar"required name="sampul" value="{{isset($insert) ? $insert->sampul : ''}}" >
                                                </div>
                                            </div>
                                            <button class="btn btn-primary" type="submit" style="width: 100%">Simpan Data</button>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="card">
                                                <div class="card-header"><h4>Data Buku</h4></div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            ISBN*
                                                            <input type="number" class="form-control" required name="isbn" value="{{ old('isbn') }}" >
                                                            <br/>

                                                            Judul Buku*
                                                            <input type="text" class="form-control" required name="judul" value="{{ old('judul') }}" >
                                                            <br/>

                                                            Kategori*
                                                            <select required name="id_kategori" class="form-control" value="{{ old('id_kategori') }}" data-live-search="true">
                                                                <option value=''>- Pilih -</option>
                                                                @foreach($kategori as $jen)
                                                                    <option value="{{ $jen['id'] }}"> {{$jen->nama}} </option>
                                                                @endforeach
                                                            </select>
                                                            <br/>

                                                            Penulis*
                                                            <select required name="id_penulis" class="form-control" value="{{ old('id_penulis') }}" data-live-search="true">
                                                                <option value=''>- Pilih -</option>
                                                                @foreach($penulis as $pel)
                                                                    <option value="{{ $pel['id'] }}"> {{$pel->nama}} </option>
                                                                @endforeach
                                                            </select>

                                                            <br/>
                                                            Penerbit*
                                                            <select required name="id_penerbit" class="form-control" value="{{ old('id_penerbit') }}" data-live-search="true">
                                                                <option value=''>- Pilih -</option>
                                                                @foreach($penerbit as $per)     
                                                                    <option value="{{ $per['id'] }}"> {{$per->nama}} </option>
                                                                @endforeach
                                                            </select>

                                                            <br/>
                                                            Pemasok*
                                                            <select required name="id_pemasok" class="form-control" value="{{ old('id_pemasok') }}" data-live-search="true">
                                                                <option value=''>- Pilih -</option>
                                                                @foreach($Pemasok as $sup)     
                                                                    <option value="{{ $sup['id'] }}"> {{$sup->nama}} </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                Tahun Terbit Buku*
                                                                <input type="number" class="form-control" required name="tahun_terbit" value="{{ old('tahun_terbit') }}" >
                                                                 <br/>

                                                                Lokasi Buku*
                                                                <select required name="id_lokasi" class="form-control" value="{{ old('id_lokasi') }}" data-live-search="true">
                                                                    <option value=''>- Pilih -</option>
                                                                    @foreach($lokasi as $lok)
                                                                        <option value="{{ $lok['id'] }}"> {{$lok->nama}} </option>
                                                                    @endforeach
                                                                </select>
                                                                <br/>

                                                                Harga Beli Dari Pemasok*
                                                                <input type="number" class="form-control" required name="harga_beli" value="{{ old('harga_beli') }}" >
                                                                <br/>

                                                                Harga Jual Dari Pemasok*
                                                                <input type="number" class="form-control" required name="harga_jual" value="{{ old('harga_jual') }}" >
                                                                <br/>

                                                                Harga Buku*
                                                                <input type="number" class="form-control" required name="harga" value="{{ old('harga') }}" >
                                                                <br/>

                                                                Jumlah Stok*
                                                                <input type="number" class="form-control" required name="jumlah" value="{{ old('jumlah') }}" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                   
                            </form>
                        </div>
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
