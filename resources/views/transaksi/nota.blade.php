<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
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
      <td>Buku </td>
      <td>Harga </td>
      <td>QTY </td>
      <td>Diskon </td>
      <td>Sub Total </td>
    </tr>
    <tr>
      <td colspan="5"><hr></td>
    </tr>
    
    @foreach ($transaksi->detail as $p)
    <tr>
      <td>{{ $p->buku ? $p->buku->judul : '-' }}<br>
      <td>Rp {{ number_format($p->harga, 2, ',', '.') }}<br>
      <td>x {{ $p->jumlah }}</td>
      <td>{{ !!$p->diskon ? $p->diskon . '%' : '-' }}</td>
      <td>Rp {{ number_format($p->jumlah * (!!$p->diskon ? ($p->harga - (($p->harga / 100) * $p->diskon)) : $p->harga), 2, ',', '.') }}</td>
    </tr>
    @endforeach
  </table>

<hr>


    <table style="width: 100%; text-align : center;">
      <tbody>

        <tr>
          <td>Nominal Pembayaran</td>
          <td>Rp {{ number_format($transaksi->bayar, 2, ',', '.') }}</td>
        </tr>
        <tr>
          <td >Total Harga</td>
          <td >Rp {{ number_format($transaksi->total_harga, 2, ',', '.') }}</td>
        </tr>
        <tr>
          <td>Kembalian</td>
          <td>Rp {{ number_format($transaksi->bayar - $transaksi->total_harga, 2, ',', '.') }}</td>
        </tr>
      </tbody>
    </table>
  
<hr>
<table style="width: 50%; border-width: 0">
  <tbody>
    <tr>
      <td><h6>Kode Transaksi</h6></td>
      <td><h6>:</h6></td>
      <td><h6>{{ $transaksi->kode }}</h6></td>
    </tr>
    <tr>
      <td><h6>Tanggal</h6></td>
      <td><h6>:</h6></td>
      <td><h6>{{ $transaksi->created_at }}</h6></td>
    </tr>
  </tbody>
</table>
{{-- <br>
<center>Terima kasih telah membeli buku di {{ $pengaturan->nama_toko }}<br>
Buku yang telah dibeli tidak dapat ditukar atau dikembalikan<br>
Terima kasih atas kunjungan anda</center> --}}