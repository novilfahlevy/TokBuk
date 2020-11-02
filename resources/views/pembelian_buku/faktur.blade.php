<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
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
      <td>Harga Beli</td>
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
      <th scope="col">Jumlah</th>
      <th scope="col">Harga Per Buku</th>
      <th scope="col">Total Harga</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($pembelian->detail as $p)
      <tr>
        <td>{{ $loop->index + 1 }}</td>
        <td>{{ $p->buku()->withTrashed()->first()->isbn }}</td>
        <td>{{ $p->buku()->withTrashed()->first()->judul }}</td>
        <td>{{ $p->jumlah }}</td>
        <td>Rp {{ number_format($p->harga_jual) }}</td>
        <td>Rp {{ number_format($p->harga_jual * $p->jumlah) }}</td>
      </tr>
    @endforeach
  </tbody>
</table>