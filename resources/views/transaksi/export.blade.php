<table style="text-align: center">
  <thead>
    <tr>
      <th>No</th>
      <th>Kode Transaksi</th>
      <th>Tanggal</th>
      <th>ISBN</th>
      <th>Judul Buku</th>
      <th>Harga</th>
      <th>Diskon</th>
      <th>Jumlah</th>
      <th>Total Harga</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($transaksi as $t)
      @php
        $transaksiParent = $t->transaksi;
        $buku = $t->buku;
      @endphp
      <tr>
        <td>{{ $loop->index + 1 }}</td>
        <td>{{ $transaksiParent->kode }}</td>
        <td>{{ $t->created_at }}</td>
        <td>{{ $buku ? $buku->isbn : '-' }}</td>
        <td>{{ $buku ? $buku->judul : '-' }}</td>
        <td>Rp {{ number_format($t->harga, 2, ',', '.') }}</td>
        <td>{{ $t->diskon ? $t->diskon . '%' : '-' }}</td>
        <td>{{ $t->jumlah }}</td>
        <td>Rp {{ number_format($t->jumlah * ($t->diskon ? $t->harga - (($t->harga / 100) * $t->diskon) : $t->harga), 2, ',', '.') }}</td>
      </tr>
    @endforeach
  </tbody>
</table>