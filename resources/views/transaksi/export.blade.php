<table style="text-align: center">
  <thead>
    <tr>
      <th>No</th>
      <th>Kode Transaksi</th>
      <th>Tanggal</th>
      <th>ISBN</th>
      <th>Judul Buku</th>
      <th>Harga</th>
      <th>Jumlah</th>
      <th>Total Harga</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($transaksi as $t)
      @php
        $transaksiParent = $t->transaksi()->withTrashed()->first();
        $buku = $t->buku()->withTrashed()->first();
      @endphp
      <tr>
        <td>{{ $loop->index + 1 }}</td>
        <td>{{ $transaksiParent->kode }}</td>
        <td>{{ $t->created_at }}</td>
        <td>{{ $buku->isbn }}</td>
        <td>{{ $buku->judul }}</td>
        <td>Rp {{ number_format($t->harga, 2, ',', '.') }}</td>
        <td>{{ $t->jumlah }}</td>
        <td>Rp {{ number_format($t->harga * $t->jumlah, 2, ',', '.') }}</td>
        <td></td>
      </tr>
    @endforeach
  </tbody>
</table>