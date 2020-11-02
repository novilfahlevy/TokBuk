<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<h4>Faktur Transaksi</h4>
<table class="display table table-striped table-bordered" style="width:100%; text-align:center;" border="1" cellpadding="10" cellspacing="0">
  <tbody>
    <tr>
      <td>Kode</td>
      <td>{{ $transaksi->kode }}</td>
    </tr>
    <tr>
      <td>Tanggal</td>
      <td>{{ $transaksi->created_at }}</td>
    </tr>
    <tr>
      <td>Total Harga</td>
      <td>Rp {{ number_format($transaksi->total_harga) }}</td>
    </tr>
    <tr>
      <td>Bayar</td>
      <td>Rp {{ number_format($transaksi->bayar) }}</td>
    </tr>
    <tr>
      <td>Kembalian</td>
      <td>Rp {{ number_format($transaksi->bayar - $transaksi->total_harga) }}</td>
    </tr>
  </tbody>
</table>
<table class="display table table-striped table-bordered" style="width:100%; text-align:center;" border="1" cellpadding="10" cellspacing="0">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">ISBN</th>
      <th scope="col">Judul</th>
      <th scope="col">Jumlah</th>
      <th scope="col">Harga Per Buku</th>
      <th scope="col">Total Harga</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($transaksi->detail as $p)
      <tr>
        <td>{{ $loop->index + 1 }}</td>
        <td>{{ $p->buku()->withTrashed()->first()->isbn }}</td>
        <td>{{ $p->buku()->withTrashed()->first()->judul }}</td>
        <td>{{ $p->jumlah }}</td>
        <td>Rp {{ number_format($p->harga) }}</td>
        <td>Rp {{ number_format($p->harga * $p->jumlah) }}</td>
      </tr>
    @endforeach
  </tbody>
</table>