<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<div class="container" style="width: 60% !important">
  <h5 style="text-align: center">{{ $pengaturan->nama_toko }}</h5>
<h5 style="text-align: center">Laporan Pengadaan</h5><br>
<table style="width: 50%; border-width: 0">
  <tbody>
    <tr>
      <td><h6>Kode Pengadaan</h6></td>
      <td><h6>:</h6></td>
      <td><h6>{{ $pengadaan->kode }}</h6></td>
    </tr>
    <tr>
      <td><h6>Tanggal</h6></td>
      <td><h6>:</h6></td>
      <td><h6>{{ $pengadaan->tanggal }}</h6></td>
    </tr>
    <tr>
      <td><h6>Distributor</h6></td>
      <td><h6>:</h6></td>
      <td><h6>{{ $pengadaan->distributor->nama }}</h6></td>
    </tr>
    <tr>
      <td><h6>Keterangan</h6></td>
      <td><h6>:</h6></td>
      <td><h6>{{ $pengadaan->keterangan ?? '-' }}</h6></td>
    </tr>
  </tbody>
</table>
<hr>

<table cellpadding="10" style="width: 100%">
  <tr>
    <td>Buku</td>
    <td>Harga</td>
    <td>QTY</td>
    <td>Sub Total</td>
  </tr>
  <tr>
    <td colspan="4"><hr></td>
  </tr>
  
  @foreach ($pengadaan->detail as $p)
  <tr>
    <td>
      {{ $p->buku ? $p->buku->judul : '-' }}
      <br>
      {{ $p->buku ? $p->buku->isbn : '-' }}
    </td>
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
        <td>Rp {{ number_format($pengadaan->bayar, 2, ',', '.') }}</td>
      </tr>
      <tr>
        <td >Total Harga</td>
        <td >Rp {{ number_format($pengadaan->total_harga, 2, ',', '.') }}</td>
      </tr>
      <tr>
        <td>Kembalian</td>
        <td>Rp {{ number_format($pengadaan->bayar - $pengadaan->total_harga, 2, ',', '.') }}</td>
      </tr>
    </tbody>
  </table>
</div>

<script>
  window.print();
</script>