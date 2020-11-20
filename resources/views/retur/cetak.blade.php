<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<div class="container" style="width: 60% !important">
  <h5 style="text-align: center">
    {{ $pengaturan->nama_toko }} <br>
  </h5>
  <table style="width: 50%; border-width: 0">
    <tbody>
      <tr>
        <td><h6>Email</h6></td>
        <td><h6>:</h6></td>
        <td><h6>{{ $pengaturan->email }}</h6></td>
      </tr>
      <tr>
        <td><h6>Telepon</h6></td>
        <td><h6>:</h6></td>
        <td><h6>{{ $pengaturan->telepon }}</h6></td>
      </tr>
      <tr>
        <td><h6>Alamat</h6></td>
        <td><h6>:</h6></td>
        <td><h6>{{ $pengaturan->alamat }}</h6></td>
      </tr>
    </tbody>
  </table>
  <hr>
    <table style="width: 100%">
      <tr>
        <td>ISBN </td>
        <td>Judul Buku </td>
        <td>Keterangan</td>
        <td>Harga</td>
        <td>QTY</td>
        <td>Sub Total </td>
      </tr>
      <tr>
        <td colspan="6"><hr></td>
      </tr>
      
      @foreach ($retur->detail as $r)
      <tr>
        <th>{{ $r->pengadaan->buku()->withTrashed()->first()->isbn }}</th>
        <th>{{ $r->pengadaan->buku()->withTrashed()->first()->judul }}</th>
        <th>{{ $r->keterangan }}</th>
        <th>Rp {{ number_format($r->dana_pengembalian, 2, ',', '.') }}</th>
        <th>{{ $r->jumlah }}</th>
        <th>Rp {{ number_format($r->dana_pengembalian * $r->jumlah, 2, ',', '.') }}</th>
      </tr>
      @endforeach
    </table>
  
  <hr>
  
  
      <table style="width: 100%; text-align : center;">
        <tbody>
  
          <tr>
            <td>Jumlah Buku</td>
            <td>{{ $retur->detail->sum('jumlah') }}</td>
          </tr>
          <tr>
            <td >Total Dana Pengembalian</td>
            <td >Rp {{ number_format($retur->total_dana_pengembalian, 2, ',', '.') }}</td>
          </tr>
        </tbody>
      </table>
    
  <hr>
  <table style="width: 50%; border-width: 0">
    <tbody>
      <tr>
        <td><h6>Kode Transaksi</h6></td>
        <td><h6>:</h6></td>
        <td><h6>{{ $retur->kode }}</h6></td>
      </tr>
      <tr>
        <td><h6>Tanggal</h6></td>
        <td><h6>:</h6></td>
        <td><h6>{{ $retur->tanggal }}</h6></td>
      </tr>
    </tbody>
  </table>
  {{-- <br>
  <center>Terima kasih telah membeli buku di {{ $pengaturan->nama_toko }}<br>
  Buku yang telah dibeli tidak dapat ditukar atau dikembalikan<br>
  Terima kasih atas kunjungan anda</center> --}}
</div>
<script>
  window.print();
</script>