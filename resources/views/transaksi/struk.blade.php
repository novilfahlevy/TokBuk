<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<h5 style="text-align: center">
  TokBuk <br>
</h5>
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
<hr style="border-bottom: dashed;">
  <table style="width: 100%">
    <tr>
      <td>Buku <hr style="border-bottom: dashed;"></td>
      <td>QTY <hr style="border-bottom: dashed;"></td>
      <td>Harga <hr style="border-bottom: dashed;"></td>
    </tr>
    
    @foreach ($transaksi->detail as $p)
    <tr>
      <td>{{ $p->buku()->withTrashed()->first()->judul }}<br>
      <td>x {{ $p->jumlah }}</td>
      <td>Rp {{ number_format($p->harga) }}</td>
    </tr>
    @endforeach
  </table>

<hr style="border-bottom: dashed;">


    <table style="width: 100%; text-align : center;">
      <tbody>
        
        <tr>
          <td>Bayar</td>
          <td>Rp {{ number_format($transaksi->bayar) }}</td>
        </tr>
        <tr>
          <td >Total Harga</td>
          <td >Rp {{ number_format($transaksi->total_harga) }}</td>
        </tr>
        <tr>
          <td>Kembalian</td>
          <td>Rp {{ number_format($transaksi->bayar - $transaksi->total_harga) }}</td>
        </tr>
      </tbody>
    </table>
  
<hr style="border-bottom: dashed;">
<center>Terima kasih telah membeli buku di TokBuk<br>
Buku yang telah dibeli tidak dapat ditukar atau dikembalikan<br>
Terima kasih atas kunjungan anda</center>