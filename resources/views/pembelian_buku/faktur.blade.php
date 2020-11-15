<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<h5 style="text-align: center">{{ $pengaturan->nama_toko }}</h5>
<h5 style="text-align: center">Laporan Pembelian Buku</h5><br>
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
      <td><h6>{{ $pembelian->tanggal }}</h6></td>
    </tr>
    <tr>
      <td><h6>Distributor</h6></td>
      <td><h6>:</h6></td>
      <td><h6>{{ $pembelian->distributor->nama }}</h6></td>
    </tr>
    <tr>
      <td><h6>Keterangan</h6></td>
      <td><h6>:</h6></td>
      <td><h6>{{ $pembelian->keterangan ?? '-' }}</h6></td>
    </tr>
  </tbody>
</table>
<hr>

<table style="width: 100%">
  <tr>
    <td>Buku</td>
    <td>Harga</td>
    <td>QTY</td>
    <td>Sub Total</td>
  </tr>
  <tr>
    <td colspan="4"><hr></td>
  </tr>
  
  @foreach ($pembelian->detail as $p)
  <tr>
    <td>{{ $p->buku()->withTrashed()->first()->judul }}<br>
      {{ $p->buku()->withTrashed()->first()->isbn }}</td>
      <td>Rp {{ number_format($p->harga, 2, ',', '.') }}</td>
      <td>{{ $p->jumlah }}</td>
      <td>Rp {{ number_format($p->harga * $p->jumlah, 2, ',', '.') }}</td>
    </tr>
    @endforeach
  </table>
  <hr>

  <table style="width: 100%; text-align : center;">
    <tbody>
      <tr>
        <td>Nominal Pembayaran</td>
        <td>Rp {{ number_format($pembelian->bayar, 2, ',', '.') }}</td>
      </tr>
      <tr>
        <td >Total Harga</td>
        <td >Rp {{ number_format($pembelian->total_harga, 2, ',', '.') }}</td>
      </tr>
      <tr>
        <td>Kembalian</td>
        <td>Rp {{ number_format($pembelian->bayar - $pembelian->total_harga, 2, ',', '.') }}</td>
      </tr>
    </tbody>
  </table>