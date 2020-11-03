{{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<h4>Faktur Pembelian Buku</h4>
<table class="display table table-striped table-bordered" style="width:100%; text-align:center;" border="1" cellpadding="10" cellspacing="0">
  <tbody>
    <tr>
      <td>Kode</td>
      <td>{{ $pembelian->kode }}</td>
    </tr>
    <tr>
      <td>Tanggal</td>
      <td>{{ $pembelian->created_at }}</td>
    </tr>
    <tr>
      <td>Pemasok</td>
      <td>{{ $pembelian->pemasok->nama }}</td>
    </tr>
    <tr>
      <td>Bayar</td>
      <td>Rp {{ number_format($pembelian->harga_beli) }}</td>
    </tr>
    <tr>
      <td>Total Harga</td>
      <td>Rp {{ number_format($pembelian->total_harga_jual) }}</td>
    </tr>
    <tr>
      <td>Kembalian</td>
      <td>Rp {{ number_format($pembelian->harga_beli - $pembelian->total_harga_jual) }}</td>
    </tr>
  </tbody>
</table>
<table class="display table table-striped table-bordered" style="width:100%; text-align:center;" border="1" cellpadding="10" cellspacing="0">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">ISBN</th>
      <th scope="col">Judul</th>
      <th scope="col">Harga</th>
      <th scope="col">Jumlah</th>
      <th scope="col">Total Harga</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($pembelian->detail as $p)
      <tr>
        <td>{{ $loop->index + 1 }}</td>
        <td>{{ $p->buku()->withTrashed()->first()->isbn }}</td>
        <td>{{ $p->buku()->withTrashed()->first()->judul }}</td>
        <td>Rp {{ number_format($p->harga_jual) }}</td>
        <td>{{ $p->jumlah }}</td>
        <td>Rp {{ number_format($p->harga_jual * $p->jumlah) }}</td>
      </tr>
    @endforeach
  </tbody>
</table> --}}

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<h5 style="text-align: center">TokBuk </h5>
<h5 style="text-align: center">Faktur Pembelian Buku</h5><br>
<table style="width: 50%; border-width: 0">
  <tbody>
    <tr>
      <td><h6>Kode Pembelian</h6></td>
      <td><h6>:</h6></td>
      <td><h6>{{ $pembelian->kode }}</h6></td>
    </tr>
    <tr>
      <td><h6>Tanggal</h6></td>
      <td><h6>:</h6></td>
      <td><h6>{{ $pembelian->created_at }}</h6></td>
    </tr>
    <tr>
      <td><h6>Pemasok</h6></td>
      <td><h6>:</h6></td>
      <td><h6>{{ $pembelian->pemasok->nama }}</h6></td>
    </tr>
    <tr>
      <td><h6>Dilayani</h6></td>
      <td><h6>:</h6></td>
      <td><h6>{{ $pembelian->user->name}}</h6></td>
    </tr>
  </tbody>
</table>
<hr style="border-bottom: dashed;">

<table style="width: 100%">
  <tr>
    <td>Buku <hr style="border-bottom: dashed;"></td>
    <td>Harga <hr style="border-bottom: dashed;"></td>
    <td>QTY<hr style="border-bottom: dashed;"></td>
    <td>Total Harga <hr style="border-bottom: dashed;"></td>
  </tr>
  
  @foreach ($pembelian->detail as $p)
  <tr>
    <td>{{ $p->buku()->withTrashed()->first()->judul }}<br>
      {{ $p->buku()->withTrashed()->first()->isbn }}</td>
      <td>Rp {{ number_format($p->harga_jual) }}</td>
      <td>{{ $p->jumlah }}</td>
      <td>Rp {{ number_format($p->harga_jual * $p->jumlah) }}</td>
    </tr>
    @endforeach
  </table>
  <hr style="border-bottom: dashed;">

  <table style="width: 100%; text-align : center;">
    <tbody>
      <tr>
        <td>Bayar</td>
        <td>Rp {{ number_format($pembelian->harga_beli) }}</td>
      </tr>
      <tr>
        <td >Total Harga</td>
        <td >Rp {{ number_format($pembelian->total_harga_jual) }}</td>
      </tr>
      
      <tr>
        <td>Kembalian</td>
        <td>Rp {{ number_format($pembelian->harga_beli - $pembelian->total_harga_jual) }}</td>
      </tr>
    </tbody>
  </table>